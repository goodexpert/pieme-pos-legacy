<?php

App::uses('AppController', 'Controller');

class PaymentsController extends AppController {

    // Authorized : Payment can access only admin
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
 * This controller uses PaymentType and MerchantPaymentType models.
 *
 * @var array
 */
    public $uses = array(
        'PaymentType',
        'MerchantPaymentType'
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function create() {
        $user = $this->Auth->user();
        
        if($this->request->is('post')) {
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];

            $this->MerchantPaymentType->create();
            $this->MerchantPaymentType->save($data);
            
            header("Location: /setup/payments");
            exit();
        }
        
        $this->loadModel('PaymentGroup');
        
        $paymentGroups = $this->PaymentGroup->find('all');
        $this->set('paymentGroups',$paymentGroups);

        $payments = $this->PaymentType->find('all', array(
            'conditions' => array(
                'PaymentType.is_active' => 1
            ),
            'order' => array(
                'PaymentType.payment_group_id ASC'
            )
        ));
        $this->set('payments', $payments);
    }

    public function edit($id) {
        $user = $this->Auth->user();

        $payment = $this->MerchantPaymentType->findById($id);
        $this->set('payment', $payment);
        
        if($this->request->is('put')) {
            $data = $this->request->data;
            $result = array();
            try {
                $this->MerchantPaymentType->id = $id;
                $this->MerchantPaymentType->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function delete($id) {
        $user = $this->Auth->user();
        
        if($this->request->is('delete')) {
            $result = array();
            try {
                $this->MerchantPaymentType->delete($id);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
