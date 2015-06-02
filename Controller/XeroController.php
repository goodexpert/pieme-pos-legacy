<?php

App::uses('AppController', 'Controller');

class XeroController extends AppController {

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
 * Enable xero accounts function.
 *
 * @return void
 */
    public function enableXero() {
        $this->Xero->enableXero();
        exit;
    }

/**
 * Retrieve contacts from Xero contacts.
 *
 * @return void
 */
    public function getContacts() {
        $contacts = $this->Xero->getContacts();
        debug($contacts);
        exit;
    }

/**
 * Post invoice to Xero.
 *
 * @return void
 */
    public function postInvoice($id) {
        //$this->redirect('/setup/xero', 301, false);
    }

}
