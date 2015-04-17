<?php

App::uses('AppController', 'Controller');

class ReportsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array();

/**
 * Name of layout to use with this View.
 *
 * @var string
 */
    public $layout = 'home';

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

/**
 * Sales Totals by Period
 *
 * @return void
 */
    public function sales_by_period() {
    }

/**
 * Sales Totals by Month
 *
 * @return void
 */
    public function sales_by_month() {
    }

/**
 * Sales Totals by Day
 *
 * @return void
 */
    public function sales_by_day() {
    }

/**
 * Sales Activity by Hour
 *
 * @return void
 */
    public function sales_by_hour() {
    }

/**
 * Sales by Tag
 *
 * @return void
 */
    public function sales_by_category() {
    }

/**
 * Sales by Outlet
 *
 * @return void
 */
    public function sales_by_outlet() {
    }

/**
 * Register Sales Detail
 *
 * @return void
 */
    public function register_sales_detail() {
    }

/**
 * Payment Types by Month
 *
 * @return void
 */
    public function payments_by_month() {
    }

/**
 * Popular Products
 *
 * @return void
 */
    public function popular_products() {
    }

/**
 * Product Sales by Merchant User
 *
 * @return void
 */
    public function products_by_user() {
    }

/**
 * Product Sales by Customer
 *
 * @return void
 */
    public function products_by_customer() {
    }

/**
 * Product Sales by Customer Group
 *
 * @return void
 */
    public function products_by_customer_group() {
    }

/**
 * Product Sales by Type
 *
 * @return void
 */
    public function products_by_type() {
    }

/**
 * Product Sales by Outlet
 *
 * @return void
 */
    public function products_by_oulet() {
    }

/**
 * Product Sales by Supplier
 *
 * @return void
 */
    public function products_by_supplier() {
    }

/**
 * Register closure information
 *
 * @return void
 */
    public function stock_levels() {
    }

/**
 * Register closure information
 *
 * @return void
 */
    public function stock_low() {
    }

/**
 * Register closure information
 *
 * @return void
 */
    public function stock_onhand() {
    }

/**
 * Register closure information
 *
 * @return void
 */
    public function closures() {
    	$user = $this->Auth->user();
    	
    	$this->loadModel('MerchantOutlet');
    	$outlets = $this->MerchantOutlet->find('all', array(
    		'conditions' => array(
    			'MerchantOutlet.merchant_id' => $user['merchant_id']
    		)
    	));
    	$this->set('outlets',$outlets);
    	
    	$outlet_ids = array();
    	foreach($outlets as $outlet) {
        	array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
    	}
    	
    	$this->loadModel('MerchantRegister');
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        
        $register_ids = array();
        foreach($registers as $register) {
            array_push($register_ids,$register['MerchantRegister']['id']);
        }
        
        $this->loadModel('MerchantRegisterOpen');
        $this->MerchantRegisterOpen->bindModel(array(
            'belongsTo' => array(
                'MerchantRegister' => array(
                    'className' => 'MerchantRegister',
                    'foreignKey' => 'register_id'
                )
            )
        ));
        
        $criteria = array(
            'MerchantRegisterOpen.register_id' => $register_ids
        );
        
        if(isset($_GET)) {
            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == 'register_id') {
                        $criteria['MerchantRegisterOpen.'.$key] = $value;
                    } else if($key == 'outlet_id') {
                        $criteria['MerchantRegister.'.$key] = $value;
                    }
                }
            }
        }
        
        $closures = $this->MerchantRegisterOpen->find('all', array(
            'conditions' => $criteria
        ));
        $this->set('closures',$closures);

    }

}
