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
            $data = $this->request->data;
            $errors = array();

            if (isset($data['MerchantUser']['domain_prefix'])) {
                $domain_prefix = trim($data['MerchantUser']['domain_prefix']);

                if (empty($domain_prefix) || strlen($domain_prefix) < 5) {
                    $errors['domain_prefix'] = 'Your address must be at least 5 characters.';
                } elseif (!$this->Auth->isExistDomain($domain_prefix)) {
                    $errors['domain_prefix'] = 'does not exist';
                } else {
                    $this->Auth->setLoginDomain($domain_prefix);
                }
            }

            if (isset($data['MerchantUser']['username']) &&
                empty($data['MerchantUser']['username'])) {
                $errors['username'] = 'An email address or username is required.';
            }

            if (isset($data['MerchantUser']['password']) &&
                empty($data['MerchantUser']['password'])) {
                $errors['password'] = 'A password is required.';
            }

            if (!empty($errors)) {
                $this->set('errors', $errors);
            } elseif ($this->Auth->login()) {
                $user = $this->Auth->user();

                $conditions = array(
                    'MerchantOutlet.id = MerchantRegister.outlet_id',
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                );

                if (isset($user['outlet_id'])) {
                    $conditions = array_merge($conditions, array(
                        'MerchantOutlet.id' => $user['outlet_id']
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
                            'conditions' => $conditions
                        )
                    )
                ));

                $plan = $this->Plan->findById($user['Merchant']['plan_id']);
                $this->Session->write('Auth.User.Merchant.Plan', $plan['Plan']);

                if (count($registers) == 1) {
                    $register = $registers[0];
                    $this->Session->write('Auth.User.MerchantRegister', $register['MerchantRegister']);
                    $this->Session->write('Auth.User.MerchantOutlet', $register['MerchantOutlet']);
                    $_SESSION["Auth"]["User"]["outlet_id"] = $register['MerchantOutlet']['id'];
                }
                $_SESSION["Auth"]["User"]["RegisterCount"] = count($registers);

                $this->MerchantUser->id = $user['id'];
                $user['last_ip_address'] = $_SERVER['REMOTE_ADDR'];
                $user['last_logged'] = date("Y-m-d H:i:s");
                $this->MerchantUser->save($user);
                
                if(!empty($user['retailer_id'])) {
                    $_SESSION["Auth"]["User"]["MerchantRetailer"] = $this->MerchantRetailer->findById($user['retailer_id']);
                }

                $_SESSION["Auth"]["User"]["Subscriber"] = $this->Subscriber->findById($user['Merchant']['subscriber_id']);
                $_SESSION["Auth"]["User"]["Loyalty"] = $this->MerchantLoyalty->findByMerchantId($user['merchant_id']);

                // Create a cookie variable
                $this->Cookie->write('session_id', rand());
                return $this->redirect($this->Auth->redirect(), 301, false);
            } else {
                $this->Session->setFlash(__('Invalid username or password, try again'));
            }
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
        if ($this->request->is('post')) {
        }
    }

/**
 * Check if a domain name exists.
 *
 * @param string subdomain name.
 * @return bool true if a domain can be found, false if one cannot.
 */
    protected function _check_domain_prefix($domain_prefix) {
        $this->loadModel('Merchant');

        try {
            if (!in_array($domain_prefix, array('secure'))) {
                $merchant = $this->Merchant->findByDomainPrefix($domain_prefix);

                if (!empty($merchant) && is_array($merchant)) {
                    return true;
                }
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        return false;
    }

}
