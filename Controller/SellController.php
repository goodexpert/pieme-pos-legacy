<?php

App::uses('AppController', 'Controller');

class SellController extends AppController {

    // Authorized : User who have login session can access
    public function isAuthorized($user = null) {
        if (isset($user)) {
            return true;
        }
        // Default deny
        return false;
    }

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
    public $uses = [];

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
    }

}
