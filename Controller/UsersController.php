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
 * This controller uses MerchantUser, MerchantUserType, MerchantRegister and MerchantOutlet models.
 *
 * @var array
 */
    public $uses = array('MerchantUser', 'MerchantUserType', 'MerchantOutlet', 'MerchantRegister', 'Subscriber', 'Plan');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'lock', 'check_exist', 'check_store_name');
    }

/**
 * Login function.
 *
 * @return void
 */
    public function login() {
        $this->layout = false;

        // set a default notification message.
        $this->Session->setFlash(__('Enter any username and password.'), 'default');
        $show_alert = false;

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
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
                
                $_SESSION["Auth"]["User"]["Subscriber"] = $this->Subscriber->findById($user['Merchant']['subscriber_id']);

                // Create a cookie variable
                $this->Cookie->write('session_id', rand());

                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
            $show_alert = true;
        }
        $this->set('show_alert', $show_alert);
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
        $this->layout = 'lock';
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

        $user_types = $this->MerchantUserType->find('all');
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
                
                if(empty($data['password'])) {
                    unset($data['password']);
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

        $user_types = $this->MerchantUserType->find('all');
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
    }
    
    public function check_exist() {
	    if($this->request->is('post') || $this->request->is('ajax')) {
	    	$this->loadModel('Merchant');
	    	$result = array(
	    		'success' => false
	    	);
	    	try {
	    		$data = $this->request->data;
		    	$merchant = $this->Merchant->findByMerchantCode($data);
		    	if(!empty($merchant)) {
			    	$result['success'] = true;
			    	$result['merchant_id'] = $merchant['Merchant']['id'];
			    	$result['store_name'] = $merchant['Merchant']['name'];
			    	$result['subscriber_id'] = $merchant['Merchant']['subscriber_id'];
		    	}
		    } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
	    }
    }
    
    public function check_store_name() {
	    if($this->request->is('post') || $this->request->is('ajax')) {
	    	$this->loadModel('Merchant');
	    	$result = array(
	    		'success' => true
	    	);
	    	try {
	    		$data = $this->request->data;
		    	$merchant = $this->Merchant->findByName($data);
		    	if(!empty($merchant)) {
			    	$result['success'] = false;
		    	}
		    } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
	    }
    }

}
