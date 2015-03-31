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
    }

}
