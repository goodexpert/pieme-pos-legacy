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
    public $uses = array('MerchantProduct', 'RegisterSale', 'RegisterSaleItem', 'MerchantCustomer', 'MerchantUser', 'SaleStatus');

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
        
        $this->loadModel('MerchantRegister');
        $registers = $this->MerchantRegister->find('all',array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $user['MerchantOutlet']['id']
            )
        ));
        $this->set('registers',$registers);
        
        $status = $this->SaleStatus->find('all');
        $this->set('status',$status);
        
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
                )
            )
        ));

        $this->RegisterSale->recursive = 2;
        
        $criteria = array(
            'RegisterSale.register_id' => $user['MerchantRegister']['id']
        );
        
        if(isset($_GET)) {
            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == 'from') {
                        $criteria['RegisterSale.created >='] = $value;
                    } else if($key == 'to') {
                        $criteria['RegisterSale.created <='] = $value;
                    } else if($key == 'customer') {
                        $criteria['MerchantCustomer.name LIKE'] = '%'.$value.'%';
                    } else {
                        $criteria['RegisterSale.'.$key] = $value;
                    }
                }
            }
        }
        
        $sales = $this->RegisterSale->find('all', array(
            'fields' => array(
                'RegisterSale.*',
                'MerchantCustomer.*'
            ),
            'conditions' => $criteria,
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
        
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
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
        $sales = $this->RegisterSale->findById($_GET['r']);
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
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                $data['modified'] = date('Y-m-d H:i:s');
                
                $this->RegisterSale->id = $data['id'];
                $this->RegisterSale->save($data);
                
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
