<?php

App::uses('AppController', 'Controller');

class AddOnsController extends AppController {

    // Authorized : Addon can access only admin
    public function isAuthorized($user = null) {
        if (isset($user['user_type_id'])) {
            return (bool)($user['user_type_id'] === 'user_type_admin');
        }

        // Default deny
        return false;
    }

/**
 * Components property.
 *
 * @var array
 */
    public $components = array('RequestHandler');

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
 * index function.
 *
 * @return void
 */
    public function index() {
    }

/**
 * myob add-on function.
 *
 * @return void
 */
    public function myob() {
    }

/**
 * shopify add-on function.
 *
 * @return void
 */
    public function shopify() {
    }

/**
 * xero add-on function.
 *
 * @return void
 */
    public function xero() {
    }

}
