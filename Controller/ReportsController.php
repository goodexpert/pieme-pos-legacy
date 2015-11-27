<?php

App::uses('AppController', 'Controller');

class ReportsController extends AppController {

    // Authorized : Report can access admin and manager(some function)
  public function isAuthorized($user = null) {
    if (isset($user['user_type_id'])) {
      if ($user['user_type_id'] === 'user_type_admin') {
        return true;
      } else if ($user['user_type_id'] === 'user_type_manager') {
        if (in_array($this->action, array(
            'sales_by_period',
            'sales_by_month',
            'sales_by_day',
            'sales_by_category',
            'payments_by_month',
            'popular_products',
            'products_by_user',
            'products_by_customer',
            'products_by_customer_group',
            'products_by_type',
            'closures'
          ))) {
          return true;
        }
      }
    }
    // Default deny
    return false;
  }

/**
 * This controller does not use a model
 *
 * @var array
 */
    public $uses = array(
        'Merchant',
        'MerchantOutlet',
        'MerchantRegister',
        'MerchantRegisterOpen',
        'MerchantUser',
        'MerchantCustomer',
        'MerchantPaymentType',
        'RegisterSale',
        'RegisterSaleItem',
        'RegisterSalePayment'
    );

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


            //TODO: Only modified select oulet info logic. must change cacluration
            // Get outlet info
            $outlet_ids = array();
            $outlet_names = array();
            if ($user['user_type_id'] === "user_type_admin") {
                $outlets = $this->MerchantOutlet->find('all', array(
                    'conditions' => array(
                        'MerchantOutlet.merchant_id' => $user['merchant_id']
                    )
                ));
                foreach($outlets as $outlet) {
                    array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
                }
            } else  if ($user['user_type_id'] === "user_type_manager") {
                $outlet = $this->MerchantOutlet->findById($user['outlet_id']);
                array_push($outlet_ids, $user['outlet_id']);
                array_push($outlet_names, $outlet['MerchantOutlet']['name']);
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

        // get Merchant info
        $merchant_info = array();
        $merchant = $this->Merchant->findById($user['merchant_id']);
        array_push($merchant_info, $merchant['Merchant']);

        // Get outlet info
        $outlet_ids = array();
        $oultet_infos = array();
        if ($user['user_type_id'] === "user_type_admin") {
            if(isset($_GET['outlet_id']) && !empty($_GET['outlet_id'])) {
                $outlet = $this->MerchantOutlet->findById($_GET['outlet_id']);
                array_push($outlet_ids, $outlet['MerchantOutlet']['id']);

                $outlets = $this->MerchantOutlet->find('all', array(
                    'conditions' => array(
                        'MerchantOutlet.merchant_id' => $user['merchant_id']
                    )
                ));
                foreach ($outlets as $outlet) {
                    array_push($oultet_infos, $outlet['MerchantOutlet']);
                }
            } else {
                $outlets = $this->MerchantOutlet->find('all', array(
                    'conditions' => array(
                        'MerchantOutlet.merchant_id' => $user['merchant_id']
                    )
                ));
                foreach ($outlets as $outlet) {
                    array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
                    array_push($oultet_infos, $outlet['MerchantOutlet']);
                }
            }
        } else if ($user['user_type_id'] === "user_type_manager") {
            $outlet = $this->MerchantOutlet->findById($user['outlet_id']);
            array_push($outlet_ids, $user['outlet_id']);
            array_push($oultet_infos, $outlet['MerchantOutlet']);
        }



        if(isset($_GET['period']) && !empty($_GET['period'])) {

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

                $key = $year.'-'.$month;

                $sales[$key] = $this->RegisterSale->find('all', array(
                    'conditions' => $criteria
                ));
                $month = $month - 1;
            }
            $this->set('sales',$sales);
        }
        $this->set('merchant',$merchant_info);
        $this->set('outlets',$oultet_infos);
    }

/**
 * Sales Totals by Day
 *
 * @return void
 */
    public function sales_by_day() {
        $user = $this->Auth->user();

        // Get outlet info
        $outlet_ids = array();
        $outlet_names = array();
        if ($user['user_type_id'] === "user_type_admin") {
            $outlets = $this->MerchantOutlet->find('all', array(
                'conditions' => array(
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                )
            ));
            foreach($outlets as $outlet) {
                array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
            }
        } else  if ($user['user_type_id'] === "user_type_manager") {
            $outlet = $this->MerchantOutlet->findById($user['outlet_id']);
            array_push($outlet_ids, $user['outlet_id']);
            array_push($outlet_names, $outlet['MerchantOutlet']['name']);
        }

        // Get register info
        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
               'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        $register_ids = array();
        foreach($registers as $register) {
            array_push($register_ids, $register['MerchantRegister']['id']);
        }
        // Set date range
        $interval = new DateInterval('P1D');
        $begin = new DateTime(date('Y-m-d'));
        $begin = $begin->modify( '-1 month' );
        $end = new DateTime(date('Y-m-d'));
        foreach($_GET as $key => $value) {
            if(!empty($value) && $value != '') {
                if($key == 'from') {
                    $begin = new DateTime($value);
                    $endTemp = new DateTime($value);
                    $endTemp = $endTemp->modify( '+1 month' );
                    if ($endTemp < $end) {
                        $end = $endTemp;
                    }
                }
                if($key == 'to') {
                    $end = new DateTime($value);
                }
            }
        }
        $end = $end->modify( '+1 day' );
        $daterange = new DatePeriod($begin, $interval ,$end);
        $sale_days = array();
        foreach ($daterange as $date) {
            $sale_days[] = $date->format("Y-m-d");
        }

        // set conditions
        $criteria = array(
            'RegisterSale.register_id' => $register_ids
        );
        $criteria['RegisterSale.sale_date >='] = $begin;
        $criteria['RegisterSale.sale_date <='] = $end;

        $sales = array();
        foreach($daterange as $date) {
            $saleData = [];
            $salesIncl = 0;
            $tax = 0;
            $salesExc = 0;
            $cost = 0;
            $discounts = 0;
            $grossProfit = 0;
            $grossMargin = 0;

            $sales[$date->format("Y-m-d")] = array();
            $targetSale = $this->RegisterSale->find('all', array(
                'conditions' => array(
                    'RegisterSale.sale_date >=' => $date->format("Y-m-d 00:00:00"),
                    'RegisterSale.sale_date <=' => $date->format("Y-m-d 23:59:59")
                )
            ));
            if(!empty($targetSale)) {
                foreach ($targetSale as $sale) {
                    $salesIncl += $sale['RegisterSale']['total_price_incl_tax'];
                    $tax += $sale['RegisterSale']['total_tax'];
                    $salesExc += $sale['RegisterSale']['total_price'];
                    $cost += $sale['RegisterSale']['total_cost'];
                    $discounts += $sale['RegisterSale']['total_discount'];
                }
                $grossProfit = $salesExc - $cost;
                $grossMargin = $grossProfit / $salesExc * 100;
            }
            $saleData['salesIncl'] = $salesIncl;
            $saleData['tax'] = $tax;
            $saleData['salesExc'] = $salesExc;
            $saleData['cost'] = $cost;
            $saleData['discounts'] = $discounts;
            $saleData['grossProfit'] = $grossProfit;
            $saleData['grossMargin'] = $grossMargin;
            $sales[$date->format("Y-m-d")] = $saleData;
        }

        $this->set('sales',$sales);
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
            $criteriaInventory = array(
                'MerchantProductInventory.count <=' => 0,
            );
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
    public function stock_onhand() {
    }

/**
 * Register closure information
 *
 * @return void
 */
    public function closures() {
        $user = $this->Auth->user();

        // get Merchant info
        $merchant_info = array();
        $merchant = $this->Merchant->findById($user['merchant_id']);
        array_push($merchant_info, $merchant['Merchant']);

        // Get outlet info
        $outlet_ids = array();
        $oultet_infos = array();
        if ($user['user_type_id'] === "user_type_admin") {

            $outlets = $this->MerchantOutlet->find('all', array(
                'conditions' => array(
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                )
            ));
            foreach ($outlets as $outlet) {
                array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
                array_push($oultet_infos, $outlet['MerchantOutlet']);
            }
        } else if ($user['user_type_id'] === "user_type_manager") {
            $outlet = $this->MerchantOutlet->findById($user['outlet_id']);
            array_push($outlet_ids, $user['outlet_id']);
            array_push($oultet_infos, $outlet['MerchantOutlet']);
        }


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
        $this->set('merchant',$merchant_info);
        $this->set('outlets',$oultet_infos);

    }

    /**
     * Register closure information
     *
     * @return void
     */
    public function closure_verify($id) {
        $user = $this->Auth->user();

        $register_info = array();

        $total = array();
        $total['tax'] = 0.00;
        $total['transaction'] = 0;
        $total['discount'] = 0.00;
        $total['payment'] = 0.00;
        $total['sale'] = 0.00;

        $layby_sales = array();
        $laybySales = 0.00;
        $laybyPayments = 0.00;

        $onaccount_sales = array();
        $onaccountSales = 0.00;
        $onaccountPayments = 0.00;

        $new_sales = array();
        $salesAmount = 0.00;
        $paymentsAmount = 0.00;

        // get register closure information
        $closure = $this->MerchantRegisterOpen->findById($id);
        if (count($closure) > 0) {
            $closure = $closure['MerchantRegisterOpen'];
            $register_info['opened'] = $closure['register_open_time'];
            $register_info['closed'] = $closure['register_close_time'];
        }

        // get register details
        $register = $this->MerchantRegister->findById($closure['register_id']);
        if (count($register) > 0) {
            $register = $register['MerchantRegister'];
            $register_info['name'] = $register['name'];
        }

        // get outlet detailes
        $outlet = $this->MerchantOutlet->findById($register['outlet_id']);
        if (count($outlet) > 0) {
            $outlet = $outlet['MerchantOutlet'];
            $register_info['outlet'] = $outlet['name'];
        }

        // get payment types
        $payment_types = $this->MerchantPaymentType->find('all', array(
            'conditions' => array(
                'MerchantPaymentType.merchant_id' => $user['merchant_id'],
                'MerchantPaymentType.is_active' => 1
            )
        ));
        $payment_types = Hash::map($payment_types, "{n}", function($type) {
            $newType = [];
            $newType['name'] = $type['MerchantPaymentType']['name'];
            $newType['id'] = $type['MerchantPaymentType']['id'];
            $newType['type_id'] = $type['MerchantPaymentType']['payment_type_id'];
            $newType['amount'] = 0.00;
            return $newType;
        });

        // get sales data
        $conditions = [];
        if (!empty($closure['register_close_time'])) {
            $conditions[] = [
                'RegisterSale.register_id' => $register['id'],
                'RegisterSale.sale_date >=' => $closure['register_open_time'],
                'RegisterSale.sale_date <=' => $closure['register_close_time']
            ];
        } else {
            $conditions[] = [
                'RegisterSale.register_id' => $register['id'],
                'RegisterSale.sale_date >=' => $closure['register_open_time']
            ];
        }
        $sales = $this->RegisterSale->find('all', [
            'conditions' => $conditions
        ]);
        if (count($sales) > 0) {
            $sales = Hash::map($sales, "{n}", function($sale) {
                return $sale['RegisterSale'];
            });

            // get payments with sale_id
            for ($idx = 0; $idx < count($sales); $idx++) {
                $sale = $sales[$idx];
                $sale_id = $sale['id'];
                $payments = $this->RegisterSalePayment->find('all', array(
                    'conditions' => array(
                        'RegisterSalePayment.sale_id' => $sale_id
                    )
                ));
                $payments = Hash::map($payments, "{n}", function($payment) {
                    return $payment['RegisterSalePayment'];
                });
                $sales[$idx]['payments'] = $payments;

                // get total amount
                $amount = 0.00;
                foreach ($payments as $payment) {
                    $amount += (float)$payment['amount'];

                    for ($loop = 0; $loop < count($payment_types); $loop++ ) {
                        if ($payment_types[$loop]['id'] == $payment['merchant_payment_type_id']) {
                            $payment_types[$loop]['amount'] += (float)$payment['amount'];
                        }
                    }
                };
                $total['payment'] += $amount;

                // get user name
                $user_name = $this->MerchantUser->findById($sale['user_id']);
                if (count($user_name) > 0) {
                    $user_name = $user_name['MerchantUser']['username'];
                }

                // get customer name
                $customer_name = $this->MerchantCustomer->findById($sale['customer_id']);
                if (count($customer_name) > 0) {
                    $customer_name = $customer_name['MerchantCustomer']['name'];
                }


                    // get value with sale status
                switch ($sale['status']) {
                    case 'sale_status_layby':
                    case 'sale_status_layby_closed':
                    //TODO: add logic for on layby sale
//                        $total['transaction'] += 1;
//                        $total['tax'] += $sale['total_tax'];
//                        $total['discount'] += $sale['total_discount'];
//                        $total['sale'] += $sale['total_price_incl_tax'];
//
//                        $laybySales += $sale['total_price_incl_tax'];
//                        $laybyPayments += $sale['total_payment'];
//
//                        $laybySale = array();
//                        $laybySale['sale_date'] = $sale['sale_date'];
//                        $laybySale['reciept_number'] = $sale['receipt_number'];
//                        $laybySale['user_name'] = $user_name;
//                        $laybySale['customer_name'] = $customer_name;
//                        $laybySale['note'] = $sale['note'];
//                        $laybySale['amount'] = $sale['total_price_incl_tax'];



//                        $scope.register.layby_sales.total_sales += registerSale.total_price;
//                        $scope.register.layby_sales.sales.push(laybySale);
//
//                        if (registerSale.payments != null) {
//                            for (var loop in registerSale.payments) {
//                                var salePayment = registerSale.payments[loop];
//                                var laybyPayment = {};
//                                laybyPayment.sale_date = new Date(salePayment.payment_date * 1000).format("yyyy-MM-dd hh:mm:ss");
//                                laybyPayment.reciept_number = registerSale.receipt_number;
//                                laybyPayment.user_name = registerSale.user_name;
//                                laybyPayment.customer_name = registerSale.customer_name;
//                                laybyPayment.note = _getPaymentTypeName(salePayment.payment_type_id);
//                                laybyPayment.amount = salePayment.amount;
//
//                                $scope.register.layby_sales.total_payments += salePayment.amount;
//                                $scope.register.layby_sales.payments.push(laybyPayment);
//                            }
//                        }
                        break;


                    case 'sale_status_onaccount':
                    case 'sale_status_onaccount_closed':

                        //TODO: add logic for on account sale

                        $total['transaction'] += 1;
                        $total['tax'] += $sale['total_tax'];
                        $total['discount'] += $sale['total_discount'];
                        $total['sale'] += $sale['total_price_incl_tax'];
                        break;


                    case 'sale_status_closed':
                        $total['transaction'] += 1;
                        $total['tax'] += $sale['total_tax'];
                        $total['discount'] += $sale['total_discount'];
                        $total['sale'] += $sale['total_price_incl_tax'];

                        $salesAmount += $sale['total_price'];;
                        $paymentsAmount += $amount;
                        break;
                }
            }

            if ($salesAmount > 0 || $paymentsAmount > 0) {
                $sale = array("name" => "New", "total_sales" => $salesAmount, "total_payments" => $paymentsAmount );
                $new_sales[] = $sale;
            }

            //TODO: layby and onaccount
//            if (onAccountSales > 0 || onAccountPayments > 0) {
//                var sale = {"name" : "On account", "total_sales" : onAccountSales, "total_payments" : onAccountPayments };
//                $scope.register.sales.push(sale);
//            }
//            if (laybySales > 0 || laybyPayments > 0) {
//                var sale = {"name" : "Layby", "total_sales" : laybySales, "total_payments" : laybyPayments };
//                $scope.register.sales.push(sale);
//            }
        }


        $this->set('register_info', $register_info);
        $this->set('payment_types', $payment_types);
        $this->set('sales', $sales);
        $this->set('new_sales', $new_sales);
        $this->set('total', $total);

    }
}
