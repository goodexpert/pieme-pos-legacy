<?php

App::uses('AppController', 'Controller');

class SisooController extends AppController {

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
        $this->Auth->allow('index');
    }

    public function index() {
    }

}
