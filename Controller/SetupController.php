<?php

App::uses('AppController', 'Controller');

class SetupController extends AppController {

    // Authorized : Setup can access only admin
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
        'MerchantAddon'
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
 * General setup function.
 *
 * @return void
 */
    public function index() {
        $user = $this->Auth->user();

        $this->loadModel('Contact');
        $this->loadModel('Country');
        $this->loadModel('Merchant');
        $this->loadModel('MerchantTaxRate');
        $this->loadModel('Subscriber');

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;
            $result = array();

            try {
                $this->Merchant->id = $user['merchant_id'];
                $this->Merchant->save($data);

                $this->Contact->id = $user['Subscriber']['contact_id'];
                $this->Contact->save($data);
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
        } else if ($this->request->is('get')){

            $this->Merchant->recursive = 2;

            $merchant = $this->Merchant->find('first', array(
                'conditions' => array(
                    'Merchant.id' => $user['merchant_id']
                )
            ));
            $this->set('merchant', $merchant);

            $countries = $this->Country->find('all');
            $this->set('countries',$countries);

            $taxes = $this->MerchantTaxRate->find('all', array(
                'conditions' => array(
                    'MerchantTaxRate.merchant_id' => $user['merchant_id']
                )
            ));
            $this->set('taxes', $taxes);
        }
    }

/**
 * Outlet and register setup function.
 *
 * @return void
 */
    public function outlets_and_registers() {
        $this->loadModel('MerchantRegister');
        $this->loadModel('MerchantQuickKey');
        $this->loadModel('MerchantReceiptTemplate');
        $this->loadModel('MerchantOutlet');

        $user = $this->Auth->user();

        $receipt_templates = $this->MerchantReceiptTemplate->find('all', array(
            'conditions' => array(
                'MerchantReceiptTemplate.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("receipt_templates",$receipt_templates);

        $this->MerchantRegister->bindModel(array(
            'belongsTo' => array(
                'MerchantQuickKey' => array(
                    'className' => 'MerchantQuickKey',
                    'foreignKey' => 'quick_key_id'
                )
            )
        ));

        $this->MerchantRegister->bindModel(array(
            'belongsTo' => array(
                'MerchantReceiptTemplate' => array(
                    'className' => 'MerchantReceiptTemplate',
                    'foreignKey' => 'receipt_template_id'
                )
            )
        ));

        $this->MerchantOutlet->bindModel(array(
            'hasMany' => array(
                'MerchantRegister' => array(
                    'className' => 'MerchantRegister',
                    'foreignKey' => 'outlet_id'
                )
            ),
        ));

        $this->MerchantOutlet->recursive = 2;

        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));

        $this->set("outlets", $outlets);
    }

/**
 * Payment setup function.
 *
 * @return void
 */
    public function payments() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantPaymentType');

        $payments = $this->MerchantPaymentType->find('all', array(
            'conditions' => array(
                'MerchantPaymentType.merchant_id' => $user['merchant_id']
            ),
            'order' => array(
                'MerchantPaymentType.name ASC'
            )
        ));
        $this->set("payments", $payments);
    }

/**
 * Tax setup function.
 *
 * @return void
 */
    public function taxes() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantTaxRate');

        $taxes = $this->MerchantTaxRate->find('all', array(
            'conditions' => array(
                'MerchantTaxRate.merchant_id' => $user['merchant_id']
            ),
            'order' => array(
                'MerchantTaxRate.name ASC'
            )
        ));
        $this->set("taxes", $taxes);
    }

    /**
     * Resources function.
     *
     * @return void
     */
    public function resources() {
        $this->redirect(array('controller' => 'Resources', 'action' => 'index'));
    }

/**
 * QuickKey setup function.
 *
 * @return void
 */
    public function quick_keys() {
        $this->loadModel('MerchantQuickKey');
        $this->loadModel('MerchantOutlet');
        $this->loadModel('MerchantRegister');

        $user = $this->Auth->user();

        $items = $this->MerchantQuickKey->find('all', array(
            'conditions' => array(
                'MerchantQuickKey.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("items",$items);

        $this->MerchantOutlet->bindModel(array(
            'hasMany' => array(
                'MerchantRegister' => array(
                    'className' => 'MerchantRegister',
                    'foreignKey' => 'outlet_id'
                )
            )
        ));

        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);
    }

/**
 * Loyalty setup function.
 *
 * @return void
 */
    public function loyalty() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantLoyalty');

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantLoyalty->getDataSource();
            $dataSource->begin();

            try {
                if (isset($data['MerchantLoyalty']['welcome_email_body'])) {
                    $data['MerchantLoyalty']['welcome_email_body'] = base64_encode($data['MerchantLoyalty']['welcome_email_body']);
                }

                $this->MerchantLoyalty->id = $data['MerchantLoyalty']['id'];
                $this->MerchantLoyalty->save($data);

                $this->_updateLoyaltyPaymentType($user['merchant_id'], $data['MerchantLoyalty']['enable_loyalty']);

                // update the session data.
                $this->Session->write('Auth.User.Loyalty', $data['MerchantLoyalty']);

                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
            }
        }

        if (empty($this->request->data)) {
            $data = $this->MerchantLoyalty->findByMerchantId($user['merchant_id']);
            if (isset($data['MerchantLoyalty']['welcome_email_body'])) {
                $data['MerchantLoyalty']['welcome_email_body'] = base64_decode($data['MerchantLoyalty']['welcome_email_body']);
            }
            $this->request->data = $data;
        }
    }

/**
 * User setup function.
 *
 * @return void
 */
    public function user() {
        $user = $this->Auth->user();

        /*
        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantUser->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];

                $this->MerchantUser->create();
                $this->MerchantUser->save($data);

                $dataSource->commit();

                $result['success'] = true;
                $result['user_id'] = $this->MerchantUser->id;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
            return;
        }
        */

        $filter = $this->get('merchant_user');

        $users = $this->_getUsers($user['merchant_id'], $filter);
        $this->set('users', $users);

        $user_types = $this->_getUserTypes($user['merchant_id']);
        $this->set('user_types', $user_types);

        if (empty($user['retailer_id'])) {
            // get the list of merchant's outlets
            $outlets = $this->_getOutletByMerchantId($user['merchant_id']);
        } else {
            // get the list of retail's outlets
            $outlets = $this->_getOutletByRetailerId($user['retailer_id']);
        }
        $this->set('filter', $filter);
        $this->set('outlets', $outlets);
    }

/**
 * Add-ons setup function.
 *
 * @return void
 */
    public function add_ons() {
        $user = $this->Auth->user();
    }

/**
 * Xero setup function.
 *
 * @return void
 */
    public function xero() {
        $user = $this->Auth->user();

        $this->loadModel('MerchantAddon');

        if (!isset($user['Addons']['xero_auth_token']) || empty($user['Addons']['xero_auth_token'])) {
            return $this->redirect('/setup/add_ons');
        }

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $this->MerchantAddon->id = $user['Addons']['id'];
            $this->MerchantAddon->saveField('xero_config', json_encode($data['xero_config']));
        }

        $payment_types = $this->_getPaymentTypes($user['merchant_id'], $user['Loyalty']['enable_loyalty']);
        $this->set('payment_types', $payment_types);

        $tax_rates = $this->_getTaxRates($user['merchant_id']);
        $this->set('tax_rates', $tax_rates);

        $xero_tax_rates= $this->_getXeroTaxRates($user['merchant_id'], $user['retailer_id']);
        $this->set('xero_tax_rates', $xero_tax_rates);

        $xero_accounts = $this->_getXeroAccounts($user['merchant_id'], $user['retailer_id']);
        $this->set('xero_accounts', $xero_accounts);

        $addons = $this->MerchantAddon->findById($user['Addons']['id']);
        $this->set('addons', $addons);

        if (empty($this->request->data) && isset($user['Addons']['id'])) {
            $result = $this->MerchantAddon->findById($user['Addons']['id']);
            $this->request->data = array(
                'xero_config' => json_decode($result['MerchantAddon']['xero_config'], true)
            );
        }
    }

/**
 * Get the merchant's payment types.
 *
 * @param string merchant id
 * @param string enable loyalty flag
 * @return array the list
 */
    protected function _getPaymentTypes($merchant_id, $enable_loyalty) {
        $this->loadModel('MerchantPaymentType');

        $this->MerchantPaymentType->virtualFields['payment_type_name'] = 'PaymentType.name';

        $payment_types = $this->MerchantPaymentType->find('all', array(
            'conditions' => array(
                'MerchantPaymentType.merchant_id' => $merchant_id,
                'MerchantPaymentType.is_active' => 1
            )
        ));
        // reset virtual field so it won't mess up subsequent finds
        unset($this->MerchantPaymentType->virtualFields['payment_type_name']);

        $payment_types = Hash::map($payment_types, "{n}", function($array) {
            return $array['MerchantPaymentType'];
        });
        return $payment_types;
    }

/**
 * Get the merchant's tax rates.
 *
 * @param string merchant id
 * @return array the list
 */
    protected function _getTaxRates($merchant_id) {
        $this->loadModel('MerchantTaxRate');

        $tax_rates = $this->MerchantTaxRate->find('all', array(
            'conditions' => array(
                'MerchantTaxRate.merchant_id' => $merchant_id
            )
        ));
        $tax_rates = Hash::map($tax_rates, "{n}", function($array) {
            return $array['MerchantTaxRate'];
        });
        return $tax_rates;
    }

/**
 * Get the xero tax rates.
 *
 * @param string merchant id
 * @param string retailer id
 * @return array the list
 */
    protected function _getXeroTaxRates($merchant_id, $retailer_id) {
        $this->loadModel('XeroTaxRate');

        $tax_rates = $this->XeroTaxRate->find('list', array(
            'fields' => array(
                'XeroTaxRate.tax_type',
                'XeroTaxRate.name'
            ),
            'conditions' => array(
                'XeroTaxRate.merchant_id' => $merchant_id,
                'XeroTaxRate.retailer_id' => $retailer_id
            )
        ));
        return $tax_rates;
    }

/**
 * Get the xero account codes.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string class code
 * @return array the list
 */
    protected function _getXeroAccounts($merchant_id, $retailer_id) {
        $this->loadModel('XeroAccount');

        $accounts = $this->XeroAccount->find('all', array(
            'conditions' => array(
                'XeroAccount.merchant_id' => $merchant_id,
                'XeroAccount.retailer_id' => $retailer_id
            ),
            'order' => array('class', 'code')
        ));

        $list = array();
        foreach ($accounts as $account) {
            $type = $account['XeroAccount']['type'];
            if (empty($list[$type])) {
                $list[$type] = array();
            }

            $code = $account['XeroAccount']['code'];
            $list[$type][$code] = $code . '-' . $account['XeroAccount']['name'];
        }
        return $list;
    }

/**
 * Update the loyalty payment type.
 *
 * @param string merchant id
 * @param string enable loyalty flag
 * @return array the list
 */
    protected function _updateLoyaltyPaymentType($merchant_id, $enable_loyalty) {
        $this->loadModel('MerchantPaymentType');

        $payment_type = $this->MerchantPaymentType->find('first', array(
            'conditions' => array(
                'MerchantPaymentType.merchant_id' => $merchant_id,
                'PaymentType.name' => 'Loyalty'
            )
        ));
        if (empty($payment_type) || !is_array($payment_type)) {
            $this->loadModel('PaymentType');

            $payment = $this->PaymentType->find('first', array(
                'conditions' => array(
                    'PaymentType.name' => array('Loyalty')
                )
            ));

            $payment_type = array();
            $payment_type['MerchantPaymentType']['merchant_id'] = $merchant_id;
            $payment_type['MerchantPaymentType']['payment_type_id'] = $payment['PaymentType']['id'];
            $payment_type['MerchantPaymentType']['name'] = $payment['PaymentType']['name'];
            $payment_type['MerchantPaymentType']['config'] = $payment['PaymentType']['config'];

            $this->MerchantPaymentType->create();
        } else {
            $this->MerchantPaymentType->id = $payment_type['MerchantPaymentType']['id'];
        }

        $payment_type['MerchantPaymentType']['is_active'] = $enable_loyalty;
        $this->MerchantPaymentType->save($payment_type);
    }

/**
 * Get the merchant's outlets.
 *
 * @param string merchant id
 * @return array the list
 */
    protected function _getOutletByMerchantId($merchant_id) {
        $this->loadModel('MerchantOutlet');

        $outlets = $this->MerchantOutlet->find('list', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $merchant_id
            )
        ));
        return $outlets;
    }

/**
 * Get the retailer's outlets.
 *
 * @param string retailer id
 * @return array the list
 */
    protected function _getOutletByRetailerId($retailer_id) {
        $this->loadModel('MerchantOutlet');

        $outlets = $this->MerchantOutlet->find('list', array(
            'conditions' => array(
                'MerchantOutlet.retailer_id' => $retailer_id
            )
        ));
        return $outlets;
    }

/**
 * Get the user types.
 *
 * @param string merchant id
 * @return array the list
 */
    protected function _getUserTypes($merchant_id) {
        $this->loadModel('MerchantUserType');

        $user_types = $this->MerchantUserType->find('list', array(
            'conditions' => array(
                'MerchantUserType.is_active' => 1
            )
        ));
        return $user_types;
    }

/**
 * Get the user list.
 *
 * @param string merchant id
 * @return array the list
 */
    protected function _getUsers($merchant_id, $filter ) {
        $this->loadModel('MerchantUser');
        $conditions = [];

        $conditions[] = [
            'MerchantUser.merchant_id' => $merchant_id
        ];

        if(isset($filter['user_type_id']) && !empty($filter['user_type_id'])) {
          $conditions = array_merge($conditions, array(
              'MerchantUser.user_type_id' => $filter['user_type_id']
          ));
        }

        if (isset($filter['outlet_id']) && !empty($filter['outlet_id'])) {
          $conditions = array_merge($conditions, array(
              'MerchantUser.outlet_id' => $filter['outlet_id']
          ));
        }

        $this->MerchantUser->bindModel([
            'belongsTo' => [
                'MerchantOutlet' => [
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                ],
                'MerchantUserType' => [
                    'className' => 'MerchantUserType',
                    'foreignKey' => 'user_type_id'
                ]
            ],
        ]);

        $users = $this->MerchantUser->find('all', [
            'fields' => [
                'MerchantUser.id',
                'MerchantUser.username',
                'MerchantUser.display_name',
                'MerchantUser.email',
                'MerchantUser.image',
                'MerchantUser.last_ip_address',
                'MerchantUser.last_logged',
                'MerchantUserType.name',
                'MerchantOutlet.name',
            ],
            'conditions' => $conditions
        ]);

        $this->MerchantUser->unbindModel([
            'belongsTo' => ['MerchantUserType', 'MerchantOutlet']
        ]);
        return $users;
    }

}
