<?php

App::uses('AppController', 'Controller');

class DashboardController extends AppController {

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

        $this->loadModel("MerchantOutlet");
        $this->loadModel("MerchantRegister");
        $this->loadModel("RegisterSale");

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

        $sales = array();
        $count = 0;
        for($i = 0; $i <= 5; $i++) {
            $amount = 0;
            $tax = 0;
            $cost = 0;
            $month = date("m") - $i;
            if($month <= 0) {
                $month = 12 + $month;
            }
            $data = $this->RegisterSale->find('all', array(
                'conditions' => array(
                    'RegisterSale.register_id' => $register_ids,
                    'RegisterSale.sale_date >=' => date("Y").'-'.$month.'-01',
                    'RegisterSale.sale_date <=' => date("Y").'-'.$month.'-31'
                )
            ));
            $count = count($data);
            foreach($data as $sale) {
                $amount += $sale['RegisterSale']['total_price_incl_tax'];
                $tax += $sale['RegisterSale']['total_tax'];
                $cost += $sale['RegisterSale']['total_cost'];
            }

            $sales[date("M", strtotime('2015-'.$month.'-01'))]['amount'] = $amount;
            $sales[date("M", strtotime('2015-'.$month.'-01'))]['tax'] = $tax;
            $sales[date("M", strtotime('2015-'.$month.'-01'))]['cost'] = $cost;
            $sales[date("M", strtotime('2015-'.$month.'-01'))]['count'] = $count;
            $sales[date("M", strtotime('2015-'.$month.'-01'))]['sales'] = $data;
        }
        $this->set('sales', $sales);
    }

}
