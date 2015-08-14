<?php

App::uses('AppController', 'Controller');

class SellController extends AppController {

/**
 * Components property.
 *
 * @var array
 */
    public $components = ['RequestHandler'];

/**
 * Name of layout to use with this View.
 *
 * @var string
 */
    public $layout = 'sell';

/**
 * This controller uses the following models.
 *
 * @var array
 */
    public $uses = [
    ];

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('get_current_register_sale');
    }

/**
 * Index function.
 *
 * @return void
 */
    public function index() {
    }

    public function get_current_register_sale() {
      $response = [
        'success' => false
      ];
      $this->serialize($response);
    }
}
