<?php

App::uses('AppController', 'Controller');

class OutletController extends AppController {

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
        'MerchantRegister',
        'MerchantQuickKey',
        'MerchantProduct',
        'MerchantProductInventory',
        'MerchantOutlet'
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
        
        $this->MerchantRegister->bindModel(array(
            'belongsTo' => array(
                'MerchantQuickKey' => array(
                    'className' => 'MerchantQuickKey',
                    'foreignKey' => 'quick_key_id'
                )
            )
        ));
        
        $this->MerchantRegister->bindModel(array(
            'belongsTo' => array(
                'MerchantReceiptTemplate' => array(
                    'className' => 'MerchantReceiptTemplate',
                    'foreignKey' => 'receipt_template_id'
                )
            )
        ));

        $this->MerchantOutlet->bindModel(array(
            'hasMany' => array(
                'MerchantRegister' => array(
                    'className' => 'MerchantRegister',
                    'foreignKey' => 'outlet_id'
                )
            ),
        ));
        
        $this->MerchantOutlet->recursive = 2;

        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));

        $this->set("outlets", $outlets);
    }

    public function add() {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            $dataSource = $this->MerchantOutlet->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];

                $this->MerchantOutlet->create();
                $this->MerchantOutlet->save(array('MerchantOutlet' => $data));

                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => array(
                        'MerchantProduct.merchant_id' => $user['merchant_id'],
                        'MerchantProduct.track_inventory' => 1
                    )
                ));

                foreach ($products as $product) {
                    $inventory = array();
                    $inventory['outlet_id'] = $this->MerchantOutlet->id;
                    $inventory['product_id'] = $product['MerchantProduct']['id'];

                    $this->MerchantProductInventory->create();
                    $this->MerchantProductInventory->save(array('MerchantProductInventory' => $inventory));
                }
                $dataSource->commit();

                $result['success'] = true;
                $result['outlet_id'] = $this->MerchantOutlet->id;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
        }
    }
    
    public function edit($id) {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];

                $this->MerchantOutlet->id = $data['id'];
                $this->MerchantOutlet->save(array('MerchantOutlet' => $data));

                $result['success'] = true;
                $result['outlet_id'] = $this->MerchantOutlet->id;
            } catch (Exception $e) {
                $result = $data;
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
        } else if ($this->request->is('get')) {
            $outlet = $this->MerchantOutlet->findById($id);

            if (empty($outlet) || !isset($outlet['MerchantOutlet'])) {
                $this->redirect('/outlet');
            } else if ($outlet['MerchantOutlet']['merchant_id'] != $user['merchant_id']){
                $this->redirect('/outlet');
            }

            $this->set("outlet", $outlet['MerchantOutlet']);
            
            $this->loadModel('Country');
            $countries = $this->Country->find('all');
            $this->set('countries',$countries);
            
            
        }
    }

}
