<?php

App::uses('AppController', 'Controller');

class HomeController extends AppController {

    public $components = array('RequestHandler');

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array('MerchantCustomer','MerchantCustomerGroup','Country','MerchantProduct','TaxRate','RegisterSale','RegisterSaleItem','RegisterSalePayment','MerchantUser','MerchantOutlet','MerchantPaymentType','MerchantProductInventory','MerchantProductLog','MerchantRegisterOpen');
    public $layout = 'home';

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantQuickKey');
        $this->loadModel('MerchantPriceBook');
        $this->loadModel('MerchantRegister');
        
        if(!empty($this->Auth->user()['outlet_id'])) {
            $key_id = $this->MerchantRegister->findById($this->Auth->user()['MerchantRegister']['id'])['MerchantRegister']['quick_key_id'];
            $quick = $this->MerchantQuickKey->findById($key_id);
            $quick = json_decode($quick['MerchantQuickKey']['key_layouts'],true);
            $products_ids = array();
            foreach($quick['pages'] as $page) {
            	if(!empty($page['keys'])){
	                foreach($page['keys'] as $product) {
	                    $arr = array(
	                    	'product_id'=>$product['product_id'],
	                    	'page'=>$page['page']
	                    );
	                    array_push($products_ids, $arr);
	                }
	            }
            }
            $this->MerchantProduct->bindModel(array(
                'hasMany' => array(
                    'MerchantProductInventory' => array(
                        'className' => 'MerchantProductInventory',
                        'foreignKey' => 'product_id'
                    )
                )
            ));

            $items = $this->MerchantProduct->find('all', array(
                'fields' => array(
                    'MerchantProduct.*',
                    'Merchant.*',
                    'MerchantTaxRate.*'
                ),
                'conditions' => array(
                    'MerchantProduct.merchant_id' => $user['merchant_id'],
                    'MerchantProduct.is_active' => 1
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
            
            $key_items = Hash::combine($items, "{n}.MerchantProduct.id", "{n}");
            
            $this->set("key_layout",$products_ids);
            $this->set("key_items",$key_items);

            $this->MerchantPriceBook->bindModel(array(
                'hasMany' => array(
                    'MerchantPriceBookEntry' => array(
                        'className' => 'MerchantPriceBookEntry',
                        'foreignKey' => 'price_book_id'
                    )
                )
            ));
            
            $pricebooks = $this->MerchantPriceBook->find('all', array(
                'conditions' => array(
                    'MerchantPriceBook.merchant_id' => $user['merchant_id'],
                    array(
                        'OR' => array(
                            array('MerchantPriceBook.valid_from <=' => date("Y-m-d")),
                            array('MerchantPriceBook.valid_from' => null)
                        )
                    ),
                    array(
                        'OR' => array(
                            array('MerchantPriceBook.valid_to >=' => date("Y-m-d")),
                            array('MerchantPriceBook.valid_to' => null)
                        )
                    ),
                    array(
                        'OR' => array(
                            array('MerchantPriceBook.outlet_id' => $user['outlet_id']),
                            array('MerchantPriceBook.outlet_id' => null)
                        )
                    )
                ),
                'order' => array('MerchantPriceBook.created DESC')
            ));
            $this->set('pricebooks',$pricebooks);
        }
        $merchant = $this->MerchantRegister->findById($user['MerchantRegister']['id']);
        $this->set('merchant',$merchant);
        
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
            
            $this->loadModel('MerchantCustomer');
            
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
    
            $this->RegisterSale->recursive = 2;
    
            $retrieves = $this->RegisterSale->find('all', array(
                'fields' => array(
                    'RegisterSale.*'
                ),
                'conditions' => array(
                    'RegisterSale.register_id' => $user['MerchantRegister']['id'],
                    'RegisterSale.status' => array('saved','layby','onaccount')
                )
            ));
            $this->set('retrieves',$retrieves);
    
            $groups = $this->MerchantCustomerGroup->find('all', array(
                'conditions' => array(
                    'MerchantCustomerGroup.merchant_id' => $this->Auth->user()['merchant_id']
                ),
                'order' => array('MerchantCustomerGroup.created ASC')
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
        $this->loadModel("MerchantRegister");
        $user = $this->Auth->user();
        $result = array();


        if ($this->request->is('post')) {
            try {
                $data = $this->request->data;
                $data['register_id'] = $this->Auth->user()['MerchantRegister']['id'];
                $data['user_id'] = $this->Auth->user()['id'];
                $data['sale_date'] = date('Y-m-d H:i:s');

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
                
                if(isset($_POST['sale_id'])){
                    $this->RegisterSaleItem->deleteAll(array('RegisterSaleItem.sale_id' => $data['sale_id']), false);
                    $this->RegisterSale->id = $data['sale_id'];
                    $currentStatus = $this->RegisterSale->findById($data['sale_id'])['RegisterSale']['status'];
                    if($currentStatus == 'layby')
                    	$data['status'] = 'layby_closed';
                    if($currentStatus == 'onaccount')
                    	$data['status'] = 'onaccount_closed';
                } else {
                    $this->RegisterSale->create();
                    $data['status'] = 'closed';
                }
                $this->RegisterSale->save($data);

                $paymentArray = json_decode($data['amount']);

                foreach($paymentArray as $pay) {

                    $this->RegisterSalePayment->create();
                    $payment['sale_id'] = $this->RegisterSale->id;
                    $payment['merchant_payment_type_id'] = $pay[0];
                    $payment['amount'] = $pay[1];
                    $payment['payment_date'] = date('Y-m-d H:i:s');
                    $this->RegisterSalePayment->save($payment);

                }

                $array = json_decode($_POST['items']);
                $generalQuantity = 0;
                $outletQuantity = 0;
                foreach($array as $item) {
                    $this->RegisterSaleItem->create();
                    $line->RegisterSaleItem['sale_id'] = $this->RegisterSale->id;
                    $line->RegisterSaleItem['product_id'] = $item[0];
                    $line->RegisterSaleItem['quantity'] = $item[1];
                    $line->RegisterSaleItem['price'] = $item[2];
                    $line->RegisterSaleItem['sequence'] = $item[3];
                    $line->RegisterSaleItem['status'] = 'VALID';
                    $this->RegisterSaleItem->save($line);
                    
                    $quantities = $this->MerchantProductInventory->find('all', array(
                    	'conditions' => array(
                    		'MerchantProductInventory.product_id' => $item[0]
                    	)
                    ));
                    foreach($quantities as $quantity) {
	                    $generalQuantity += $quantity['MerchantProductInventory']['count'];
	                    if($quantity['MerchantProductInventory']['outlet_id'] == $user['outlet_id']) {
	                    	$outletQuantity = $quantity['MerchantProductInventory']['count'];
	                    	
	                    	$this->MerchantProductInventory->id = $quantity['MerchantProductInventory']['id'];
	                    	$update['MerchantProductInventory']['count'] = $outletQuantity - $item[1];
	                    	$this->MerchantProductInventory->save($update);
	                    }
                    }
                    
                    if($data['status'] == 'closed') {
	                    $this->MerchantProductLog->create();
	                    $log['MerchantProductLog']['product_id'] = $item[0];
	                    $log['MerchantProductLog']['user_id'] = $user['id'];
	                    $log['MerchantProductLog']['outlet_id'] = $user['outlet_id'];
	                    $log['MerchantProductLog']['quantity'] = $generalQuantity - $item[1];
	                    $log['MerchantProductLog']['outlet_quantity'] = $outletQuantity - $item[1];
	                    $log['MerchantProductLog']['change'] = -$item[1];
	                    $log['MerchantProductLog']['action_type'] = 'sale';
	                    $this->MerchantProductLog->save($log);
	                    
	                    $generalQuantity = 0;
	                    $outletQuantity = 0;
	                }
                }
                $this->MerchantRegister->id = $user['MerchantRegister']['id'];
                $increase->MerchantRegister['invoice_sequence'] = $this->MerchantRegister->findById($user['MerchantRegister']['id'])['MerchantRegister']['invoice_sequence'] + 1;
                $this->MerchantRegister->save($increase);
                
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }
    
    public function park() {
        $user = $this->Auth->user();
    
        $result = array();

        if ($this->request->is('post')) {
            try {
                $data = $this->request->data;
                $data['register_id'] = $this->Auth->user()['MerchantRegister']['id'];
                $data['user_id'] = $user['id'];

                if(isset($_POST['sale_id'])){
                    $this->RegisterSaleItem->deleteAll(array('RegisterSaleItem.sale_id' => $data['sale_id']), false);
                    $this->RegisterSale->id = $data['sale_id'];
                } else {
                    $this->RegisterSale->create();
                }
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
                    
                    $quantities = $this->MerchantProductInventory->find('all', array(
                    	'conditions' => array(
                    		'MerchantProductInventory.product_id' => $item[0]
                    	)
                    ));
                    
                    $generalQuantity = 0;
                    $outletQuantity = 0;
                    foreach($quantities as $quantity) {
	                    $generalQuantity += $quantity['MerchantProductInventory']['count'];
	                    if($quantity['MerchantProductInventory']['outlet_id'] == $user['outlet_id']) {
	                    	$outletQuantity = $quantity['MerchantProductInventory']['count'];
	                    	
	                    	$this->MerchantProductInventory->id = $quantity['MerchantProductInventory']['id'];
	                    	$update['MerchantProductInventory']['count'] = $outletQuantity - $item[1];
	                    	$this->MerchantProductInventory->save($update);
	                    }
                    }
                    
                    if($data['status'] !== 'saved') {
	                    $this->MerchantProductLog->create();
	                    $log['MerchantProductLog']['product_id'] = $item[0];
	                    $log['MerchantProductLog']['user_id'] = $user['id'];
	                    $log['MerchantProductLog']['outlet_id'] = $user['outlet_id'];
	                    $log['MerchantProductLog']['quantity'] = $generalQuantity - $item[1];
	                    $log['MerchantProductLog']['outlet_quantity'] = $outletQuantity - $item[1];
	                    $log['MerchantProductLog']['change'] = -$item[1];
	                    if($data['status'] == 'layby')
	                       $log['MerchantProductLog']['action_type'] = 'layby_sale';
	                    if($data['status'] == 'onaccount')
	                       $log['MerchantProductLog']['action_type'] = 'account_sale';
	                    $this->MerchantProductLog->save($log);
	                    
	                    $generalQuantity = 0;
	                    $outletQuantity = 0;
	                }
                }
                
                $paymentArray = json_decode($data['payments']);

                foreach($paymentArray as $pay) {

                    $this->RegisterSalePayment->create();
                    $payment['sale_id'] = $this->RegisterSale->id;
                    $payment['merchant_payment_type_id'] = $pay[0];
                    $payment['amount'] = $pay[1];
                    $payment['payment_date'] = date('Y-m-d H:i:s');
                    $this->RegisterSalePayment->save($payment);

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
                    
                    $this->MerchantCustomer->id = $data['customer_id'];
                    $balance->MerchantCustomer['balance'] = $this->MerchantCustomer->findById($data['customer_id'])['MerchantCustomer']['balance'] - $data['actual_amount'];
                    $this->MerchantCustomer->save($balance);
                    
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

        $opens = $this->MerchantRegisterOpen->find('first',array(
            'conditions' => array(
                'MerchantRegisterOpen.register_id' => $this->Auth->user()['MerchantRegister']['id'],
                'MerchantRegisterOpen.register_close_time' => ''
            )
        ));
        
        if($this->request->is('post')) {
        
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                $this->MerchantRegisterOpen->id = $opens['MerchantRegisterOpen']['id'];
                $this->MerchantRegisterOpen->save($data);
                
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }
        
        $this->set("user",$user);
        $this->set('open',$opens);
        
        $this->RegisterSalePayment->bindModel(array(
            'belongsTo' => array(
                'MerchantPaymentType' => array(
                    'className' => 'MerchantPaymentType',
                    'foreignKey' => 'merchant_payment_type_id'
                )
            )
        ));
        
        $this->RegisterSale->bindModel(array(
            'hasMany' => array(
                'RegisterSalePayment' => array(
                    'className' => 'RegisterSalePayment',
                    'foreignKey' => 'sale_id'
                )
            ),
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
        
        $this->RegisterSale->recursive = 2;
        
        $laybys = $this->RegisterSale->find('all', array(
            'conditions' => array(
                'RegisterSale.created >=' => $opens['MerchantRegisterOpen']['register_open_time'],
                'RegisterSale.status' => array('layby','layby_closed')
            )
        ));
        $this->set('laybys',$laybys);
        
        $this->RegisterSale->bindModel(array(
            'hasMany' => array(
                'RegisterSalePayment' => array(
                    'className' => 'RegisterSalePayment',
                    'foreignKey' => 'sale_id'
                )
            ),
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
        
        $onaccounts = $this->RegisterSale->find('all', array(
            'conditions' => array(
                'RegisterSale.created >=' => $opens['MerchantRegisterOpen']['register_open_time'],
                'RegisterSale.status' => array('onaccount','onaccount_closed')
            )
        ));
        $this->set('onaccounts',$onaccounts);
        
        $this->RegisterSalePayment->bindModel(array(
            'belongsTo' => array(
                'MerchantPaymentType' => array(
                    'className' => 'MerchantPaymentType',
                    'foreignKey' => 'merchant_payment_type_id'
                )
            )
        ));
        
        $this->RegisterSalePayment->recursive = 2;

        $payments = $this->RegisterSalePayment->find('all', array(
            'fields' => array(
                'RegisterSalePayment.*',
                'RegisterSale.*'
            ),
            'conditions' => array(
                'RegisterSalePayment.payment_date >=' => $opens['MerchantRegisterOpen']['register_open_time'],
                'RegisterSale.register_id' => $user['MerchantRegister']['id']
            ),
            'joins' => array(
                array(
                    'table' => 'register_sales',
                    'alias' => 'RegisterSale',
                    'type' => 'INNER',
                    'conditions' => array(
                        'RegisterSalePayment.sale_id = RegisterSale.id'
                    )
                )
            )
        ));
        $this->set('payments',$payments);
    }
    
    public function select_register() {
        if($this->request->is('post')) {
            $this->loadModel("MerchantRegister");
            
            $data = $this->request->data;
            
            $_SESSION["Auth"]["User"]["outlet_id"] = $data['outlet_id'];
            
            $outlet = $this->MerchantOutlet->findById($data['outlet_id']);
            $_SESSION["Auth"]["User"]["MerchantOutlet"] = $outlet['MerchantOutlet'];
            
            $register = $this->MerchantRegister->findById($data['register_id']);
            $_SESSION["Auth"]["User"]["MerchantRegister"] = $register['MerchantRegister'];
            
        }
    }
    public function edit_sale() {
        if($this->request->is('post')) {
            
        }
    }
}
