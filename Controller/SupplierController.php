<?php

App::uses('AppController', 'Controller');

class SupplierController extends AppController {

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
 * This controller uses Contact and MerchantSupplier models.
 *
 * @var array
 */
    public $uses = array('Contact', 'MerchantSupplier');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
    
        $this->loadModel("MerchantSupplier");
        $suppliers = $this->MerchantSupplier->find('all',array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
        $this->set("suppliers",$suppliers);

    }

    public function add() {
    
        $this->loadModel("MerchantSupplier");
        $this->loadModel("Contact");
        $this->loadModel("Country");
        
        $countries = $this->Country->find('all');
        $this->set('countries',$countries);
        
        $result = array(
            'success' => false
        );
        
        if($this->request->is('post')) {
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                
                if(empty($data['physical_country']))
                    unset($data['physical_country']);
                    
                if(empty($data['postal_country']))
                    unset($data['postal_country']);
                
                $this->Contact->create();
                $this->Contact->save($data);
                
                $data['contact_id'] = $this->Contact->id;
                
                $this->MerchantSupplier->create();
                $this->MerchantSupplier->save($data);
                
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }

    public function quick_add() {
        $data = $this->request->data;
        $result = array();
        try {
            $this->Contact->create();
            $this->Contact->save($data);
            
            $this->MerchantSupplier->create();
            $supplier['MerchantSupplier']['merchant_id'] = $this->Auth->user()['merchant_id'];
            $supplier['MerchantSupplier']['contact_id'] = $this->Contact->id;
            $supplier['MerchantSupplier']['name'] = $_POST['name'];
            $supplier['MerchantSupplier']['description'] = $_POST['description'];
            $this->MerchantSupplier->save($supplier);
            $result['id'] = $this->MerchantSupplier->id;
            $result['name'] = $_POST['name'];
        } catch  (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
    }

    public function edit() {
        $this->loadModel("Country");
        $countries = $this->Country->find('all');
        $this->set('countries',$countries);
        
        $this->loadModel("MerchantSupplier");
        $supplier = $this->MerchantSupplier->findById($_GET['id']);
        $this->set("supplier",$supplier);
        
        $this->loadModel("MerchantSupplier");
        $this->loadModel("Contact");
        
        if($this->request->is('post')){
            $result = array();
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                
                if(empty($data['physical_country']))
                    unset($data['physical_country']);
                    
                if(empty($data['postal_country']))
                    unset($data['postal_country']);

                $this->Contact->id = $data['contact_id'];
                $this->Contact->save($data);

                $this->MerchantSupplier->id = $data['supplier_id'];
                $this->MerchantSupplier->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function delete() {
        $this->loadModel('MerchantSupplier');
        
        if($this->request->is('post')){
            $result = array();
            try {
                $this->MerchantSupplier->delete($_POST['id']);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
