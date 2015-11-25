<?php

App::uses('AppController', 'Controller');

class DashboardController extends AppController {

    // Authorized : Dashboard can access admin and manager(some function)
    public function isAuthorized($user = null) {
        if (isset($user['user_type_id'])) {
            return (bool)(($user['user_type_id'] === 'user_type_admin') || ($user['user_type_id'] === 'user_type_manager'));
        }
        // Default deny
        return false;
    }

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
    public $uses = array(
        'MerchantOutlet',
        'MerchantRegister',
        'RegisterSale',
        'RegisterSaleItem'
    );

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

        // Set date range (1month)
        $interval = new DateInterval('P1D');
        $begin = new DateTime(date('Y-m-d'));
        $begin = $begin->modify( '-14 day' );
        $end = new DateTime(date('Y-m-d'));
        $end = $end->modify( '+1 day' );
        $daterange = new DatePeriod($begin, $interval ,$end);
        $sale_days = array();
        foreach ($daterange as $date) {
            $sale_days[] = $date->format("Y-m-d");
        }

        // Get outlet IDs
        $outlet_ids = array();
        $outlet_names = array();

        if ($user['user_type_id'] === "user_type_admin") {
            $outlets = $this->MerchantOutlet->find('all', array(
                'conditions' => array(
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                )
            ));
            foreach ($outlets as $outlet) {
                array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
                array_push($outlet_names, $outlet['MerchantOutlet']['name']);
            }
        } else  if ($user['user_type_id'] === "user_type_manager") {
            $outlet = $this->MerchantOutlet->findById($user['outlet_id']);
            array_push($outlet_ids, $user['outlet_id']);
            array_push($outlet_names, $outlet['MerchantOutlet']['name']);
        }

        // -----------------
        // Get Sales
        // -----------------

        $outlets = array();
        foreach ($outlet_ids as $outlet_id) {
            // Get register IDs
            $register_ids = array();
            $registers = $this->MerchantRegister->find('all', array(
                'conditions' => array(
                    'MerchantRegister.outlet_id' => $outlet_id
                )
            ));
            foreach ($registers as $register) {
                array_push($register_ids, $register['MerchantRegister']['id']);
            }

            // Get sale data per day
            $amounts = array();
            foreach ($daterange as $date) {
                $targetSale = $this->RegisterSale->find('all', [
                    'fields' => [
                        'RegisterSale.sale_date',
                        'RegisterSale.total_price_incl_tax'
                    ],
                    'conditions' => array(
                        'RegisterSale.sale_date >=' => $date->format("Y-m-d 00:00:00"),
                        'RegisterSale.sale_date <=' => $date->format("Y-m-d 23:59:59"),
                        'RegisterSale.register_id' => $register_ids
                    )
                ]);

                // Get total amount
                $total_amount = 0;
                if (!empty($targetSale)) {
                    foreach ($targetSale as $saleData) {
                        $total_amount += $saleData["RegisterSale"]["total_price_incl_tax"];
                    }
                }
                $amounts[] = $total_amount;
            }
            $outlets[] = $amounts;
        }

        $sales["sale_days"] = $sale_days;
        $sales["outlet_names"] = $outlet_names;
        $sales["outlets"] = $outlets;

        $this->set('sales',$sales);

        // -----------------
        // Get Products
        // -----------------

        $products = array();

        // get all registers with outlets
        if (count($outlet_ids) > 0) {
            $registers = $this->MerchantRegister->find('all', array(
                'fields' => [
                    'MerchantRegister.id'
                ],
                'conditions' => array(
                    'MerchantRegister.outlet_id' => $outlet_ids
                )
            ));
            foreach ($registers as $register) {
                array_push($register_ids, $register['MerchantRegister']['id']);
            }

            // get all register sales with registers
            if (count($register_ids) > 0) {
                $register_sales = $this->RegisterSale->find('all', array(
                    'fields' => [
                        'RegisterSale.id'
                    ],
                    'conditions' => array(
                        'RegisterSale.register_id' => $register_ids
                    )
                ));
                $sale_ids = array();
                foreach ($register_sales as $register_sale) {
                    array_push($sale_ids, $register_sale['RegisterSale']['id']);
                }

                // get all sale items with register sales
                if (count($sale_ids) > 0) {
                    $sale_items = $this->RegisterSaleItem->find('all', array(
                        'fields' => [
                            'RegisterSaleItem.id',
                            'RegisterSaleItem.name',
                            'RegisterSaleItem.product_id',
                        ],
                        'conditions' => array(
                            'RegisterSaleItem.sale_id' => $sale_ids
                        )
                    ));
                    $product_name = [];
                    $product_count = [];
                    foreach ($sale_items as $sale_item) {
                        $item_id = $sale_item['RegisterSaleItem']['product_id'];
                        $item_name = $sale_item['RegisterSaleItem']['name'];
                        if (array_key_exists($item_id, $product_name) == true) {
                            $product_count[$item_id] = $product_count[$item_id] + 1;
                        } else {
                            $product_name[$item_id] = $item_name;
                            $product_count[$item_id] = 1;
                        }
                    }
                    $products['name'] = array_values($product_name);
                    $products['count'] = array_values($product_count);
                }
            }
        }

        $this->set('products',$products);
    }

}
