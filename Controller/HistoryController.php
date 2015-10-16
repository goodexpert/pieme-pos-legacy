<?php

App::uses('AppController', 'Controller');

class HistoryController extends AppController {

    // Authorized : History can access admin and manager(some function)
    public function isAuthorized($user = null) {
        if (isset($user['user_type_id'])) {
            return (bool)(($user['user_type_id'] === 'user_type_admin') || ($user['user_type_id'] === 'user_type_manager'));
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
        'MerchantProduct',
        'RegisterSale',
        'RegisterSaleItem',
        'RegisterSalePayment',
        'MerchantCustomer',
        'MerchantUser',
        'SaleStatus'
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
 * Index function.
 *
 * @return void
 */
    public function index() {
        $user = $this->Auth->user();
        
        $date_from = $this->get('date_from');
        $date_to = $this->get('date_to');
        $filter = $this->get('filter');
        $customer = $this->get('customer');
        $receipt_number = $this->get('receipt_number');
        $register_id = $this->get('register_id');
        $user_id = $this->get('user_id');;
        $amount = $this->get('amount');;
        $this->request->data = $_GET;

        $sales = $this->_getRegisterSales($user['merchant_id'], $user['retailer_id'],
            $filter, $register_id, $user_id, $customer, $date_from, $date_to, $receipt_number, $amount);
        $this->set('sales', $sales);

        $payments = $this->_getPaymentTypes($user['merchant_id']);
        $this->set('payments', $payments);

        $status = $this->_getSaleStatus();
        $this->set('status', $status);

        $registers = $this->_getRegisters($user['merchant_id'], $user['retailer_id']);
        $this->set('registers', $registers);

        $users = $this->_getUsers($user['merchant_id'], $user['retailer_id']);
        $this->set('users', $users);
    }

/**
 * Get the register sales.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string status
 * @param string register id
 * @param string user id
 * @param string customer name
 * @param string date from
 * @param string date to
 * @param string receipt number
 * @param string amount
 * @return array
 */
    protected function _getRegisterSales($merchant_id, $retailer_id, $status, $register_id, $user_id, $customer_name, $date_from, $date_to, $receipt_number, $amount) {
        $this->loadModel('RegisterSale');

        $this->RegisterSaleItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->RegisterSale->bindModel(array(
            'hasMany' => array(
                'RegisterSaleItem' => array(
                    'className' => 'RegisterSaleItem',
                    'foreignKey' => 'sale_id'
                ),
                'RegisterSalePayment' => array(
                    'className' => 'RegisterSalePayment',
                    'foreignKey' => 'sale_id'
                )
            )
        ));

        $conditions = array(
            'MerchantOutlet.merchant_id' => $merchant_id
        );

        if (!empty($retailer_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantOutlet.retailer_id' => $retailer_id
            ));
        }

        if (!empty($status)) {
            $conditions = array_merge($conditions, array(
                'RegisterSale.status' => $status
            ));
        }

        if (!empty($register_id)) {
            $conditions = array_merge($conditions, array(
                'RegisterSale.register_id' => $register_id
            ));
        }

        if (!empty($user_id)) {
            $conditions = array_merge($conditions, array(
                'RegisterSale.user_id' => $user_id
            ));
        }

        if (!empty($customer_name)) {
            $conditions = array_merge($conditions, array(
                'MerchantCustomer.name LIKE' => '%' . $customer_name . '%'
            ));
        }

        if (!empty($date_from)) {
            $conditions = array_merge($conditions, array(
                'RegisterSale.sale_date >=' => $date_from
            ));
        }

        if (!empty($date_to)) {
            $conditions = array_merge($conditions, array(
                'RegisterSale.sale_date <=' => $date_to
            ));
        }

        if (!empty($receipt_number)) {
            $conditions = array_merge($conditions, array(
                'RegisterSale.receipt_number' => $receipt_number
            ));
        }

        if (!empty($amount)) {
            $conditions = array_merge($conditions, array(
                'RegisterSale.total_price_incl_tax' => $amount
            ));
        }

        $this->RegisterSale->virtualFields['status_name'] = 'SaleStatus.name';

        $results = $this->RegisterSale->find('all', array(
            'fields' => array(
                'RegisterSale.*',
                'MerchantCustomer.*',
                'MerchantUser.*',
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_registers',
                    'alias' => 'MerchantRegister',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantRegister.id = RegisterSale.register_id'
                    )
                ),
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantOutlet.id = MerchantRegister.outlet_id'
                    )
                ),
                array(
                    'table' => 'merchant_customers',
                    'alias' => 'MerchantCustomer',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantCustomer.id = RegisterSale.customer_id'
                    )
                ),
                array(
                    'table' => 'merchant_users',
                    'alias' => 'MerchantUser',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantUser.id = RegisterSale.user_id'
                    )
                ),
                array(
                    'table' => 'sale_status',
                    'alias' => 'SaleStatus',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'SaleStatus.id = RegisterSale.status'
                    )
                )
            ),
            'conditions' => $conditions,
            'order' => array('RegisterSale.created'),
            'recursive' => 2
        ));

        // reset virtual field so it won't mess up subsequent finds
        unset($this->RegisterSale->virtualFields['status_name']);

        return $results;
    }

/**
 * Get the payment types.
 *
 * @param string merchant id
 * @return array
 */
    protected function _getPaymentTypes($merchant_id) {
        $this->loadModel('MerchantPaymentType');

        $results = $this->MerchantPaymentType->find('all', array(
            'fields' => array(
                'MerchantPaymentType.id',
                'MerchantPaymentType.name',
            ),
            'conditions' => array(
                'MerchantPaymentType.merchant_id' => $merchant_id
            )
        ));
        return $results;
    }

/**
 * Get the merchant's registers.
 *
 * @param string merchant id
 * @param string retailer id
 * @return array
 */
    protected function _getRegisters($merchant_id, $retailer_id) {
        $this->loadModel('MerchantRegister');

        $conditions = array(
            'MerchantOutlet.merchant_id' => $merchant_id
        );

        if (!empty($retailer_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantOutlet.retailer_id' => $retailer_id
            ));
        }

        $results = $this->MerchantRegister->find('list', array(
            'fields' => array(
                'MerchantRegister.id',
                'MerchantRegister.name'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantOutlet.id = MerchantRegister.outlet_id'
                    )
                )
            ),
            'conditions' => $conditions
        ));
        return $results;
    }

/**
 * Get the sale status.
 *
 * @return array
 */
    protected function _getSaleStatus() {
        $this->loadModel('SaleStatus');

        $results = $this->SaleStatus->find('list', array(
            'fields' => array(
                'SaleStatus.id',
                'SaleStatus.name',
            ),
        ));
        return $results;
    }

/**
 * Get the merchant's users.
 *
 * @param string merchant id
 * @param string retailer id
 * @return array
 */
    protected function _getUsers($merchant_id, $retailer_id) {
        $this->loadModel('MerchantUser');

        $conditions = array(
            'MerchantUser.merchant_id' => $merchant_id
        );

        if (!empty($retailer_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantUser.retailer_id' => $retailer_id
            ));
        }

        $results = $this->MerchantUser->find('list', array(
            'fields' => array(
                'MerchantUser.id',
                'MerchantUser.username'
            ),
            'conditions' => $conditions
        ));
        return $results;
    }

    public function receipt() {
    
        $this->RegisterSaleItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->RegisterSale->bindModel(array(
            'hasMany' => array(
                'RegisterSaleItem' => array(
                    'className' => 'RegisterSaleItem',
                    'foreignKey' => 'sale_id'
                )
            ),
            'belongsTo' => array(
                'MerchantCustomer' => array(
                    'className' => 'MerchantCustomer',
                    'foreignKey' => 'customer_id'
                ),
                'MerchantRegister' => array(
                    'className' => 'MerchantRegister',
                    'foreignKey' => 'register_id'
                ),
                'MerchantUser' => array(
                    'className' => 'MerchantUser',
                    'foreignKey' => 'user_id'
                )
            )
        ));

        $this->RegisterSale->recursive = 2;
        $sales = $this->RegisterSale->findById($_GET['r']);
        $this->set('sales', $sales);
    }

    public function edit() {
        $sales = $this->RegisterSale->find('all', array(
            'fields' => array(
                'RegisterSale.*',
                'MerchantCustomer.*'
            ),
            'conditions' => array(
                'RegisterSale.register_id' => $this->Auth->user()['MerchantRegister']['id'],
                'RegisterSale.id' => $_GET['r']
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_customers',
                    'alias' => 'MerchantCustomer',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantCustomer.id = RegisterSale.customer_id'
                    )
                )
            )
        ));
        $this->set('sales', $sales);
        
        $this->loadModel('MerchantRegister');
        $registers = $this->MerchantRegister->find('all',array(
            'conditions' => array(
                'MerchantRegister.outlet_id' => $this->Auth->user()['MerchantOutlet']['id']
            )
        ));
        $this->set('registers',$registers);
        
        $this->loadModel('MerchantCustomer');
        $customers = $this->MerchantCustomer->find('all',array(
            'conditions' => array(
                'MerchantCustomer.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
        $this->set('customers',$customers);
        
        if($this->request->is('post')){
            
            $data = $this->request->data;
            $data['modified'] = date('Y-m-d H:i:s');
            
            $this->RegisterSale->id = $data['id'];
            $this->RegisterSale->save($data);
        }
    }

    public function void(){
        if($this->request->is('post')){
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                $data['modified'] = date('Y-m-d H:i:s');
                
                $this->RegisterSale->id = $data['id'];
                $this->RegisterSale->save($data);
                
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function send_receipt() {
        if($this->request->is('post')) {
            $Email = new CakeEmail('default');
        $Email->template('letter')
            ->emailFormat('html')
            ->to('sisoo.han@emcormedia.co.nz')
            ->viewVars(array('fullname' => 'Seongwuk Park'))
            ->send();
        }
    }

    public function add_register_sale_payments() {
        $user = $this->Auth->user();
        if($this->request->is('post')) {
            $result = array(
                'success' => flase
            );
            try {
                $data = $this->request->data;
                $this->RegisterSalePayment->create();
                $this->RegisterSalePayment->save($data);
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
