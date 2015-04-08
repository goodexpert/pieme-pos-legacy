<?php

App::uses('AppController', 'Controller');

class HistoryController extends AppController {

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
 * This controller uses MerchantProduct, RegisterSale and RegisterSaleItem models.
 *
 * @var array
 */
    public $uses = array('MerchantProduct', 'RegisterSale', 'RegisterSaleItem', 'MerchantCustomer');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        
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
        ));

        $this->RegisterSale->recursive = 2;
        $sales = $this->RegisterSale->find('all', array(
            'fields' => array(
                'RegisterSale.*',
                'MerchantCustomer.*'
            ),
            'conditions' => array(
                'RegisterSale.register_id' => $this->Auth->user()['MerchantRegister']['id']
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_customers',
                    'alias' => 'MerchantCustomer',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantCustomer.id = RegisterSale.customer_id'
                    )
                )
            ),
            'order' => array('RegisterSale.created' => 'DESC')
        ));
        $this->set('sales', $sales);
    }

    public function receipt() {
    
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
        $sales = $this->RegisterSale->find('all', array(
            'conditions' => array(
                'RegisterSale.register_id' => $this->Auth->user()['MerchantRegister']['id'],
                'RegisterSale.id' => $_GET['r']
            )
        ));
        $this->set('sales', $sales);
    }

    public function edit() {
        $sales = $this->RegisterSale->find('all', array(
            'fields' => array(
                'RegisterSale.*',
                'MerchantCustomer.*'
            ),
            'conditions' => array(
                'RegisterSale.register_id' => $this->Auth->user()['MerchantRegister']['id'],
                'RegisterSale.id' => $_GET['r']
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_customers',
                    'alias' => 'MerchantCustomer',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantCustomer.id = RegisterSale.customer_id'
                    )
                )
            )
        ));
        $this->set('sales', $sales);
        
        $this->loadModel('MerchantRegister');
        $registers = $this->MerchantRegister->find('all',array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $this->Auth->user()['MerchantOutlet']['id']
            )
        ));
        $this->set('registers',$registers);
        
        $this->loadModel('MerchantCustomer');
        $customers = $this->MerchantCustomer->find('all',array(
            'conditions' => array(
                'MerchantCustomer.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
        $this->set('customers',$customers);
        
        if($this->request->is('post')){
            
            $data = $this->request->data;
            $data['modified'] = date('Y-m-d H:i:s');
            
            $this->RegisterSale->id = $data['id'];
            $this->RegisterSale->save($data);
            
        }
    }

    public function void(){
        if($this->request->is('post')){
            $data = $this->request->data;
            $data['modified'] = date('Y-m-d H:i:s');
            
            $this->RegisterSale->id = $data['id'];
            $this->RegisterSale->save($data);
        }
    }

}
