<?php

App::uses('AppController', 'Controller');

class PricebookController extends AppController {

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
        'MerchantCustomerGroup',
        'MerchantOutlet',
        'MerchantProduct',
        'MerchantPriceBook',
        'MerchantPriceBookEntry',
        'MerchantTaxRate'
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
        $this->MerchantPriceBook->bindModel(array(
            'belongsTo' => array(
                'MerchantCustomerGroup' => array(
                    'className' => 'MerchantCustomerGroup',
                    'foreignKey' => 'customer_group_id'
                ),
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                )
            )
        ));
    
        $books = $this->MerchantPriceBook->find('all',array(
            'conditions' => array(
                'MerchantPriceBook.merchant_id' => $this->Auth->user()['merchant_id']
            ),
            'order' => array('MerchantPriceBook.created ASC')
        ));
        $this->set('books',$books);
    
    }

    public function add() {
        $user = $this->Auth->user();
        
        if($this->request->is('post')){
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantPriceBook->getDataSource();
            $dataSource->begin();
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];
                if($data['outlet_id'] == ''){
                    $data['outlet_id'] = null;
                }
            
                //Step 1: Create Merchant Price Book
                $this->MerchantPriceBook->create();
                $this->MerchantPriceBook->save($data);
                
                //Step 2: Create Merchant Price Book Entry
                if($data['type'] == 'general') {
                    $products = $this->MerchantProduct->find('all',array(
                        'fields' => array(
                            'MerchantProduct.*',
                            'MerchantTaxRate.*'
                        ),
                        'conditions' => array(
                            'MerchantProduct.merchant_id' => $user['merchant_id']
                        ),
                        'joins' => array(
                            array(
                                'table' => 'merchant_tax_rates',
                                'alias' => 'MerchantTaxRate',
                                'type' => 'INNER',
                                'conditions' => array(
                                    'MerchantProduct.tax_id = MerchantTaxRate.id'
                                )
                            )
                        )
                    ));
                    if(!empty($products) && is_array($products)) {
                        foreach($products as $product) {
                            $this->MerchantPriceBookEntry->create();
                            $entry->MerchantPriceBookEntry['price_book_id'] = $this->MerchantPriceBook->id;
                            $entry->MerchantPriceBookEntry['product_id'] = $product['MerchantProduct']['id'];
                            $entry->MerchantPriceBookEntry['markup'] = $data['general_markup'];
                            $entry->MerchantPriceBookEntry['discount'] = $data['general_discount'];
                            $entry->MerchantPriceBookEntry['price'] = $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1);
                            $entry->MerchantPriceBookEntry['tax'] = $product['MerchantTaxRate']['rate'] * $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1);
                            $entry->MerchantPriceBookEntry['price_include_tax'] = $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1) + $product['MerchantTaxRate']['rate'] * $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1) - $data['general_discount'];
                            $entry->MerchantPriceBookEntry['min_units'] = $data['general_min_units'];
                            $entry->MerchantPriceBookEntry['max_units'] = $data['general_max_units'];
                            $this->MerchantPriceBookEntry->save($entry);
                        }
                    }
                } else {
                    if(!empty($data['entries']) && isset($data['entries'])) {
                        $entryArray = json_decode($data['entries'],true);
                        foreach($entryArray as $ent){
                            $this->MerchantPriceBookEntry->create();
                            $entry->MerchantPriceBookEntry['price_book_id'] = $this->MerchantPriceBook->id;
                            $entry->MerchantPriceBookEntry['product_id'] = $ent['product_id'];
                            $entry->MerchantPriceBookEntry['markup'] = $ent['markup'];
                            $entry->MerchantPriceBookEntry['discount'] = $ent['discount'];
                            $entry->MerchantPriceBookEntry['price'] = $ent['price'];
                            $entry->MerchantPriceBookEntry['price_include_tax'] = $ent['price_include_tax'];
                            $entry->MerchantPriceBookEntry['tax'] = $ent['tax'];
                            $entry->MerchantPriceBookEntry['min_units'] = $ent['min_units'];
                            $entry->MerchantPriceBookEntry['max_units'] = $ent['max_units'];
                            $this->MerchantPriceBookEntry->save($entry);
                       }
                    }
               }
               $dataSource->commit();
               $result['success'] = true;
               $result['price_book_id'] = $this->MerchantPriceBook->id;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            
            $this->serialize($result);
            return;
        }
        
        $this->MerchantProduct->bindModel(array(
           'belongsTo' => array(
                'MerchantTaxRate' => array(
                    'className' => 'MerchantTaxRate',
                    'foreignKey' => 'tax_id'
                )
            )
        ));
        
        $this->MerchantProduct->bindModel(array(
           'belongsTo' => array(
                'MerchantTaxRate' => array(
                    'className' => 'MerchantTaxRate',
                    'foreignKey' => 'tax_id'
                )
            )
        ));
        
        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("items",$items);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("groups",$groups);
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("outlets",$outlets);
    
    }

    public function view() {
        $this->MerchantPriceBookEntry->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));
    
        $this->MerchantPriceBook->bindModel(array(
            'hasMany' => array(
                'MerchantPriceBookEntry' => array(
                    'className' => 'MerchantPriceBookEntry',
                    'foreignKey' => 'price_book_id'
                )
            ),
        ));
        
        $this->MerchantPriceBook->recursive = 2;
    
        $book = $this->MerchantPriceBook->findById($_GET['r']);
        
        $this->set('book',$book);
    }
    
    public function edit($id){
        $user = $this->Auth->user();
        
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantPriceBook->getDataSource();
            $dataSource->begin();
            try {
                $data = $this->request->data;
                if($data['outlet_id'] == ''){
                    $data['outlet_id'] = null;
                }
            
                //Step 1: Create Merchant Price Book
                $this->MerchantPriceBook->id = $id;
                $this->MerchantPriceBook->save($data);
                
                //Step 2: Delete Merchant Price Book Entry
                $this->MerchantPriceBookEntry->deleteAll(array('MerchantPriceBookEntry.price_book_id' => $id), false);
                
                if($data['type'] == 'general') {
                    
                    $products = $this->MerchantProduct->find('all',array(
                        'fields' => array(
                            'MerchantProduct.*',
                            'MerchantTaxRate.*'
                        ),
                        'conditions' => array(
                            'MerchantProduct.merchant_id' => $user['merchant_id']
                        ),
                        'joins' => array(
                            array(
                                'table' => 'merchant_tax_rates',
                                'alias' => 'MerchantTaxRate',
                                'type' => 'INNER',
                                'conditions' => array(
                                    'MerchantProduct.tax_id = MerchantTaxRate.id'
                                )
                            )
                        )
                    ));
                    
                    if(!empty($products) && is_array($products)) {
                        foreach($products as $product) {
                            $this->MerchantPriceBookEntry->create();
                            $entry->MerchantPriceBookEntry['price_book_id'] = $this->MerchantPriceBook->id;
                            $entry->MerchantPriceBookEntry['product_id'] = $product['MerchantProduct']['id'];
                            $entry->MerchantPriceBookEntry['markup'] = $data['general_markup'];
                            $entry->MerchantPriceBookEntry['discount'] = $data['general_discount'];
                            $entry->MerchantPriceBookEntry['price'] = $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1);
                            $entry->MerchantPriceBookEntry['tax'] = $product['MerchantTaxRate']['rate'] * $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1);
                            $entry->MerchantPriceBookEntry['price_include_tax'] = $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1) + $product['MerchantTaxRate']['rate'] * $product['MerchantProduct']['supply_price'] * ($data['general_markup'] + 1) - $data['general_discount'];
                            $entry->MerchantPriceBookEntry['min_units'] = $data['general_min_units'];
                            $entry->MerchantPriceBookEntry['max_units'] = $data['general_max_units'];
                            $this->MerchantPriceBookEntry->save($entry);
                        }
                    }
                    
                } else {
                    //Step 2: Create Merchant Price Book Entry
                    if(!empty($data['entries']) && isset($data['entries'])) {
                        $entryArray = json_decode($data['entries'],true);
                        foreach($entryArray as $ent){
                            $this->MerchantPriceBookEntry->create();
                            $entry->MerchantPriceBookEntry['price_book_id'] = $this->MerchantPriceBook->id;
                            $entry->MerchantPriceBookEntry['product_id'] = $ent['product_id'];
                            $entry->MerchantPriceBookEntry['markup'] = $ent['markup'];
                            $entry->MerchantPriceBookEntry['discount'] = $ent['discount'];
                            $entry->MerchantPriceBookEntry['price'] = $ent['price'];
                            $entry->MerchantPriceBookEntry['price_include_tax'] = $ent['price_include_tax'];
                            $entry->MerchantPriceBookEntry['tax'] = $ent['tax'];
                            $entry->MerchantPriceBookEntry['min_units'] = $ent['min_units'];
                            $entry->MerchantPriceBookEntry['max_units'] = $ent['max_units'];
                            $this->MerchantPriceBookEntry->save($entry);
                       }
                   }
               }
               $dataSource->commit();
               $result['success'] = true;
               $result['price_book_id'] = $this->MerchantPriceBook->id;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }
        
        $this->MerchantProduct->bindModel(array(
           'belongsTo' => array(
                'MerchantTaxRate' => array(
                    'className' => 'MerchantTaxRate',
                    'foreignKey' => 'tax_id'
                )
            )
        ));
        
        $this->MerchantPriceBookEntry->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));
        
        $this->MerchantPriceBook->bindModel(array(
            'hasMany' => array(
                'MerchantPriceBookEntry' => array(
                    'className' => 'MerchantPriceBookEntry',
                    'foreignKey' => 'price_book_id'
                )
            ),
        ));
        
        $this->MerchantPriceBook->recursive = 3;
        
        $pricebook = $this->MerchantPriceBook->findById($id);
        $this->set('pricebook',$pricebook);
        
        
        $this->MerchantProduct->bindModel(array(
           'belongsTo' => array(
                'MerchantTaxRate' => array(
                    'className' => 'MerchantTaxRate',
                    'foreignKey' => 'tax_id'
                )
            )
        ));
        
        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("items",$items);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("groups",$groups);
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("outlets",$outlets);
        
    }
    
    public function delete(){
        if($this->request->is('post')) {
            $result = array(
                'success' => false
            );
            $data = $this->request->data;
            try {
                $this->MerchantPriceBook->delete($data['id']);
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }
    }

}
