<?php

App::uses('AppController', 'Controller');

class TaxesController extends AppController {

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
 * This controller uses MerchantTaxRate models.
 *
 * @var array
 */
    public $uses = array('MerchantTaxRate');

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

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];

            $result = array(
                'success' => false
            );

            try {
                $this->MerchantTaxRate->create();
                $this->MerchantTaxRate->save($data);
                $result['id'] = $this->MerchantTaxRate->id;
                $result['data'] = $data;
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function edit() {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $this->loadModel('MerchantProduct');
            $this->loadModel('MerchantPriceBook');
            $this->loadModel('MerchantPriceBookEntry');
            $data = $this->request->data;
            $data['merchant_id'] = $user['merchant_id'];
            
            $result = array(
                'success' => false
            );

            try {
                $this->MerchantTaxRate->id = $data['id'];
                $this->MerchantTaxRate->save($data);

                $priceBook = $this->MerchantPriceBook->find('all', array(
                    'conditions' => array(
                        'MerchantPriceBook.merchant_id' => $user['merchant_id'],
                        'MerchantPriceBook.name' => "General Price Book (All Products)"
                    )
                ));

                $products = $this->MerchantProduct->find('all', array(
                    'conditions' => array(
                        'MerchantProduct.tax_id' => $data['id']
                    )
                ));

                foreach ($products as $product) {
                    $this->MerchantProduct->id = $product['MerchantProduct']['id'];
                    $change['MerchantProduct']['tax'] = $product['MerchantProduct']['price'] * $data['rate'];
                    $change['MerchantProduct']['price_include_tax'] = $product['MerchantProduct']['price'] * $data['rate'] + $product['MerchantProduct']['price'];
                    $this->MerchantProduct->save($change);

                    $entries = $this->MerchantPriceBookEntry->find('all', array(
                        'conditions' => array(
                            'MerchantPriceBookEntry.price_book_id' => $priceBook[0]['MerchantPriceBook']['id'],
                            'MerchantPriceBookEntry.product_id' => $product['MerchantProduct']['id']
                        )
                    ));

                    foreach($entries as $entry) {
                        $this->MerchantPriceBookEntry->id = $entry['MerchantPriceBookEntry']['id'];
                        $change['MerchantPriceBookEntry']['tax'] = $product['MerchantProduct']['price'] * $data['rate'];
                        $change['MerchantPriceBookEntry']['price_include_tax'] = $product['MerchantProduct']['price'] * $data['rate'] + $product['MerchantProduct']['price'];
                        $this->MerchantPriceBookEntry->save($change);
                    }
                }
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function delete() {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            try {
                $this->MerchantTaxRate->delete($_POST['id']);
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
