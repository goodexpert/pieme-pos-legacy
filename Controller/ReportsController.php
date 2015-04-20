<?php

App::uses('AppController', 'Controller');

class ReportsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array('MerchantOutlet', 'MerchantRegister', 'RegisterSale', 'RegisterSaleItem');

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
        $user = $this->Auth->user();
        
        if(isset($_GET['from'])) {
        
            $outlets = $this->MerchantOutlet->find('all', array(
                'conditions' => array(
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                )
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
            
            $register_ids = array();
            foreach($registers as $register) {
                array_push($register_ids, $register['MerchantRegister']['id']);
            }
            
            $criteria = array(
                'RegisterSale.register_id' => $register_ids
            );
            
            $this->RegisterSale->bindModel(array(
                'hasMany' => array(
                    'RegisterSaleItem' => array(
                        'className' => 'RegisterSaleItem',
                        'foreignKey' => 'sale_id'
                    )
                )
            ));
            
            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == 'from')
                        $criteria['RegisterSale.sale_date >='] = $value;
                    if($key == 'to')
                        $criteria['RegisterSale.sale_date <='] = $value;
                }
            }
            
            $sales = $this->RegisterSale->find('all', array(
                'conditions' => $criteria
            ));
            
            $this->set('sales',$sales);
        }
    }

/**
 * Sales Totals by Month
 *
 * @return void
 */
    public function sales_by_month() {
        $user = $this->Auth->user();

        if(isset($_GET['period'])) {

            $outlets = $this->MerchantOutlet->find('all', array(
                'conditions' => array(
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                )
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
            
            $register_ids = array();
            foreach($registers as $register) {
                array_push($register_ids, $register['MerchantRegister']['id']);
            }
            
            $criteria = array(
                'RegisterSale.register_id' => $register_ids
            );
            
            $this->RegisterSale->bindModel(array(
                'hasMany' => array(
                    'RegisterSaleItem' => array(
                        'className' => 'RegisterSaleItem',
                        'foreignKey' => 'sale_id'
                    )
                )
            ));

            $sales = array();
            $year = $_GET['year'];
            $month = $_GET['month'];

            for($i = 1;$i <= $_GET['period'];$i++) {
                if($month < 1) {
                    $year = $year - 1;
                    $month = 12;
                }
                $criteria['RegisterSale.sale_date >='] = $year.'-'.$month.'-01';
                $criteria['RegisterSale.sale_date <='] = $year.'-'.$month.'-31';
            
                $sales[$month] = $this->RegisterSale->find('all', array(
                    'conditions' => $criteria
                ));
                $month = $month - 1;
            }
            $this->set('sales',$sales);
        }
    }

/**
 * Sales Totals by Day
 *
 * @return void
 */
    public function sales_by_day() {
        $user = $this->Auth->user();
        
        if(isset($_GET['from'])) {
        
            $outlets = $this->MerchantOutlet->find('all', array(
                'conditions' => array(
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                )
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
            
            $register_ids = array();
            foreach($registers as $register) {
                array_push($register_ids, $register['MerchantRegister']['id']);
            }
            
            $criteria = array(
                'RegisterSale.register_id' => $register_ids
            );
            
            $interval = new DateInterval('P1D');
            $begin = new DateTime(date('Y-m-d'));
            $begin = $begin->modify( '-60 day' );
            $end = new DateTime(date('Y-m-d'));
            
            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == 'from') {
                        $criteria['RegisterSale.sale_date >='] = $value;
                        $begin = new DateTime($value);
                    }
                    if($key == 'to') {
                        $criteria['RegisterSale.sale_date <='] = $value;
                        $end = new DateTime($value);
                    }
                }
            }
            
            $end = $end->modify( '+1 day' );

            $daterange = new DatePeriod($begin, $interval ,$end);

            $sales = array();

            foreach($daterange as $date) {
                $sales[$date->format("Y-m-d")] = array();
                $targetSale = $this->RegisterSale->find('all', array(
                    'conditions' => array(
                        'RegisterSale.sale_date >=' => $date->format("Y-m-d 00:00:00"),
                        'RegisterSale.sale_date <=' => $date->format("Y-m-d 23:59:59")
                    )
                ));
                if(!empty($targetSale))
                    foreach($targetSale as $saleData)
                        array_push($sales[$date->format("Y-m-d")], $saleData);
            }

            $this->RegisterSale->bindModel(array(
                'hasMany' => array(
                    'RegisterSaleItem' => array(
                        'className' => 'RegisterSaleItem',
                        'foreignKey' => 'sale_id'
                    )
                )
            ));
            $this->set('sales',$sales);
        }
    }

/**
 * Sales Activity by Hour
 *
 * @return void
 */
    public function sales_by_hour() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        
        $outlet_ids = array();
        foreach($outlets as $outlet) {
            array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
        }
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
               'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);

        if(isset($_GET['from'])) {

            $register_ids = array();
            foreach($registers as $register) {
                array_push($register_ids, $register['MerchantRegister']['id']);
            }

            $criteria = array(
                'RegisterSale.register_id' => $register_ids
            );

            $interval = new DateInterval('P1D');
            $begin = new DateTime('2015-04-10');
            $end = new DateTime('2015-04-30');
            
            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == 'from') {
                        $criteria['RegisterSale.sale_date >='] = $value;
                        $begin = new DateTime($value);
                    }
                    if($key == 'to') {
                        $criteria['RegisterSale.sale_date <='] = $value;
                        $end = new DateTime($value);
                    }
                }
            }

            $end = $end->modify( '+1 day' );
            $daterange = new DatePeriod($begin, $interval ,$end);

            $sales = array();

            foreach($daterange as $date) {
                $sales[$date->format("Y-m-d")] = array();
                $targetSale = $this->RegisterSale->find('all', array(
                    'conditions' => array(
                        'RegisterSale.sale_date >=' => $date->format("Y-m-d 00:00:00"),
                        'RegisterSale.sale_date <=' => $date->format("Y-m-d 23:59:59")
                    )
                ));
                if(!empty($targetSale))
                    foreach($targetSale as $saleData)
                        array_push($sales[$date->format("Y-m-d")], $saleData);
            }

            $this->RegisterSale->bindModel(array(
                'hasMany' => array(
                    'RegisterSaleItem' => array(
                        'className' => 'RegisterSaleItem',
                        'foreignKey' => 'sale_id'
                    )
                )
            ));
            $this->set('sales',$sales);
        }
    }

/**
 * Sales by Tag
 *
 * @return void
 */
    public function sales_by_category() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductTag');

        $this->MerchantProductCategory->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                ),
                'MerchantProductTag' => array(
                    'className' => 'MerchantProductTag',
                    'foreignKey' => 'product_tag_id'
                )
            )
        ));
        
        $category = $this->MerchantProductCategory->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $user['merchant_id']
            )
        ));
        
        $tagArray = [];
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        
        foreach($tags as $tag) {
            $tagArray[$tag['MerchantProductTag']['name']] = array();
        }
        
        foreach($category as $ct) {
            array_push($tagArray[$ct['MerchantProductTag']['name']], $ct);
        }
    
        $this->set('tag',$tagArray);
    
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
