<?php

App::uses('AppController', 'Controller');

class TestController extends AppController {

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
        $this->Auth->allow('index', 'error404', 'testPage1');
    }

    public function error404() {
    }

    public function testPage1() {
    }

}
