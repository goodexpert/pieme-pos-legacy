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
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $result = array();
            try {
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
    }

    public function edit(){
        if ($this->request->is('post')) {

            $data = $this->request->data;
            $result = array();

            try {
                $this->MerchantQuickKey->id = $_GET['id'];
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
        $keys = $this->MerchantQuickKey->findById($_GET['id']);
        $this->set("keys",$keys);
    }
}
