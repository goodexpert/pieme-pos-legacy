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
 * Retreive price books by specified register_id
 *
 * @return array
 */
    public function get_price_books() {
      $response = [];

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
 * Retreive products by specified register_id
 *
 * @return array
 */
    public function get_products() {
      $response = [];

      $this->request->onlyAllow('get');

      $merchant_id = $this->get('merchant_id');
      if (empty($merchant_id)) {
        $merchant_id = '55b99423-5b44-44ee-8d43-25e04cf3b98e';
      }

      $this->loadModel('MerchantProduct');

      $products = $this->MerchantProduct->find('all', [
        'fields' => [
          'MerchantProduct.id',
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
            'type' => 'INNER',
            'conditions' => [
              'MerchantProductBrand.id = MerchantProduct.product_brand_id'
            ]
          ],
          [
            'table' => 'merchant_suppliers',
            'alias' => 'MerchantSupplier',
            'type' => 'INNER',
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
          'MerchantProduct.merchant_id' => $merchant_id,
          'MerchantProduct.is_active' => 1,
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
 * Retreive quick keys by specified register_id
 *
 * @return array
 */
    public function get_quick_keys() {
      $response = [];

      $this->request->onlyAllow('get');

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
          ]
        ],
        'conditions' => [
          'MerchantRegister.id' => $register_id
        ]
      ]);

      if (!empty($quickKey)) {
        $response = json_decode($quickKey['MerchantQuickKey']['key_layouts'], true);
      }

      $this->serialize($response);
    }

}
