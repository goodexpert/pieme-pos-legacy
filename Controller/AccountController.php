<?php

App::uses('AppController', 'Controller');

class AccountController extends AppController {

    // Authorized : Account can access only admin
    public function isAuthorized($user = null) {
        if (isset($user['user_type_id'])) {
            return (bool)($user['user_type_id'] === 'user_type_admin');
        }

        // Default deny
        return false;
    }
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
    public $uses = array();

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

        $plans = $this->Plan->find('all', array(
            'order' => array('Plan.price ASC')
        ));
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
        $this->loadModel("MerchantRetailer");
        $this->loadModel("Plan");
        $this->loadModel("MerchantUser");
        $user = $this->Auth->user();

        if($this->request->is('post')) {
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                if(empty($user['retailer_id'])){
                    if(strpos($data['plan_id'],"franchise") !== false && strpos($data['plan_id'],"hq") == false) {
                        $this->MerchantRetailer->create();
                        $this->MerchantRetailer->save($data);

                        //$this->Merchant->delete($user['merchant_id']);

                        $this->MerchantUser->id = $user['id'];
                        $userData['MerchantUser']['merchant_id'] = $data['merchant_id'];
                        $userData['MerchantUser']['retailer_id'] = $this->MerchantRetailer->id;
                        $this->MerchantUser->save($userData);
                    } else {
                        $this->Merchant->id = $user['merchant_id'];
                        $this->Merchant->save($data);
                    }
                } else {
                    $this->MerchantRetailer->id = $user['retailer_id'];
                    $this->MerchantRetailer->save($data);
                }
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
