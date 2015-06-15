<?php

App::uses('Component', 'Controller');
App::uses('CakeSession', 'Model/Datasource');
App::uses('XeroOAuth', 'Vendor/XeroOAuth/lib');

class XeroComponent extends Component {

/**
 * Other components utilized by XeroComponent
 *
 * @var array
 */
    public $components = array('Session');

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
                $oauth = $this->Session->read('Auth.xero_oauth');
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

                    // Synchronize data with Xero
                    $this->_synchronize();

                    $redirect_uri = '/setup/xero';
                    if (isset($oauth['redirect_uri'])) {
                        $redirect_uri = $oauth['redirect_uri'];
                    }
                    $this->Session->delete('Auth.xero_oauth');
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
                    $this->Session->write('Auth.xero_oauth', $oauth);

                    $authurl = $XeroOAuth->url("Authorize", '') . "?oauth_token={$oauth['oauth_token']}&scope=" . $scope;
                    //echo '<p>To complete the OAuth flow follow this URL: <a href="' . $authurl . '">' . $authurl . '</a></p>';
                    $this->Controller->redirect($authurl, 301, true);
                } else {
                }
            }
        }
    }

/**
 * Retrieve accounts from Xero.
 *
 * @return false|array
 */
    public function getAccounts() {
        return $this->_request('GET', 'Accounts', array('where' => 'Status="ACTIVE"'), "", 'json');
    }

/**
 * Retrieve contacts from Xero.
 *
 * @return false|array
 */
    public function getContacts() {
        return $this->_request('GET', 'Contacts', array('where' => 'ContactStatus="ACTIVE" AND IsCustomer=true'), "", 'json');
    }

/**
 * Retrieve tax rates from Xero.
 *
 * @return false|array
 */
    public function getTaxRates() {
        return $this->_request('GET', 'TaxRates', array('where' => 'Status="ACTIVE"'), "", 'json');
    }

/**
 * Get a invoice from Xero.
 *
 * @return void
 */
    public function getInvoice($id) {
        return $this->_request('GET', 'Invoices/' . $id, array(), "", 'json');
    }

/**
 * Post invoices to Xero.
 *
 * @return void
 */
    public function postInvoice($xml) {
        return $this->_request('POST', 'Invoices', array(), $xml, 'json');
    }

/**
 * Reload accounts from Xero.
 *
 * @return void
 */
    public function reloadAccounts() {
        $user = $this->Session->read('Auth.User');

        // reload accounts
        $this->_reloadAccounts($user['merchant_id'], $user['retailer_id']);

        return $this->Controller->redirect($this->Controller->referer());
    }

/**
 * Synchronize data with Xero.
 *
 * @return void
 */
    public function synchronize() {
        $this->_synchronize();
    }

/**
 * Unlink Xero Account.
 *
 * @return void
 */
    public function unlink() {
        $this->_setOAuthToken(null);
        $this->Controller->redirect('/setup/add-ons', 301, true);
    }

/**
 * Synchronize data with Xero.
 *
 * @return void
 */
    protected function _synchronize() {
        $user = $this->Session->read('Auth.User');

        // update tax rates
        $this->_reloadTaxRates($user['merchant_id'], $user['retailer_id']);

        // reload accounts
        $this->_reloadAccounts($user['merchant_id'], $user['retailer_id']);

        // update contacts
        $this->_reloadContacts($user['merchant_id'], $user['retailer_id'], $user['Merchant']['default_customer_group_id']);
    }

/**
 * Update tax rates from Xero.
 *
 * @return array
 */
    protected function _reloadTaxRates($merchant_id, $retailer_id) {
        $response = $this->_request('GET', 'TaxRates', array('where' => 'Status="ACTIVE"'), "", 'json');
        if ($response['code'] == 200) {
            $response = json_decode($response['response'], true);

            $objInstance = ClassRegistry::init('XeroTaxRate');

            $dataSource = $objInstance->getDataSource();
            $dataSource->begin();

            try {
                $objInstance->deleteAll(array(
                    'XeroTaxRate.merchant_id' => $merchant_id,
                    'XeroTaxRate.retailer_id' => $retailer_id
                ));

                foreach ($response['TaxRates'] as $tax_rate) {
                    $data = array();
                    $data['merchant_id'] = $merchant_id;
                    $data['retailer_id'] = $retailer_id;
                    $data['name'] = $tax_rate['Name'];
                    $data['tax_type'] = $tax_rate['TaxType'];
                    $data['rate'] = $tax_rate['EffectiveRate'];

                    $objInstance->create();
                    $objInstance->save(array('XeroTaxRate' => $data));
                }
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
            }
        }
    }

/**
 * Update accounts from Xero.
 *
 * @return array
 */
    protected function _reloadAccounts($merchant_id, $retailer_id) {
        $response = $this->_request('GET', 'Accounts', array('where' => 'Status="ACTIVE"'), "", 'json');
        if ($response['code'] == 200) {
            $response = json_decode($response['response'], true);

            $objInstance = ClassRegistry::init('XeroAccount');

            $dataSource = $objInstance->getDataSource();
            $dataSource->begin();

            try {
                $objInstance->deleteAll(array(
                    'XeroAccount.merchant_id' => $merchant_id,
                    'XeroAccount.retailer_id' => $retailer_id
                ));

                foreach ($response['Accounts'] as $account) {
                    $data = array();
                    $data['merchant_id'] = $merchant_id;
                    $data['retailer_id'] = $retailer_id;
                    $data['account_id'] = $account['AccountID'];
                    $data['code'] = $account['Code'];
                    $data['name'] = $account['Name'];
                    $data['tax_type'] = $account['TaxType'];
                    $data['class'] = $account['Class'];
                    $data['type'] = $account['Type'];
                    if (isset($account['CurrencyCode'])) {
                        $data['currency_code'] = $account['CurrencyCode'];
                    }

                    $objInstance->create();
                    $objInstance->save(array('XeroAccount' => $data));
                }
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
            }
        }
    }

/**
 * Update contacts from Xero.
 *
 * @return array
 */
    protected function _reloadContacts($merchant_id, $retailer_id, $customer_group_id) {
        $response = $this->_request('GET', 'Contacts', array('where' => 'ContactStatus="ACTIVE" AND IsCustomer=true'), "", 'json');
        if ($response['code'] == 200) {
            $response = json_decode($response['response'], true);

            $contactInstance = ClassRegistry::init('Contact');
            $customerInstance = ClassRegistry::init('MerchantCustomer');

            $dataSource = $customerInstance->getDataSource();
            $dataSource->begin();

            try {
                foreach ($response['Contacts'] as $contact) {
                    $result = $customerInstance->find('first', array(
                        'conditions' => array(
                            'MerchantCustomer.merchant_id' => $merchant_id,
                            'MerchantCustomer.xero_contact_id' => $contact['ContactID']
                        )
                    ));

                    if (empty($result) || !is_array($result)) {
                        $data = array();
                        $data['company_name'] = $contact['Name'];
                        $data['first_name'] = $contact['FirstName'];
                        $data['last_name'] = $contact['LastName'];
                        $data['email'] = $contact['EmailAddress'];

                        foreach ($contact['Addresses'] as $address) {
                            if ($address['AddressType'] === 'POBOX') {
                                if (isset($address['AddressLine1'])) {
                                    $data['postal_address1'] = $address['AddressLine1'];
                                }

                                if (isset($address['AddressLine2'])) {
                                    $data['postal_address2'] = $address['AddressLine2'];
                                }

                                if (isset($address['City'])) {
                                    $data['postal_city'] = $address['City'];
                                }

                                if (isset($address['Region'])) {
                                    $data['postal_state'] = $address['Region'];
                                }

                                if (isset($address['PostalCode'])) {
                                    $data['postal_postcode'] = $address['PostalCode'];
                                }

                                if (!empty($address['Country'])) {
                                    $data['postal_county_id'] = $address['Country'];
                                }
                            } else {
                                if (isset($address['AddressLine1'])) {
                                    $data['physical_address1'] = $address['AddressLine1'];
                                }

                                if (isset($address['AddressLine2'])) {
                                    $data['physical_address2'] = $address['AddressLine2'];
                                }

                                if (isset($address['City'])) {
                                    $data['physical_city'] = $address['City'];
                                }

                                if (isset($address['Region'])) {
                                    $data['physical_state'] = $address['Region'];
                                }

                                if (isset($address['PostalCode'])) {
                                    $data['physical_postcode'] = $address['PostalCode'];
                                }

                                if (!empty($address['Country'])) {
                                    $data['physical_county_id'] = $address['Country'];
                                }
                            }
                        }

                        foreach ($contact['Phones'] as $phone) {
                            if ($phone['PhoneType'] === 'DEFAULT') {
                                $data['phone'] = $phone['PhoneAreaCode'] . ' ' . $phone['PhoneNumber'];
                            } elseif ($phone['PhoneType'] === 'MOBILE') {
                                $data['mobile'] = $phone['PhoneAreaCode'] . ' ' . $phone['PhoneNumber'];
                            } elseif ($phone['PhoneType'] === 'FAX') {
                                $data['fax'] = $phone['PhoneAreaCode'] . ' ' . $phone['PhoneNumber'];
                            }
                        }

                        $contactInstance->create();
                        $contactInstance->save(array('Contact' => $data));

                        $data = array();
                        $data['merchant_id'] = $merchant_id;
                        $data['contact_id'] = $contactInstance->id;
                        $data['customer_group_id'] = $customer_group_id;
                        $data['customer_code'] = $contact['Name'] . '-' . $this->_generateCode();
                        $data['name'] = $contact['Name'];
                        $data['xero_contact_id'] = $contact['ContactID'];

                        $customerInstance->create();
                        $customerInstance->save(array('MerchantCustomer' => $data));
                    }
                }
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
            }
        }
    }

/**
 * Retrieve the OAuth access token and session handle
 *
 * @return array
 */
    protected function _getOAuthToken() {
        $user = $this->Session->read('Auth.User');

        $result = ClassRegistry::init('MerchantAddon')->find('first', array(
            'conditions' => array(
                'MerchantAddon.merchant_id' => $user['merchant_id'],
                'MerchantAddon.retailer_id' => $user['retailer_id']
            )
        ));

        if (empty($result) || !is_array($result)) {
            return null;
        }
        return json_decode($result['MerchantAddon']['xero_auth_token'], true);
    }

/**
 * Persist the OAuth access token and session handle somewhere
 *
 * @param array $token the token parameters as an array of key=value pairs
 * @return void
 */
    protected function _setOAuthToken($token) {
        $user = $this->Session->read('Auth.User');
        $xero_auth_token = is_array($token) ? json_encode($token) : null;

        $objInstance = ClassRegistry::init('MerchantAddon');

        if (empty($user['Addons']) || !is_array($user['Addons'])) {
            $user['Addons'] = array();
            $user['Addons']['merchant_id'] = $user['merchant_id'];
            $user['Addons']['retailer_id'] = $user['retailer_id'];

            $objInstance->create();
        } else {
            $objInstance->id = $user['Addons']['id'];
        }

        $user['Addons']['xero_auth_token'] = $xero_auth_token;

        $objInstance->save(array('MerchantAddon' => $user['Addons']));
        $user['Addons']['id'] = $objInstance->id;

        $this->Session->write('Auth.User.Addons', $user['Addons']);
    }

	/**
	 * Refreshes the access token for partner API type applications
	 *
	 * @return boolean
	 */
    protected function _refreshToken() {
        $token = $this->_getOAuthToken();
        $params = array(
            'oauth_token' => $token['oauth_token'],
            'oauth_session_handle' => $token['oauth_session_handle']
        );

        $XeroOAuth = new XeroOAuth($this->settings);

        $initialCheck = $XeroOAuth->diagnostics();
        if (count($initialCheck) > 0) {
            // you could handle any config errors here, or keep on truckin if you like to live dangerously
            foreach ( $initialCheck as $check ) {
                echo 'Error: ' . $check . PHP_EOL;
            }
        } else {
            $response = $XeroOAuth->request('GET', $XeroOAuth->url('AccessToken', ''), $params);
            if ($response['code'] == 200) {
                $token = $XeroOAuth->extract_params($response['response']);

                // Store token in persistent storage.
                $this->_setOAuthToken($token);
            } else {
                debug($response);
            }
        }
        return false;
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
        $this->settings['access_token'] = $token['oauth_token'];
        $this->settings['access_token_secret'] = $token['oauth_token_secret'];
        if (isset($token['oauth_session_handle'])) {
            $this->settings['session_handle'] = $token['oauth_session_handle'];
        } else {
            $this->settings['session_handle'] = '';
        }

        $XeroOAuth = new XeroOAuth($this->settings);

        $initialCheck = $XeroOAuth->diagnostics();
        if (count($initialCheck) > 0) {
            // you could handle any config errors here, or keep on truckin if you like to live dangerously
            foreach ( $initialCheck as $check ) {
                echo 'Error: ' . $check . PHP_EOL;
            }
        } else {
            return $XeroOAuth->request($method, $XeroOAuth->url($resource, 'core'), $params, $xml, $format);
        }
        return false;
    }

/**
 * Generate a random code
 *
 * @return string
 */
    protected function _generateCode($length = 4) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle( $chars ), 0, $length);
    }

}
