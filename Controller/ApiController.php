<?php

App::uses('AppController', 'Controller');

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
          'MerchantPaymentType.is_deleted' => 0
        ],
        'order' => [
          'MerchantPaymentType.created'
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
        'joins' => [
          [
            'table' => 'merchant_outlets',
            'alias' => 'MerchantOutlet',
            'type' => 'INNER',
            'conditions' => [
              'MerchantOutlet.id = MerchantRegister.outlet_id'
            ]
          ]
        ],
        'conditions' => $conditions,
        'order' => [
          'MerchantRegister.created'
        ]
      ]);

      $response = Hash::map($registers, "{n}", function($array) {
        return $array['MerchantRegister'];
      });
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
        return array_merge($array['MerchantPriceBook'], $array['MerchantPriceBookEntry']);
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
      $response = [];
      $user = $this->Auth->user();

      $register_id = $this->get('register_id');
      if (empty($register_id)) {
        $register_id = '55cfd1ed-4594-4e0f-8f76-14d84cf3b98e';
      }

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

      if (!empty($quickKey)) {
        $response = json_decode($quickKey['MerchantQuickKey']['key_layouts'], true);
      }

      $this->serialize($response);
    }

}
