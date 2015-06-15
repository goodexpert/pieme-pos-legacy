<?php

App::uses('AppController', 'Controller');

class XeroController extends AppController {

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
 * No connected xero accounts function.
 *
 * @return void
 */
    public function noxero() {
    }

/**
 * Enable xero accounts function.
 *
 * @return void
 */
    public function enableXero() {
        $this->Xero->enableXero();
    }

/**
 * Retrieve contacts from Xero contacts.
 *
 * @return void
 */
    public function getContacts() {
        $result = array(
            'success' => false
        );

        $response = $this->Xero->getContacts();
        if ($response) {
            $result['response'] = json_decode(json_encode($response), true);
            $result['success'] = true;
        }
        $this->serialize($result);
    }

/**
 * Get a invoice from Xero.
 *
 * @return void
 */
    public function getInvoice($id) {
        $result = array(
            'success' => false
        );

        $response = $this->Xero->getInvoice($id);
        if ($response) {
            $result['response'] = json_decode(json_encode($response), true);
            $result['success'] = true;
        }
        $this->serialize($result);
    }

/**
 * Post invoices to Xero.
 *
 * @return void
 */
    public function postInvoice() {
        $user = $this->Auth->user();

        if ($this->request->is('get')) {
            $id = $this->get('id');
        }

        $sale = $this->_getRegisterSaleById($id, $user['merchant_id'], $user['retailer_id']);
        if (!empty($sale) && is_array($sale)) {
            $xml = "<Invoice>";
            $xml .= "<Type>ACCREC</Type>";
            $xml .= "<Reference>" . $sale['RegisterSale']['receipt_number'] . "</Reference>";
            $xml .= "<Contact>";
            $xml .= "<ContactID>" . $sale['MerchantCustomer']['xero_contact_id'] . "</ContactID>";
            $xml .= "<Name>" . $sale['MerchantCustomer']['name'] . "</Name>";
            $xml .= "</Contact>";
            $xml .= "<Date>" . $sale['RegisterSale']['sale_date'] . "</Date>";
            $xml .= "<DueDate>" . $sale['RegisterSale']['sale_date'] . "</DueDate>";
            $xml .= "<Status>AUTHORISED</Status>";
            $xml .= "<Url>" . "http://secure.onzsa.com" . "/history?sale_id=" . $id . "</Url>";
            $xml .= "<LineAmountTypes>Inclusive</LineAmountTypes>";
            $xml .= "<SubTotal>" . $sale['RegisterSale']['total_price'] . "</SubTotal>";
            $xml .= "<TotalTax>" . $sale['RegisterSale']['total_tax'] . "</TotalTax>";
            $xml .= "<Total>" . $sale['RegisterSale']['total_price_incl_tax'] . "</Total>";
            $xml .= "<LineItems>";

            foreach ($sale['RegisterSaleItem'] as $item) {
                $line_amount = round($item['price_include_tax'] * $item['quantity'], 2);

                $xml .= "<LineItem>";
                $xml .= "<Description>" . $item['MerchantProduct']['name'] . "</Description>";
                $xml .= "<UnitAmount>" . $item['price_include_tax'] . "</UnitAmount>";
                $xml .= "<TaxAmount>" . $item['tax'] . "</TaxAmount>";
                $xml .= "<LineAmount>" . $line_amount . "</LineAmount>";
                $xml .= "<Quantity>" . $item['quantity'] . "</Quantity>";
                $xml .= "<TaxType>NONE</TaxType>";
                $xml .= "<AccountCode>200</AccountCode>";
                $xml .= "</LineItem>";
            }
            $xml .= "</LineItems>";
            $xml .= "</Invoice>";
        }

        $response = $this->Xero->postInvoice($xml);
        if ($response['code'] == 200) {
            $result = json_decode($response['response'], true);
            $this->_updateRegisterSale($id, $result['Invoices'][0]['InvoiceID']);
        } else {
            debug($response);
        }
        return $this->redirect($this->referer());
    }

/**
 * Reload Xero Account.
 *
 * @return void
 */
    public function reloadAccounts() {
        $this->Xero->reloadAccounts();
    }

/**
 * Unlink Xero Account.
 *
 * @return void
 */
    public function unlink() {
        $this->Xero->unlink();
    }

    public function test() {
        $response = $this->Xero->synchronize();
    }

/**
 * Get the register sale.
 *
 * @param string sale id
 * @param string merchant id
 * @param string retailer id
 * @return array
 */
    protected function _getRegisterSaleById($sale_id, $merchant_id, $retailer_id) {
        $this->loadModel('RegisterSale');
        $this->loadModel('RegisterSaleItem');

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
            'RegisterSale.id' => $sale_id,
            'MerchantOutlet.merchant_id' => $merchant_id
        );

        if (!empty($retailer_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantOutlet.retailer_id' => $retailer_id
            ));
        }

        $results = $this->RegisterSale->find('first', array(
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
        return $results;
    }

/**
 * Update the invoice id.
 *
 * @param string sale id
 * @param string invoice id
 * @return array
 */
    protected function _updateRegisterSale($sale_id, $invoice_id) {
        $this->loadModel('RegisterSale');

        $this->RegisterSale->id = $sale_id;
        $this->RegisterSale->saveField('xero_invoice_id', $invoice_id);
    }

}
