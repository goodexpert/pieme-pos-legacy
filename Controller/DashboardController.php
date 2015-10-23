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
        'RegisterSale'
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
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        foreach ($outlets as $outlet) {
            array_push($outlet_ids, $outlet['MerchantOutlet']['id']);
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

        $registers = $this->MerchantRegister->find('all', array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $outlet_ids
            )
        ));
        foreach ($registers as $register) {
            array_push($register_ids, $register['MerchantRegister']['id']);
        }

//        $this->set('products',$products);
    }

}
