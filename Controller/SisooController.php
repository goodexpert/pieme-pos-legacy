<?php

App::uses('AppController', 'Controller');

class SisooController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array();
	public $layout = 'home';

	public function index() {
	}
	
	/**
	 * Callback is called before any controller action logic is executed.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index');
    }
}
