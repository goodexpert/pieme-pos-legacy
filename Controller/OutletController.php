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
 * This controller uses the following models.
 *
 * @var array
 */
    public $uses = array(
        'MerchantOutlet',
        'MerchantRegister',
        'MerchantQuickKey',
        'MerchantProduct',
        'MerchantProductInventory'
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

    public function add() {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $dataSource = $this->MerchantOutlet->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;
                $data['MerchantOutlet']['merchant_id'] = $user['merchant_id'];

                if (empty($data['MerchantOutlet']['physical_country'])) {
                    unset($data['MerchantOutlet']['physical_country']);
                }
                $this->MerchantOutlet->create();
                $this->MerchantOutlet->save($data);

                $dataSource->commit();

                if ($this->request->is('ajax')) {
                    return $this->serialize(array(
                        'success' => true,
                        'id' => $this->MerchantOutlet->id
                    ));
                }
                return $this->redirect('/register/add?outlet=' . $this->MerchantOutlet->id);
            } catch (Exception $e) {
                $dataSource->rollback();

                if ($this->request->is('ajax')) {
                    return $this->serialize(array(
                        'success' => false,
                        'message' => $e->getMessage()
                    ));
                }
            }
        }

        $this->set('countries', $this->_getCountries());
    }
    
    public function edit($id) {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post') || $this->request->is('put')) {
            $dataSource = $this->MerchantOutlet->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;

                if (empty($data['MerchantOutlet']['physical_country'])) {
                    unset($data['MerchantOutlet']['physical_country']);
                }
                $this->MerchantOutlet->id = $id;
                $this->MerchantOutlet->save($data);

                $dataSource->commit();

                if ($this->request->is('ajax')) {
                    return $this->serialize(array(
                        'success' => true,
                        'id' => $this->MerchantOutlet->id
                    ));
                }
                return $this->redirect('/setup/outlets_and_registers');
            } catch (Exception $e) {
                $dataSource->rollback();

                if ($this->request->is('ajax')) {
                    return $this->serialize(array(
                        'success' => false,
                        'message' => $e->getMessage()
                    ));
                }
            }
        }

        if (empty($this->request->data)) {
            $outlet = $this->MerchantOutlet->findById($id);
            if (empty($outlet) || !is_array($outlet)) {
                throw new NotFoundException();
            }

            if (!empty($user['retailer_id']) && $user['retailer_id'] != $outlet['MerchantOutlet']['retailer_id']) {
                return $this->redirect('/setup/outlets_and_registers', 301, false);
            }

            $this->request->data = $outlet;
        }

        $this->set('outlet_id', $id);
        $this->set('countries', $this->_getCountries());
    }

/**
 * Get the countries.
 *
 * @return array the list
 */
    protected function _getCountries() {
        $this->loadModel('Country');
        return $this->Country->find('list', array(
            'fields' => array(
                'Country.country_code',
                'Country.country_name'
            )
        ));
    }

}
