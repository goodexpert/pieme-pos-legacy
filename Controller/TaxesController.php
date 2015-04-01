<?php

App::uses('AppController', 'Controller');

class TaxesController extends AppController {

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
 * This controller uses MerchantTaxRate models.
 *
 * @var array
 */
    public $uses = array('MerchantTaxRate');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function add() {
        $user = $this->Auth->user();
        if($this->request->is('post')) {
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];
            
            $result = array();
            try {
                $this->MerchantTaxRate->create();
                $this->MerchantTaxRate->save($data);
                $result['id'] = $this->MerchantTaxRate->id;
                $result['data'] = $data;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function edit($id) {
        $user = $this->Auth->user();
        if($this->request->is('post')) {
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];
            
            $result = array();
            try {
                $this->MerchantTaxRate->id = $data['id'];
                $this->MerchantTaxRate->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function delete($id) {
        $user = $this->Auth->user();
        if($this->request->is('post')) {
            $result = array();
            try {
                $this->MerchantTaxRate->delete($_POST['id']);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
