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
 * This controller uses MerchantProduct, MerchantPriceBook and MerchantPriceBookEntry models.
 *
 * @var array
 */
    public $uses = array('MerchantProduct', 'MerchantTaxRate', 'MerchantOutlet', 'MerchantPriceBook', 'MerchantPriceBookEntry', 'MerchantCustomerGroup');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $books = $this->MerchantPriceBook->find('all',array(
            'conditions' => array(
                'MerchantPriceBook.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
        $this->set('books',$books);
    
    }

    public function add() {
        $user = $this->Auth->user();
        
        if($this->request->is('post')){
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];
            $result = array();
            try {
            
                //Step 1: Create Merchant Price Book
                $this->MerchantPriceBook->create();
                $this->MerchantPriceBook->save($data);
                
                //Step 2: Create Merchant Price Book Entry
                foreach(json_decode($data['entries'],true) as $ent){
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
                
            } catch (Exception $e) {
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
        
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = array();
            try {
            
                //Step 1: Create Merchant Price Book
                $this->MerchantPriceBook->id = $id;
                $this->MerchantPriceBook->save($data);
                
                $this->MerchantPriceBookEntry->deleteAll(array('MerchantPriceBookEntry.price_book_id' => $id), false);
                
                //Step 2: Create Merchant Price Book Entry
                foreach(json_decode($data['entries'],true) as $ent){
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
                
            } catch (Exception $e) {
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

}
