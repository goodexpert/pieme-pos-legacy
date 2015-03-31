<?php

App::uses('AppController', 'Controller');

class HomeController extends AppController {

	public $components = array('RequestHandler');

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('MerchantCustomer','MerchantCustomerGroup','Country','MerchantProduct','TaxRate','RegisterSale','RegisterSaleItem','RegisterSalePayment','MerchantUser','MerchantOutlet','MerchantPaymentType');
	public $layout = 'home';

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		//$this->Auth->allow('index');
	}

	public function index() {
		$user = $this->Auth->user();
		
		$this->loadModel('MerchantQuickKey');
		$this->loadModel('MerchantOutlet');
		$this->loadModel('MerchantRegister');
		
		if(!empty($this->Auth->user()['outlet_id'])) {
			$key_id = $this->MerchantRegister->findById($this->Auth->user()['MerchantRegister']['id'])['MerchantRegister']['quick_key_id'];
			$quick = $this->MerchantQuickKey->findById($key_id);
			$quick = json_decode($quick['MerchantQuickKey']['key_layouts'],true);
			$products_ids = array();
			foreach($quick['pages'] as $page) {
				foreach($page['keys'] as $product) {
					array_push($products_ids, $product['product_id']);
				}
			}
	
			$items = $this->MerchantProduct->find('all', array(
				'fields' => array(
					'MerchantProduct.*',
					'Merchant.*',
					'MerchantTaxRate.*'
				),
				'conditions' => array(
					'MerchantProduct.merchant_id' => $user['merchant_id'],
					'MerchantProduct.is_active' => 1,
					'MerchantProduct.id' => $products_ids
				),
				'joins' => array(
					array(
						'table' => 'merchants',
						'alias' => 'Merchant',
						'type' => 'INNER',
						'conditions' => array(
							'Merchant.id = MerchantProduct.merchant_id'
						)
					),
					array(
						'table' => 'merchant_tax_rates',
						'alias' => 'MerchantTaxRate',
						'type' => 'INNER',
						'conditions' => array(
							'MerchantTaxRate.id = MerchantProduct.tax_id'
						)
					)
				)
			));
	
			$this->set('items', $items);
		}
		$this->MerchantOutlet->bindModel(array(
			'hasMany' => array(
				'MerchantRegister' => array(
					'className' => 'MerchantRegister',
					'foreignKey' => 'outlet_id'
				)
			)
		));
		
		$outlets = $this->MerchantOutlet->find('all', array(
			'conditions' => array(
				'MerchantOutlet.merchant_id' => $this->Auth->user()['merchant_id']
			)
		));
		$this->set('outlets',$outlets);
		
		if(!empty($this->Auth->user()['MerchantRegister'])){
			$this->loadModel('MerchantRegisterOpen');
			$registerOpen = $this->MerchantRegisterOpen->find('all',array(
				'conditions' => array(
					'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
					'MerchantRegisterOpen.register_close_time' => ''
				)
			));
			$sequence = $this->MerchantRegisterOpen->find('count',array(
				'conditions' => array(
					'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
				)
			));
			if(count($registerOpen) == 0){
				$this->MerchantRegisterOpen->create();
				$open->MerchantRegisterOpen['register_id'] = $this->Auth->user()['MerchantRegister']['id'];
				$open->MerchantRegisterOpen['register_open_count_sequence'] = $sequence;
				$open->MerchantRegisterOpen['register_open_time'] = date('Y-m-d H:i:s');
				$this->MerchantRegisterOpen->save($open);
			}
		
			$customers = $this->MerchantCustomer->find('all', array(
				'fields' => array(
					'MerchantCustomer.*'
				),
				'conditions' => array(
					'MerchantCustomer.merchant_id' => $user['merchant_id']
				),
				'order' => array('MerchantCustomer.created ASC')
			));
			$this->set("customers",$customers);
			
			$countries = $this->Country->find('all');
			$this->set('countries',$countries);
			
			$this->RegisterSaleItem->bindModel(array(
				'belongsTo' => array(
					'MerchantProduct' => array(
						'className' => 'MerchantProduct',
						'foreignKey' => 'product_id'
					)
				)
			));
	
			$this->RegisterSale->bindModel(array(
				'hasMany' => array(
					'RegisterSaleItem' => array(
						'className' => 'RegisterSaleItem',
						'foreignKey' => 'sale_id'
					)
				),
			));
	
			$this->RegisterSale->recursive = 2;
	
			$retrieves = $this->RegisterSale->find('all', array(
				'fields' => array(
					'MerchantUser.*',
					'RegisterSale.*'
				),
				'conditions' => array(
					'RegisterSale.register_id' => $this->Auth->user()['MerchantRegister']['id'],
					'RegisterSale.status' => array('saved','layby','onaccount')
				),
				'joins' => array(
					array(
						'table' => 'merchant_users',
						'alias' => 'MerchantUser',
						'type' => 'INNER',
						'conditions' => array(
							'RegisterSale.user_id = MerchantUser.id'
						)
					)
				)
			));
			$this->set('retrieves',$retrieves);
	
			$groups = $this->MerchantCustomerGroup->find('all', array(
				'conditions' => array(
					'MerchantCustomerGroup.merchant_id' => $this->Auth->user()['merchant_id']
				),
			));
			$this->set("groups",$groups);
			
			$payments = $this->MerchantPaymentType->find('all', array(
				'conditions' => array(
					'MerchantPaymentType.merchant_id' => $user['merchant_id']
				),
			));
			$this->set('payments',$payments);
		}
	}

	public function pay() {
		$this->loadModel('MerchantRegisterOpen');
		$result = array();


		if ($this->request->is('post')) {
			try {
				$data = $this->request->data;
				$data['register_id'] = $this->Auth->user()['MerchantRegister']['id'];
				$data['user_id'] = $this->Auth->user()['id'];
				$data['status'] = 'closed';
				$data['sale_date'] = date('Y-m-d H:i:s');
				if($_POST['customer_id']){
					$data['customer_id'] = $_POST['customer_id'];
				} else {
					unset($data['customer_id']);
				}

				$registerOpen = $this->MerchantRegisterOpen->find('all',array(
					'conditions' => array(
						'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
						'MerchantRegisterOpen.register_close_time' => null
					)
				));
				$sequence = $this->MerchantRegisterOpen->find('count',array(
					'conditions' => array(
						'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
					)
				));
				
				$customer = $this->MerchantCustomer->find('all',array(
					'conditions' => array(
						'MerchantCustomer.merchant_id' => $this->Auth->user()['merchant_id']
					),
					'order' => array('MerchantCustomer.created ASC')
				));

				if(count($registerOpen) == 0){
					$this->MerchantRegisterOpen->create();
					$open->MerchantRegisterOpen['register_id'] = $this->Auth->user()['MerchantRegister']['id'];
					$open->MerchantRegisterOpen['register_open_count_sequence'] = $sequence;
					
					if($customer[0]['MerchantCustomer']['id'] == $data['customer_id']){
						$open->MerchantRegisterOpen['total_new_sales'] = $data['total_price'];
						$open->MerchantRegisterOpen['total_new_tax'] = $data['total_tax'];
						$open->MerchantRegisterOpen['total_new_payments'] = $data['total_price'] + $data['total_tax'];
					}
					
					$open->MerchantRegisterOpen['total_sales'] = $data['total_price'];
					$open->MerchantRegisterOpen['total_tax'] = $data['total_tax'];
					$open->MerchantRegisterOpen['total_payments'] = $data['total_price'] + $data['total_tax'];
					$open->MerchantRegisterOpen['register_open_time'] = date('Y-m-d H:i:s');
					$this->MerchantRegisterOpen->save($open);
				} else {
					$this->MerchantRegisterOpen->id = $registerOpen[0]['MerchantRegisterOpen']['id'];
					
					if($customer[0]['MerchantCustomer']['id'] == $data['customer_id']){
						$open->MerchantRegisterOpen['total_new_sales'] = $registerOpen[0]['MerchantRegisterOpen']['total_new_sales'] + $data['total_price'];
						$open->MerchantRegisterOpen['total_new_tax'] = $registerOpen[0]['MerchantRegisterOpen']['total_new_tax'] + $data['total_tax'];
						$open->MerchantRegisterOpen['total_new_payments'] = $registerOpen[0]['MerchantRegisterOpen']['total_new_payments'] + $data['total_price'] + $data['total_tax'];
					}
					
					$open->MerchantRegisterOpen['total_sales'] = $registerOpen[0]['MerchantRegisterOpen']['total_sales'] + $data['total_price'];
					$open->MerchantRegisterOpen['total_tax'] = $registerOpen[0]['MerchantRegisterOpen']['total_tax'] + $data['total_tax'];
					$open->MerchantRegisterOpen['total_payments'] = $registerOpen[0]['MerchantRegisterOpen']['total_payments'] + $data['total_price'] + $data['total_tax'];
					$this->MerchantRegisterOpen->save($open);
				}

				$this->RegisterSale->create();
				$this->RegisterSale->save($data);

				$this->RegisterSalePayment->create();
				$payment['sale_id'] = $this->RegisterSale->id;
				$payment['merchant_payment_type_id'] = $this->request->data['merchant_payment_type_id'];
				$payment['amount'] = $this->RegisterSale->total_price;
				$this->RegisterSalePayment->save($payment);

				$array = json_decode($_POST['items']);

				foreach($array as $item) {
					$this->RegisterSaleItem->create();
					$line->RegisterSaleItem['sale_id'] = $this->RegisterSale->id;
					$line->RegisterSaleItem['product_id'] = $item[0];
					$line->RegisterSaleItem['quantity'] = $item[1];
					$line->RegisterSaleItem['price'] = $item[2];
					$line->RegisterSaleItem['sequence'] = $item[3];
					$line->RegisterSaleItem['status'] = 'VALID';
					$this->RegisterSaleItem->save($line);
				}
			} catch (Exception $e) {
				$result['message'] = $e->getMessage();
			}
		}
		$this->serialize($result);
	}
	
	public function park() {
	
		$result = array();

		if ($this->request->is('post')) {
			try {
				$data = $this->request->data;
				$data['register_id'] = $this->Auth->user()['MerchantRegister']['id'];
				$data['user_id'] = $this->Auth->user()['id'];

				$this->RegisterSale->create();
				$this->RegisterSale->save($data);
				
				$array = json_decode($_POST['items']);
				
				foreach($array as $item) {
					$this->RegisterSaleItem->create();
					$line->RegisterSaleItem['sale_id'] = $this->RegisterSale->id;
					$line->RegisterSaleItem['product_id'] = $item[0];
					$line->RegisterSaleItem['quantity'] = $item[1];
					$line->RegisterSaleItem['price'] = $item[2];
					$line->RegisterSaleItem['sequence'] = $item[3];
					$line->RegisterSaleItem['status'] = 'VALID';
					$this->RegisterSaleItem->save($line);
				}
				
				if($data['status'] !== 'saved') {
					$this->loadModel('MerchantRegisterOpen');
					$registerOpen = $this->MerchantRegisterOpen->find('all',array(
						'conditions' => array(
							'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
							'MerchantRegisterOpen.register_close_time' => ''
						)
					));
					$sequence = $this->MerchantRegisterOpen->find('count',array(
						'conditions' => array(
							'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
						)
					));
					
					$customer = $this->MerchantCustomer->find('all',array(
						'conditions' => array(
							'MerchantCustomer.merchant_id' => $this->Auth->user()['merchant_id']
						)
					));
					
					if(count($registerOpen) == 0){
						$this->MerchantRegisterOpen->create();
						$open->MerchantRegisterOpen['register_id'] = $this->Auth->user()['MerchantRegister']['id'];
						$open->MerchantRegisterOpen['register_open_count_sequence'] = $sequence;
						
						if($customer[0]['MerchantCustomer']['id'] == $data['customer_id']){
							$open->MerchantRegisterOpen['total_new_sales'] = $data['total_price'];
							$open->MerchantRegisterOpen['total_new_tax'] = $data['total_tax'];
							
							if($data['status'] == 'onaccount') {
								$open->MerchantRegisterOpen['onaccount'] = $data['total_price'] + $data['total_tax'];
							}
							if($data['status'] == 'layby') {
								$open->MerchantRegisterOpen['layby'] = $data['total_price'] + $data['total_tax'];
							}
						}
						
						$open->MerchantRegisterOpen['total_sales'] = $data['total_price'];
						$open->MerchantRegisterOpen['total_tax'] = $data['total_tax'];
						$open->MerchantRegisterOpen['register_open_time'] = date('Y-m-d H:i:s');
						$this->MerchantRegisterOpen->save($open);
					} else {
						$this->MerchantRegisterOpen->id = $registerOpen[0]['MerchantRegisterOpen']['id'];
						
						if($customer[0]['MerchantCustomer']['id'] == $data['customer_id']){
							$open->MerchantRegisterOpen['total_new_sales'] = $registerOpen[0]['MerchantRegisterOpen']['total_new_sales'] + $data['total_price'];
							$open->MerchantRegisterOpen['total_new_tax'] = $registerOpen[0]['MerchantRegisterOpen']['total_new_tax'] + $data['total_tax'];
						}
						
						$open->MerchantRegisterOpen['total_sales'] = $registerOpen[0]['MerchantRegisterOpen']['total_sales'] + $data['total_price'];
						$open->MerchantRegisterOpen['total_tax'] = $registerOpen[0]['MerchantRegisterOpen']['total_tax'] + $data['total_tax'];
						if($data['status'] == 'onaccount') {
							$open->MerchantRegisterOpen['onaccount'] = $registerOpen[0]['MerchantRegisterOpen']['onaccount'] + $data['total_price'] + $data['total_tax'];
						}
						if($data['status'] == 'layby') {
							$open->MerchantRegisterOpen['layby'] = $registerOpen[0]['MerchantRegisterOpen']['layby'] + $data['total_price'] + $data['total_tax'];
						}
						$this->MerchantRegisterOpen->save($open);
					}
				}

			} catch (Exception $e) {
				$result['message'] = $e->getMessage();
			}
		}
		$this->serialize($result);
		
	}
	
	public function close() {
		$user = $this->Auth->user();
		$this->set("user",$user);
		
		$this->loadModel('MerchantRegisterOpen');
		$opens = $this->MerchantRegisterOpen->find('all',array(
			'conditions' => array(
				'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
				'MerchantRegisterOpen.register_close_time' => ''
			)
		));
		$open = $opens[0];
		$this->set('open',$open);
		if($this->request->is('post')) {
			$this->MerchantRegisterOpen->id = $open['MerchantRegisterOpen']['id'];
			$close->MerchantRegisterOpen['register_close_time'] = date('Y-m-d H:i:s');
			$this->MerchantRegisterOpen->save($close);
		}
	}
	
	public function select_register() {
		if($this->request->is('post')) {
			$this->loadModel("MerchantRegister");
			
			$data = $this->request->data;
			
			$_SESSION["Auth"]["User"]["outlet_id"] = $data['outlet_id'];
			$_SESSION["Auth"]["User"]["MerchantOutlet"]["id"] = $data['outlet_id'];
			$_SESSION["Auth"]["User"]["MerchantRegister"]["id"] = $data['register_id'];
			
			$register = $this->MerchantRegister->findById($data['register_id']);
			$_SESSION["Auth"]["User"]["MerchantRegister"] = $register['MerchantRegister'];
			
		}
	}
}
