<?php

App::uses('AppController', 'Controller');

class AccountController extends AppController {

/**
 * Name of layout to use with this View.
 *
 * @var string
 */
    public $layout = 'home';

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array();

    public $components = array('RequestHandler');

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
        $this->loadModel("Plan");
        $this->loadModel("MerchantOutlet");
        $this->loadModel("MerchantRegister");
        $this->loadModel("MerchantUser");
        $this->loadModel("MerchantProduct");
        $this->loadModel("MerchantCustomer");
        
        $plans = $this->Plan->find('all');
        $this->set('plans',$plans);
        
        $outletCriteria = array();
        $userCriteria = array();
        if(empty($user['retailer_id'])) {
            $outletCriteria['MerchantOutlet.merchant_id'] = $user['merchant_id'];
            $userCriteria['MerchantUser.merchant_id'] = $user['merchant_id'];
        } else {
            $outletCriteria['MerchantOutlet.retailer_id'] = $user['retailer_id'];
            $userCriteria['MerchantUser.retailer_id'] = $user['retailer_id'];
        }
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => $outletCriteria
        ));
        $outlet_ids = array();
        foreach($outlets as $outlet) {
            array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
        }
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $users = $this->MerchantUser->find('all', array(
            'conditions' => $userCriteria
        ));
        $products = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $user['merchant_id']
            )
        ));
        $customers = $this->MerchantCustomer->find('all', array(
            'conditions' => array(
                'MerchantCustomer.merchant_id' => $user['merchant_id'],
                'NOT' => array(
                    'MerchantCustomer.customer_code' => 'walkin'
                )
            )
        ));
        $this->set("total_outlet", count($outlets));
        $this->set("total_register", count($registers));
        $this->set("total_user", count($users));
        $this->set("total_product", count($products));
        $this->set("total_customer", count($customers));
    }

    public function update_plan() {
        $this->loadModel("Merchant");
        $this->loadModel("Retailer");
        $this->loadModel("Plan");
        $user = $this->Auth->user();
        
        if($this->request->is('post')) {
            
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                if(empty($user['retailer_id'])){
                    $this->Merchant->id = $user['merchant_id'];
                    $this->Merchant->save($data);
                } else {
                    $this->Retailer->id = $user['retailer_id'];
                    $this->Retailer->save($data);
                }
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
