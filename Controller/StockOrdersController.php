<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class StockOrdersController extends AppController {

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
        'MerchantStockOrder',
        'MerchantStockOrderItem'
    );

/**
 * Options property.
 *
 * @var array
 */
    public $options = array(
        'stock_type' => array(
            'STANDARD'
        )
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
        
        $status = $this->get('status');
        if (empty($status)) {
            $status = 'OPEN';
        }
        $this->set('status', $status);

        $name = $this->get('name');
        $this->set('name', $name);

        $date_from = $this->get('date_from');
        $this->set('date_from', $date_from);

        $date_to = $this->get('date_to');
        $this->set('date_to', $date_to);

        $due_date_from = $this->get('due_date_from');
        $this->set('due_date_from', $due_date_from);

        $due_date_to = $this->get('due_date_to');
        $this->set('due_date_to', $due_date_to);

        $supplier_invoice = $this->get('supplier_invoice');
        $this->set('supplier_invoice', $supplier_invoice);

        $outlet_id = $this->get('outlet_id');
        $this->set('outlet_id', $outlet_id);

        $supplier_id = $this->get('supplier_id');
        $this->set('supplier_id', $supplier_id);

        // get the list of order filter
        if ($user['Merchant']['is_franchise'] == 1) {
            $filters = array(
                'ALL' => 'All orders',
                'OPEN' => 'Open orders',
                'SENT' => 'Sent orders',
                'APPROVED' => 'Approved orders',
                'SHIPPPED' => 'Shipped orders',
                'RECEIVED' => 'Received orders',
                //'OVERDUE' => 'Overdue orders',
                'CANCELLED' => 'Cancelled orders',
                'REJECTED' => 'Rejected orders',
                'CLOSED' => 'Closed orders'
            );
        } else {
            $filters = array(
                'ALL' => 'All orders',
                'OPEN' => 'Open orders',
                'SENT' => 'Sent orders',
                'RECEIVED' => 'Received orders',
                //'OVERDUE' => 'Overdue orders',
                'CANCELLED' => 'Cancelled orders',
                'REJECTED' => 'Rejected orders'
            );
        }
        $this->set('filters', $filters);

        if (empty($user['retailer_id'])) {
            // get the list of merchant's outlets
            $outlets = $this->_getOutletByMerchantId($user['merchant_id']);
        } else {
            // get the list of retail's outlets
            $outlets = $this->_getOutletByRetailerId($user['retailer_id']);
        }
        $this->set('outlets', $outlets);

        // get the list of merchant's suppliers
        $suppliers = $this->_getSupplierByMerchantId($user['merchant_id']);
        $this->set('suppliers', $suppliers);

        // get the list of stock orders
        $orders = $this->_getStockOrders($user['merchant_id'], $user['retailer_id'], $status, $name, $date_from, $date_to, $due_date_from, $due_date_to, $supplier_invoice, $outlet_id, $supplier_id);
        $this->set('orders', $orders);
    }

/**
 * Create a stock order.
 *
 * @return void
 */
    public function createOrder() {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $result = $this->_saveStockOrder($user['merchant_id'], $user['retailer_id']);

            if ($result['success'] && isset($result['id'])) {
                $this->redirect('/stock_orders/' . $result['id'] . '/edit');
            } else {
                $this->Session->setFlash($result['message']);
            }
        }

        if (empty($user['retailer_id'])) {
            // get the list of merchant's outlets
            $outlets = $this->_getOutletByMerchantId($user['merchant_id']);
        } else {
            // get the list of retail's outlets
            $outlets = $this->_getOutletByRetailerId($user['retailer_id']);
        }
        $this->set('outlets', $outlets);

        // get the list of merchant's suppliers
        $suppliers = $this->_getSupplierByMerchantId($user['merchant_id']);
        $this->set('suppliers', $suppliers);

        $this->set('order_type', 'stock_order_type_stockorder');
        $this->render('add');
    }

/**
 * Create a stock transfer.
 *
 * @return void
 */
    public function createTransfer() {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $result = $this->_saveStockOrder($user['merchant_id'], $user['retailer_id']);

            if ($result['success'] && isset($result['id'])) {
                $this->redirect('/stock_orders/' . $result['id'] . '/edit');
            } else {
                $this->Session->setFlash($result['message']);
            }
        }

        if (empty($user['retailer_id'])) {
            // get the list of merchant's outlets
            $outlets = $this->_getOutletByMerchantId($user['merchant_id']);
        } else {
            // get the list of retail's outlets
            $outlets = $this->_getOutletByRetailerId($user['retailer_id']);
        }
        $this->set('outlets', $outlets);

        $this->set('order_type', 'stock_order_type_transfer');
        $this->render('add');
    }

/**
 * Edit a stock order or a stock transfer.
 *
 * @param string order id
 * @return void
 */
    public function edit($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        if ($this->request->is('post')) {
            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;

                if (!empty($data['items']) && is_array($data['items'])) {
                    $this->MerchantStockOrderItem->saveMany($data['items']);
                }

                $dataSource->commit();

                $redirect_url = '/stock_orders/' . $id;
                if (isset($data['save-send']) && $data['save-send'] == 1) {
                    $redirect_url .= '?send=1';
                } elseif (isset($data['save-receive']) && $data['save-receive'] == 1) {
                    $redirect_url .= '?recevie=1';
                }
                $this->redirect($redirect_url);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        $data = $this->_getStockOrder($id);
        $this->set('data', $data);

        if (empty($this->request->data)) {
            $this->request->data = $data;
        }
    }

/**
 * Edit a stock order details or a stock transfer details.
 *
 * @param string order id
 * @return void
 */
    public function editDetails($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        if ($this->request->is('post')) {
            $result = $this->_saveStockOrder($user['merchant_id'], $user['retailer_id']);

            if ($result['success'] && isset($result['id'])) {
                $this->redirect('/stock_orders/' . $result['id'] . '/edit');
            } else {
                $this->Session->setFlash($result['message']);
            }
        }

        $data = $this->_getStockOrderDetails($id);
        $this->set('data', $data);

        if (empty($this->request->data)) {
            $this->request->data = $data;
        }
    }

/**
 * View a stock order or a stock transfer.
 *
 * @param string order id
 * @return void
 */
    public function view($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        if (!empty($this->get('send'))) {
            $this->set('send', $this->get('send'));
        }

        if (!empty($this->get('receive'))) {
            $this->set('receive', $this->get('receive'));
        }

        $data = $this->_getStockOrder($id);
        $this->set('data', $data);
    }

/**
 * Generate bar codes for items of a stock order or a stock transfer.
 *
 * @param string order id
 * @return void
 */
    public function barcodes($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }
    }

/**
 * Cancel a stock order or a stock transfer.
 *
 * @param string order id
 * @return void
 */
    public function cancel($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        if ($this->request->is('post')) {
            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                $this->MerchantStockOrder->id = $id;
                $this->MerchantStockOrder->saveField('order_status_id', 'stock_order_status_cancelled');

                $dataSource->commit();

                $this->redirect('/stock_orders');
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        $this->set('order_id', $id);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
    }

/**
 * Mark as 'sent' of a stock order or a stock transfer.
 *
 * @param string order id
 * @return void
 */
    public function markSent($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        $data = $this->request->data;

        $dataSource = $this->MerchantStockOrder->getDataSource();
        $dataSource->begin();

        try {
            $order = $this->_getStockOrderDetails($id);

            if (in_array($order['MerchantStockOrder']['order_status_id'], array(
                    'stock_order_status_open', 'stock_order_status_sent'
                ))) {
                $this->MerchantStockOrder->id = $id;
                $this->MerchantStockOrder->saveField('order_status_id', 'stock_order_status_sent');

                $dataSource->commit();
            }
        } catch (Exception $e) {
            $dataSource->rollback();
            $this->Session->setFlash($e->getMessage());
        }

        $this->redirect('/stock_orders/' . $id);
    }

/**
 * Send a stock order or a stock transfer.
 *
 * @param string order id
 * @return void
 */
    public function send($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                $order = $this->_getStockOrder($id);

                if (in_array($order['MerchantStockOrder']['order_status_id'], array(
                        'stock_order_status_open', 'stock_order_status_sent'
                    ))) {
                    $from = $user['email'];
                    $to = $data['to'];
                    $cc = empty($data['cc']) ? array() : $data['cc'];

                    $email = new CakeEmail();
                    $email->template('order', 'onzsa')
                        ->emailFormat('html')
                        ->to($to)
                        ->cc($cc)
                        ->from($from)
                        ->subject($data['subject'])
                        ->viewVars(array(
                            'recipient_name' => $data['recipient_name'],
                            'message' => $data['message'],
                            'order' => $order
                        ))
                        ->send();

                    $this->MerchantStockOrder->id = $id;
                    $this->MerchantStockOrder->saveField('order_status_id', 'stock_order_status_sent');

                    $dataSource->commit();
                }

                $this->redirect('/stock_orders/' . $id);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        $this->set('order_id', $id);

        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
    }

/**
 * Receive a stock order or a stock transfer.
 *
 * @param string order id
 * @return void
 */
    public function receive($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        if ($this->request->is('post')) {
            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;

                if (!empty($data['items']) && is_array($data['items'])) {
                    $this->MerchantStockOrderItem->saveMany($data['items']);
                }

                $dataSource->commit();

                $redirect_url = '/stock_orders/' . $id;
                if (isset($data['save-send']) && $data['save-send'] == 1) {
                    $redirect_url .= '?send=1';
                } elseif (isset($data['save-receive']) && $data['save-receive'] == 1) {
                    $redirect_url .= '?recevie=1';
                }
                $this->redirect($redirect_url);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        $data = $this->_getStockOrder($id);
        $this->set('data', $data);

        if (empty($this->request->data)) {
            $this->request->data = $data;
        }
    }

/**
 * Add a stock order product.
 *
 * @param string order id
 * @return void
 */
    public function addProduct($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderId($id)) {
            throw new NotFoundException();
        }

        $result = array(
            'success' => false
        );

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                $data = $this->request->data;

                if (isset($data['MerchantStockOrderItem']['product_uom']) &&
                    empty($data['MerchantStockOrderItem']['product_uom'])) {
                    unset($data['MerchantStockOrderItem']['product_uom']);
                }

                if (isset($data['MerchantStockOrderItem']['id']) && !empty($data['MerchantStockOrderItem']['id'])) {
                    $this->MerchantStockOrderItem->id = $data['MerchantStockOrderItem']['id'];
                } else {
                    $this->MerchantStockOrderItem->create();
                }
                $this->MerchantStockOrderItem->save($data);

                $dataSource->commit();
                $result['success'] = true;
                $result['id'] = $this->MerchantStockOrderItem->id;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
        }

        if ($this->request->is('ajax')) {
            $this->serialize($result);
        } else {
            $this->redirect('/stock_orders');
        }
    }

/**
 * Delete a stock order product.
 *
 * @param string order item id
 * @return void
 */
    public function deleteProduct($id) {
        $user = $this->Auth->user();

        if (!$this->_isValidOrderItemId($id)) {
            throw new NotFoundException();
        }

        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockOrderItem->getDataSource();
        $dataSource->begin();

        try {
            $this->MerchantStockOrderItem->delete($id);

            $dataSource->commit();
            $result['success'] = true;
            $result['id'] = $id;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }

        if ($this->request->is('ajax')) {
            $this->serialize($result);
        } else {
            $this->redirect('/stock_orders');
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
        $outlet_id = null;

        if ($this->request->is('get')) {
            $keyword = $this->get('keyword');
            $outlet_id = $this->get('outlet_id');
        } elseif ($this->request->is('post')) {
            $keyword = $this->post('keyword');
            $outlet_id = $this->post('outlet_id');
        }

        $products = $this->MerchantProduct->find('all', array(
            'fields' => array(
                'MerchantProduct.*',
                'MerchantProductInventory.count'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantProductInventory.product_id = MerchantProduct.id',
                        'MerchantProductInventory.outlet_id' => $outlet_id
                    )
                )
            ),
            'conditions' => array(
                'MerchantProduct.merchant_id' => $user['merchant_id'],
                'MerchantProduct.stock_type' => $this->options['stock_type'],
                'MerchantProduct.is_active = 1',
                'OR' => array(
                    'MerchantProduct.name LIKE' => '%' . $keyword . '%',
                    'MerchantProduct.handle LIKE' => '%' . $keyword . '%',
                    'MerchantProduct.sku LIKE' => '%' . $keyword . '%'
                )
            )
        ));

        $products = Hash::map($products, "{n}", function($array) {
            $newArray = $array['MerchantProduct'];
            $newArray['in_stock'] = $array['MerchantProductInventory']['count'];

            if ('COMPOSITE' === $newArray['stock_type']) {
                $subitems = $this->MerchantProductComposite->find('all', array(
                    'fields' => array(
                        'MerchantProductComposite.quantity',
                        'MerchantProduct.*'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'merchant_products',
                            'alias' => 'MerchantProduct',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantProduct.id = MerchantProductComposite.product_id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'MerchantProductComposite.parent_id' => $newArray['id']
                    )
                ));
                $newArray['subitems'] = Hash::map($subitems, "{n}", function($array) {
                    $array['quantity'] = $array['MerchantProductComposite']['quantity'];
                    unset($array['MerchantProductComposite']);
                    return $array;
                });
            }
            return $newArray;
        });
        $result['products'] = $products;
        $result['success'] = true;
        $this->serialize($result);
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
 * Get the merchant's suppliers.
 *
 * @param string merchant id
 * @return array the list
 */
    protected function _getSupplierByMerchantId($merchant_id) {
        $this->loadModel('MerchantSupplier');

        $suppliers = $this->MerchantSupplier->find('list', array(
            'recursive' => 0,
            'fields' => array(
                'MerchantSupplier.id',
                'MerchantSupplier.name'
            ),
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $merchant_id
            )
        ));
        return $suppliers;
    }

/**
 * Get the outlet's inventories.
 *
 * @param string outlet id
 * @return array the outlet inventories
 */
    protected function _getOutletInventories($outlet_id) {
        $this->loadModel('MerchantProductInventory');

        $inventories = $this->MerchantProductInventory->find('all', array(
            'conditions' => array(
                'MerchantProductInventory.outlet_id' => $outlet_id
            )
        ));
        return $inventories;
    }

/**
 * Validate the stock order id.
 *
 * @param string order id
 * @return boolean return true if the stock order id exists.
 */
    protected function _isValidOrderId($id) {
        $order = $this->MerchantStockOrder->findById($id);
        return !empty($order) && is_array($order);
    }

/**
 * Validate the stock order item id.
 *
 * @param string order id
 * @return boolean return true if the stock order id exists.
 */
    protected function _isValidOrderItemId($id) {
        $item = $this->MerchantStockOrderItem->findById($id);
        return !empty($item) && is_array($item);
    }

/**
 * Get the stock order details.
 *
 * @param string order item id
 * @return array the stock order datails
 */
    protected function _getStockOrderDetails($order_id) {
        $order = $this->MerchantStockOrder->find('first', array(
            'fields' => array(
                'MerchantStockOrder.*',
                'MerchantOutlet.id',
                'MerchantOutlet.name',
                'MerchantSourceOutlet.id',
                'MerchantSourceOutlet.name',
                'MerchantSupplier.id',
                'MerchantSupplier.name',
                'StockOrderStatus.name'
            ),
            'joins' => array(
                array(
                    'table' => 'stock_order_status',
                    'alias' => 'StockOrderStatus',
                    'type' => 'INNER',
                    'conditions' => array(
                        'StockOrderStatus.id = MerchantStockOrder.order_status_id'
                    )
                ),
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantOutlet.id = MerchantStockOrder.outlet_id'
                    )
                ),
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantSourceOutlet',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantSourceOutlet.id = MerchantStockOrder.source_outlet_id'
                    )
                ),
                array(
                    'table' => 'merchant_suppliers',
                    'alias' => 'MerchantSupplier',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantSupplier.id = MerchantStockOrder.supplier_id'
                    )
                )
            ),
            'conditions' => array(
                'MerchantStockOrder.id' => $order_id
            )
        ));
        return $order;
    }

/**
 * Get the stock order details and items.
 *
 * @param string order id
 * @return false|array the stock order datails and items
 */
    protected function _getStockOrder($order_id) {
        $order = $this->_getStockOrderDetails($order_id);
        if (empty($order) || !is_array($order)) {
            return false;
        }

        $order_items = $this->MerchantStockOrderItem->find('all', array(
            'fields' => array(
                'MerchantStockOrderItem.*',
                'MerchantProduct.sku',
                'MerchantProduct.supplier_code',
                'MerchantProduct.price_include_tax',
                'MerchantProductInventory.count as in_stock'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_products',
                    'alias' => 'MerchantProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProduct.id = MerchantStockOrderItem.product_id'
                    )
                ),
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantProductInventory.product_id = MerchantStockOrderItem.product_id',
                        'MerchantProductInventory.outlet_id' => $order['MerchantStockOrder']['outlet_id']
                    )
                )
            ),
            'conditions' => array(
                'MerchantStockOrderItem.order_id' => $order_id
            ),
            'order' => array(
                'MerchantStockOrderItem.sequence ASC'
            )
        ));

        $order['MerchantStockOrderItem'] = Hash::map($order_items, "{n}", function($array) {
            $newArray = $array['MerchantStockOrderItem'];
            $newArray = array_merge($newArray, $array['MerchantProduct']);
            $newArray = array_merge($newArray, $array['MerchantProductInventory']);

            if ('COMPOSITE' === $newArray['stock_type']) {
                $subitems = $this->MerchantProductComposite->find('all', array(
                    'fields' => array(
                        'MerchantProductComposite.quantity',
                        'MerchantProduct.*'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'merchant_products',
                            'alias' => 'MerchantProduct',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantProduct.id = MerchantProductComposite.product_id'
                            )
                        )
                    ),
                    'conditions' => array(
                        'MerchantProductComposite.parent_id' => $newArray['id']
                    )
                ));
                $newArray['subitems'] = Hash::map($subitems, "{n}", function($array) {
                    $array['quantity'] = $array['MerchantProductComposite']['quantity'];
                    unset($array['MerchantProductComposite']);
                    return $array;
                });
            }
            return $newArray;
        });
        return $order;
    }

/**
 * Get the stock orders.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string order status
 * @param string keyword
 * @param string order date from
 * @param string order date to
 * @param string due date from
 * @param string due date to
 * @param string supplier invoice
 * @param string supplier id
 * @param string outlet id
 * @return array the list
 */
    protected function _getStockOrders($merchant_id, $retailer_id, $status, $keyword, $date_from, $date_to, $due_date_from, $due_date_to, $supplier_invoice, $outlet_id, $supplier_id) {
        $conditions = array(
            'MerchantStockOrder.merchant_id' => $merchant_id
        );

        $joins = array(
            array(
                'table' => 'stock_order_status',
                'alias' => 'StockOrderStatus',
                'type' => 'INNER',
                'conditions' => array(
                    'StockOrderStatus.id = MerchantStockOrder.order_status_id'
                )
            ),
            array(
                'table' => 'merchant_outlets',
                'alias' => 'MerchantOutlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'MerchantOutlet.id = MerchantStockOrder.outlet_id'
                )
            ),
            array(
                'table' => 'merchant_outlets',
                'alias' => 'MerchantSourceOutlet',
                'type' => 'LEFT',
                'conditions' => array(
                    'MerchantSourceOutlet.id = MerchantStockOrder.source_outlet_id'
                )
            ),
            array(
                'table' => 'merchant_suppliers',
                'alias' => 'MerchantSupplier',
                'type' => 'LEFT',
                'conditions' => array(
                    'MerchantSupplier.id = MerchantStockOrder.supplier_id'
                )
            ),
            array(
                'table' => 'merchant_stock_order_items',
                'alias' => 'MerchantStockOrderItem',
                'type' => 'LEFT',
                'conditions' => array(
                    'MerchantStockOrderItem.order_id = MerchantStockOrder.id'
                )
            )
        );

        if (!empty($retailer_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantOutlet.retailer_id' => $retailer_id
            ));
        }

        if (!empty($keyword)) {
            $joins = array_merge($joins, array(
                array(
                    'table' => 'merchant_products',
                    'alias' => 'MerchantProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProduct.id = MerchantStockOrderItem.product_id',
                        'MerchantProduct.name LIKE' => '%' . $keyword . '%'
                    )
                )
            ));
        }

        if (!empty($status) && $status !== 'ALL') {
            $order_status = array(
                'OPEN' => 'stock_order_status_open',
                'SENT' => 'stock_order_status_sent',
                'APPROVED' => 'stock_order_status_approved',
                'SHIPPPED' => 'stock_order_status_shipped',
                'RECEIVED' => 'stock_order_status_received',
                'CANCELLED' => 'stock_order_status_cancelled',
                'REJECTED' => 'stock_order_status_rejected',
                'CLOSED' => 'stock_order_status_closed'
            );

            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.order_status_id' => $order_status[$status]
            ));
        } else {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.order_status_id NOT' => array(
                    'stock_order_status_cancelled',
                    'stock_order_status_rejected'
                )
            ));
        }

        if (!empty($date_from)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.date) >=' => $date_from
            ));
        }

        if (!empty($date_to)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.date) >=' => $date_to
            ));
        }

        if (!empty($due_date_from)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.due_date) >=' => $due_date_from
            ));
        }

        if (!empty($due_date_to)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.due_date) >=' => $due_date_to
            ));
        }

        if (!empty($supplier_invoice)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.supplier_invoice' => $supplier_invoice
            ));
        }

        if (!empty($outlet_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.outlet_id' => $outlet_id
            ));
        }

        if (!empty($supplier_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.supplier_id' => $supplier_id
            ));
        }

        $this->MerchantStockOrder->virtualFields['order_item_quantity'] = 'SUM(MerchantStockOrderItem.quantity)';

        $orders = $this->MerchantStockOrder->find('all', array(
            'fields' => array(
                'MerchantStockOrder.id',
                'MerchantStockOrder.name',
                'MerchantStockOrder.order_type_id',
                'MerchantStockOrder.date',
                'MerchantStockOrder.due_date',
                'MerchantOutlet.name',
                'MerchantSourceOutlet.name',
                'MerchantSupplier.name',
                'MerchantStockOrder.order_item_quantity',
                'MerchantStockOrder.order_status_id',
                'StockOrderStatus.name'
            ),
            'conditions' => $conditions,
            'joins' => $joins,
            'group' => 'MerchantStockOrder.id',
            'order' => array(
                'MerchantStockOrder.created' => 'DESC'
            )
        ));

        //reset virtual field so it won't mess up subsequent finds
        unset($this->MerchantStockOrder->virtualFields['order_item_quantity']);

        return $orders;
    }

/**
 * Save a stock order or a stock transfer.
 *
 * @param string $merchant_id merchant id
 * @param string $retailer_id retailer id
 * @return array
 */
    protected function _saveStockOrder($merchant_id, $retailer_id) {
        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockOrder->getDataSource();
        $dataSource->begin();

        try {
            $data = $this->request->data;

            if (isset($data['MerchantStockOrder']['supplier_id']) &&
                empty($data['MerchantStockOrder']['supplier_id'])) {
                unset($data['MerchantStockOrder']['supplier_id']);
            }

            if (isset($data['MerchantStockOrder']['source_outlet_id']) &&
                empty($data['MerchantStockOrder']['source_outlet_id'])) {
                unset($data['MerchantStockOrder']['source_outlet_id']);
            }

            if (isset($data['MerchantStockOrder']['id']) && !empty($data['MerchantStockOrder']['id'])) {
                $this->MerchantStockOrder->id = $data['MerchantStockOrder']['id'];
            } else {
                $data['MerchantStockOrder']['merchant_id'] = $merchant_id;
                $data['MerchantStockOrder']['retailer_id'] = $retailer_id;
                $data['MerchantStockOrder']['order_status_id'] = 'stock_order_status_open';
                $data['MerchantStockOrder']['date'] = date("Y-m-d H:i:s");

                $this->MerchantStockOrder->create();
            }
            $this->MerchantStockOrder->save($data);

            $order_id = $this->MerchantStockOrder->id;
            $outlet_id = $data['MerchantStockOrder']['outlet_id'];

            $orders = array();
            $sequence = 1;

            if (isset($data['auto_fill']) && $data['auto_fill'] == 1) {
                $orders1 = $this->_autoFill($merchant_id, $order_id, $outlet_id);
                foreach ($orders1 as $order) {
                    if (empty($order))
                        continue;
                    $order['MerchantStockOrderItem']['sequence'] = $sequence++;
                    $orders = array_merge($orders, array($order));
                }
            }

            if (isset($_FILES['order_file']) && !empty($_FILES['order_file']['tmp_name'])) {
                $orders2 = $this->_importCSV($merchant_id, $order_id, $_FILES['order_file']['tmp_name']);
                foreach ($orders2 as $order) {
                    if (empty($order))
                        continue;

                    $found = false;
                    foreach ($orders as $temp) {
                        if ($temp['MerchantStockOrderItem']['product_id'] === $order['MerchantStockOrderItem']['product_id'] &&
                            $temp['MerchantStockOrderItem']['supply_price'] === $order['MerchantStockOrderItem']['supply_price']) {
                            $temp['MerchantStockOrderItem']['quantity'] += $order['MerchantStockOrderItem']['quantity'];
                            $found = true;
                            break;
                        }
                    }

                    if (!$found) {
                        $order['MerchantStockOrderItem']['sequence'] = $sequence++;
                        $orders = array_merge($orders, array($order));
                    }
                }
            }

            if (!empty($orders) && is_array($orders)) {
                $this->MerchantStockOrderItem->saveMany($orders);
            }

            $dataSource->commit();

            $result['success'] = true;
            $result['id'] = $order_id;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }
        return $result;
    }

/**
 * Generate stock order items from the reorder point of inventories.
 *
 * @param string $merchant_id merchant id
 * @param string $order_id order id
 * @param string $outlet_id outlet id
 * @return false|array The list of stock order items, or false if reading fails.
 */
    protected function _autoFill($merchant_id, $order_id, $outlet_id) {
        $this->loadModel('MerchantProductInventory');
        $this->MerchantProductInventory->virtualFields['order_id'] = '"' . $order_id . '"';
        $this->MerchantProductInventory->virtualFields['order_quantity'] = 'SUM(MerchantStockOrderItem.quantity)';

        $products = $this->MerchantProductInventory->find('all', array(
            'fields' => array(
                'MerchantProductInventory.order_id',
                'MerchantProductInventory.restock_level',
                'MerchantProductInventory.order_quantity',
                'MerchantProduct.id as product_id',
                'MerchantProduct.name',
                'MerchantProduct.product_uom',
                'MerchantProduct.supply_price',
                'MerchantProduct.stock_type'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_products',
                    'alias' => 'MerchantProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProduct.id = MerchantProductInventory.product_id',
                        'MerchantProduct.stock_type' => $this->options['stock_type'],
                        'MerchantProduct.is_active = 1'
                    )
                ),
                array(
                    'table' => 'merchant_stock_orders',
                    'alias' => 'MerchantStockOrder',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantStockOrder.outlet_id = MerchantProductInventory.outlet_id',
                        'MerchantStockOrder.order_status_id' => array(
                            'stock_order_status_open', 'stock_order_status_sent',
                            'stock_order_status_approved', 'stock_order_status_shipped'
                        )
                    )
                ),
                array(
                    'table' => 'merchant_stock_order_items',
                    'alias' => 'MerchantStockOrderItem',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantStockOrderItem.order_id = MerchantStockOrder.id',
                        'MerchantStockOrderItem.product_id = MerchantProduct.id'
                    )
                )
            ),
            'conditions' => array(
                'MerchantProductInventory.outlet_id' => $outlet_id,
                'MerchantProductInventory.count <= MerchantProductInventory.reorder_point'
            ),
            'group' => 'MerchantProduct.id',
            'order' => array(
                'MerchantProduct.created' => 'DESC'
            )
        ));

        $order_products = Hash::map($products, "{n}", function($array) {
            $newArray = $array['MerchantProductInventory'];
            $newArray = array_merge($newArray, $array['MerchantProduct']);

            $newArray['quantity'] = $newArray['restock_level'] - floatval($newArray['order_quantity']);
            if ($newArray['quantity'] > 0) {
                unset($newArray['order_quantity']);
                unset($newArray['restock_level']);
                return array('MerchantStockOrderItem' => $newArray);
            }
        });

        //reset virtual field so it won't mess up subsequent finds
        unset($this->MerchantProductInventory->virtualFields['order_id']);
        unset($this->MerchantProductInventory->virtualFields['order_quantity']);

        return $order_products;
    }

/**
 * Import stock order items from csv file.
 *
 * @param string $merchant_id merchant id
 * @param string $order_id order id
 * @return false|array The list of stock order item, or false if reading fails.
 */
    protected function _importCSV($merchant_id, $order_id, $file) {
        $contents = file_get_contents($file);
        $csv = array_map("str_getcsv", explode("\n", $contents));

        if (!in_array(array('handle', 'sku', 'supply_price', 'quantity'), $csv)) {
            return false;
        }

        $handle_idx = -1;
        $sku_idx = -1;
        $supply_price_idx = -1;
        $quantity_idx = -1;

        foreach ($csv[0] as $idx => $value) {
            if ($value === 'handle') {
                $handle_idx = $idx;
            } elseif ($value === 'sku') {
                $sku_idx = $idx;
            } elseif ($value === 'supply_price') {
                $supply_price_idx = $idx;
            } elseif ($value === 'quantity') {
                $quantity_idx = $idx;
            }
        }

        $this->MerchantProduct->virtualFields['order_id'] = '"' . $order_id . '"';

        $order_products = array();
        for ($i = 1; $i < count($csv); $i++) {
            if (empty($csv[$i][0])) {
                continue;
            }

            $handle = $csv[$i][$handle_idx];
            $sku = $csv[$i][$sku_idx];

            $product = $this->MerchantProduct->find('first', array(
                'fields' => array(
                    'MerchantProduct.order_id',
                    'MerchantProduct.id as product_id',
                    'MerchantProduct.name',
                    'MerchantProduct.product_uom',
                    'MerchantProduct.supply_price',
                    'MerchantProduct.stock_type'
                ),
                'conditions' => array(
                    'MerchantProduct.merchant_id' => $merchant_id,
                    'MerchantProduct.handle' => $handle,
                    'MerchantProduct.sku' => $sku,
                    'MerchantProduct.stock_type' => $this->options['stock_type'],
                    'MerchantProduct.is_active = 1'
                )
            ));

            if (empty($product) || !is_array($product)) {
                continue;
            }

            $order['MerchantStockOrderItem'] = $product['MerchantProduct'];
            $order['MerchantStockOrderItem']['supply_price'] = $csv[$i][$supply_price_idx];
            $order['MerchantStockOrderItem']['quantity'] = $csv[$i][$quantity_idx];

            $order_products = array_merge($order_products, array($order));
        }

        //reset virtual field so it won't mess up subsequent finds
        unset($this->MerchantProduct->virtualFields['order_id']);

        return $order_products;
    }

}
