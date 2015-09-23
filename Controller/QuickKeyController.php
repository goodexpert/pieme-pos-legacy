<?php

App::uses('AppController', 'Controller');

class QuickKeyController extends AppController {

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
        'MerchantQuickKey'
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
        $items = $this->MerchantQuickKey->find('all');
        $this->set("items",$items);
    }

    public function add(){
        if ($this->request->is('post')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantQuickKey->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;
                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                
                $this->MerchantQuickKey->create();
                $this->MerchantQuickKey->save($data);
                
                $result['success'] = true;
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }

        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array(
            'MerchantProduct.merchant_id' => $this->Auth->user()['merchant_id'],
            )
        ));
        $this->set("items",$items);
    }

    public function edit($id){
        if ($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantQuickKey->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;
                
                $this->MerchantQuickKey->id = $id;
                $this->MerchantQuickKey->save($data);
                
                $result['success'] = true;
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }

        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array(
            'MerchantProduct.merchant_id' => $this->Auth->user()['merchant_id'],
            )
        ));
        $this->set("items",$items);
        $keys = $this->MerchantQuickKey->findById($id);
        $this->set("keys",$keys);
    }

  public function delete($id) {
    if($this->request->is('post')) {
      $result = array(
          'success' => false
      );
      try {
        $data = $this->request->data;
        if(isset($data['request']) && $data['request'] == 'delete') {
          $this->MerchantQuickKey->delete($id);
          $result['success'] = true;
        }
      } catch (Exception $e) {
        $result['message'] = $e->getMessage();
      }
      $this->serialize($result);
      return;
    }
  }

    public function assign(){
        $this->loadModel('MerchantRegister');
        $user = $this->Auth->user();
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            $dataSource = $this->MerchantRegister->getDataSource();
            $dataSource->begin();
            
            try {
                $data = $this->request->data;
                $this->MerchantRegister->id = $data['register_id'];
                $this->MerchantRegister->save($data);
                
                $dataSource->commit();
                $result['success'] = true;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            return;
        }
    }

/**
 * Search products by keyword.
 *
 * @return void
 */
    public function search() {
        $user = $this->Auth->user();

        $result = array(
            'success' => false
        );

        $keyword = null;
        if ($this->request->is('get')) {
            $keyword = $this->get('keyword');
        } elseif ($this->request->is('post')) {
            $keyword = $this->post('keyword');
        }

        $products = $this->MerchantProduct->find('all', array(
            'fields' => array(
                'MerchantProduct.*'
            ),
            'conditions' => array(
                'MerchantProduct.merchant_id' => $user['merchant_id'],
                'MerchantProduct.is_active = 1',
                'OR' => array(
                    'MerchantProduct.name LIKE' => '%' . $keyword . '%',
                    'MerchantProduct.handle LIKE' => '%' . $keyword . '%',
                    'MerchantProduct.sku LIKE' => '%' . $keyword . '%'
                ),
                'NOT' => array(
                    'MerchantProduct.id' => $user['Merchant']['discount_product_id']
                )
            )
        ));

        $products = Hash::map($products, "{n}", function($array) {
            $product = $array['MerchantProduct'];
            return $product;
        });

        $result['products'] = $products;
        $result['success'] = true;
        $this->serialize($result);
    }

/**
 * Get Option Variants Data.
 *
 * @return void
 */
    public function variants() {
      $user = $this->Auth->user();

      $result = array(
        'success' => false
      );

      $keyword = null;
      if ($this->request->is('get')) {
        $product_id = $this->get('product_id');
        $sku =  $this->get('sku');
        $label =  $this->get('label');
        $parent_id =  $this->get('parent_id');
      } elseif ($this->request->is('post')) {
        $product_id = $this->post('product_id');
        $sku =  $this->post('sku');
        $label =  $this->post('label');
        $parent_id =  $this->post('parent_id');
      }
      $parent = true;
      $searchId = $product_id;
      if( $parent_id != null ) {
        $searchId = $parent_id;
        $parent = false;
      }

      $products = $this->MerchantProduct->find('all', array(
        'fields' => array(
          'MerchantProduct.*'
        ),
        'conditions' => array(
          'MerchantProduct.merchant_id' => $user['merchant_id'],
          'MerchantProduct.is_active = 1',
          'OR' => array(
            'MerchantProduct.id' => $searchId,
            'MerchantProduct.parent_id' => $searchId
            )
        )
      ));

      $vValue1 = array(); $vValue2 = array(); $vValue3 = array();
      $parentItem = [];
      $variants = array(); $selections = array();

      foreach($products as $item) {
        $product = $item['MerchantProduct'];
        if($product['parent_id'] == null || $product['id'] == $parent_id) {
          $parentItem = $product;
        }
        // selected item
        if($product['id'] == $product_id) {
          // make selections
          $selections = array();
          if ($product['variant_option_one_name'] != "") {
            $selections = array_merge($selections, array($product['variant_option_one_name'] => $product['variant_option_one_value']));
          }
          if ($product['variant_option_two_name'] != "") {
            $selections = array_merge($selections, array($product['variant_option_two_name'] => $product['variant_option_two_value']));
          }
          if ($product['variant_option_three_name'] != "") {
            $selections = array_merge($selections, array($product['variant_option_three_name'] => $product['variant_option_three_value']));
          }
        }
        // gather all value
        $vValue1[] = strtolower($product['variant_option_one_value']);
        $vValue2[] = strtolower($product['variant_option_two_value']);
        $vValue3[] = strtolower($product['variant_option_three_value']);

        // make variants
        $variant = array('product_id' => $product['id']);
        if ($product['variant_option_one_name'] != "") {
          $variant = array_merge($variant, array($product['variant_option_one_name'] => $product['variant_option_one_value']));
        }
        if ($product['variant_option_two_name'] != "") {
          $variant = array_merge($variant, array($product['variant_option_two_name'] => $product['variant_option_two_value']));
        }
        if ($product['variant_option_three_name'] != "") {
          $variant = array_merge($variant, array($product['variant_option_three_name'] => $product['variant_option_three_value']));
        }
        array_push($variants, $variant);
      }

      // remove same value
      $vValue1 = array_unique($vValue1);
      $vValue2 = array_unique($vValue2);
      $vValue3 = array_unique($vValue3);

      // make options
      if ($parentItem['variant_option_one_name'] != "") {
        $options[] = ['label' => $parentItem['variant_option_one_name'], 'options' => $vValue1];
      }
      if ($parentItem['variant_option_two_name'] != "") {
        $options[] = ['label' => $parentItem['variant_option_two_name'], 'options' => $vValue2];
      }
      if ($parentItem['variant_option_three_name'] != "") {
        $options[] = ['label' => $parentItem['variant_option_three_name'], 'options' => $vValue3];
      }

//      $result['debug'] = $debug;
      // set array
      $result['success'] = true;
      $result['id'] = $product_id;
      $result['sku'] = $sku;
      $result['label'] = $label;
      $result['parent'] = $parent;
      if($parent == true) {
        $result['options'] = $options;
        $result['variants'] = $variants;
      }
      $result['selections'] = $selections;

      $this->serialize($result);
    }

}
