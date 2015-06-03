<?php

App::uses('Component', 'Controller');
App::uses('XeroOAuth', 'Vendor/XeroOAuth/lib');

class XeroComponent extends Component {

/**
 * Settings for this Component
 *
 * @var array
 */
    public $settings = array(
        // Development key
        'consumer_key' => 'N4XH6CT4HUWGXKXNU51I3MQMBIIUKH',
        'shared_secret' => 'BEAASCFDGMTSKZLEIQLDH8CXHP6N2D',
        'application_type' => 'Public',
        // API versions
        'core_version' => '2.0',
        'payroll_version' => '1.0',
        'file_version' => '1.0' 
    );

/**
 * Constructor
 *
 * @param ComponentCollection $collection A ComponentCollection this component can use to lazy load its components
 * @param array $settings Array of configuration settings.
 */
    public function __construct(ComponentCollection $collection, $settings = array()) {
        $settings = array_merge($this->settings, (array)$settings);
        $this->Controller = $collection->getController();
        parent::__construct($collection, $settings);
    }

/**
 * Enable xero accounts function.
 *
 * @return void
 */
    public function enableXero() {
        $XeroOAuth = new XeroOAuth($this->settings);

        $initialCheck = $XeroOAuth->diagnostics();
        $checkErrors = count($initialCheck);
        if ($checkErrors > 0) {
            // you could handle any config errors here, or keep on truckin if you like to live dangerously
            foreach ( $initialCheck as $check ) {
                echo 'Error: ' . $check . PHP_EOL;
            }
        } else {
            $here = XeroOAuth::php_self();

            if (isset($_REQUEST['oauth_verifier'])) {
                $oauth = $_SESSION['xero_oauth'];
                $XeroOAuth->config['access_token'] = $oauth['oauth_token'];
                $XeroOAuth->config['access_token_secret'] = $oauth['oauth_token_secret'];

                $response = $XeroOAuth->request('GET', $XeroOAuth->url('AccessToken', ''), array(
                    'oauth_verifier' => $_REQUEST['oauth_verifier'],
                    'oauth_token' => $_REQUEST['oauth_token'] 
                ));

                if ($response['code'] == 200) {
                    $token = $XeroOAuth->extract_params($response['response']);

                    // Store token in persistent storage.
                    $this->_setOAuthToken($token);

                    $redirect_uri = '/setup/xero';
                    if (isset($oauth['redirect_uri'])) {
                        $redirect_uri = $oauth['redirect_uri'];
                    }
                    unset($_SESSION['xero_oauth']);
                    $this->Controller->redirect($redirect_uri, 301, true);
                } else {
                }
            } else {
                $params = array(
                    'oauth_callback' => $here
                );

                $response = $XeroOAuth->request('GET', $XeroOAuth->url('RequestToken', ''), $params);

                if ($response ['code'] == 200) {
                    $oauth = $XeroOAuth->extract_params($response['response']);
                    $scope = "";

                    if (isset($_REQUEST['redirect_uri'])) {
                        $oauth['redirect_uri'] = $_REQUEST['redirect_uri'];
                    }
                    // Store temporary data in session storage.
                    $_SESSION['xero_oauth'] = $oauth;

                    $authurl = $XeroOAuth->url("Authorize", '') . "?oauth_token={$oauth['oauth_token']}&scope=" . $scope;
                    //echo '<p>To complete the OAuth flow follow this URL: <a href="' . $authurl . '">' . $authurl . '</a></p>';
                    $this->Controller->redirect($authurl, 301, true);
                } else {
                }
            }
        }
    }

/**
 * Retrieve contacts from Xero contacts.
 *
 * @return false|array
 */
    public function getContacts() {
        return $this->_request('GET', 'Contacts', array('where' => 'IsCustomer=true'), "", 'json');
    }

/**
 * Post invoice to Xero.
 *
 * @return void
 */
    public function postInvoice() {
        //$this->redirect('/setup/xero', 301, false);
    }

/**
 * Reload accounts from Xero.
 *
 * @return void
 */
    public function reloadAccounts() {
        //$this->redirect('/setup/xero', 301, false);
    }

/**
 * Synchronize data with Xero.
 *
 * @return void
 */
    public function synchronize() {
        //$this->redirect('/setup/xero', 301, false);
    }

/**
 * Retrieve the OAuth access token and session handle
 *
 * @return array
 */
    protected function _getOAuthToken() {
        return $_SESSION['xero_token'];
    }

/**
 * Persist the OAuth access token and session handle somewhere
 *
 * @param array $token the token parameters as an array of key=value pairs
 * @return void
 */
    protected function _setOAuthToken($token) {
        $_SESSION['xero_token'] = $token;
    }

/**
 * Send a request message to Xero
 *
 * @param string $method
 *          the HTTP method being used. e.g. POST, GET, HEAD etc
 * @param string $resource
 *          the request resource path. e.g. Contacts, Invoices, Payments etc
 * @param array $params
 *          the request parameters as an array of key=value pairs
 * @param string $format
 *          the format of the response. Default json. Set to an empty string to exclude the format
 * @return false|array
 */
    protected function _request($method, $resource, $params = array(), $xml = "", $format = 'xml') {
        $token = $this->_getOAuthToken();
        $this->settings['access_token']  = $token['oauth_token'];
        $this->settings['access_token_secret'] = $token['oauth_token_secret'];
        $this->settings['session_handle'] = $token['oauth_session_handle'];

        $XeroOAuth = new XeroOAuth($this->settings);

        $initialCheck = $XeroOAuth->diagnostics();
        if (count($initialCheck) > 0) {
            // you could handle any config errors here, or keep on truckin if you like to live dangerously
            foreach ( $initialCheck as $check ) {
                echo 'Error: ' . $check . PHP_EOL;
            }
        } else {
            $response = $XeroOAuth->request($method, $XeroOAuth->url($resource, 'core'), $params, $xml, $format);
            if ($response ['code'] == 200) {
                $contacts = $XeroOAuth->parseResponse($response['response'], $format);
                return $contacts;
            } else {
            }
        }
        return false;
    }

}
