<?php

App::uses('AppController', 'Controller');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

class UsersController extends AppController {

/**
 * Name of layout to use with this View.
 *
 * @var string
 */
    public $layout = 'home';

/**
 * This controller uses MerchantUser, MerchantRegister and MerchantOutlet models.
 *
 * @var array
 */
    public $uses = array('MerchantUser', 'MerchantOutlet', 'MerchantRegister');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('login', 'lock');
    }

/**
 * Login function.
 *
 * @return void
 */
    public function login() {
        $this->layout = false;

        // set a default notification message.
        $this->Session->setFlash(__('Enter any username and password.'), 'default');
        $show_alert = false;

        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $user = $this->Auth->user();

                $conditions = array(
                    'MerchantOutlet.id = MerchantRegister.outlet_id',
                    'MerchantOutlet.merchant_id' => $user['merchant_id']
                );

                if (isset($user['outlet_id'])) {
                    $conditions = array_merge($conditions, array(
                        'MerchantOutlet.id' => $user['outlet_id']
                    ));
                }

                $registers = $this->MerchantRegister->find('all', array(
                    'fields' => array(
                        'MerchantRegister.*',
                        'MerchantOutlet.*'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'merchant_outlets',
                            'alias' => 'MerchantOutlet',
                            'type' => 'INNER',
                            'conditions' => $conditions
                        )
                    )
                ));

                if (count($registers) == 1) {
                    $register = $registers[0];
                    $this->Session->write('Auth.User.MerchantRegister', $register['MerchantRegister']);
                    $this->Session->write('Auth.User.MerchantOutlet', $register['MerchantOutlet']);
                    $_SESSION["Auth"]["User"]["outlet_id"] = $register['MerchantOutlet']['id'];
                }
                $_SESSION["Auth"]["User"]["RegisterCount"] = count($registers);

                $this->MerchantUser->id = $user['id'];
                $user['last_ip_address'] = $_SERVER['REMOTE_ADDR'];
                $user['last_logged'] = date("Y-m-d H:i:s");
                $this->MerchantUser->save($user);

                // Create a cookie variable
                $this->Cookie->write('session_id', rand());

                return $this->redirect($this->Auth->redirect());
            }
            $this->Session->setFlash(__('Invalid username or password, try again'));
            $show_alert = true;
        }
        $this->set('show_alert', $show_alert);
    }

/**
 * Logout function.
 *
 * @return void
 */
    public function logout() {
        // Delete a cookie variable
        $this->Cookie->delete('session_id');

        return $this->redirect($this->Auth->logout());
    }

/**
 * Lock screen function.
 *
 * @return void
 */
    public function lock() {
        $this->layout = 'lock';
    }

}
