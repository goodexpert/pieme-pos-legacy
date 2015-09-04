<?php

App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');

class SignupController extends AppController {

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
    public $layout = 'signup';

/**
 * This controller uses the following models.
 *
 * @var array
 */
    public $uses = array(
        'Contact',
        'Merchant',
        'MerchantRetailer',
        'Signup',
        'Subscriber'
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();

        $this->Auth->allow('index', 'check_domain_prefix', 'check_username', 'check_exist', 'setup');
    }

/**
 * Index function.
 *
 * @return void
 */
    public function index() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            //$data['name'] = $data['store_name'];
            //$data['domain_prefix'] = str_replace(' ', '_', strtolower($data['name']));

            if (in_array($data['domain_prefix'], array('secure'))) {
                $this->Session->setFlash('This web address is unavailable.');
            } else {
                $this->_createSubscriber($data);
            }
        }
    }

/**
 * Check the domain prefix name.
 *
 * @return void
 */
    public function check_domain_prefix() {
        $result = array(
            'success' => false,
            'is_exist' => false
        );

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $this->loadModel('Merchant');

            try {
                $data = $this->request->data;

                if (!in_array($data['domain_prefix'], array('secure'))) {
                    $merchant = $this->Merchant->findByDomainPrefix($data);

                    if (!empty($merchant) && is_array($merchant)) {
                        $result['is_exist'] = true;
                    }
                }
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }

/**
 * Check the username.
 *
 * @return void
 */
    public function check_username() {
        $result = array(
            'success' => false,
            'is_exist' => false
        );

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $this->loadModel('Subscriber');

            try {
                $data = $this->request->data;

                $subscriber = $this->Subscriber->findByUsername($data);

                if (!empty($subscriber) && is_array($subscriber)) {
                    $result['is_exist'] = true;
                }
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }

/**
 * Check the merchant code.
 *
 * @return void
 */
    public function check_exist() {
        $result = array(
            'success' => false
        );

        if ($this->request->is('post') || $this->request->is('ajax')) {
            $this->loadModel('Merchant');

            try {
                $data = $this->request->data;
                $merchant = $this->Merchant->findByMerchantCode($data);

                if (!empty($merchant) && is_array($merchant)) {
                    $result['success'] = true;
                    $result['merchant_id'] = $merchant['Merchant']['id'];
                    $result['store_name'] = $merchant['Merchant']['name'];
                    $result['subscriber_id'] = $merchant['Merchant']['subscriber_id'];
                }
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }

/**
 * Test setup function.
 *
 * @return void
 */
    public function setup() {
        $data = array(
            'name' => 'master',
            'plan_id' => 'subscriber_plan_retailer_trial',
            'domain_prefix' => 'master',
            'first_name' => 'Steve',
            'last_name' => 'Park',
            'username' => 'master@onzsa.com',
            'password' => 'master',
            'physical_city' => 'Auckland',
            'physical_country' => 'NZ',
            'default_currency' => 'NZD',
            'time_zone' => 'Pacific/Auckland',
        );
        $this->_createSubscriber($data);
    }

/**
 * Generate a random code
 *
 * @return string
 */
    protected function _generateCode($length = 4) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle( $chars ), 0, $length);
    }

/**
 * Create the subscriber function.
 *
 * @param array signup data
 * @return void
 */
    protected function _createSubscriber($data) {
        $dataSource = $this->Contact->getDataSource();
        $dataSource->begin();

        try {
            $subscriber = $this->Subscriber->findByUsername($data['username']);
            if (!empty($subscriber) && is_array($subscriber)) {
                $errors['subscriber'] = array(
                    'username' => 'Already subscriber'
                );
                throw new Exception(json_encode($errors));
            }

            // create a contact
            $contact = array();
            $contact['first_name'] = $data['first_name'];
            $contact['last_name'] = $data['last_name'];
            $contact['email'] = $data['username'];
            $contact['company_name'] = $data['name'];
            $contact['physical_city'] = $data['physical_city'];
            $contact['physical_country'] = $data['physical_country'];

            $this->Contact->create();
            if (!$this->Contact->save(array('Contact' => $contact))) {
                $errors['contact'] = $this->Subscriber->validationErrors;
                throw new Exception(json_encode($errors));
            }

            // create a subscriber
            $subscriber = array();
            $subscriber['contact_id'] = $this->Contact->id;
            $subscriber['name'] = $data['name'];
            $subscriber['username'] = $data['username'];
            $subscriber['password'] = $data['password'];

            $this->Subscriber->create();
            if (!$this->Subscriber->save(array('Subscriber' => $subscriber))) {
                $errors['subscriber'] = $this->Subscriber->validationErrors;
                throw new Exception(json_encode($errors));
            }

            // create a merchant
            $merchant['subscriber_id'] = $this->Subscriber->id;
            $merchant['name'] = $data['name'];
            $merchant['domain_prefix'] = $data['domain_prefix'];
            $merchant['merchant_code'] = preg_replace('/\s+/', '', ucwords($data['domain_prefix'])) . '-' . $this->_generateCode();
            $merchant['plan_id'] = $data['plan_id'];
            if ($data['plan_id'] == 'subscriber_plan_retailer_trial') {
                $merchant['trial_ends'] = CakeTime::format('+30 days', '%Y-%m-%d');
                $merchant['status'] = 'trialing';
            } else {
                $merchant['status'] = 'activate';
            }
            $merchant['default_currency'] = $data['default_currency'];
            $merchant['time_zone'] = $data['time_zone'];

            $this->Merchant->create();
            if (!$this->Merchant->save(array('Merchant' => $merchant))) {
                $errors['merchant'] = $this->Merchant->validationErrors;
                throw new Exception(json_encode($errors));
            }
            $merchant_id = $this->Merchant->id;
            
            // create a default user
            $this->_createDefaultUser($merchant_id, NULL, $data['username'], $data['password'], $data['first_name'] . ' ' . $data['last_name']);
            
            // create a default customer group
            $customer_group_id = $this->_createDefaultCustomerGroup($merchant_id);
            $merchant['default_customer_group_id'] = $customer_group_id;

            // create a default customer
            $customer_id = $this->_createDefaultCustomer($merchant_id, $customer_group_id);
            $merchant['default_customer_id'] = $customer_id;

            // create default tax rates
            $tax_rates = $this->_createDefaultTaxRates($merchant_id, $data['physical_country']);
            $merchant['default_no_tax_group_id'] = $tax_rates['default_no_tax_group_id'];
            $merchant['default_tax_id'] = $tax_rates['default_tax_id'];

            // create default payment types
            $this->_createDefaultPaymentTypes($merchant_id);

            // create a quick key
            $quick_key_id = $this->_createDefaultQuickKey($merchant_id, NULL);
            $merchant['default_quick_key_id'] = $quick_key_id;

            // create a receipt template
            $receipt_template_id = $this->_createDefaultReceiptTemplate($merchant_id, NULL, $data['name']);

            // create a main outlet and register
            $this->_createDefaultOutlet($merchant_id, NULL, $quick_key_id, $receipt_template_id);

            // create default supplier
            $supplier_id = $this->_createDefaultSupplier($merchant_id, $contact, $data['name']);

            // create discount product
            $discount_product_id = $this->_createDiscountProduct($merchant_id, $tax_rates['default_tax_id']);
            $merchant['discount_product_id'] = $discount_product_id;

            // create default products
            $this->_createDefaultProducts($merchant_id, $supplier_id, $tax_rates['default_tax_id'], $quick_key_id);

            // create a default price book
            $price_book_id = $this->_createDefaultPriceBook($merchant_id, $customer_group_id);
            $merchant['default_price_book_id'] = $price_book_id;

            // create a default inventories
            $this->_createDefaultInventory($merchant_id);

            // create a merchant loyalty
            $this->_createMerchantLoyalty($merchant_id, $data['name']);

            // create a merchant addon
            $this->_createMerchantAddon($merchant_id, NULL);

            // update the merchant
            if (!$this->Merchant->save(array('Merchant' => $merchant))) {
                $errors['merchant'] = $this->Merchant->validationErrors;
                throw new Exception(json_encode($errors));
            }

            $dataSource->commit();

            if (empty($this->Auth->subdomain) || $this->Auth->subdomain === $data['domain_prefix']) {
                $redirect_url = '/signin';
            } else {
                $redirect_url = 'https://' . $data['domain_prefix'] . '.onzsa.com/signin';
            }
            $this->redirect($redirect_url);
        } catch (Exception $e) {
            $dataSource->rollback();
            $this->Session->setFlash($e->getMessage());
            if (json_decode($e->getMessage()) != null) {
                $this->set('errors', json_decode($e->getMessage(), true));
            }
        }

        /*
        try {
            if (isset($data['plan_id_1']) && !empty($data['plan_id_1']) && $data['plan_id_1'] == 'subscriber_plan_franchise') {
                // create a retailer
                $this->MerchantRetailer->create();
                $data['merchant_id'] = $data['parent_merchant_id'];
                $this->MerchantRetailer->save($data);
                $merchant_id = $data['parent_merchant_id'];
                $retailer_id = $this->MerchantRetailer->id;
                
                // create a default user
                $this->_createDefaultUser($merchant_id, $retailer_id, $data['username'], $data['password'], $data['first_name'] . ' ' . $data['last_name']);
                
                // create a quick key
                $quick_key_id = $this->_createDefaultQuickKey($merchant_id, $retailer_id);

                // create a receipt template
                $receipt_template_id = $this->_createDefaultReceiptTemplate($merchant_id, $retailer_id, $data['name']);
                
                // create a main outlet and register
                $this->createDefaultOutlet($merchant_id, $retailer_id, $quick_key_id, $receipt_template_id);
            } else {
                // create a contact
                $this->Contact->create();
                $contact['Contact'] = $data;
                $contact['Contact']['email'] = $data['username'];
                $this->Contact->save($contact);
                
                // create a subscriber
                $this->Subscriber->create();
                $subscriber['Subscriber']['contact_id'] = $this->Contact->id;
                $subscriber['Subscriber']['username'] = $data['username'];
                $subscriber['Subscriber']['password'] = $data['password'];
                $this->Subscriber->save($subscriber);
                $data['subscriber_id'] = $this->Subscriber->id;

                // create a merchant
                $this->Merchant->create();
                $merchant['Merchant'] = $data;
                $merchant['Merchant']['merchant_code'] = $this->_generateMerchantCode(6);
                if ($data['plan_id'] == 'subscriber_plan_retailer_trial') {
                    $merchant['Merchant']['trial_ends'] = CakeTime::format('+30 days', '%Y-%m-%d');
                }
                $this->Merchant->save($merchant);
                $merchant_id = $this->Merchant->id;
                
                // create a default user
                $this->_createDefaultUser($merchant_id, NULL, $data['username'], $data['password'], $data['first_name'] . ' ' . $data['last_name']);
                
                // create a default customer group
                $customer_group_id = $this->_createDefaultCustomerGroup($merchant_id);
    
                // create a default customer
                $this->_createDefaultCustomer($merchant_id, $customer_group_id);
    
                // create default tax rates
                $default_tax_id = $this->_createDefaultTaxRates($merchant_id, $data['physical_country']);
    
                // create default payment types
                $this->_createDefaultPaymentTypes($merchant_id);
    
                // create a quick key
                $quick_key_id = $this->_createDefaultQuickKey($merchant_id, NULL);
    
                // create a receipt template
                $receipt_template_id = $this->_createDefaultReceiptTemplate($merchant_id, NULL, $data['name']);
    
                // create a main outlet and register
                $this->_createDefaultOutlet($merchant_id, NULL, $quick_key_id, $receipt_template_id);
    
                // create default supplier
                $supplier_id = $this->_createDefaultSupplier($merchant_id, $contact, $data['name']);
    
                // create default products
                $this->_createDefaultProducts($merchant_id, $supplier_id, $default_tax_id, $quick_key_id);
    
                // create a default price book
                $this->_createDefaultPriceBook($merchant_id, $customer_group_id);
    
                // create a default inventories
                $this->_createDefaultInventory($merchant_id);
    
                // create a merchant loyalty
                $this->_createMerchantLoyalty($merchant_id, $data['name']);
            }

            $dataSource->commit();

            $names = explode(".", $_SERVER['HTTP_HOST']);
            if ($_SERVER['HTTP_HOST'] !== 'localhost' && !is_numeric($names[0])) {
                $this->redirect('https://'.$data['domain_prefix'].'.onzsa.com/users/login');
            } else {
                $this->redirect('/users/login');
            }
        } catch (Exception $e) {
            $dataSource->rollback();
            $this->Session->setFlash($e->getMessage());
        }
         */
    }

/**
 * Create a default user function.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string username
 * @param string password
 * @param string display name
 * @return void
 */
    protected function _createDefaultUser($merchant_id, $retailer_id, $username, $password, $display_name) {
        $this->loadModel('MerchantUser');

        $user = array();
        $user['merchant_id'] = $merchant_id;
        $user['retailer_id'] = $retailer_id;
        $user['user_type_id'] = 'user_type_admin';
        $user['username'] = $username;
        $user['password'] = $password;
        $user['display_name'] = $display_name;
        $user['email'] = $username;

        $this->MerchantUser->create();
        if (!$this->MerchantUser->save(array('MerchantUser' => $user))) {
            $errors['internal'] = $this->MerchantUser->validationErrors;
            throw new Exception(json_encode($errors));
        }
    }

/**
 * Create a default customer group function.
 *
 * @param string merchant id
 * @return uuid
 */
    protected function _createDefaultCustomerGroup($merchant_id) {
        $this->loadModel('MerchantCustomerGroup');

        $group = array();
        $group['merchant_id'] = $merchant_id;
        $group['group_code'] = 'onzsa';
        $group['name'] = 'All Customers';

        $this->MerchantCustomerGroup->create();
        if (!$this->MerchantCustomerGroup->save(array('MerchantCustomerGroup' => $group))) {
            $errors['internal'] = $this->MerchantCustomerGroup->validationErrors;
            throw new Exception(json_encode($errors));
        }
        return $this->MerchantCustomerGroup->id;
    }

/**
 * Create a default customer function.
 *
 * @param string merchant id
 * @param string customer group id
 * @return uuid
 */
    protected function _createDefaultCustomer($merchant_id, $customer_group_id) {
        $this->loadModel('MerchantCustomer');

        $customer = array();
        $customer['merchant_id'] = $merchant_id;
        $customer['customer_group_id'] = $customer_group_id;
        $customer['customer_code'] = 'walkin';
        $customer['name'] = 'Walkin';

        $this->MerchantCustomer->create();
        if (!$this->MerchantCustomer->save(array('MerchantCustomer' => $customer))) {
            $errors['internal'] = $this->MerchantCustomer->validationErrors;
            throw new Exception(json_encode($errors));
        }
        return $this->MerchantCustomer->id;
    }

/**
 * Create default payment types function.
 *
 * @param string merchant id
 * @return void
 */
    protected function _createDefaultPaymentTypes($merchant_id) {
        $this->loadModel('MerchantPaymentType');
        $this->loadModel('PaymentType');

        $payments = $this->PaymentType->find('all', array(
            'conditions' => array(
                'PaymentType.name' => array('Cash', 'Credit Card', 'Loyalty', 'Xero')
            )
        ));

        foreach ($payments as $payment) {
            $data = array();
            $data['merchant_id'] = $merchant_id;
            $data['payment_type_id'] = $payment['PaymentType']['id'];
            $data['name'] = $payment['PaymentType']['name'];
            $data['config'] = $payment['PaymentType']['config'];
            $data['is_active'] = $payment['PaymentType']['is_active'];

            $this->MerchantPaymentType->create();
            if (!$this->MerchantPaymentType->save(array('MerchantPaymentType' => $data))) {
                $errors['internal'] = $this->MerchantPaymentType->validationErrors;
                throw new Exception(json_encode($errors));
            }
        }
    }

/**
 * Create default tax rates function.
 *
 * @param string merchant id
 * @param string country id
 * @return array
 */
    protected function _createDefaultTaxRates($merchant_id, $country) {
        $this->loadModel('MerchantTaxRate');
        $this->loadModel('TaxRate');

        $rates = $this->TaxRate->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'TaxRate.country' => $country,
                    'TaxRate.country IS NULL'
                )
            )
        ));

        $tax_rates = array();
        foreach ($rates as $rate) {
            $data = $rate['TaxRate'];
            $data['merchant_id'] = $merchant_id;
            unset($data['id']);

            $this->MerchantTaxRate->create();
            if (!$this->MerchantTaxRate->save(array('MerchantTaxRate' => $data))) {
                $errors['internal'] = $this->MerchantTaxRate->validationErrors;
                throw new Exception(json_encode($errors));
            }

            if ($data['is_default'] == 1) {
                $tax_rates['default_tax_id'] = $this->MerchantTaxRate->id;
            } elseif ($data['name'] === 'No Tax') {
                $tax_rates['default_no_tax_group_id'] = $this->MerchantTaxRate->id;
            }
        }

        return $tax_rates;
    }

/**
 * Create a default quick key function.
 *
 * @param string merchant id
 * @param string retailer id
 * @return uuid
 */
    protected function _createDefaultQuickKey($merchant_id, $retailer_id) {
        $this->loadModel('MerchantQuickKey');

        // create a quick key
        $data = array();
        $data['merchant_id'] = $merchant_id;
        $data['retailer_id'] = $retailer_id;
        $data['name'] = 'Default Stock List';

        $this->MerchantQuickKey->create();
        if (!$this->MerchantQuickKey->save(array('MerchantQuickKey' => $data))) {
            $errors['internal'] = $this->MerchantQuickKey->validationErrors;
            throw new Exception(json_encode($errors));
        }
        return $this->MerchantQuickKey->id;
    }

/**
 * Create a default receipt template function.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string store name
 * @return uuid
 */
    protected function _createDefaultReceiptTemplate($merchant_id, $retailer_id, $store_name) {
        $this->loadModel('MerchantReceiptTemplate');
        $this->loadModel('ReceiptStyle');

        if (empty($retailer_id)) {
            $data = array();
            $data['merchant_id'] = $merchant_id;
            $data['name'] = 'Standard Receipt';
            $data['receipt_style_id'] = 1;
            $data['receipt_header'] = $store_name;

            $this->MerchantReceiptTemplate->create();
            if (!$this->MerchantReceiptTemplate->save(array('MerchantReceiptTemplate' => $data))) {
                $errors['internal'] = $this->MerchantReceiptTemplate->validationErrors;
                throw new Exception(json_encode($errors));
            }
            return $this->MerchantReceiptTemplate->id;
        } else {
            return $this->MerchantReceiptTemplate->findByMerchantId($merchant_id)['MerchantReceiptTemplate']['id'];
        }
    }

/**
 * Create a main outlet and register function.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string quick key id
 * @param string receipt template id
 * @return void
 */
    protected function _createDefaultOutlet($merchant_id, $retailer_id, $quick_key_id, $receipt_template_id) {
        $this->loadModel('MerchantOutlet');
        $this->loadModel('MerchantRegister');

        // create a main outlet
        $outlet = array();
        $outlet['merchant_id'] = $merchant_id;
        $outlet['name'] = 'Main Outlet';

        $this->MerchantOutlet->create();
        if (!$this->MerchantOutlet->save(array('MerchantOutlet' => $outlet))) {
            $errors['internal'] = $this->MerchantOutlet->validationErrors;
            throw new Exception(json_encode($errors));
        }

        // create a main register
        $register = array();
        $register['outlet_id'] = $this->MerchantOutlet->id;
        $register['name'] = 'Main Register';
        $register['quick_key_id'] = $quick_key_id;
        $register['receipt_template_id'] = $receipt_template_id;

        $this->MerchantRegister->create();
        if (!$this->MerchantRegister->save(array('MerchantRegister' => $register))) {
            $errors['internal'] = $this->MerchantRegister->validationErrors;
            throw new Exception(json_encode($errors));
        }
    }

/**
 * Create a default supplier function.
 *
 * @param string merchant id
 * @param array contact information
 * @param string supplier name
 * @return uuid
 */
    protected function _createDefaultSupplier($merchant_id, $contact, $name) {
        $this->loadModel('MerchantSupplier');

        // create a contact
        $this->Contact->create();
        $this->Contact->save($contact);

        // create a default supplier
        $supplier['merchant_id'] = $merchant_id;
        $supplier['contact_id'] = $this->Contact->id;
        $supplier['name'] = $name;

        $this->MerchantSupplier->create();
        if (!$this->MerchantSupplier->save(array('MerchantSupplier' => $supplier))) {
            $errors['internal'] = $this->MerchantSupplier->validationErrors;
            throw new Exception(json_encode($errors));
        }
        return $this->MerchantSupplier->id;
    }

/**
 * Create default products function.
 *
 * @param string merchant id
 * @param string supplier id
 * @param string tax rate id
 * @param string quick key id
 * @return void
 */
    protected function _createDefaultProducts($merchant_id, $supplier_id, $default_tax_id, $quick_key_id) {
        $this->loadModel('MerchantProductBrand');
        $this->loadModel('MerchantProductType');
        $this->loadModel('MerchantProductTag');
        $this->loadModel('MerchantProductCategory');
        $this->loadModel('MerchantProduct');

        // create a default product brand
        $brand = array();
        $brand['merchant_id'] = $merchant_id;
        $brand['name'] = 'General';

        $this->MerchantProductBrand->create();
        if (!$this->MerchantProductBrand->save(array('MerchantProductBrand' => $brand))) {
            $errors['internal'] = $this->MerchantProductBrand->validationErrors;
            throw new Exception(json_encode($errors));
        }

        // create a default product type
        $type = array();
        $type['merchant_id'] = $merchant_id;
        $type['name'] = 'General';

        $this->MerchantProductType->create();
        if (!$this->MerchantProductType->save(array('MerchantProductType' => $type))) {
            $errors['internal'] = $this->MerchantProductType->validationErrors;
            throw new Exception(json_encode($errors));
        }

        // create a default product tag
        $tag = array();
        $tag['merchant_id'] = $merchant_id;
        $tag['name'] = 'General';

        $this->MerchantProductTag->create();
        if (!$this->MerchantProductTag->save(array('MerchantProductTag' => $tag))) {
            $errors['internal'] = $this->MerchantProductTag->validationErrors;
            throw new Exception(json_encode($errors));
        }

        // get a default tax rate
        $rate = $this->MerchantTaxRate->findById($default_tax_id);

        // create a product of yoghurt flavour banana
        $product1 = array();
        $product1['merchant_id'] = $merchant_id;
        $product1['name'] = 'Yoghurt Fruity Tart';
        $product1['handle'] = 'yoghurt-fruity-tart';
        $product1['sku'] = 'yoghurt-fruity-tart';
        $product1['product_brand_id'] = $this->MerchantProductBrand->id;
        $product1['product_type_id'] = $this->MerchantProductType->id;
        $product1['supplier_id'] = $supplier_id;
        $product1['supply_price'] = 3.0;
        $product1['markup'] = 0.20;
        $product1['price'] = $product1['supply_price'] * (1.0 + $product1['markup']);
        $product1['tax'] = $product1['price'] * $rate['MerchantTaxRate']['rate'];
        $product1['tax_id'] = $rate['MerchantTaxRate']['id'];
        $product1['price_include_tax'] = $product1['price'] + $product1['tax'];
        $product1['image'] = "/img/no-image.png";
        $product1['image_large'] = "/img/no-image.png";

        $this->MerchantProduct->create();
        if (!$this->MerchantProduct->save(array('MerchantProduct' => $product1))) {
            $errors['internal'] = $this->MerchantProduct->validationErrors;
            throw new Exception(json_encode($errors));
        }
        $product1['id'] = $this->MerchantProduct->id;

        // Add a product category
        $category = array();
        $category['product_id'] = $product1['id'];
        $category['product_tag_id'] = $this->MerchantProductTag->id;

        $this->MerchantProductCategory->create();
        if (!$this->MerchantProductCategory->save(array('MerchantProductCategory' => $category))) {
            $errors['internal'] = $this->MerchantProductCategory->validationErrors;
            throw new Exception(json_encode($errors));
        }

        // create a product of yoghurt flavour banana
        $product2['merchant_id'] = $merchant_id;
        $product2['name'] = 'Yoghurt Creamy Delight';
        $product2['handle'] = 'yoghurt-creamy-delight';
        $product2['sku'] = 'yoghurt-creamy-delight';
        $product2['product_brand_id'] = $this->MerchantProductBrand->id;
        $product2['product_type_id'] = $this->MerchantProductType->id;
        $product2['supplier_id'] = $supplier_id;
        $product2['supply_price'] = 3.2;
        $product2['markup'] = 0.20;
        $product2['price'] = $product2['supply_price'] * (1.0 + $product2['markup']);
        $product2['tax'] = $product2['price'] * $rate['MerchantTaxRate']['rate'];
        $product2['tax_id'] = $rate['MerchantTaxRate']['id'];
        $product2['price_include_tax'] = $product2['price'] + $product2['tax'];
        $product2['image'] = "/img/no-image.png";
        $product2['image_large'] = "/img/no-image.png";

        $this->MerchantProduct->create();
        if (!$this->MerchantProduct->save(array('MerchantProduct' => $product2))) {
            $errors['internal'] = $this->MerchantProduct->validationErrors;
            throw new Exception(json_encode($errors));
        }
        $product2['id'] = $this->MerchantProduct->id;

        // Add a product category
        $category = array();
        $category['product_id'] = $product2['id'];
        $category['product_tag_id'] = $this->MerchantProductTag->id;

        $this->MerchantProductCategory->create();
        if (!$this->MerchantProductCategory->save(array('MerchantProductCategory' => $category))) {
            $errors['internal'] = $this->MerchantProductCategory->validationErrors;
            throw new Exception(json_encode($errors));
        }

        // update a default quick key layout
        /*
        $quick_key_layout = array(
            'name' => 'Default',
            'pages' => array(
                array(
                    'page' => 1,
                    'keys' => array(
                        array(
                            'position' => 0,
                            'product_id' => $product1['id'],
                            'sku' => $product1['sku'],
                            'label' => $product1['name'],
                            'color' => '#ffffff',
                            'image' => '/img/no-image.png'
                        ),
                        array(
                            'position' => 1,
                            'product_id' => $product2['id'],
                            'sku' => $product2['sku'],
                            'label' => $product2['name'],
                            'color' => '#ffffff',
                            'image' => '/img/no-image.png'
                        )
                    )
                )
            )
        );
         */
        $quick_key_layout = array(
            'quick_keys' => array(
                'groups' => array(
                    array(
                        'position' => 0,
                        'name' => 'Group 1',
                        'color' => 'white',
                        'pages' => array(
                            array(
                                'page' => 1,
                                'keys' => array(
                                    array(
                                        'position' => 0,
                                        'label' => $product1['name'],
                                        'sku' => $product1['sku'],
                                        'product_id' => $product1['id'],
                                        'color' => '#fff',
                                        'image' => '/img/no-image.png'
                                    ),
                                    array(
                                        'position' => 1,
                                        'product_id' => $product2['id'],
                                        'sku' => $product2['sku'],
                                        'label' => $product2['name'],
                                        'color' => '#fff',
                                        'image' => '/img/no-image.png'
                                    )
                                )
                            )
                        )
                    )
                )
            )
        );

        $this->MerchantQuickKey->id = $quick_key_id;
        $this->MerchantQuickKey->saveField('key_layouts', json_encode($quick_key_layout));
    }

/**
 * Create discount product function.
 *
 * @param string merchant id
 * @param string tax rate id
 * @return void
 */
    protected function _createDiscountProduct($merchant_id, $default_tax_id) {
        $this->loadModel('MerchantProduct');

        // create a discount product
        $product['merchant_id'] = $merchant_id;
        $product['name'] = 'Line Price';
        $product['handle'] = 'onzsa-line-price';
        $product['sku'] = 'onzsa-line-price';
        $product['supply_price'] = 0;
        $product['markup'] = 0;
        $product['price'] = 0;
        $product['tax'] = 0;
        $product['tax_id'] = $default_tax_id;
        $product['price_include_tax'] = 0;
        $product['image'] = "/img/no-image.png";
        $product['image_large'] = "/img/no-image.png";

        $this->MerchantProduct->create();
        if (!$this->MerchantProduct->save(array('MerchantProduct' => $product))) {
            $errors['internal'] = $this->MerchantProduct->validationErrors;
            throw new Exception(json_encode($errors));
        }

        return $this->MerchantProduct->id;
    }

/**
 * Create default price book function.
 *
 * @param string merchant id
 * @param string customer group id
 * @return void
 */
    protected function _createDefaultPriceBook($merchant_id, $customer_group_id) {
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantPriceBook');
        $this->loadModel('MerchantPriceBookEntry');

        // create a default price book
        $priceBook = array();
        $priceBook['merchant_id'] = $merchant_id;
        $priceBook['name'] = 'General Price Book (All Products)';
        $priceBook['customer_group_id'] = $customer_group_id;
        $priceBook['is_default'] = 1;

        $this->MerchantPriceBook->create();
        if (!$this->MerchantPriceBook->save(array('MerchantPriceBook' => $priceBook))) {
            $errors['internal'] = $this->MerchantPriceBook->validationErrors;
            throw new Exception(json_encode($errors));
        }

        // get product list
        $products = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $merchant_id
            )
        ));

        // create a price book entry
        foreach ($products as $product) {
            $data = array();
            $data['price_book_id'] = $this->MerchantPriceBook->id;
            $data['product_id'] = $product['MerchantProduct']['id'];
            $data['markup'] = $product['MerchantProduct']['markup'];
            $data['price'] = $product['MerchantProduct']['price'];
            $data['price_include_tax'] = $product['MerchantProduct']['price_include_tax'];
            $data['tax'] = $product['MerchantProduct']['tax'];

            $this->MerchantPriceBookEntry->create();
            if (!$this->MerchantPriceBookEntry->save(array('MerchantPriceBookEntry' => $data))) {
                $errors['internal'] = $this->MerchantPriceBookEntry->validationErrors;
                throw new Exception(json_encode($errors));
            }
        }

        return $this->MerchantPriceBook->id;
    }

/**
 * Create default inventories function.
 *
 * @param string merchant id
 * @return void
 */
    protected function _createDefaultInventory($merchant_id) {
        $this->loadModel('MerchantOutlet');
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductInventory');

        // get outlet list
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $merchant_id
            )
        ));

        // get product list
        $products = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $merchant_id
            )
        ));

        // create a product inventory
        foreach ($outlets as $outlet) {
            foreach ($products as $product) {
                $data = array();
                $data['outlet_id'] = $outlet['MerchantOutlet']['id'];
                $data['product_id'] = $product['MerchantProduct']['id'];

                $this->MerchantProductInventory->create();
                if (!$this->MerchantProductInventory->save(array('MerchantProductInventory' => $data))) {
                    $errors['internal'] = $this->MerchantProductInventory->validationErrors;
                    throw new Exception(json_encode($errors));
                }
            }
        }
    }

/**
 * Create a merchant loyalty function.
 *
 * @param string merchant id
 * @param string store name
 * @return void
 */
    protected function _createMerchantLoyalty($merchant_id, $store_name) {
        $this->loadModel('MerchantLoyalty');

        // create a merchant loyalty
        $loyalty = array();
        $loyalty['merchant_id'] = $merchant_id;
        $loyalty['loyalty_earn_amount'] = 1;
        $loyalty['loyalty_spend_amount'] = 50;
        $loyalty['offer_signup_bonus_loyalty'] = 0;
        $loyalty['signup_bonus_loyalty_amount'] = 0;
        $loyalty['send_welcome_email'] = 0;
        $loyalty['welcome_email_subject'] = 'Welcome to the ' . $store_name . ' Loyalty Program';

        $email_body = '<h1>Welcome to ' . $store_name . ' Loyalty Program</h1>';
        $email_body .= '<p>You can earn Loyalty $ when you make purchases at onzsa and redeem your credit in store.</p>';
        $email_body .= '<p>Thanks,<br>' . $store_name . '</p>';
        $email_body .= '<p>Register your details with the ' . $store_name . ' Loyalty Program to earn an additional $ Loyalty:</p>';
        $loyalty['welcome_email_body'] = base64_encode($email_body);

        $this->MerchantLoyalty->create();
        if (!$this->MerchantLoyalty->save(array('MerchantLoyalty' => $loyalty))) {
            $errors['internal'] = $this->MerchantLoyalty->validationErrors;
            throw new Exception(json_encode($errors));
        }
    }

/**
 * Create a merchant addons function.
 *
 * @param string merchant id
 * @param string retailer id
 * @return void
 */
    protected function _createMerchantAddon($merchant_id, $retailer_id) {
        $this->loadModel('MerchantAddon');

        // create a merchant addons
        $data = array();
        $data['merchant_id'] = $merchant_id;
        $data['retailer_id'] = $retailer_id;

        $this->MerchantAddon->create();
        if (!$this->MerchantAddon->save(array('MerchantAddon' => $data))) {
            $errors['internal'] = $this->MerchantAddon->validationErrors;
            throw new Exception(json_encode($errors));
        }
    }

}
