<?php

App::uses('AppController', 'Controller');

class SetupController extends AppController {

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
 * This controller does not use a model
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

    public function index() {
        $user = $this->Auth->user();

        $this->loadModel('Contact');
        $this->loadModel('Merchant');
        $this->loadModel('MerchantTaxRate');

        if ($this->request->is('ajax') || $this->request->is('post')) {
            //General save here
        } else if ($this->request->is('get')){
            $merchant = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id' => $user['merchant_id']
                )
            ));
            $this->set('merchant', $merchant);

            $taxes = $this->MerchantTaxRate->find('all', array(
                'conditions' => array(
                    'MerchantTaxRate.merchant_id' => $user['merchant_id']
                )
            ));
            $this->set('taxes', $taxes);
        }
    }
    
    public function edit() {
        $user = $this->Auth->user();
        
        $this->loadModel("Merchant");
        $this->loadModel("Contact");
        
        if($this->request->is('put')) {
            $data = $this->request->data;
            
            $result = array();
            try {
                $this->Merchant->id = $user['merchant_id'];
                $this->Merchant->save($data);
                
                $this->Contact->id = $user['Merchant']['contact_id'];
                $this->Contact->save($data);
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            var_dump($result);
            exit();
        }
    }

    public function payments() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantPaymentType');

        $payments = $this->MerchantPaymentType->find('all', array(
            'conditions' => array(
                'MerchantPaymentType.merchant_id' => $user['merchant_id']
            ),
            'order' => array(
                'MerchantPaymentType.name ASC'
            )
        ));
        $this->set("payments", $payments);
    }

    public function outlets_and_registers() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantOutlet');
        $this->MerchantOutlet->bindModel(array(
            'hasMany' => array(
                'MerchantRegister' => array(
                    'className' => 'MerchantRegister',
                    'foreignKey' => 'outlet_id'
                )
            ),
        ));

        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("outlets", $outlets);
    }

    public function taxes() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantTaxRate');

        $taxes = $this->MerchantTaxRate->find('all', array(
            'conditions' => array(
                'MerchantTaxRate.merchant_id' => $user['merchant_id']
            ),
            'order' => array(
                'MerchantTaxRate.name ASC'
            )
        ));
        $this->set("taxes", $taxes);
    }

    public function quick_keys() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantQuickKey');

        $items = $this->MerchantQuickKey->find('all', array(
            'conditions' => array(
                'MerchantQuickKey.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("items",$items);
    }

    public function loyalty() {
    }

    public function user() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantUser');

        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users', $users);
    }

}
