<?php

App::uses('AppController', 'Controller');
App::uses('XeroOAuth', 'Vendor/XeroOAuth/lib');

class XeroController extends AppController {

/**
 * Components property.
 *
 * @var array
 */
    public $components = array('RequestHandler');

/**
 * Name of layout to use with this View.
 *
 * @var string
 */
    public $layout = 'home';

/**
 * This controller uses the following models.
 *
 * @var array
 */
    public $uses = array(
    );

/**
 * Xero config property.
 *
 * @var array
 */
    protected $config = array (
        'consumer_key' => 'N4XH6CT4HUWGXKXNU51I3MQMBIIUKH',
        'shared_secret' => 'BEAASCFDGMTSKZLEIQLDH8CXHP6N2D',
        'application_type' => 'Public',
        // API versions
        'core_version' => '2.0',
        'payroll_version' => '1.0',
        'file_version' => '1.0' 
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

/**
 * enable xero accounts function.
 *
 * @return void
 */
    public function enableXero() {
        $XeroOAuth = new XeroOAuth($this->config);

        $initialCheck = $XeroOAuth->diagnostics();
        $checkErrors = count($initialCheck);
        if ($checkErrors > 0) {
            // you could handle any config errors here, or keep on truckin if you like to live dangerously
            foreach ( $initialCheck as $check ) {
                echo 'Error: ' . $check . PHP_EOL;
            }
        } else {
            $here = XeroOAuth::php_self ();
        }

        if (isset($_REQUEST['oauth_verifier'])) {
            $XeroOAuth->config['access_token'] = $_SESSION['oauth']['oauth_token'];
            $XeroOAuth->config['access_token_secret'] = $_SESSION['oauth']['oauth_token_secret'];

            $code = $XeroOAuth->request ('GET', $XeroOAuth->url('AccessToken', ''), array(
                'oauth_verifier' => $_REQUEST['oauth_verifier'],
                'oauth_token' => $_REQUEST['oauth_token'] 
            ));

            if ($XeroOAuth->response ['code'] == 200) {
                $response = $XeroOAuth->extract_params($XeroOAuth->response['response']);
                //$session = persistSession($response);
                $_SESSION['oauth'] = $response;

                //unset ( $_SESSION ['oauth'] );
                header ( "Location: {$here}" );
            } else {
                debug($XeroOAuth);
            }
        //} elseif (isset($_REQUEST['authenticate']) || isset($_REQUEST['authorize'])) {
        } else {
            $params = array(
                'oauth_callback' => 'http://localhost/xero/enableXero'
            );
            $response = $XeroOAuth->request('GET', $XeroOAuth->url('RequestToken', ''), $params);

            if ($response ['code'] == 200) {
                $scope = 'payroll.employees,payroll.payruns,payroll.timesheets';
                $scope = '';

                $oauth = $XeroOAuth->extract_params($response['response']);
                $_SESSION['oauth'] = $oauth;

                $authurl = $XeroOAuth->url("Authorize", '') . "?oauth_token={$oauth['oauth_token']}&scope=" . $scope;
                echo '<p>To complete the OAuth flow follow this URL: <a href="' . $authurl . '">' . $authurl . '</a></p>';
                //$this->redirect($authurl, 301, false);
            } else {
            }
        }
        exit;
    }

/**
 * post invoice function.
 *
 * @return void
 */
    public function postInvoice($id) {
        $this->redirect('/setup/xero', 301, false);
    }

/**
 * reload accounts function.
 *
 * @return void
 */
    public function reloadAccounts() {
        $this->redirect('/setup/xero', 301, false);
    }

/**
 * Retrieve the OAuth access token and session handle
 *
 * @return void
 */
    protected function _getOAuthToken() {
    }

/**
 * Persist the OAuth access token and session handle somewhere
 *
 * @param array $token the token parameters as an array of key=value pairs
 * @return void
 */
    protected function _setOAuthToken($token) {
    }

}
