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
        $this->loadModel('Country');
        $this->loadModel('Merchant');
        $this->loadModel('MerchantTaxRate');

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;
            
            $result = array();
            try {
                $this->Merchant->id = $user['merchant_id'];
                $this->Merchant->save($data);
                
                $this->Contact->id = $user['Merchant']['contact_id'];
                $this->Contact->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        } else if ($this->request->is('get')){
            $merchant = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id' => $user['merchant_id']
                )
            ));
            $this->set('merchant', $merchant);

            $countries = $this->Country->find('all');
            $this->set('countries',$countries);

            $taxes = $this->MerchantTaxRate->find('all', array(
                'conditions' => array(
                    'MerchantTaxRate.merchant_id' => $user['merchant_id']
                )
            ));
            $this->set('taxes', $taxes);
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
        $this->loadModel('MerchantRegister');
        $this->loadModel('MerchantQuickKey');
        $this->loadModel('MerchantReceiptTemplate');
        $this->loadModel('MerchantOutlet');
    
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
    	$user = $this->Auth->user();
    	
    	$this->loadModel('MerchantLoyalty');
    	
    	$loyalty = $this->MerchantLoyalty->findByMerchantId($user['merchant_id']);
    	$this->set('loyalty',$loyalty);
    	
    	if($this->request->is('post')) {
	    	$data = $this->request->data;
	    	$data['merchant_id'] = $user['merchant_id'];
	    	$result = array();
	    	try {
	    		if(empty($loyalty)){
		    		$this->MerchantLoyalty->create();
		    	} else {
			    	$this->MerchantLoyalty->id = $loyalty['MerchantLoyalty']['id'];
		    	}
		    	$this->MerchantLoyalty->save($data);
	    	} catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
    	}
    
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
