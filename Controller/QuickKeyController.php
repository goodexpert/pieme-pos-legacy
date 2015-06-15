<?php

App::uses('AppController', 'Controller');

class QuickKeyController extends AppController {

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
        'MerchantProduct',
        'MerchantQuickKey'
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
        $items = $this->MerchantQuickKey->find('all');
        $this->set("items",$items);
    }

    public function add(){
        /*
        if ($this->request->is('post')) {
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                
                $this->MerchantQuickKey->create();
                $this->MerchantQuickKey->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }

        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array(
            'MerchantProduct.merchant_id' => $this->Auth->user()['merchant_id'],
            )
        ));
        $this->set("items",$items);
         */
    }

    public function edit($id){
        if ($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantQuickKey->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;
                
                $this->MerchantQuickKey->id = $id;
                $this->MerchantQuickKey->save($data);
                
                $result['success'] = true;
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }

        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array(
            'MerchantProduct.merchant_id' => $this->Auth->user()['merchant_id'],
            )
        ));
        $this->set("items",$items);
        $keys = $this->MerchantQuickKey->findById($id);
        $this->set("keys",$keys);
    }
    
    public function assign(){
        $this->loadModel('MerchantRegister');
        $user = $this->Auth->user();
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantRegister->getDataSource();
            $dataSource->begin();
            
            try {
                $data = $this->request->data;
                $this->MerchantRegister->id = $data['register_id'];
                $this->MerchantRegister->save($data);
                
                $dataSource->commit();
                $result['success'] = true;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }
    }

}
