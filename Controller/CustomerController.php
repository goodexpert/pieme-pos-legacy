<?php

App::uses('AppController', 'Controller');

class CustomerController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('MerchantCustomer','Contact','MerchantCustomerGroup');
	public $layout = 'home';
	
	public $components = array('RequestHandler');

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
	
	/**
	 * Callback is called before any controller action logic is executed.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('index', 'add');
    }
}
