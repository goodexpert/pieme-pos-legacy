<?php

App::uses('AppController', 'Controller');

class CustomerController extends AppController {

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
 * This controller uses Contact, MerchantCustomer and MerchantCustomerGroup models.
 *
 * @var array
 */
    public $uses = array('Contact', 'MerchantCustomer', 'MerchantCustomerGroup');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $customers = $this->MerchantCustomer->find('all', array(
            'fields' => array(
                'MerchantCustomer.*',
                'Contact.*',
                'MerchantCustomerGroup.*'
            ),
            'conditions' => array(
                'MerchantCustomer.merchant_id' => $this->Auth->user()['merchant_id'],
            ),
            'joins' => array(
                array(
                    'table' => 'contacts',
                    'alias' => 'Contact',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Contact.id = MerchantCustomer.contact_id'
                    )
                ),
                array(
                    'table' => 'merchant_customer_groups',
                    'alias' => 'MerchantCustomerGroup',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantCustomer.customer_group_id = MerchantCustomerGroup.id'
                    )
                )
            )
        ));
        $this->set("customers",$customers);
    
    }

    public function add() {
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $this->Auth->user()['merchant_id']
            ),
        ));
        $this->set("groups",$groups);
    
        if($this->request->is('post')) {
            $result = array();
            try {
                $data = $this->request->data;
            
                $this->Contact->create();
                $this->Contact->save($data);

                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                $data['contact_id'] = $this->Contact->id;
                
                $this->MerchantCustomer->create();
                $this->MerchantCustomer->save($data);
                $result['id'] = $this->MerchantCustomer->id;
                $result['data'] = $data;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            var_dump($result);
            exit();
        }
    
    }
    
    public function group() {
        $user = $this->Auth->user();
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
    }
    
    public function add_group() {
        $user = $this->Auth->user();
        
        if($this->request->is('post')) {
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];
            
            $result = array();
            try {
                $this->MerchantCustomerGroup->create();
                $this->MerchantCustomerGroup->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }
    
    public function edit_group() {
        $user = $this->Auth->user();
        
        if($this->request->is('post')) {
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];
            
            $result = array();
            try {
                $this->MerchantCustomerGroup->id = $data['id'];
                $this->MerchantCustomerGroup->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function delete_group(){
        if($this->request->is('post')) {
            $data = $this->request->data;
            
            $result = array();
            try {
                $this->MerchantCustomerGroup->delete($data['id']);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function customer_quick_add() {
        if($this->request->is('post')) {
            $result = array();
            try {
                $data = $this->request->data;
            
                $this->Contact->create();
                $this->Contact->save($data);

                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                $data['contact_id'] = $this->Contact->id;
                
                $this->MerchantCustomer->create();
                $this->MerchantCustomer->save($data);
                $result['id'] = $this->MerchantCustomer->id;
                $result['data'] = $data;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }
	
	public function view(){}

}
