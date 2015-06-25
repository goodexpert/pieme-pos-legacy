<?php

App::uses('AppController', 'Controller');

class HomeController extends AppController {

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
        'Country',
        'MerchantCustomer',
        'MerchantCustomerGroup',
        'MerchantProduct',
        'MerchantOutlet',
        'MerchantPaymentType',
        'MerchantProductInventory',
        'MerchantProductLog',
        'MerchantRegisterOpen',
        'MerchantRegister',
        'MerchantUser',
        'TaxRate',
        'RegisterSale',
        'RegisterSaleItem',
        'RegisterSalePayment'
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
 * Index function.
 *
 * @return void
 */
    public function index() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantQuickKey');
        $this->loadModel('MerchantPriceBook');
        
        if(!empty($user['current_outlet_id'])) {
            $key_id = $this->MerchantRegister->findById($user['MerchantRegister']['id'])['MerchantRegister']['quick_key_id'];
            $quick = $this->MerchantQuickKey->findById($key_id);
            $this->set("quick_key", $quick['MerchantQuickKey']['key_layouts']);
            $quick = json_decode($quick['MerchantQuickKey']['key_layouts'],true);
            $products_ids = array();
            foreach($quick['quick_keys']['groups'] as $group) {
                foreach($group['pages'] as $page) {
                    if(!empty($page['keys'])){
                        foreach($page['keys'] as $product) {
                            $arr = array(
                                'product_id'=>$product['product_id'],
                                'page'=>$page['page'],
				'color'=>$product['color'],
				'label'=>$product['label'],
				'group'=>$group['position']
                            );
                            array_push($products_ids, $arr);
                        }
                    }
                }
            }
            $this->MerchantProduct->bindModel(array(
                'hasMany' => array(
                    'MerchantProductInventory' => array(
                        'className' => 'MerchantProductInventory',
                        'foreignKey' => 'product_id'
                    )
                ),
                'belongsTo' => array(
                    'ProductUom' => array(
                        'className' => 'ProductUom',
                        'foreignKey' => 'product_uom'
                    ),
                    'MerchantTaxRate' => array(
                        'className' => 'MerchantTaxRate',
                        'foreignKey' => 'tax_id'
                    )
                )
            ));
            
            $this->MerchantProduct->recursive = 2;

            $items = $this->MerchantProduct->find('all', array(
                'fields' => array(
                    'MerchantProduct.*',
                    'Merchant.*'
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
                            array('MerchantPriceBook.outlet_id' => $user['current_outlet_id']),
                            array('MerchantPriceBook.outlet_id' => null)
                        )
                    )
                ),
                'order' => array('MerchantPriceBook.created DESC')
            ));
            $this->set('pricebooks',$pricebooks);
        }
        if(isset($user['MerchantRegister']['id']) && !empty($user['MerchantRegister']['id'])) {
            $merchant = $this->MerchantRegister->findById($user['MerchantRegister']['id']);
            $this->set('merchant',$merchant);
        }

        /*
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
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        */
        $registers = $this->_getRegisterByOutletId($user['merchant_id'], $user['outlet_id']);
        $this->set('registers', $registers);
        
        if(!empty($user['MerchantRegister'])){
            $this->loadModel('MerchantRegisterOpen');
            $registerOpen = $this->MerchantRegisterOpen->find('all',array(
                'conditions' => array(
                    'MerchantRegisterOpen.register_id' => $user['MerchantRegister']['id'],
                    'MerchantRegisterOpen.register_close_time' => ''
                )
            ));
            $sequence = $this->MerchantRegisterOpen->find('count',array(
                'conditions' => array(
                    'MerchantRegisterOpen.register_id' => $user['MerchantRegister']['id'],
                )
            ));
            if(count($registerOpen) == 0){
                $this->MerchantRegisterOpen->create();
                $open->MerchantRegisterOpen['register_id'] = $user['MerchantRegister']['id'];
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
                    ),
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
    
            $retrieves = $this->RegisterSale->find('all', array(
                'fields' => array(
                    'RegisterSale.*'
                ),
                'conditions' => array(
                    'RegisterSale.register_id' => $user['MerchantRegister']['id'],
                    'RegisterSale.status' => array('sale_status_saved','sale_status_layby','sale_status_onaccount')
                )
            ));
            $this->set('retrieves',$retrieves);
    
            $groups = $this->MerchantCustomerGroup->find('all', array(
                'conditions' => array(
                    'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
                ),
                'order' => array('MerchantCustomerGroup.created ASC')
            ));
            $this->set("groups",$groups);
            
            $payments = $this->MerchantPaymentType->find('all', array(
                'conditions' => array(
                    'MerchantPaymentType.merchant_id' => $user['merchant_id'],
                    'MerchantPaymentType.is_active' => 1
                ),
            ));
            $this->set('payments',$payments);
        }
    }

    public function pay() {
        $this->loadModel('MerchantRegisterOpen');
        $user = $this->Auth->user();

        if ($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                $data['register_id'] = $user['MerchantRegister']['id'];
                $data['user_id'] = $user['id'];
                $data['sale_date'] = date('Y-m-d H:i:s');

                $registerOpen = $this->MerchantRegisterOpen->find('all',array(
                    'conditions' => array(
                        'MerchantRegisterOpen.register_id' => $user['MerchantRegister']['id'],
                        'MerchantRegisterOpen.register_close_time' => null
                    )
                ));
                $sequence = $this->MerchantRegisterOpen->find('count',array(
                    'conditions' => array(
                        'MerchantRegisterOpen.register_id' => $user['MerchantRegister']['id'],
                    )
                ));
                
                $customer = $this->MerchantCustomer->find('all',array(
                    'conditions' => array(
                        'MerchantCustomer.merchant_id' => $user['merchant_id']
                    ),
                    'order' => array('MerchantCustomer.created ASC')
                ));

                if(count($registerOpen) == 0){
                    $this->MerchantRegisterOpen->create();
                    $open->MerchantRegisterOpen['register_id'] = $user['MerchantRegister']['id'];
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
                    if($currentStatus == 'sale_status_layby')
                        $data['status'] = 'sale_status_layby_closed';
                    if($currentStatus == 'sale_status_onaccount')
                        $data['status'] = 'sale_status_onaccount_closed';
                    if($currentStatus == 'sale_status_saved')
                        $data['status'] = 'sale_status_closed';

                    $this->MerchantCustomer->id = $data['customer_id'];
                    $cBalance['MerchantCustomer']['balance'] = $this->MerchantCustomer->findById($data['customer_id'])['MerchantCustomer']['balance'] + $data['total_price_incl_tax'];
                    $this->MerchantCustomer->save($cBalance);
                } else {
                    $this->RegisterSale->create();
                    $data['status'] = 'sale_status_closed';
                }
                $this->RegisterSale->save($data);

                if($user['Loyalty']['MerchantLoyalty']['enable_loyalty'] == 1) {
                    $loyaltyBalance = number_format($data['total_price_incl_tax'] / $user['Loyalty']['MerchantLoyalty']['loyalty_spend_amount'],0,'','') * $user['Loyalty']['MerchantLoyalty']['loyalty_earn_amount'];
                    $this->MerchantCustomer->id = $data['customer_id'];
                    $ct['MerchantCustomer']['loyalty_balance'] = $this->MerchantCustomer->findById($data['customer_id'])['MerchantCustomer']['loyalty_balance'] + $loyaltyBalance;
                    $this->MerchantCustomer->save($ct);
                    
                }

                if(!empty($data['amount'])) {
                    $paymentArray = json_decode($data['amount']);
                    $seq = 0;
                    foreach($paymentArray as $pay) {
                        $this->RegisterSalePayment->create();
                        $payment['sale_id'] = $this->RegisterSale->id;
                        $payment['merchant_payment_type_id'] = $pay[0];
                        $payment['amount'] = $pay[1];
                        $payment['payment_date'] = date('Y-m-d H:i:s');
                        $payment['sequence'] = $seq;
                        $this->RegisterSalePayment->save($payment);
                        $seq++;
                    }
                }

                $generalQuantity = 0;
                $outletQuantity = 0;
                $items = json_decode($_POST['items'],true);
                foreach($items as $item) {
                    $this->RegisterSaleItem->create();
                    $item['sale_id'] = $this->RegisterSale->id;
                    $this->RegisterSaleItem->save($item);
                    
                    $quantities = $this->MerchantProductInventory->find('all', array(
                        'conditions' => array(
                            'MerchantProductInventory.product_id' => $item['product_id']
                        )
                    ));
                    foreach($quantities as $quantity) {
                        $generalQuantity += $quantity['MerchantProductInventory']['count'];
                        if($quantity['MerchantProductInventory']['outlet_id'] == $user['current_outlet_id']) {
                            $outletQuantity = $quantity['MerchantProductInventory']['count'];
                            
                            $this->MerchantProductInventory->id = $quantity['MerchantProductInventory']['id'];
                            $update['MerchantProductInventory']['count'] = $outletQuantity - $item['quantity'];
                            $this->MerchantProductInventory->save($update);
                        }
                    }
                    
                    if($data['status'] == 'sale_status_closed') {
                        $this->MerchantProductLog->create();
                        $log['MerchantProductLog']['product_id'] = $item['product_id'];
                        $log['MerchantProductLog']['user_id'] = $user['id'];
                        $log['MerchantProductLog']['outlet_id'] = $user['current_outlet_id'];
                        $log['MerchantProductLog']['quantity'] = $generalQuantity - $item['quantity'];
                        $log['MerchantProductLog']['outlet_quantity'] = $outletQuantity - $item['quantity'];
                        $log['MerchantProductLog']['change'] = -$item['quantity'];
                        $log['MerchantProductLog']['action_type'] = 'sale';
                        $this->MerchantProductLog->save($log);
                        
                        $generalQuantity = 0;
                        $outletQuantity = 0;
                    }
                }
                $this->MerchantRegister->id = $user['MerchantRegister']['id'];
                $increase->MerchantRegister['invoice_sequence'] = $this->MerchantRegister->findById($user['MerchantRegister']['id'])['MerchantRegister']['invoice_sequence'] + 1;
                $this->MerchantRegister->save($increase);
                $result['success'] = true;
                
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }
    
    public function park() {
        $user = $this->Auth->user();

        if ($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                $data['register_id'] = $user['MerchantRegister']['id'];
                $data['user_id'] = $user['id'];

                if ($data['status'] !== 'sale_status_saved') {
                    $data['sale_date'] = date('Y-m-d H:i:s');
                }

                if(isset($_POST['sale_id'])){
                    $this->RegisterSaleItem->deleteAll(array('RegisterSaleItem.sale_id' => $data['sale_id']), false);
                    $this->RegisterSale->id = $data['sale_id'];
                } else {
                    $this->RegisterSale->create();
                }
                $this->RegisterSale->save($data);
                
                if(isset($data['receipt_number']) && !empty($data['receipt_number'])) {
                    $this->MerchantRegister->id = $user['MerchantRegister']['id'];
                    $rs['MerchantRegister']['invoice_sequence'] = $data['receipt_number'] + 1;
                    $this->MerchantRegister->save($rs);
                }
                
                $array = json_decode($_POST['items'],true);
                
                foreach($array as $item) {
                    $this->RegisterSaleItem->create();
                    $item['sale_id'] = $this->RegisterSale->id;
                    $this->RegisterSaleItem->save($item);
                    
                    $quantities = $this->MerchantProductInventory->find('all', array(
                        'conditions' => array(
                            'MerchantProductInventory.product_id' => $item['product_id']
                        )
                    ));
                    
                    $generalQuantity = 0;
                    $outletQuantity = 0;
                    foreach($quantities as $quantity) {
                        $generalQuantity += $quantity['MerchantProductInventory']['count'];
                        if($quantity['MerchantProductInventory']['outlet_id'] == $user['current_outlet_id']) {
                            $outletQuantity = $quantity['MerchantProductInventory']['count'];
                            
                            $this->MerchantProductInventory->id = $quantity['MerchantProductInventory']['id'];
                            $update['MerchantProductInventory']['count'] = $outletQuantity - $item['quantity'];
                            $this->MerchantProductInventory->save($update);
                        }
                    }
                    
                    if($data['status'] !== 'sale_status_saved' && $data['status'] !== 'sale_status_voided') {
                        $this->MerchantProductLog->create();
                        $log['MerchantProductLog']['product_id'] = $item['product_id'];
                        $log['MerchantProductLog']['user_id'] = $user['id'];
                        $log['MerchantProductLog']['outlet_id'] = $user['current_outlet_id'];
                        $log['MerchantProductLog']['quantity'] = $generalQuantity - $item['quantity'];
                        $log['MerchantProductLog']['outlet_quantity'] = $outletQuantity - $item['quantity'];
                        $log['MerchantProductLog']['change'] = -$item['quantity'];
                        if($data['status'] == 'sale_status_layby')
                           $log['MerchantProductLog']['action_type'] = 'layby_sale';
                        if($data['status'] == 'sale_status_onaccount')
                           $log['MerchantProductLog']['action_type'] = 'account_sale';
                        $this->MerchantProductLog->save($log);
                        
                        $generalQuantity = 0;
                        $outletQuantity = 0;
                    }
                }
                
                if(!empty($data['payments'])) {
                
                    $paymentArray = json_decode($data['payments']);
    
                    foreach($paymentArray as $pay) {
    
                        $this->RegisterSalePayment->create();
                        $payment['sale_id'] = $this->RegisterSale->id;
                        $payment['merchant_payment_type_id'] = $pay[0];
                        $payment['amount'] = $pay[1];
                        $payment['payment_date'] = date('Y-m-d H:i:s');
                        $this->RegisterSalePayment->save($payment);
    
                    }
                }
                
                if($data['status'] !== 'sale_status_saved') {
                    $this->loadModel('MerchantRegisterOpen');
                    $registerOpen = $this->MerchantRegisterOpen->find('all',array(
                        'conditions' => array(
                            'MerchantRegisterOpen.register_id' => $user['MerchantRegister']['id'],
                            'MerchantRegisterOpen.register_close_time' => ''
                        )
                    ));
                    $sequence = $this->MerchantRegisterOpen->find('count',array(
                        'conditions' => array(
                            'MerchantRegisterOpen.register_id' => $user['MerchantRegister']['id'],
                        )
                    ));
                    
                    $customer = $this->MerchantCustomer->find('all',array(
                        'conditions' => array(
                            'MerchantCustomer.merchant_id' => $user['merchant_id']
                        )
                    ));
                    
                    $this->MerchantCustomer->id = $data['customer_id'];
                    $balance->MerchantCustomer['balance'] = $this->MerchantCustomer->findById($data['customer_id'])['MerchantCustomer']['balance'] - $data['actual_amount'];
                    $this->MerchantCustomer->save($balance);
                    
                    if(count($registerOpen) == 0){
                        $this->MerchantRegisterOpen->create();
                        $open->MerchantRegisterOpen['register_id'] = $user['MerchantRegister']['id'];
                        $open->MerchantRegisterOpen['register_open_count_sequence'] = $sequence;
                        
                        if($customer[0]['MerchantCustomer']['id'] == $data['customer_id']){
                            $open->MerchantRegisterOpen['total_new_sales'] = $data['total_price'];
                            $open->MerchantRegisterOpen['total_new_tax'] = $data['total_tax'];
                            
                            if($data['status'] == 'sale_status_onaccount') {
                                $open->MerchantRegisterOpen['onaccount'] = $data['total_price'] + $data['total_tax'];
                            }
                            if($data['status'] == 'sale_status_layby') {
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
                        if($data['status'] == 'sale_status_onaccount') {
                            $open->MerchantRegisterOpen['onaccount'] = $registerOpen[0]['MerchantRegisterOpen']['onaccount'] + $data['total_price'] + $data['total_tax'];
                        }
                        if($data['status'] == 'sale_status_layby') {
                            $open->MerchantRegisterOpen['layby'] = $registerOpen[0]['MerchantRegisterOpen']['layby'] + $data['total_price'] + $data['total_tax'];
                        }
                        $this->MerchantRegisterOpen->save($open);
                    }
                }
                $result['success'] = true;
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
                'MerchantRegisterOpen.register_id' => $user['MerchantRegister']['id'],
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
                'RegisterSale.status' => array('sale_status_layby','sale_status_layby_closed')
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
                'RegisterSale.status' => array('sale_status_onaccount','sale_status_onaccount_closed')
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
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            return $this->redirect('/dashboard', 301, false);
        }

        $data = $this->request->data;
        $register = $this->_getRegisterById($data['register_id']);

        if (is_array($register)) {
            $outlet = $register['MerchantOutlet'];
            unset($register['MerchantOutlet']);

            $this->Session->delete('Auth.User.MerchantOutlet');
            $this->Session->delete('Auth.User.MerchantRegister');

            $this->Session->write('Auth.User.current_outlet_id', $outlet['id']);
            $this->Session->write('Auth.User.MerchantOutlet', $outlet);
            $this->Session->write('Auth.User.MerchantRegister', $register);
        }

        if ($this->request->is('ajax')) {
            $result = array(
                'success' => is_array($register)
            );
            $this->serialize($result);
        } elseif ($this->request->is('post')) {
            return $this->redirect('/home', 301, false);
        }
    }

/**
 * Get the merchant's register.
 *
 * @param string register id.
 * @return array the list.
 */
    protected function _getRegisterById($register_id) {
        $this->loadModel('MerchantRegister');

        $register = $this->MerchantRegister->find('first', array(
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
            'conditions' => array(
                'MerchantRegister.id' => $register_id
            )
        ));
        if (!empty($register) && is_array($register)) {
            $temp = $register['MerchantRegister'];
            $temp['MerchantOutlet'] = $register['MerchantOutlet'];
            $register = $temp;
        }
        return $register;
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

}
