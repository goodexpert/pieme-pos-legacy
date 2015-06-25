<?php

App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {

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
        'MerchantUser',
        'MerchantRetailer',
        'MerchantUserType',
        'MerchantOutlet',
        'MerchantRegister',
        'MerchantLoyalty',
        'Plan',
        'Subscriber',
        'RegisterSale'
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login');
    }

/**
 * Add a new user function.
 *
 * @return void
 */
    public function add() {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantUser->getDataSource();
            $dataSource->begin();
            
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];
                
                $this->MerchantUser->create();
                $this->MerchantUser->save($data);
                
                $dataSource->commit();
                
                $result['success'] = true;
                $result['user_id'] = $this->MerchantUser->id;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
            return;
        }

        $user_types = $this->MerchantUserType->find('list', array(
            'conditions' => array(
                'MerchantUserType.is_active' => 1
            )
        ));
        $this->set('user_types', $user_types);

        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets', $outlets);
    }

/**
 * Edit a user details function.
 *
 * @return void
 */
    public function edit($id) {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            $dataSource = $this->MerchantUser->getDataSource();
            $dataSource->begin();
            
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];
                
                if (empty($data['password'])) {
                    unset($data['password']);
                }

                if (isset($data['outlet_id']) && empty($data['outlet_id'])) {
                    $data['outlet_id'] = null;
                }
                
                $this->MerchantUser->id = $id;
                $this->MerchantUser->save($data);
                
                $dataSource->commit();
                
                $result['success'] = true;
                $result['user_id'] = $this->MerchantUser->id;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
            return;
        }

        $user_types = $this->MerchantUserType->find('list', array(
            'conditions' => array(
                'MerchantUserType.is_active' => 1
            )
        ));
        $this->set('user_types', $user_types);

        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets', $outlets);
        
        $users = $this->MerchantUser->findById($id);
        $this->set('users',$users);
    }

/**
 * View a user details function.
 *
 * @return void
 */
    public function view($id) {
        $user = $this->Auth->user();
        $user = $this->MerchantUser->findById($id);
        $this->set('user',$user);
        
        $this->RegisterSale->bindModel(array(
        	'belongsTo' => array(
        		'MerchantUser' => array(
                    'className' => 'MerchantUser',
                    'foreignKey' => 'user_id'
                ),
                'MerchantCustomer' => array(
                	'className' => 'MerchantCustomer',
                	'foreignKey' => 'customer_id'
                )
        	)
        ));
        
        $sales = $this->RegisterSale->find('all', array(
        	'conditions' => array(
        		'RegisterSale.user_id' => $id
        	)
        ));
        $this->set('sales',$sales);
    }

/**
 * Login function.
 *
 * @return void
 */
    public function login() {
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
                $_SESSION["Auth"]["User"]["register_counts"] = count($registers);

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
        $this->layout = 'signin';
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

}
