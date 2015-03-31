<?php

App::uses('AppController', 'Controller');

class OutletController extends AppController {

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
 * This controller uses MerchantRegister and MerchantOutlet models.
 *
 * @var array
 */
    public $uses = array('MerchantRegister', 'MerchantOutlet');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $user = $this->Auth->user();

        $this->MerchantOutlet->bindModel(array(
            'hasMany' => array(
                'MerchantRegister' => array(
                    'className' => 'MerchantRegister',
                    'foreignKey' => 'outlet_id'
                )
            ),
        ));

        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));

        $this->set("outlets", $outlets);
    }

    public function add() {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];

                $this->MerchantOutlet->create();
                $this->MerchantOutlet->save(array('MerchantOutlet' => $data));

                $result['success'] = true;
                $result['outlet_id'] = $this->MerchantOutlet->id;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
        }
    }
    
    public function edit($id) {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];

                $this->MerchantOutlet->id = $data['id'];
                $this->MerchantOutlet->save(array('MerchantOutlet' => $data));

                $result['success'] = true;
                $result['outlet_id'] = $this->MerchantOutlet->id;
            } catch (Exception $e) {
                $result = $data;
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
        } else if ($this->request->is('get')) {
            $outlet = $this->MerchantOutlet->findById($id);

            if (empty($outlet) || !isset($outlet['MerchantOutlet'])) {
                $this->redirect('/outlet');
            } else if ($outlet['MerchantOutlet']['merchant_id'] != $user['merchant_id']){
                $this->redirect('/outlet');
            }

            $this->set("outlet", $outlet['MerchantOutlet']);
        }
    }

}
