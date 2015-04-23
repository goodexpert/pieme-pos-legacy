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
            
            $interval = new DateInterval('P1D');
            $begin = new DateTime(date('Y-m-d'));
            $begin = $begin->modify( '-60 day' );
            $end = new DateTime(date('Y-m-d'));
            
            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == 'from')
                        $begin = new DateTime(date($value));
                        $criteria['RegisterSale.sale_date >='] = $value;
                    if($key == 'to')
                        $end = new DateTime(date($value));
                        $criteria['RegisterSale.sale_date <='] = $value;
                }
            }

            $daterange = new DatePeriod($begin, $interval ,$end);
            $diff = 0;
            foreach($daterange as $dara) {
                $diff++;
            }
            
            for($i = 0;$i <= $_GET['period'] - 1;$i++){
                $st = date('Y-m-d',strtotime($begin->format('Y-m-d').' - '.$diff * $i.' day'));
                $en = date('Y-m-d',strtotime($end->format('Y-m-d').' - '.($diff * $i).' day'));
                
                $criteria['RegisterSale.sale_date >='] = $st;
                $criteria['RegisterSale.sale_date <='] = $en;
                
                $sales[$st.'~'.$en] = $this->RegisterSale->find('all', array(
                    'conditions' => $criteria
                ));
            }
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
        
            $outletCriteria = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(isset($_GET['outlet_id']) && !empty($_GET['outlet_id'])) {
                $outletCriteria['MerchantOutlet.id'] = $_GET['outlet_id'];
            }
            
            $outletFilter = $this->MerchantOutlet->find('all',array(
                'conditions' => $outletCriteria
            ));
            $outletFilter_ids = array();
            foreach($outletFilter as $otf) {
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);
            }
            
            $registerCriteria = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(isset($_GET['register_id']) && !empty($_GET['register_id'])) {
                $registerCriteria['MerchantRegister.id'] = $_GET['register_id'];
            }
            
            $registerFilter = $this->MerchantRegister->find('all',array(
                'conditions' => $registerCriteria
            ));

            $register_ids = array();
            foreach($registerFilter as $register) {
                array_push($register_ids, $register['MerchantRegister']['id']);
            }

            $criteria = array(
                'RegisterSale.register_id' => $register_ids
            );
            if(isset($_GET['user_id']) && !empty($_GET['user_id'])) {
                $criteria['RegisterSale.user_id'] = $_GET['user_id'];
            }

            $interval = new DateInterval('P1D');
            $begin = new DateTime(date('Y-m-d'));
            $begin = $begin->modify( '-60 day' );
            $end = new DateTime(date('Y-m-d'));

            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == 'from') {
                        $begin = new DateTime($value);
                    }
                    if($key == 'to') {
                        $end = new DateTime($value);
                    }
                }
            }

            $end = $end->modify( '+1 day' );
            $daterange = new DatePeriod($begin, $interval ,$end);

            $sales = array();

            foreach($daterange as $date) {
                $sales[$date->format("Y-m-d")] = array();
                for($i = 0;$i <= 23;$i++) {
                    $sales[$date->format("Y-m-d")][$i] = array();
                
                    $criteria['RegisterSale.sale_date >='] = $date->format("Y-m-d ".$i.":00:00");
                    $criteria['RegisterSale.sale_date <='] = $date->format("Y-m-d ".$i.":59:59");
                    $targetSale = $this->RegisterSale->find('all', array(
                        'conditions' => $criteria
                    ));
                    if(!empty($targetSale))
                        foreach($targetSale as $saleData)
                            array_push($sales[$date->format("Y-m-d")][$i], $saleData);
                }
            }
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
        
        if(isset($_GET['from'])) {

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
            
            $tagArray = array();
            
            $tags = $this->MerchantProductTag->find('all', array(
                'conditions' => array(
                    'MerchantProductTag.merchant_id' => $user['merchant_id']
                )
            ));
            
            foreach($tags as $tag) {
                $tagArray[$tag['MerchantProductTag']['id']] = array(
                    'name' => $tag['MerchantProductTag']['name']
                );
            }
            
            foreach($category as $cat) {
                $tagArray[$cat['MerchantProductCategory']['product_tag_id']]['products'][$cat['MerchantProductCategory']['product_id']] = array();
    
                $criteria = array(
                    'RegisterSaleItem.product_id' => $cat['MerchantProductCategory']['product_id']
                );
                if(!empty($_GET['from']))
                    $criteria['RegisterSaleItem.created >='] = $_GET['from'];
                if(!empty($_GET['to']))
                    $criteria['RegisterSaleItem.created <='] = $_GET['to'];

                $sales = $this->RegisterSaleItem->find('all', array(
                    'conditions' => $criteria
                ));
                
                array_push($tagArray[$cat['MerchantProductCategory']['product_tag_id']]['products'][$cat['MerchantProductCategory']['product_id']], $sales);
            }
    
            $this->set('tags',$tagArray);
        }
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
        $user = $this->Auth->user();
        
        $this->loadModel("MerchantCustomerGroup");
        $this->loadModel("MerchantCustomer");
        
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
        
        $customerGroups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('customerGroups',$customerGroups);
        
        if(isset($_GET['from'])) {
            $criteriaOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaOutlet
            ));
            $outletFilter_ids = array();
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);

            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            $registerFilter_ids = array();
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);
            
            $customer_ids = array();
            if(!empty($_GET['customer_group_id'])) {
                $customers = $this->MerchantCustomer->find('all', array(
                    'conditions' => array(
                        'MerchantCustomer.customer_group_id' => $_GET['customer_group_id']
                    )
                ));
                foreach($customers as $customer)
                    array_push($customer_ids, $customer['MerchantCustomer']['id']);
            }
            
            $this->RegisterSaleItem->bindModel(array(
                'belongsTo' => array(
                    'MerchantProduct' => array(
                        'className' => 'MerchantProduct',
                        'foreignKey' => 'product_id'
                    )
                )
            ));

            $this->RegisterSale->bindModel(array(
                'hasMany' => array(
                    'RegisterSaleItem' => array(
                        'className' => 'RegisterSaleItem',
                        'foreignKey' => 'sale_id'
                    ),
                    'RegisterSalePayment' => array(
                        'className' => 'RegisterSalePayment',
                        'foreignKey' => 'sale_id'
                    )
                ),
                'belongsTo' => array(
                    'MerchantRegister' => array(
                        'className' => 'MerchantRegister',
                        'foreignKey' => 'register_id'
                    ),
                    'MerchantUser' => array(
                        'className' => 'MerchantUser',
                        'foreignKey' => 'user_id'
                    ),
                    'MerchantCustomer' => array(
                        'className' => 'MerchantCustomer',
                        'foreignKey' => 'customer_id'
                    )
                )
            ));
            
            $this->RegisterSale->recursive = 2;

            $criteria = array(
                'RegisterSale.register_id' => $registerFilter_ids
            );
            if(!empty($customer_ids))
                $criteria['RegisterSale.customer_id'] = $customer_ids;
            $sales = $this->RegisterSale->find('all', array(
                'conditions' => $criteria
            ));

            $this->set('sales',$sales);
        }
    }

/**
 * Payment Types by Month
 *
 * @return void
 */
    public function payments_by_month() {
        $user = $this->Auth->user();

        if(isset($_GET['period'])) {
            $this->loadModel("RegisterSalePayment");
            $this->loadModel("MerchantPaymentType");

            $paymentTypes = $this->MerchantPaymentType->find('all', array(
                'conditons' => array(
                    'MerchantPaymentType.merchant_id' => $user['merchant_id']
                )
            ));

            $sales = array();
            $criteria = array();

            foreach($paymentTypes as $paymentType) {
                $year = $_GET['year'];
                $month = $_GET['month'];
                for($i = 1;$i <= $_GET['period'];$i++) {
                    if($month < 1) {
                        $year = $year - 1;
                        $month = 12;
                    }
                    $criteria['RegisterSalePayment.payment_date >='] = $year.'-'.$month.'-01';
                    $criteria['RegisterSalePayment.payment_date <='] = $year.'-'.$month.'-31';
    
                    $criteria['RegisterSalePayment.merchant_payment_type_id'] = $paymentType['MerchantPaymentType']['id'];
                    $sales[$paymentType['MerchantPaymentType']['name']][$month] = $this->RegisterSalePayment->find('all', array(
                        'conditions' => $criteria
                    ));

                    $month = $month - 1;
                }
            }
            $this->set('sales',$sales);
            
        }
    
    }

/**
 * Popular Products
 *
 * @return void
 */
    public function popular_products() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantCustomerGroup');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProductTag');
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        $outlet_ids = array();
        foreach($outlets as $outlet)
            array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);
        
        if(isset($_GET['from'])) {
            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            
            $outletFilter_ids = array();
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);


            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];

            $registerFilter_ids = array();
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);

            $criteriaRegisterSale = array(
                'RegisterSale.register_id' => $registerFilter_ids
            );
            if(!empty($_GET['user_id']))
                $criteriaRegisterSale['RegisterSale.user_id'] = $_GET['user_id'];
            if(!empty($_GET['from']))
                $criteriaRegisterSale['RegisterSale.sale_date >='] = $_GET['from'];
            if(!empty($_GET['to']))
                $criteriaRegisterSale['RegisterSale.sale_date <='] = $_GET['to'];

            $this->MerchantProductCategory->bindModel(array(
                'belongsTo' => array(
                    'MerchantProductTag' => array(
                        'className' => 'MerchantProductTag',
                        'foreignKey' => 'product_tag_id'
                    )
                )
            ));
            
            $this->RegisterSaleItem->bindModel(array(
                'belongsTo' => array(
                    'RegisterSale' => array(
                        'className' => 'RegisterSale',
                        'foreignKey' => 'sale_id',
                        'conditions' => $criteriaRegisterSale
                    )
                )
            ));
            $tag_ids = array();
            if(!empty($_GET['tag'])) {
                $tagData = $_GET['tag'];
                foreach($tagData as $td){
                    array_push($tag_ids, $this->MerchantProductTag->find('all',array(
                        'conditions'=>array(
                            'MerchantProductTag.name'=>$td,
                            'MerchantProductTag.merchant_id'=>$user['merchant_id']
                        )
                    ))[0]['MerchantProductTag']['id']);
                }
            }
        
            $this->MerchantProduct->bindModel(array(
                'hasMany' => array(
                    'RegisterSaleItem' => array(
                        'className' => 'RegisterSaleItem',
                        'foreignKey' => 'product_id'
                    ),
                    'MerchantProductCategory' => array(
                        'className' => 'MerchantProductCategory',
                        'foreignKey' => 'product_id',
                        'conditions' => array(
                            'MerchantProductCategory.product_tag_id' => $tag_ids
                        )
                    )
                ),
                'belongsTo' => array(
                    'MerchantProductBrand' => array(
                        'className' => 'MerchantProductBrand',
                        'foreignKey' => 'product_brand_id'
                    ),
                    'MerchantProductType' => array(
                        'className' => 'MerchantProductType',
                        'foreignKey' => 'product_type_id'
                    ),
                    'MerchantSupplier' => array(
                        'className' => 'MerchantSupplier',
                        'foreignKey' => 'supplier_id'
                    )
                )
            ));
            
            $this->MerchantProduct->recursive = 2;
            
            $criteriaMerchantProduct = array(
                'MerchantProduct.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['product_brand_id']))
                $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
            if(!empty($_GET['product_type_id']))
                $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
            if(!empty($_GET['supplier_id']))
                $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];
        
            $products = $this->MerchantProduct->find('all', array(
                'conditions' => $criteriaMerchantProduct
            ));

            $this->set('products',$products);
        }
    }

/**
 * Product Sales by Merchant User
 *
 * @return void
 */
    public function products_by_user() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantCustomerGroup');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProductTag');
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        $outlet_ids = array();
        foreach($outlets as $outlet)
            array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);
        
        if(isset($_GET['from'])) {
                
            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            
            $outletFilter_ids = array();
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);


            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];

            $registerFilter_ids = array();
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);

            $criteriaMerchantUser = array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['user_id'])) {
                $criteriaMerchantUser['MerchantUser.id'] = $_GET['user_id'];
            }
            $users = $this->MerchantUser->find('all', array(
                'conditions' => $criteriaMerchantUser
            ));
            $datas = array();
            foreach($users as $us) {
                $criteriaRegisterSale = array(
                    'RegisterSale.register_id' => $registerFilter_ids,
                    'RegisterSale.user_id' => $us['MerchantUser']['id']
                );
                if(!empty($_GET['user_id']))
                    $criteriaRegisterSale['RegisterSale.user_id'] = $_GET['user_id'];
                if(!empty($_GET['from']))
                    $criteriaRegisterSale['RegisterSale.sale_date >='] = $_GET['from'];
                if(!empty($_GET['to']))
                    $criteriaRegisterSale['RegisterSale.sale_date <='] = $_GET['to'];
    
                $this->MerchantProductCategory->bindModel(array(
                    'belongsTo' => array(
                        'MerchantProductTag' => array(
                            'className' => 'MerchantProductTag',
                            'foreignKey' => 'product_tag_id'
                        )
                    )
                ));
                
                
                $this->RegisterSaleItem->bindModel(array(
                    'belongsTo' => array(
                        'RegisterSale' => array(
                            'className' => 'RegisterSale',
                            'foreignKey' => 'sale_id',
                            'conditions' => $criteriaRegisterSale
                        )
                    )
                ));
                $tag_ids = array();
                if(!empty($_GET['tag'])) {
                    $tagData = $_GET['tag'];
                    foreach($tagData as $td){
                        array_push($tag_ids, $this->MerchantProductTag->find('all',array(
                            'conditions'=>array(
                                'MerchantProductTag.name'=>$td,
                                'MerchantProductTag.merchant_id'=>$user['merchant_id']
                            )
                        ))[0]['MerchantProductTag']['id']);
                    }
                }
            
                $this->MerchantProduct->bindModel(array(
                    'hasMany' => array(
                        'RegisterSaleItem' => array(
                            'className' => 'RegisterSaleItem',
                            'foreignKey' => 'product_id'
                        ),
                        'MerchantProductCategory' => array(
                            'className' => 'MerchantProductCategory',
                            'foreignKey' => 'product_id',
                            'conditions' => array(
                                'MerchantProductCategory.product_tag_id' => $tag_ids
                            )
                        )
                    ),
                    'belongsTo' => array(
                        'MerchantProductBrand' => array(
                            'className' => 'MerchantProductBrand',
                            'foreignKey' => 'product_brand_id'
                        ),
                        'MerchantProductType' => array(
                            'className' => 'MerchantProductType',
                            'foreignKey' => 'product_type_id'
                        ),
                        'MerchantSupplier' => array(
                            'className' => 'MerchantSupplier',
                            'foreignKey' => 'supplier_id'
                        )
                    )
                ));
                
                $this->MerchantProduct->recursive = 2;
                
                $criteriaMerchantProduct = array(
                    'MerchantProduct.merchant_id' => $user['merchant_id']
                );
                if(!empty($_GET['product_brand_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
                if(!empty($_GET['product_type_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
                if(!empty($_GET['supplier_id']))
                    $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];
            
                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => $criteriaMerchantProduct
                ));
                
                $datas[$us['MerchantUser']['username']] = $products;
    
                $this->set('datas',$datas);
            }
        }
    }

/**
 * Product Sales by Customer
 *
 * @return void
 */
    public function products_by_customer() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantCustomerGroup');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProductTag');
        $this->loadModel('MerchantCustomer');
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        $outlet_ids = array();
        foreach($outlets as $outlet)
            array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);
        
        if(isset($_GET['from'])) {
                
            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            
            $outletFilter_ids = array();
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);


            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];

            $registerFilter_ids = array();
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);

            $criteriaMerchantCustomer = array(
                'MerchantCustomer.merchant_id' => $user['merchant_id'],
                'NOT' => array(
                    'MerchantCustomer.name' => ' '
                )
            );
            if(!empty($_GET['customer_id'])) {
                $criteriaMerchantCustomer['MerchantCustomer.id'] = $_GET['customer_id'];
            }
            $customers = $this->MerchantCustomer->find('all', array(
                'conditions' => $criteriaMerchantCustomer
            ));
            $datas = array();
            foreach($customers as $us) {
                $criteriaRegisterSale = array(
                    'RegisterSale.register_id' => $registerFilter_ids,
                    'RegisterSale.customer_id' => $us['MerchantCustomer']['id']
                );
                if(!empty($_GET['user_id']))
                    $criteriaRegisterSale['RegisterSale.user_id'] = $_GET['user_id'];
                if(!empty($_GET['from']))
                    $criteriaRegisterSale['RegisterSale.sale_date >='] = $_GET['from'];
                if(!empty($_GET['to']))
                    $criteriaRegisterSale['RegisterSale.sale_date <='] = $_GET['to'];

                $this->MerchantProductCategory->bindModel(array(
                    'belongsTo' => array(
                        'MerchantProductTag' => array(
                            'className' => 'MerchantProductTag',
                            'foreignKey' => 'product_tag_id'
                        )
                    )
                ));
                
                
                $this->RegisterSaleItem->bindModel(array(
                    'belongsTo' => array(
                        'RegisterSale' => array(
                            'className' => 'RegisterSale',
                            'foreignKey' => 'sale_id',
                            'conditions' => $criteriaRegisterSale
                        )
                    )
                ));
                $tag_ids = array();
                if(!empty($_GET['tag'])) {
                    $tagData = $_GET['tag'];
                    foreach($tagData as $td){
                        array_push($tag_ids, $this->MerchantProductTag->find('all',array(
                            'conditions'=>array(
                                'MerchantProductTag.name'=>$td,
                                'MerchantProductTag.merchant_id'=>$user['merchant_id']
                            )
                        ))[0]['MerchantProductTag']['id']);
                    }
                }
            
                $this->MerchantProduct->bindModel(array(
                    'hasMany' => array(
                        'RegisterSaleItem' => array(
                            'className' => 'RegisterSaleItem',
                            'foreignKey' => 'product_id'
                        ),
                        'MerchantProductCategory' => array(
                            'className' => 'MerchantProductCategory',
                            'foreignKey' => 'product_id',
                            'conditions' => array(
                                'MerchantProductCategory.product_tag_id' => $tag_ids
                            )
                        )
                    ),
                    'belongsTo' => array(
                        'MerchantProductBrand' => array(
                            'className' => 'MerchantProductBrand',
                            'foreignKey' => 'product_brand_id'
                        ),
                        'MerchantProductType' => array(
                            'className' => 'MerchantProductType',
                            'foreignKey' => 'product_type_id'
                        ),
                        'MerchantSupplier' => array(
                            'className' => 'MerchantSupplier',
                            'foreignKey' => 'supplier_id'
                        )
                    )
                ));
                
                $this->MerchantProduct->recursive = 2;
                
                $criteriaMerchantProduct = array(
                    'MerchantProduct.merchant_id' => $user['merchant_id']
                );
                if(!empty($_GET['product_brand_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
                if(!empty($_GET['product_type_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
                if(!empty($_GET['supplier_id']))
                    $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];
            
                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => $criteriaMerchantProduct
                ));
                
                $datas[$us['MerchantCustomer']['name']] = $products;
    
                $this->set('datas',$datas);
            }
        }
    }

/**
 * Product Sales by Customer Group
 *
 * @return void
 */
    public function products_by_customer_group() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantCustomerGroup');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProductTag');
        $this->loadModel('MerchantCustomer');
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        $outlet_ids = array();
        foreach($outlets as $outlet)
            array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);
        
        if(isset($_GET['from'])) {
                
            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            
            $outletFilter_ids = array();
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);


            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];

            $registerFilter_ids = array();
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);

            $criteriaMerchantCustomerGroup = array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['customer_group_id'])) {
                $criteriaMerchantCustomerGroup['MerchantCustomerGroup.id'] = $_GET['customer_group_id'];
            }
            $customerGrps = $this->MerchantCustomerGroup->find('all', array(
                'conditions' => $criteriaMerchantCustomerGroup
            ));
            $datas = array();
            foreach($customerGrps as $us) {
                $cts = $this->MerchantCustomer->find('all', array(
                    'conditions' => array(
                        'MerchantCustomer.customer_group_id' => $us['MerchantCustomerGroup']['id']
                    )
                ));
                $cts_ids = array();
                foreach($cts as $ct) {
                    array_push($cts_ids,$ct['MerchantCustomer']['id']);
                }
                $criteriaRegisterSale = array(
                    'RegisterSale.register_id' => $registerFilter_ids,
                    'RegisterSale.customer_id' => $cts_ids
                );
                $this->set('afef',$cts_ids);
                if(!empty($_GET['user_id']))
                    $criteriaRegisterSale['RegisterSale.user_id'] = $_GET['user_id'];
                if(!empty($_GET['from']))
                    $criteriaRegisterSale['RegisterSale.sale_date >='] = $_GET['from'];
                if(!empty($_GET['to']))
                    $criteriaRegisterSale['RegisterSale.sale_date <='] = $_GET['to'];

                $this->MerchantProductCategory->bindModel(array(
                    'belongsTo' => array(
                        'MerchantProductTag' => array(
                            'className' => 'MerchantProductTag',
                            'foreignKey' => 'product_tag_id'
                        )
                    )
                ));
                
                
                $this->RegisterSaleItem->bindModel(array(
                    'belongsTo' => array(
                        'RegisterSale' => array(
                            'className' => 'RegisterSale',
                            'foreignKey' => 'sale_id',
                            'conditions' => $criteriaRegisterSale
                        )
                    )
                ));
                $tag_ids = array();
                if(!empty($_GET['tag'])) {
                    $tagData = $_GET['tag'];
                    foreach($tagData as $td){
                        array_push($tag_ids, $this->MerchantProductTag->find('all',array(
                            'conditions'=>array(
                                'MerchantProductTag.name'=>$td,
                                'MerchantProductTag.merchant_id'=>$user['merchant_id']
                            )
                        ))[0]['MerchantProductTag']['id']);
                    }
                }
            
                $this->MerchantProduct->bindModel(array(
                    'hasMany' => array(
                        'RegisterSaleItem' => array(
                            'className' => 'RegisterSaleItem',
                            'foreignKey' => 'product_id'
                        ),
                        'MerchantProductCategory' => array(
                            'className' => 'MerchantProductCategory',
                            'foreignKey' => 'product_id',
                            'conditions' => array(
                                'MerchantProductCategory.product_tag_id' => $tag_ids
                            )
                        )
                    ),
                    'belongsTo' => array(
                        'MerchantProductBrand' => array(
                            'className' => 'MerchantProductBrand',
                            'foreignKey' => 'product_brand_id'
                        ),
                        'MerchantProductType' => array(
                            'className' => 'MerchantProductType',
                            'foreignKey' => 'product_type_id'
                        ),
                        'MerchantSupplier' => array(
                            'className' => 'MerchantSupplier',
                            'foreignKey' => 'supplier_id'
                        )
                    )
                ));
                
                $this->MerchantProduct->recursive = 2;
                
                $criteriaMerchantProduct = array(
                    'MerchantProduct.merchant_id' => $user['merchant_id']
                );
                if(!empty($_GET['product_brand_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
                if(!empty($_GET['product_type_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
                if(!empty($_GET['supplier_id']))
                    $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];
            
                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => $criteriaMerchantProduct
                ));
                
                $datas[$us['MerchantCustomerGroup']['name']] = $products;
    
                $this->set('datas',$datas);
            }
        }
    }

/**
 * Product Sales by Type
 *
 * @return void
 */
    public function products_by_type() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantCustomerGroup');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProductTag');
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        $outlet_ids = array();
        foreach($outlets as $outlet)
            array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);
        
        if(isset($_GET['from'])) {
                
            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            
            $outletFilter_ids = array();
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);


            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];

            $registerFilter_ids = array();
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);

            $criteriaMerchantProductType = array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            );
            
            if(!empty($_GET['product_type_id'])) {
                $criteriaMerchantProductType['MerchantProductType.id'] = $_GET['product_type_id'];
            }
            $typs = $this->MerchantProductType->find('all', array(
                'conditions' => $criteriaMerchantProductType
            ));
            $datas = array();
            foreach($typs as $us) {
                $criteriaRegisterSale = array(
                    'RegisterSale.register_id' => $registerFilter_ids,
                );
                if(!empty($_GET['user_id']))
                    $criteriaRegisterSale['RegisterSale.user_id'] = $_GET['user_id'];
                if(!empty($_GET['from']))
                    $criteriaRegisterSale['RegisterSale.sale_date >='] = $_GET['from'];
                if(!empty($_GET['to']))
                    $criteriaRegisterSale['RegisterSale.sale_date <='] = $_GET['to'];
    
                $this->MerchantProductCategory->bindModel(array(
                    'belongsTo' => array(
                        'MerchantProductTag' => array(
                            'className' => 'MerchantProductTag',
                            'foreignKey' => 'product_tag_id'
                        )
                    )
                ));
                
                
                $this->RegisterSaleItem->bindModel(array(
                    'belongsTo' => array(
                        'RegisterSale' => array(
                            'className' => 'RegisterSale',
                            'foreignKey' => 'sale_id',
                            'conditions' => $criteriaRegisterSale
                        )
                    )
                ));
                $tag_ids = array();
                if(!empty($_GET['tag'])) {
                    $tagData = $_GET['tag'];
                    foreach($tagData as $td){
                        array_push($tag_ids, $this->MerchantProductTag->find('all',array(
                            'conditions'=>array(
                                'MerchantProductTag.name'=>$td,
                                'MerchantProductTag.merchant_id'=>$user['merchant_id']
                            )
                        ))[0]['MerchantProductTag']['id']);
                    }
                }
            
                $this->MerchantProduct->bindModel(array(
                    'hasMany' => array(
                        'RegisterSaleItem' => array(
                            'className' => 'RegisterSaleItem',
                            'foreignKey' => 'product_id'
                        ),
                        'MerchantProductCategory' => array(
                            'className' => 'MerchantProductCategory',
                            'foreignKey' => 'product_id',
                            'conditions' => array(
                                'MerchantProductCategory.product_tag_id' => $tag_ids
                            )
                        )
                    ),
                    'belongsTo' => array(
                        'MerchantProductBrand' => array(
                            'className' => 'MerchantProductBrand',
                            'foreignKey' => 'product_brand_id'
                        ),
                        'MerchantProductType' => array(
                            'className' => 'MerchantProductType',
                            'foreignKey' => 'product_type_id'
                        ),
                        'MerchantSupplier' => array(
                            'className' => 'MerchantSupplier',
                            'foreignKey' => 'supplier_id'
                        )
                    )
                ));
                
                $this->MerchantProduct->recursive = 2;
                
                $criteriaMerchantProduct = array(
                    'MerchantProduct.merchant_id' => $user['merchant_id'],
                    'MerchantProduct.product_type_id' => $us['MerchantProductType']['id']
                );
                if(!empty($_GET['product_brand_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
                if(!empty($_GET['product_type_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
                if(!empty($_GET['supplier_id']))
                    $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];
            
                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => $criteriaMerchantProduct
                ));
                
                $datas[$us['MerchantProductType']['name']] = $products;
    
                $this->set('datas',$datas);
            }
        }
    }

/**
 * Product Sales by Outlet
 *
 * @return void
 */
    public function products_by_oulet() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantCustomerGroup');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProductTag');
        $this->loadModel('MerchantCustomer');
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        $outlet_ids = array();
        foreach($outlets as $outlet)
            array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);
        
        if(isset($_GET['from'])) {
                
            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            
            $outletFilter_ids = array();
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);


            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];

            $registerFilter_ids = array();
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);

            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id'])) {
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            }
            $outles = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            $datas = array();
            foreach($outles as $us) {
                $regs = $this->MerchantRegister->find('all', array(
                    'conditions' => array(
                        'MerchantRegister.outlet_id' => $us['MerchantOutlet']['id']
                    )
                ));
                $registerFilter_ids2 = array();
                foreach($regs as $reg) {
                    array_push($registerFilter_ids2, $reg['MerchantRegister']['id']);
                }
                if($_GET['register_id']) {
                    $registerFilter_ids2 = $_GET['register_id'];
                }

                $criteriaRegisterSale = array(
                    'RegisterSale.register_id' => $registerFilter_ids2
                );
                if(!empty($_GET['user_id']))
                    $criteriaRegisterSale['RegisterSale.user_id'] = $_GET['user_id'];
                if(!empty($_GET['from']))
                    $criteriaRegisterSale['RegisterSale.sale_date >='] = $_GET['from'];
                if(!empty($_GET['to']))
                    $criteriaRegisterSale['RegisterSale.sale_date <='] = $_GET['to'];
    
                $this->MerchantProductCategory->bindModel(array(
                    'belongsTo' => array(
                        'MerchantProductTag' => array(
                            'className' => 'MerchantProductTag',
                            'foreignKey' => 'product_tag_id'
                        )
                    )
                ));
                
                
                $this->RegisterSaleItem->bindModel(array(
                    'belongsTo' => array(
                        'RegisterSale' => array(
                            'className' => 'RegisterSale',
                            'foreignKey' => 'sale_id',
                            'conditions' => $criteriaRegisterSale
                        )
                    )
                ));
                $tag_ids = array();
                if(!empty($_GET['tag'])) {
                    $tagData = $_GET['tag'];
                    foreach($tagData as $td){
                        array_push($tag_ids, $this->MerchantProductTag->find('all',array(
                            'conditions'=>array(
                                'MerchantProductTag.name'=>$td,
                                'MerchantProductTag.merchant_id'=>$user['merchant_id']
                            )
                        ))[0]['MerchantProductTag']['id']);
                    }
                }
            
                $this->MerchantProduct->bindModel(array(
                    'hasMany' => array(
                        'RegisterSaleItem' => array(
                            'className' => 'RegisterSaleItem',
                            'foreignKey' => 'product_id'
                        ),
                        'MerchantProductCategory' => array(
                            'className' => 'MerchantProductCategory',
                            'foreignKey' => 'product_id',
                            'conditions' => array(
                                'MerchantProductCategory.product_tag_id' => $tag_ids
                            )
                        )
                    ),
                    'belongsTo' => array(
                        'MerchantProductBrand' => array(
                            'className' => 'MerchantProductBrand',
                            'foreignKey' => 'product_brand_id'
                        ),
                        'MerchantProductType' => array(
                            'className' => 'MerchantProductType',
                            'foreignKey' => 'product_type_id'
                        ),
                        'MerchantSupplier' => array(
                            'className' => 'MerchantSupplier',
                            'foreignKey' => 'supplier_id'
                        )
                    )
                ));
                
                $this->MerchantProduct->recursive = 2;
                
                $criteriaMerchantProduct = array(
                    'MerchantProduct.merchant_id' => $user['merchant_id']
                );
                if(!empty($_GET['product_brand_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
                if(!empty($_GET['product_type_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
                if(!empty($_GET['supplier_id']))
                    $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];
            
                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => $criteriaMerchantProduct
                ));
                
                if(!empty($_GET['register_id'])) {
                    if($this->MerchantRegister->findById($_GET['register_id'])['MerchantRegister']['outlet_id'] == $us['MerchantOutlet']['id']) {
                        $datas[$us['MerchantOutlet']['name']] = $products;
                    }
                } else {
                    $datas[$us['MerchantOutlet']['name']] = $products;
                }
    
                $this->set('datas',$datas);
            }
        }
    }

/**
 * Product Sales by Supplier
 *
 * @return void
 */
    public function products_by_supplier() {
        $user = $this->Auth->user();
        
        $this->loadModel('MerchantUser');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantCustomerGroup');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProductTag');
        $this->loadModel('MerchantCustomer');
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        $outlet_ids = array();
        foreach($outlets as $outlet)
            array_push($outlet_ids,$outlet['MerchantOutlet']['id']);
        
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $this->set('registers',$registers);
        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $groups = $this->MerchantCustomerGroup->find('all', array(
            'conditions' => array(
                'MerchantCustomerGroup.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('groups',$groups);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);
        
        if(isset($_GET['from'])) {
                
            $criteriaMerchantOutlet = array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['outlet_id']))
                $criteriaMerchantOutlet['MerchantOutlet.id'] = $_GET['outlet_id'];
            
            $outletFilter_ids = array();
            $outletFilter = $this->MerchantOutlet->find('all', array(
                'conditions' => $criteriaMerchantOutlet
            ));
            foreach($outletFilter as $otf)
                array_push($outletFilter_ids, $otf['MerchantOutlet']['id']);


            $criteriaRegister = array(
                'MerchantRegister.outlet_id' => $outletFilter_ids
            );
            if(!empty($_GET['register_id']))
                $criteriaRegister['MerchantRegister.id'] = $_GET['register_id'];

            $registerFilter_ids = array();
            $registerFilter = $this->MerchantRegister->find('all', array(
                'conditions' => $criteriaRegister
            ));
            foreach($registerFilter as $rgf)
                array_push($registerFilter_ids, $rgf['MerchantRegister']['id']);

            $criteriaMerchantSupplier = array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['supplier_id'])) {
                $criteriaMerchantSupplier['MerchantSupplier.id'] = $_GET['supplier_id'];
            }
            $spls = $this->MerchantSupplier->find('all', array(
                'conditions' => $criteriaMerchantSupplier
            ));
            $datas = array();
            foreach($spls as $us) {
                $criteriaRegisterSale = array(
                    'RegisterSale.register_id' => $registerFilter_ids,
                );
                if(!empty($_GET['user_id']))
                    $criteriaRegisterSale['RegisterSale.user_id'] = $_GET['user_id'];
                if(!empty($_GET['from']))
                    $criteriaRegisterSale['RegisterSale.sale_date >='] = $_GET['from'];
                if(!empty($_GET['to']))
                    $criteriaRegisterSale['RegisterSale.sale_date <='] = $_GET['to'];

                $this->MerchantProductCategory->bindModel(array(
                    'belongsTo' => array(
                        'MerchantProductTag' => array(
                            'className' => 'MerchantProductTag',
                            'foreignKey' => 'product_tag_id'
                        )
                    )
                ));
                
                
                $this->RegisterSaleItem->bindModel(array(
                    'belongsTo' => array(
                        'RegisterSale' => array(
                            'className' => 'RegisterSale',
                            'foreignKey' => 'sale_id',
                            'conditions' => $criteriaRegisterSale
                        )
                    )
                ));
                $tag_ids = array();
                if(!empty($_GET['tag'])) {
                    $tagData = $_GET['tag'];
                    foreach($tagData as $td){
                        array_push($tag_ids, $this->MerchantProductTag->find('all',array(
                            'conditions'=>array(
                                'MerchantProductTag.name'=>$td,
                                'MerchantProductTag.merchant_id'=>$user['merchant_id']
                            )
                        ))[0]['MerchantProductTag']['id']);
                    }
                }
            
                $this->MerchantProduct->bindModel(array(
                    'hasMany' => array(
                        'RegisterSaleItem' => array(
                            'className' => 'RegisterSaleItem',
                            'foreignKey' => 'product_id'
                        ),
                        'MerchantProductCategory' => array(
                            'className' => 'MerchantProductCategory',
                            'foreignKey' => 'product_id',
                            'conditions' => array(
                                'MerchantProductCategory.product_tag_id' => $tag_ids
                            )
                        )
                    ),
                    'belongsTo' => array(
                        'MerchantProductBrand' => array(
                            'className' => 'MerchantProductBrand',
                            'foreignKey' => 'product_brand_id'
                        ),
                        'MerchantProductType' => array(
                            'className' => 'MerchantProductType',
                            'foreignKey' => 'product_type_id'
                        ),
                        'MerchantSupplier' => array(
                            'className' => 'MerchantSupplier',
                            'foreignKey' => 'supplier_id'
                        )
                    )
                ));
                
                $this->MerchantProduct->recursive = 2;

                $criteriaMerchantProduct = array(
                    'MerchantProduct.merchant_id' => $user['merchant_id'],
                    'MerchantProduct.supplier_id' => $us['MerchantSupplier']['id']
                );
                if(!empty($_GET['product_brand_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
                if(!empty($_GET['product_type_id']))
                    $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
                if(!empty($_GET['supplier_id']))
                    $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];

                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => $criteriaMerchantProduct
                ));

                $datas[$us['MerchantSupplier']['name']] = $products;

                $this->set('datas',$datas);
            }
        }
    }

/**
 * Register closure information
 *
 * @return void
 */
    public function stock_levels() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantSupplier');
        $this->loadModel('MerchantProductInventory');
        $this->loadModel('MerchantProductTag');     

        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('types',$types);
        
        $brands = $this->MerchantProductBrand->find('all',array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('brands',$brands);
        
        $suppliers = $this->MerchantSupplier->find('all',array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers',$suppliers);
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
        
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags',$tags);

        if(isset($_GET['product_type_id'])) {
            $criteriaInventory = array();
            if(!empty($_GET['outlet_id'])) {
                $criteriaInventory['MerchantProductInventory.outlet_id'] = $_GET['outlet_id'];
            }
            
            $this->MerchantProductInventory->bindModel(array(
                'belongsTo' => array(
                    'MerchantOutlet' => array(
                        'className' => 'MerchantOutlet',
                        'foreignKey' => 'outlet_id'
                    )
                )
            ));
        
            $this->MerchantProduct->bindModel(array(
                'hasMany' => array(
                    'MerchantProductInventory' => array(
                        'className' => 'MerchantProductInventory',
                        'foreignKey' => 'product_id',
                        'conditions' => $criteriaInventory
                    )
                )
            ));
            
            $criteriaMerchantProduct = array(
                'MerchantProduct.merchant_id' => $user['merchant_id']
            );
            if(!empty($_GET['name'])) {
                $criteriaMerchantProduct['OR'] = array(
                    'MerchantProduct.name LIKE' => "%".$_GET['name']."%",
                    'MerchantProduct.sku LIKE' => "%".$_GET['name']."%",
                    'MerchantProduct.handle LIKE' => "%".$_GET['name']."%"
                );
            }
            if(!empty($_GET['product_type_id'])) {
                $criteriaMerchantProduct['MerchantProduct.product_type_id'] = $_GET['product_type_id'];
            }
            if(!empty($_GET['product_brand_id'])) {
                $criteriaMerchantProduct['MerchantProduct.product_brand_id'] = $_GET['product_brand_id'];
            }
            if(!empty($_GET['supplier_id'])) {
                $criteriaMerchantProduct['MerchantProduct.supplier_id'] = $_GET['supplier_id'];
            }
            
            $this->MerchantProduct->recursive = 2;
            
            $products = $this->MerchantProduct->find('all', array(
                'conditions' => $criteriaMerchantProduct
            ));
            
            $this->set('products',$products);
        }
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
