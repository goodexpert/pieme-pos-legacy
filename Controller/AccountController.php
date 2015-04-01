<?php

App::uses('AppController', 'Controller');

class AccountController extends AppController {

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

    public $components = array('RequestHandler');

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
        $this->loadModel("Plan");
        $plans = $this->Plan->find('all');
        $this->set('plans',$plans);
    }

    public function update_plan() {
        $this->loadModel("Merchant");
        $this->loadModel("Plan");
        $user = $this->Auth->user();
        
        if($this->request->is('post')) {
            $data = $this->request->data;
            
            $result = array();
            try {
                $this->Merchant->id = $user['merchant_id'];
                $this->Merchant->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
