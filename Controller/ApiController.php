<?php

App::uses('AppController', 'Controller');
App::uses('CakeTime', 'Utility');

class ApiController extends AppController {

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
    public $layout = '';

/**
 * This controller uses the following models.
 *
 * @var array
 */
    public $uses = array(
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();

        //$this->Auth->allow('get_price_books', 'get_products', 'get_quick_keys');
    }

/**
 * Check network connectivity.
 *
 * @return array
 */
    public function ping() {
      $response['success'] = true;
      $this->serialize($response);
    }

/**
 * Retreive session user variable
 *
 * @return array
 */
    public function check_user_session() {
      $response["user"] = $this->Auth->user();
      $this->serialize($response);
    }

/**
 * Retreive registers config by user_id
 *
 * @return array
 */
    public function config() {
      $this->loadModel('MerchantUser');
      $user = $this->Auth->user();

      $result = $this->MerchantUser->find('first', [
        'fields' => [
          'Merchant.*',
          'MerchantUser.*',
          'MerchantRetailer.*',
          'MerchantLoyalty.*',
          'MerchantOutlet.*',
        ],
        'joins' => [
          [
            'table' => 'merchant_retailers',
            'alias' => 'MerchantRetailer',
            'type' => 'LEFT',
            'conditions' => [
              'MerchantRetailer.id = MerchantUser.retailer_id'
            ]
          ],
          [
            'table' => 'merchant_loyalties',
            'alias' => 'MerchantLoyalty',
            'type' => 'LEFT',
            'conditions' => [
              'MerchantLoyalty.merchant_id = Merchant.id'
            ]
          ],
          [
            'table' => 'merchant_outlets',
            'alias' => 'MerchantOutlet',
            'type' => 'LEFT',
            'conditions' => [
              'MerchantOutlet.id = MerchantUser.outlet_id'
            ]
          ]
        ],
        'conditions' => [
          'MerchantUser.id' => $user['id']
        ]
      ]);

      $response['version']                     = 1.0;
      $response['merchant_id']                 = $result['Merchant']['id'];
      $response['merchant_name']               = $result['Merchant']['name'];
      $response['domain_prefix']               = $result['Merchant']['domain_prefix'];
      $response['business_type_id']            = $result['Merchant']['business_type_id'];
      $response['default_customer_group_id']   = $result['Merchant']['default_customer_group_id'];
      $response['default_customer_id']         = $result['Merchant']['default_customer_id'];
      $response['default_no_tax_group_id']     = $result['Merchant']['default_no_tax_group_id'];
      $response['default_tax_id']              = $result['Merchant']['default_tax_id'];
      $response['discount_product_id']         = $result['Merchant']['discount_product_id'];
      $response['default_quick_key_id']        = $result['Merchant']['default_quick_key_id'];
      $response['default_currency']            = $result['Merchant']['default_currency'];
      $response['time_zone']                   = $result['Merchant']['time_zone'];
      $response['display_price_tax_inclusive'] = $result['Merchant']['display_price_tax_inclusive'];
      $response['allow_cashier_discount']      = $result['Merchant']['allow_cashier_discount'];
      $response['allow_use_scale']             = $result['Merchant']['allow_use_scale'];
      $response['retailer_id']                 = $result['MerchantRetailer']['id'];
      $response['outlet_id']                   = $result['MerchantOutlet']['id'];
      $response['outlet_name']                 = $result['MerchantOutlet']['name'];
      $response['enable_loyalty']              = $result['MerchantLoyalty']['enable_loyalty'];
      $response['loyalty_ratio']               = $result['MerchantLoyalty']['loyalty_earn_amount'] / $result['MerchantLoyalty']['loyalty_spend_amount'];
      $response['user_id']                     = $result['MerchantUser']['id'];
      $response['user_name']                   = $result['MerchantUser']['username'];
      $response['user_display_name']           = $result['MerchantUser']['display_name'];
      $response['user_type']                   = $result['MerchantUser']['user_type_id'];

      $this->serialize($response);
    }

/**
 * Retreive taxes by user_id
 *
 * @return array
 */
    public function taxes() {
      $this->request->onlyAllow('get');

      $this->loadModel('MerchantTaxRate');
      $user = $this->Auth->user();

      $result = $this->MerchantTaxRate->find('all', [
        'conditions' => [
          'MerchantTaxRate.merchant_id' => $user['merchant_id'],
          'MerchantTaxRate.is_deleted' => 0
        ],
        'order' => [
          'MerchantTaxRate.created'
        ]
      ]);

      $response = Hash::map($result, "{n}", function($array) {
        return $array['MerchantTaxRate'];
      });

      $this->serialize($response);
    }

/**
 * Retreive payments by user_id
 *
 * @return array
 */
    public function payment_types() {
      $this->request->onlyAllow('get');

      $this->loadModel('MerchantPaymentType');
      $user = $this->Auth->user();

      $result = $this->MerchantPaymentType->find('all', [
        'conditions' => [
          'MerchantPaymentType.merchant_id' => $user['merchant_id'],
          'MerchantPaymentType.is_active' => 1,
          'MerchantPaymentType.is_deleted' => 0
        ],
        'order' => [
          'MerchantPaymentType.created',
          'MerchantPaymentType.payment_type_id'
        ]
      ]);

      $response = Hash::map($result, "{n}", function($array) {
        return $array['MerchantPaymentType'];
      });

      $this->serialize($response);
    }

/**
 * Retreive registers by user_id
 *
 * @return array
 */
    public function registers() {
      $this->request->onlyAllow('get');

      $this->loadModel('MerchantRegister');
      $user = $this->Auth->user();

      $conditions = [
        'MerchantOutlet.merchant_id' => $user['merchant_id'],
      ];

      if (!empty($user['register_id'])) {
        $conditions += [
          'MerchantOutlet.register_id' => $user['register_id']
        ];
      }

      if (!empty($user['outlet_id'])) {
        $conditions += [
          'MerchantOutlet.id' => $user['outlet_id']
        ];
      }

      $registers = $this->MerchantRegister->find('all', [
        'fields' => [
          'MerchantRegister.id',
          'MerchantRegister.name',
          'MerchantRegister.outlet_id',
          'MerchantRegister.invoice_sequence',
          'MerchantRegister.invoice_prefix',
          'MerchantRegister.invoice_suffix',
          'MerchantRegister.email_receipt',
          'MerchantRegister.print_receipt',
          'MerchantRegister.ask_for_user_on_sale',
          'MerchantRegister.ask_for_note_on_save',
          'MerchantRegister.print_note_on_receipt',
          'MerchantRegister.show_discounts',
          'MerchantRegister.register_open_count_sequence',
          'MerchantQuickKey.key_layouts',
          'MerchantReceiptTemplate.receipt_header',
          'MerchantReceiptTemplate.receipt_footer',
          'MerchantReceiptTemplate.receipt_barcode',
          'MerchantReceiptTemplate.label_invoice',
          'MerchantReceiptTemplate.label_invoice_title',
          'MerchantReceiptTemplate.label_served_by',
          'MerchantReceiptTemplate.label_line_discount',
          'MerchantReceiptTemplate.label_sub_total',
          'MerchantReceiptTemplate.label_tax',
          'MerchantReceiptTemplate.label_to_pay',
          'MerchantReceiptTemplate.label_total',
          'MerchantReceiptTemplate.label_change',
          'MerchantReceiptTemplate.banner_image',
          'ReceiptStyle.style_class',
          'MerchantRegisterOpen.id',
          'MerchantRegisterOpen.register_open_time',
          'MerchantRegisterOpen.register_close_time',
        ],
        'joins' => [
          [
            'table' => 'merchant_outlets',
            'alias' => 'MerchantOutlet',
            'type' => 'INNER',
            'conditions' => [
              'MerchantOutlet.id = MerchantRegister.outlet_id'
            ]
          ],
          [
            'table' => 'merchant_quick_keys',
            'alias' => 'MerchantQuickKey',
            'type' => 'INNER',
            'conditions' => [
              'MerchantQuickKey.id = MerchantRegister.quick_key_id'
            ]
          ],
          [
            'table' => 'merchant_receipt_templates',
            'alias' => 'MerchantReceiptTemplate',
            'type' => 'INNER',
            'conditions' => [
              'MerchantReceiptTemplate.id = MerchantRegister.receipt_template_id'
            ]
          ],
          [
            'table' => 'receipt_styles',
            'alias' => 'ReceiptStyle',
            'type' => 'INNER',
            'conditions' => [
              'ReceiptStyle.id = MerchantReceiptTemplate.receipt_style_id'
            ]
          ],
          [
            'table' => 'merchant_register_opens',
            'alias' => 'MerchantRegisterOpen',
            'type' => 'LEFT',
            'conditions' => [
              'MerchantRegisterOpen.register_id = MerchantRegister.id',
              'MerchantRegisterOpen.register_open_count_sequence = MerchantRegister.register_open_count_sequence'
            ]
          ]
        ],
        'conditions' => $conditions,
        'order' => [
          'MerchantRegister.created'
        ]
      ]);

      $response = Hash::map($registers, "{n}", function($array) {
        $newArray = $array['MerchantRegister'];
        $newArray['register_open_sequence_id'] = $array['MerchantRegisterOpen']['id'];
        $newArray['register_open_time'] = $array['MerchantRegisterOpen']['register_open_time'];
        $newArray['register_close_time'] = $array['MerchantRegisterOpen']['register_close_time'];
        $newArray['quick_keys_template'] = $array['MerchantQuickKey'];
        $newArray['receipt_template'] = $array['MerchantReceiptTemplate'];
        $newArray['receipt_template']['receipt_style_class'] = $array['ReceiptStyle']['style_class'];
        return $newArray;
      });
      $this->serialize($response);
    }

/**
 * Search customer by query string
 *
 * @return array
 */
    public function search_customer() {
      $this->request->onlyAllow('get');

      $this->loadModel('MerchantCustomer');
      $user = $this->Auth->user();
      $query = $this->get('query');
      $response = [];

      $customers = $this->MerchantCustomer->find('all', [
        'fields' => [
          'MerchantCustomer.id',
          'MerchantCustomer.customer_group_id',
          'MerchantCustomer.customer_code',
          'MerchantCustomer.name',
          'MerchantCustomer.balance',
          'MerchantCustomer.loyalty_balance',
          'Contact.first_name',
          'Contact.last_name',
          'Contact.email',
          'Contact.company_name',
        ],
        'joins' => [
          [
            'table' => 'merchants',
            'alias' => 'Merchant',
            'type' => 'INNER',
            'conditions' => [
              'Merchant.id = MerchantCustomer.merchant_id'
            ]
          ],
          [
            'table' => 'contacts',
            'alias' => 'Contact',
            'type' => 'INNER',
            'conditions' => [
              'Contact.id = MerchantCustomer.contact_id'
            ]
          ]
        ],
        'conditions' => [
          'Merchant.id' => $user['merchant_id'],
          'MerchantCustomer.is_deleted = 0',
          'OR' => [
            'MerchantCustomer.name like' => '%' . $query . '%',
            'MerchantCustomer.customer_code like' => '%' . $query . '%',
            'MerchantCustomer.id' =>  $query,
          ]
        ]
      ]);
      $response = [];

      if (!empty($customers) && is_array($customers)) {
        $response = Hash::map($customers, "{n}", function($array) {
          return $array['MerchantCustomer'];
        });
      }
      $this->serialize($response);
    }

/**
 * Retreive products by specified register_id
 *
 * @return array
 */
    public function products() {
      $this->request->onlyAllow('get');

      $this->loadModel('MerchantProduct');
      $user = $this->Auth->user();

      $products = $this->MerchantProduct->find('all', [
        'fields' => [
          'MerchantProduct.id',
          'MerchantProduct.merchant_id',
          'MerchantProduct.name',
          'MerchantProduct.handle',
          'MerchantProduct.description',
          'MerchantProduct.image',
          'MerchantProduct.image_large',
          'MerchantProduct.sku',
          'MerchantProduct.supply_price',
          'MerchantProduct.price',
          'MerchantProduct.product_uom',
          'MerchantProduct.tax',
          'MerchantProduct.price_include_tax',
          'MerchantProductBrand.name',
          'MerchantSupplier.name',
          'MerchantTaxRate.name',
          'MerchantTaxRate.rate'
        ],
        'joins' => [
          [
            'table' => 'merchant_product_brands',
            'alias' => 'MerchantProductBrand',
            'type' => 'LEFT',
            'conditions' => [
              'MerchantProductBrand.id = MerchantProduct.product_brand_id'
            ]
          ],
          [
            'table' => 'merchant_suppliers',
            'alias' => 'MerchantSupplier',
            'type' => 'LEFT',
            'conditions' => [
              'MerchantSupplier.id = MerchantProduct.supplier_id'
            ]
          ],
          [
            'table' => 'merchant_tax_rates',
            'alias' => 'MerchantTaxRate',
            'type' => 'INNER',
            'conditions' => [
              'MerchantTaxRate.id = MerchantProduct.tax_id'
            ]
          ]
        ],
        'conditions' => [
          'MerchantProduct.merchant_id' => $user['merchant_id'],
          'MerchantProduct.is_active' => 1,
          'MerchantProduct.is_deleted' => 0,
        ],
        'order' => [
          'MerchantProduct.created'
        ]
      ]);

      $response = Hash::map($products, "{n}", function($array) {
        $newArray = $array['MerchantProduct'];
        $newArray['brand_name'] = $array['MerchantProductBrand']['name'];
        $newArray['supplier_name'] = $array['MerchantSupplier']['name'];
        $newArray['tax_name'] = $array['MerchantTaxRate']['name'];
        $newArray['tax_rate'] = $array['MerchantTaxRate']['rate'];
        return $newArray;
      });

      $this->serialize($response);
    }

/**
 * Retreive price books by specified register_id
 *
 * @return array
 */
    public function get_price_books() {
      $this->request->onlyAllow('get');

      $register_id = $this->get('register_id');
      if (empty($register_id)) {
        $register_id = '55cfd1ed-4594-4e0f-8f76-14d84cf3b98e';
      }

      $this->loadModel('MerchantPriceBook');

      $list = $this->MerchantPriceBook->find('all', [
        'fields' => [
          'MerchantPriceBook.*',
          'MerchantPriceBookEntry.*',
        ],
        'joins' => [
          [
            'table' => 'merchant_price_book_entries',
            'alias' => 'MerchantPriceBookEntry',
            'type' => 'INNER',
            'conditions' => [
              'MerchantPriceBookEntry.price_book_id = MerchantPriceBook.id'
            ]
          ],
          [
            'table' => 'merchant_outlets',
            'alias' => 'MerchantOutlet',
            'type' => 'INNER',
            'conditions' => [
              'MerchantOutlet.merchant_id = MerchantPriceBook.merchant_id'
            ]
          ],
          [
            'table' => 'merchant_registers',
            'alias' => 'MerchantRegister',
            'type' => 'INNER',
            'conditions' => [
              'MerchantRegister.outlet_id = MerchantOutlet.id'
            ]
          ]
        ],
        'conditions' => [
          'MerchantRegister.id' => $register_id,
          'OR' => [
            'MerchantPriceBook.outlet_id IS NULL',
            'MerchantPriceBook.outlet_id = MerchantPriceBook.outlet_id'
          ]
        ],
        'order' => [
          'MerchantPriceBookEntry.product_id',
          'MerchantPriceBook.outlet_id DESC',
          'MerchantPriceBook.is_default ASC',
        ]
      ]);
      $response = Hash::map($list, "{n}", function($array) {
        $newArray = array_merge($array['MerchantPriceBook'], $array['MerchantPriceBookEntry']);
        $newArray['price_book_created'] = $array['MerchantPriceBook']['created'];
        return $newArray;
      });

      $this->serialize($response);
    }

/**
 * Retreive quick keys by specified register_id
 *
 * @return array
 */
    public function get_quick_keys() {
      $this->request->onlyAllow('get');

      $register_id = $this->get('register_id');
      $user = $this->Auth->user();

      $this->loadModel('MerchantQuickKey');

      $quickKey = $this->MerchantQuickKey->find('first', [
        'joins' => [
          [
            'table' => 'merchant_registers',
            'alias' => 'MerchantRegister',
            'type' => 'INNER',
            'conditions' => [
              'MerchantRegister.quick_key_id = MerchantQuickKey.id'
            ]
          ],
          [
            'table' => 'merchant_outlets',
            'alias' => 'MerchantOutlet',
            'type' => 'INNER',
            'conditions' => [
              'MerchantOutlet.id = MerchantRegister.outlet_id'
            ]
          ]
        ],
        'conditions' => [
          'MerchantOutlet.merchant_id' => $user['merchant_id'],
          'MerchantRegister.id' => $register_id
        ]
      ]);

      $response = [];
      if (!empty($quickKey)) {
        $response = json_decode($quickKey['MerchantQuickKey']['key_layouts'], true);
      }

      $this->serialize($response);
    }

/**
 * Retreive register sales and items for openning register by register_id
 *
 * @return array
 */
    public function get_register_sales() {
      $this->request->onlyAllow('get');

      $register_id = $this->get('register_id');
      $sync_date = $this->get('sync_date');
      $user = $this->Auth->user();

      $this->loadModel('RegisterSale');

      $this->RegisterSale->bindModel([
        'belongsTo' => [
            'MerchantCustomer' => [
                'classModel' => 'MerchantCustomer',
                'foreignKey' => 'customer_id',
            ],
            'MerchantUser' => [
                'classModel' => 'MerchantUser',
                'foreignKey' => 'user_id',
            ]
        ],
        'hasMany' => [
          'RegisterSaleItem' => [
            'classModel' => 'RegisterSaleItem',
            'foreignKey' => 'sale_id',
            'conditions' => [
              'RegisterSaleItem.sale_id' => 'RegisterSale.id'
            ]
          ],
          'RegisterSalePayment' => [
            'classModel' => 'RegisterSalePayment',
            'foreignKey' => 'sale_id',
            'conditions' => [
              'RegisterSalePayment.sale_id' => 'RegisterSale.id'
            ]
          ]
        ]
      ]);

      $conditions = [];
      if (!empty($sync_date)) {
        $conditions[] = [
          'RegisterSale.register_id' => $register_id,
          'RegisterSale.created >=' => $sync_date
        ];
      } else {
        $conditions[] = [
          'RegisterSale.register_id' => $register_id
        ];
      }

      $sales = $this->RegisterSale->find('all', [
        'conditions' => $conditions,
        'order' => [
          'RegisterSale.created' => 'ASC'
        ],
        'recursive' => 2
      ]);

      $response = Hash::map($sales, "{n}", function($array) {
        $newArray = $array['RegisterSale'];
        $newArray['user_name'] = $array['MerchantUser']['username'];
        $newArray['customer_code'] = $array['MerchantCustomer']['customer_code'];
        $newArray['customer_name'] = $array['MerchantCustomer']['name'];
        $newArray['sync_date'] = CakeTime::toUnix($newArray['created']);
        $newArray['sale_date'] = CakeTime::toUnix($newArray['sale_date']);
        $newArray['sync_status'] = 'sync_success';
        $newArray['total_payment'] = 0;
        $newArray['RegisterSaleItem'] = $array['RegisterSaleItem'];
        $newArray['RegisterSalePayment'] = [];

        foreach ($array['RegisterSalePayment'] as $item) {
          $item['register_id'] = $newArray['register_id'];
          $item['payment_type_id'] = $item['MerchantPaymentType']['payment_type_id'];
          unset($item['MerchantPaymentType']);
          $newArray['RegisterSalePayment'][] = $item;
          $newArray['total_payment'] += $item['amount'];
        }
        return $newArray;
      });

      $this->RegisterSale->unbindModel([
        'hasMany' => [ 'RegisterSaleItem', 'RegisterSalePayment' ]
      ]);

      $this->serialize($response);
    }

/**
 * Update register sales by register_id
 *
 * @return array
 */
    public function upload_register_sales() {
      $this->request->onlyAllow('post');

      $data = $this->request->data;
      $user = $this->Auth->user();

      $this->loadModel('RegisterSale');
      $this->loadModel('RegisterSaleItem');
      $this->loadModel('RegisterSalePayment');

      $dataSource = $this->RegisterSale->getDataSource();
      $response = [];
      $response['ids'] = [];

      foreach ($data['syncData'] as $sale) {
        $dataSource->begin();

        try {
          if (isset($sale['sale_date']) && !empty($sale['sale_date'])) {
            $sale['sale_date'] = date("Y-m-d H:i:s", (int)$sale['sale_date']);
          }

          $this->RegisterSale->create();
          $this->RegisterSale->save($sale);

          if (isset($sale['items']) && is_array($sale['items'])) {
            $this->RegisterSaleItem->saveMany($sale['items']);
          }

          if (isset($sale['payments']) && is_array($sale['payments'])) {
            $payments = $sale['payments'];

            foreach ($payments as &$payment) {
              if (isset($payment['payment_date']) && !empty($payment['payment_date'])) {
                $payment['payment_date'] = date("Y-m-d H:i:s", $payment['payment_date']);
              }
            }
            $this->RegisterSalePayment->saveMany($payments);
          }

          $dataSource->commit();
          $response['ids'][] = $this->RegisterSale->id;
        } catch (Exception $e) {
          $dataSource->rollback();
          $response['error'] = $e->getMessage();
        }
      }

      $this->serialize($response);
    }


  /**
   * Close register sales
   */
  public function close_register() {
    $this->request->onlyAllow('post');
    $user = $this->Auth->user();

    $this->loadModel('MerchantRegisterOpen');

    $result = array(
        'success' => false
    );
    try {
      $data = $this->request->data;
      $opens = $this->MerchantRegisterOpen->find('first', array(
          'conditions' => [
              'MerchantRegisterOpen.id' => $data['openId']
          ]
      ));

      $close_time = date("Y-m-d H:i:s");
      $opens['MerchantRegisterOpen']['register_close_time'] = $close_time;
      $this->MerchantRegisterOpen->save($opens['MerchantRegisterOpen']);

      $result['success'] = true;
      $result['close_time'] = $close_time;
    } catch (Exception $e) {
      $result['message'] = $e->getMessage();
    }
    $this->serialize($result);
    return;
  }

  /**
   * Check register sales opened
   *
   * @return boolean
   */
  public function is_opened_register() {
    $this->request->onlyAllow('get');
    $user = $this->Auth->user();

    $this->loadModel('MerchantRegisterOpen');

    $result = array(
        'success' => false
    );
    try {
      $register_id = $this->get('register_id');

      $opens = $this->MerchantRegisterOpen->find('all', array(
        'conditions' => array(
          'MerchantRegisterOpen.register_id' => $register_id,
          'MerchantRegisterOpen.register_close_time' => ''
        )
      ));
      if (count($opens) > 0) {
        $result['opened'] = true;
      } else {
        $result['opened'] = false;
      }
      $result['success'] = true;
    } catch (Exception $e) {
      $result['message'] = $e->getMessage();
    }
    $this->serialize($result);
    return;
  }

  /**
   *  Open register sales
   */
  public function open_register() {
    $this->request->onlyAllow('post');
    $user = $this->Auth->user();

    $this->loadModel('MerchantRegister');
    $this->loadModel('MerchantRegisterOpen');

    $result = array(
        'success' => false
    );
    try {
      $data = $this->request->data;
      $registerOpen = $this->MerchantRegisterOpen->find('all',array(
          'conditions' => array(
              'MerchantRegisterOpen.register_id' => $data['register_id'],
              'MerchantRegisterOpen.register_close_time' => ''
          )
      ));
      $sequence = $this->MerchantRegisterOpen->find('count',array(
          'conditions' => array(
              'MerchantRegisterOpen.register_id' => $data['register_id'],
          )
      ));
      $register = $this->MerchantRegister->find('first',array(
          'conditions' => array(
              'MerchantRegister.id' => $data['register_id'],
          )
      ));

      if(count($registerOpen) == 0){
        $register['MerchantRegister']['register_open_count_sequence'] = $sequence + 1;
        $this->MerchantRegister->save($register['MerchantRegister']);

        $this->MerchantRegisterOpen->create();
        $open->MerchantRegisterOpen['register_id'] = $data['register_id'];
        $open->MerchantRegisterOpen['register_open_count_sequence'] = $sequence + 1;
        $open->MerchantRegisterOpen['register_open_time'] = date('Y-m-d H:i:s');
        $this->MerchantRegisterOpen->save($open);

        $opened = $this->MerchantRegisterOpen->find('first',array(
          'conditions' => array(
            'MerchantRegisterOpen.id' => $this->MerchantRegisterOpen->id
          )
        ));

        $result['opened'] = $opened['MerchantRegisterOpen'];
        $result['success'] = true;
      } else {
        $result['$registerOpen'] = $registerOpen;
      }

    } catch (Exception $e) {
      $result['message'] = $e->getMessage();
    }
    $this->serialize($result);
    return;
  }
}
