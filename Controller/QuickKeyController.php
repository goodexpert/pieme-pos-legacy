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
 * This controller uses MerchantProduct and MerchantQuickKey models.
 *
 * @var array
 */
    public $uses = array('MerchantProduct', 'MerchantQuickKey');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $items = $this->MerchantQuickKey->find('all');
        $this->set("items",$items);
    }

    public function add(){
        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array(
            'MerchantProduct.merchant_id' => $this->Auth->user()['merchant_id'],
            )
        ));
        $this->set("items",$items);
        
        if ($this->request->is('post')) {
        
            $data = array(
                'merchant_id' => $this->Auth->user()['merchant_id'],
                'name' => $_POST['name'],
                'key_layouts' => $_POST['key_layouts']
            );
            
            $this->MerchantQuickKey->save($data);
            
        }
    }

    public function edit(){
        $items = $this->MerchantProduct->find('all');
        $this->set("items",$items);
        $keys = $this->MerchantQuickKey->findById($_GET['id']);
        $this->set("keys",$keys);
        
        if ($this->request->is('post')) {
        
            $data = array(
                'merchant_id' => '54f5104a-df94-4d9e-a2a2-bf61c0a801cd',
                'name' => $_POST['name'],
                'key_layouts' => $_POST['key_layouts'],
                'created' => date("Y-m-d H:i:s"),
                'modified' => date("Y-m-d H:i:s"),
            );
            
            $this->MerchantQuickKey->save($data);
            
        }
    }

}
