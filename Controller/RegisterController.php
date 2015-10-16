<?php

App::uses('AppController', 'Controller');

class RegisterController extends AppController {

    // Authorized : Register can access only admin
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
        'MerchantQuickKey',
        'MerchantRegister',
        'MerchantReceiptTemplate'
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function add() {
        $user = $this->Auth->user();

        $quick_keys = $this->MerchantQuickKey->find('all', array(
            'conditions' => array(
                'MerchantQuickKey.merchant_id' => $user['merchant_id']
            ),
        ));
        $quick_keys = Hash::map($quick_keys, '{n}', function($array) {
            $newArray = $array['MerchantQuickKey'];
            return $newArray;
        });
        $this->set("quick_keys", $quick_keys);

        $receipt_templates = $this->MerchantReceiptTemplate->find('all', array(
            'conditions' => array(
                'MerchantReceiptTemplate.merchant_id' => $user['merchant_id']
            )
        ));
        $receipt_templates = Hash::map($receipt_templates, '{n}', function($array) {
            $newArray = $array['MerchantReceiptTemplate'];
            return $newArray;
        });
        $this->set("receipt_templates", $receipt_templates);
    }

    public function edit($id) {
        $user = $this->Auth->user();

        $register = $this->MerchantRegister->findById($id);
        $this->set("register", $register['MerchantRegister']);

        $quick_keys = $this->MerchantQuickKey->find('all', array(
            'conditions' => array(
                'MerchantQuickKey.merchant_id' => $user['merchant_id']
            ),
        ));
        $quick_keys = Hash::map($quick_keys, '{n}', function($array) {
            $newArray = $array['MerchantQuickKey'];
            return $newArray;
        });
        $this->set("quick_keys", $quick_keys);

        $receipt_templates = $this->MerchantReceiptTemplate->find('all', array(
            'conditions' => array(
                'MerchantReceiptTemplate.merchant_id' => $user['merchant_id']
            )
        ));
        $receipt_templates = Hash::map($receipt_templates, '{n}', function($array) {
            $newArray = $array['MerchantReceiptTemplate'];
            return $newArray;
        });
        $this->set("receipt_templates", $receipt_templates);
    }

    public function create() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/outlet');
        }

        $user = $this->Auth->user();

        $result = array(
            'success' => false
        );

        try {
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];

            $this->MerchantRegister->create();
            $this->MerchantRegister->save($data);

            if ($this->MerchantRegister->id) {
                $result['register_id'] = $this->MerchantRegister->id;
                $result['success'] = true;
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
    }

    public function update() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/outlet');
        }

        $result = array(
            'success' => false
        );

        try {
            $data = $this->request->data;

            $this->MerchantRegister->id = $data['register_id'];
            $this->MerchantRegister->save($data);

            if ($this->MerchantRegister->id) {
                $result['register_id'] = $this->MerchantRegister->id;
                $result['success'] = true;
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
    }

}
