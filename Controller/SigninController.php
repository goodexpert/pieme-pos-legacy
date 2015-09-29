<?php

App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class SigninController extends AppController {

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
    public $layout = 'signin';

/**
 * This controller uses the following models.
 *
 * @var array
 */
    public $uses = array(
        'MerchantUser',
        'MerchantRetailer',
        'MerchantUserType',
        'MerchantOutlet',
        'MerchantRegister',
        'MerchantLoyalty',
        'Plan',
        'Subscriber'
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('index', 'pinpad');
    }

/**
 * Login function.
 *
 * @return void
 */
    public function index() {
        if ($this->request->is('post')) {
            $this->_login();
        }
    }

/**
 * Logout function.
 *
 * @return void
 */
    public function logout() {
        // Delete a cookie variable
        $this->Cookie->delete('session_id');

        return $this->redirect($this->Auth->logout());
    }

/**
 * Lock screen function.
 *
 * @return void
 */
    public function lock() {
        if ($this->request->is('post')) {
        }

        $this->Session->write('Auth.User.is_locked', true);
        $this->layout = 'lock';
    }

/**
 * Keepalive function.
 *
 * @return void
 */
    public function ping() {
        if ($this->request->is('ajax')) {
            $this->serialize(array(
                'success' => true
            ));
        } else {
            $this->layout = 'ajax';
        }
    }

/**
 * Login by pinpad function.
 *
 * @return void
 */
    public function pinpad() {
        $this->request->allowMethod(['get', 'post']);
        $domain = explode(".", $_SERVER['HTTP_HOST']);

        if (in_array($domain[0], ['localhost', 'secure'])) {
            $domain = 'master';
        } else {
            $domain = $domain[0];
        }

        $merchant = $this->_getMerchantByDomain($domain);
        if (!$merchant || $merchant['allow_use_pincode'] != 1) {
            return $this->redirect('/signin', 301, false);
        }

        if ($this->request->is('post')) {
            $this->_pincode();
        }

        if (empty($this->request->data)) {
            $this->request->data['MerchantUser']['domain_prefix'] = $domain[0];
        }
    }

/**
 * Log a user using standard options.
 *
 * @return void
 */
    protected function _login() {
        $data = $this->request->data;
        $errors = array();

        if (isset($data['MerchantUser']['domain_prefix'])) {
            $domain_prefix = trim($data['MerchantUser']['domain_prefix']);

            if (empty($domain_prefix) || strlen($domain_prefix) < 5) {
                $errors['domain_prefix'] = __('Your address must be at least 5 characters.');
            } elseif (!$this->Auth->isExistDomain($domain_prefix)) {
                $errors['domain_prefix'] = __('does not exist');
            } else {
                $this->Auth->setLoginDomain($domain_prefix);
            }
        }

        if (isset($data['MerchantUser']['username']) &&
            empty($data['MerchantUser']['username'])) {
            $errors['username'] = __('An email address or username is required.');
        }

        if (isset($data['MerchantUser']['password']) &&
            empty($data['MerchantUser']['password'])) {
            $errors['password'] = __('A password is required.');
        }

        if (empty($errors)) {
            if ($this->Auth->login()) {
                $user = $this->Auth->user();

                if (!empty($user['allow_ip_address']) && $user['allow_ip_address'] !== $_SERVER['REMOTE_ADDR']) {
                    $this->Auth->logout();
                    $this->Session->setFlash(__('Not allowed ip address.'));
                } else {
                    if (!empty($user['retailer_id'])) {
                        $retailer = $this->_getRetailerById($user['retailer_id']);
                        $this->Session->write('Auth.User.MerchantRetailer', $retailer);
                        $plan_id = $retailer['plan_id'];
                    } else {
                        $plan_id = $user['Merchant']['plan_id'];
                    }
                    $this->Session->write('Auth.User.Addons', $this->_getAddOns($user['merchant_id'], $user['retailer_id']));

                    $plan = $this->Plan->findById($plan_id);
                    $this->Session->write('Auth.User.Plan', $plan['Plan']);

                    $subscriber = $this->Subscriber->findById($user['Merchant']['subscriber_id']);
                    $this->Session->write('Auth.User.Subscriber', $subscriber['Subscriber']);

                    $loyalty = $this->MerchantLoyalty->findByMerchantId($user['merchant_id']);
                    $this->Session->write('Auth.User.Loyalty', $loyalty['MerchantLoyalty']);

                    $registers = $this->_getRegisterByOutletId($user['merchant_id'], $user['outlet_id']);
                    if (count($registers) == 1) {
                        $outlet = $registers[0]['MerchantOutlet'];
                        unset($registers[0]['MerchantOutlet']);

                        $this->Session->write('Auth.User.MerchantOutlet', $outlet);
                        $this->Session->write('Auth.User.MerchantRegister', $registers[0]);
                        $this->Session->write('Auth.User.current_outlet_id', $outlet['id']);
                    }
                    $this->Session->write('Auth.User.register_counts', count($registers));

                    // Create a cookie variable
                    $this->Cookie->write('session_id', rand());
                    $this->_updateLastLogin($user['id']);

                    return $this->redirect($this->Auth->redirect(), 301, false);
                }
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        } else {
            $this->set('errors', $errors);
        }
    }

/**
 * Log a user using pincode.
 *
 * @return void
 */
    protected function _pincode() {
        $data = $this->request->data;
        $errors = array();

        if (isset($data['MerchantUser']['domain_prefix'])) {
            $domain_prefix = trim($data['MerchantUser']['domain_prefix']);

            if (empty($domain_prefix) || strlen($domain_prefix) < 5) {
                $errors['domain_prefix'] = __('Your address must be at least 5 characters.');
            } elseif (!$this->Auth->isExistDomain($domain_prefix)) {
                $errors['domain_prefix'] = __('does not exist');
            } else {
                $this->Auth->setLoginDomain($domain_prefix);
            }
        }

        if (isset($data['MerchantUser']['pincode']) &&
            empty($data['MerchantUser']['pincode'])) {
            $errors['pincode'] = __('A pincode is required.');
        }

        if (empty($errors)) {
            if ($this->Auth->login()) {
                $user = $this->Auth->user();

                if (!empty($user['allow_ip_address']) && $user['allow_ip_address'] !== $_SERVER['REMOTE_ADDR']) {
                    $this->Auth->logout();
                    $this->Session->setFlash(__('Not allowed ip address.'));
                } else {
                    if (!empty($user['retailer_id'])) {
                        $retailer = $this->_getRetailerById($user['retailer_id']);
                        $this->Session->write('Auth.User.MerchantRetailer', $retailer);
                        $plan_id = $retailer['plan_id'];
                    } else {
                        $plan_id = $user['Merchant']['plan_id'];
                    }
                    $this->Session->write('Auth.User.Addons', $this->_getAddOns($user['merchant_id'], $user['retailer_id']));

                    $plan = $this->Plan->findById($plan_id);
                    $this->Session->write('Auth.User.Plan', $plan['Plan']);

                    $subscriber = $this->Subscriber->findById($user['Merchant']['subscriber_id']);
                    $this->Session->write('Auth.User.Subscriber', $subscriber['Subscriber']);

                    $loyalty = $this->MerchantLoyalty->findByMerchantId($user['merchant_id']);
                    $this->Session->write('Auth.User.Loyalty', $loyalty['MerchantLoyalty']);

                    $registers = $this->_getRegisterByOutletId($user['merchant_id'], $user['outlet_id']);
                    if (count($registers) == 1) {
                        $outlet = $registers[0]['MerchantOutlet'];
                        unset($registers[0]['MerchantOutlet']);

                        $this->Session->write('Auth.User.MerchantOutlet', $outlet);
                        $this->Session->write('Auth.User.MerchantRegister', $registers[0]);
                        $this->Session->write('Auth.User.current_outlet_id', $outlet['id']);
                    }
                    $this->Session->write('Auth.User.register_counts', count($registers));

                    // Create a cookie variable
                    $this->Cookie->write('session_id', rand());
                    $this->_updateLastLogin($user['id']);

                    return $this->redirect($this->Auth->redirect(), 301, false);
                }
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
        } else {
            $this->set('errors', $errors);
        }
    }

/**
 * Check if a domain name exists.
 *
 * @param string subdomain name.
 * @return bool true if a domain can be found, false if one cannot.
 */
    protected function _checkDomainPrefix($domain_prefix) {
        $this->loadModel('Merchant');

        if (!in_array($domain_prefix, array('secure'))) {
            $merchant = $this->Merchant->findByDomainPrefix($domain_prefix);

            if (empty($merchant) || !is_array($merchant)) {
                return false;
            }
        }
        return true;
    }

/**
 * Retreive a merchant information.
 *
 * @param string subdomain name.
 * @return false|array array if a domain can be found, false if one cannot.
 */
    protected function _getMerchantByDomain($domain_prefix) {
        $this->loadModel('Merchant');

        $merchant = $this->Merchant->findByDomainPrefix($domain_prefix);

        if (empty($merchant) || !is_array($merchant)) {
            return false;
        }
        return $merchant['Merchant'];
    }

/**
 * Get the merchant's outlets.
 *
 * @param string merchant id.
 * @return array the list.
 */
    protected function _getOutletByMerchantId($merchant_id) {
        $this->loadModel('MerchantOutlet');

        $outlets = $this->MerchantOutlet->find('list', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $merchant_id
            )
        ));
        return $outlets;
    }

/**
 * Get the merchant's users.
 *
 * @param string merchant id.
 * @param string outlet id.
 * @return array the list.
 */
    protected function _getUsersByOutlet($merchant_id, $outlet_id) {
        $this->loadModel('MerchantUser');

        if (empty($merchant_id) || empty($outlet_id))
            return array();

        $users = $this->MerchantUser->find('list', array(
            'fields' => array(
                'MerchantUser.username',
                'MerchantUser.display_name'
            ),
            'conditions' => array(
                'MerchantUser.merchant_id' => $merchant_id,
                'OR' => array(
                    'MerchantUser.outlet_id IS NULL',
                    'MerchantUser.outlet_id' => $outlet_id,
                )
            )
        ));
        return $users;
    }

/**
 * Get the merchant's retailer.
 *
 * @param string retailer id.
 * @return array the list.
 */
    protected function _getRetailerById($retailer_id) {
        $this->loadModel('MerchantRetailer');

        $retailer = $this->MerchantRegister->findById($retailer_id);
        return $retailer['MerchantRetailer'];
    }

/**
 * Get the user's register.
 *
 * @param string merchant id.
 * @param string outlet id.
 * @return array the list.
 */
    protected function _getRegisterByOutletId($merchant_id, $outlet_id) {
        $this->loadModel('MerchantRegister');

        $conditions = array(
            'MerchantOutlet.merchant_id' => $merchant_id
        );

        if (!empty($outlet_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantOutlet.id' => $outlet_id
            ));
        }

        $registers = $this->MerchantRegister->find('all', array(
            'fields' => array(
                'MerchantRegister.*',
                'MerchantOutlet.*'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantOutlet.id = MerchantRegister.outlet_id'
                    )
                )
            ),
            'conditions' => $conditions
        ));
        $registers = Hash::map($registers, "{n}", function($array) {
            $newArray = $array['MerchantRegister'];
            $newArray['MerchantOutlet'] = $array['MerchantOutlet'];
            return $newArray;
        });
        return $registers;
    }

/**
 * Get the Add-ons.
 *
 * @param string merchant id.
 * @param string retailer id.
 * @return array
 */
    protected function _getAddOns($merchant_id, $retailer_id) {
        $this->loadModel('MerchantAddon');

        $addon = $this->MerchantAddon->find('first', array(
            'conditions' => array(
                'MerchantAddon.merchant_id' => $merchant_id,
                'MerchantAddon.retailer_id' => $retailer_id
            )
        ));
        if (empty($addon) || !is_array($addon)) {
            return array();
        }
        return $addon['MerchantAddon'];
    }

/**
 * Update last login time and IP address of the last login.
 *
 * @param string user id.
 * @return void
 */
    protected function _updateLastLogin($user_id) {
        $this->loadModel('MerchantUser');

        $this->MerchantUser->id = $user_id;
        $user['last_ip_address'] = $this->server('REMOTE_ADDR');
        $user['last_logged'] = date("Y-m-d H:i:s");
        $this->MerchantUser->save($user);
    }

}
