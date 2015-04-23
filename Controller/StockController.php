<?php

App::uses('AppController', 'Controller');

class StockController extends AppController {

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
        'MerchantProductBrand',
        'MerchantProductType',
        'MerchantProductTag',
        'MerchantProductCategory',
        'MerchantProduct',
        'MerchantProductComposite',
        'MerchantProductInventory',
        'MerchantOutlet',
        'MerchantSupplier',
        'MerchantStockOrder',
        'MerchantStockOrderItem',
        'MerchantStockTake',
        'MerchantStockTakeItem'
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
 * Stock order implementation
 *
 */

/**
 * list of the merchant stock orders.
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

        // get the list of merchant orders
        $orders = $this->__getMerchantOrders($user['merchant_id'], $status, $name, $date_from, $date_to, $due_date_from, $due_date_to, $supplier_invoice, $outlet_id, $supplier_id);
        $this->set('orders', $orders);

        // get the list of order status
        $filters = $this->__listOrderStatus();
        $this->set('filters', $filters);

        // get the list of merchant outlets
        $outlets = $this->__listMerchantOutlets($user['merchant_id']);
        $this->set('outlets', $outlets);

        // get the list of merchant suppliers
        $suppliers = $this->__listMerchantSuppliers($user['merchant_id']);
        $this->set('suppliers', $suppliers);
    }

/**
 * save the merchant stock order and items into 'merchant_stock_order' table and
 * 'merchant_stock_order_items' 
 * log to the 'merchant_product_logs' table when the order sent or received ...
 */
    public function newOrder() {
        $user = $this->Auth->user();

        // save the form data when submitted...
        if($this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                $data['MerchantStockOrder']['merchant_id'] = $user['merchant_id'];
                $data['MerchantStockOrder']['type'] = 'SUPPLIER';
                $data['MerchantStockOrder']['status'] = 'OPEN';
                $data['MerchantStockOrder']['date'] = date('Y-m-d h:i:s');

                unset($data['MerchantStockOrder']['source_outlet_id']);
                if (empty($data['MerchantStockOrder']['supplier_id'])) {
                    unset($data['MerchantStockOrder']['supplier_id']);
                }

                // create a merchant stock order
                $this->MerchantStockOrder->create();
                $this->MerchantStockOrder->save($data);

                $order_id = $this->MerchantStockOrder->id;

                // check 'auto_fill'
                if (isset($data['order-auto']) && $data['order-auto'] == '1') {
                    $orderItems = $this->__autoFillProducts($order_id, $data['MerchantStockOrder']['outlet_id']);

                    // save order items ... 
                    if (is_array($orderItems)) {
                        $this->MerchantStockOrderItem->saveMany($orderItems);
                    }
                }
                $dataSource->commit();

                // redirect to edit
                $this->redirect('/stock/' . $order_id . '/edit');
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        // get the list of merchant outlets
        $outlets = $this->__listMerchantOutlets($user['merchant_id']);
        $this->set('outlets', $outlets);

        // get the list of merchant suppliers
        $suppliers = $this->__listMerchantSuppliers($user['merchant_id']);
        $this->set('suppliers', $suppliers);
    }

    public function newTransfer() {
        $user = $this->Auth->user();

        // save the form data when sumitted ...
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                $data['MerchantStockOrder']['merchant_id'] = $user['merchant_id'];
                $data['MerchantStockOrder']['type'] = 'OUTLET';
                $data['MerchantStockOrder']['status'] = 'OPEN';
                $data['MerchantStockOrder']['date'] = date('Y-m-d h:i:s');

                unset($data['MerchantStockOrder']['supplier_id']);
                if (empty($data['MerchantStockOrder']['source_outlet_id'])) {
                    unset($data['MerchantStockOrder']['source_outlet_id']);
                }

                // create a merchant stock order
                $this->MerchantStockOrder->create();
                $this->MerchantStockOrder->save($data);

                $order_id = $this->MerchantStockOrder->id;

                // check 'auto_fill'
                if (isset($data['order-auto']) && $data['order-auto'] == '1') {
                    $orderItems = $this->__autoFillProducts($order_id, $data['MerchantStockOrder']['outlet_id']);

                    // save order items ... 
                    if (is_array($orderItems)) {
                        $this->MerchantStockOrderItem->saveMany($orderItems);
                    }
                } 
                $dataSource->commit();

                // redirect to edit
                $this->redirect('/stock/' . $order_id . '/edit');
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        // get the list of merchant outlets
        $outlets = $this->__listMerchantOutlets($user['merchant_id']);
        $this->set('outlets', $outlets);
    }

/**
 *  edit a existing stock order
 *
 *  @param string merchant stock order id
 */
    public function editDetails($id) {
        $user = $this->Auth->user();

        // update the form data when submitted ...
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                // update the merchant stock order
                $this->MerchantStockOrder->id = $id;
                $this->MerchantStockOrder->save($data);

                $dataSource->commit();

                // redirect to edit
                $this->redirect('/stock/' . $id . '/edit');
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        $orderDetails = $this->__getOrderDetails($id);
        $this->set('data', $orderDetails);

        if (!$this->request->data) {
            $this->request->data = $orderDetails;
        }
    }

/**
 * edit a merchant stock order & merchant stock order item
 *
 * @param string merchant stock order id
 */
    public function edit($id) {
        $user = $this->Auth->user();

        // update form data ...
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                if (isset($data['MerchantStockOrderItem']['id']) && !empty($data['MerchantStockOrderItem']['id'])) {
                    $this->MerchantStockOrderItem->id = $data['MerchantStockOrderItem']['id'];
                } else {
                    $this->MerchantStockOrderItem->create();
                }
                $this->MerchantStockOrderItem->save($data);

                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        // get the merchant stock order
        $order = $this->__getOrderDetailsAndItems($id);
        $this->set('data', $order);

        $inventories = $this->__getOutletInventories($order['MerchantStockOrder']['outlet_id']);
        $this->set('inventories', $inventories);

        if (!$this->request->data) {
            $this->request->data = $order;
        }
    }

    public function receive($id) {
        $user = $this->Auth->user();

        // update form data ...
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                if (isset($data['MerchantStockOrderItem']['id']) && !empty($data['MerchantStockOrderItem']['id'])) {
                    $this->MerchantStockOrderItem->id = $data['MerchantStockOrderItem']['id'];
                } else {
                    $this->MerchantStockOrderItem->create();
                }
                $this->MerchantStockOrderItem->save($data);

                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        // get the merchant stock order
        $order = $this->__getOrderDetailsAndItems($id);
        $this->set('data', $order);

        $inventories = $this->__getOutletInventories($order['MerchantStockOrder']['outlet_id']);
        $this->set('inventories', $inventories);

        if (!$this->request->data) {
            $this->request->data = $order;
        }
/*
        if ( $this->request->is('post') ) {
            $data = $this->request->data['MerchantStockOrderItem'];

            // for total_cost, total_price_incl_tax
            foreach ($data as $i => &$d) {
                $total_cost = round($d['received'] * $d['supply_price'], 2);
                $data[$i]['total_cost'] = $total_cost;
                $data[$i]['total_price_incl_tax'] = round($d['received'] * $d['price_include_tax'], 2);
            }

            for ($i = 0; $i < count($data); $i++) {
                $data[$i] = array('MerchantStockOrderItem' => $data[$i]);
            }

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                $this->MerchantStockOrderItem->saveMany($data);

                $dataSource->commit();

                // redirect to the view
                $this->redirect('/stock/view/' . $id);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }
*/

        
        // get the merchant stock order
        /*
        $this->loadModel('MerchantStockOrder');

        $this->MerchantStockOrder->bindModel(array(
            'belongsTo' => array(
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                ),
                'MerchantSupplier' => array(
                    'className' => 'MerchantSupplier',
                    'foreignKey' => 'supplier_id'
                )
            ),
            'hasMany' => array(
                'MerchantStockOrderItem' => array(
                    'className' => 'MerchantStockOrderItem',
                    'foreignKey' => 'order_id'
                )
            )
        ));

        $this->MerchantStockOrderItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->loadModel('MerchantProduct');
        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id',
                    'conditions' => array(
                        'MerchantProductInventory.outlet_id' => $stockOrder['MerchantStockOrder']['outlet_id']
                    )
                )
            )
        ));

        $order = $this->MerchantStockOrder->find('first', array(
            'recursive' => 3,
            'conditions' => array(
                'MerchantStockOrder.id' => $id
            )
        ));
        $this->set('order', $order);


        // get the list of products
        $products = $this->MerchantProduct->find('all', array(
            'fields' => array('MerchantProduct.*', 'MerchantProductInventory.*'),
            'joins' => array(
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantProduct.id = MerchantProductInventory.product_id',
                        'MerchantProductInventory.outlet_id' => $order['MerchantStockOrder']['outlet_id']
                    )
                )
            ),
            'conditions' => array(
                'MerchantProduct.merchant_id' => $order['MerchantStockOrder']['merchant_id']
            )
        ));
        $this->set('products', $products);
         */
/*

        $stockOrder = $this->MerchantStockOrder->findById($id);

        $order = $this->__stockOrder($id, $stockOrder['MerchantStockOrder']['outlet_id']);
        $this->set('order', $order);

        // get the list of products
        $products = $this->__merchantProducts($this->Auth->user()['merchant_id'], $stockOrder['MerchantStockOrder']['outlet_id']);
        $this->set('products', $products);

        if ( !$this->request->data ) {
            $this->request->data = $order;
        }
*/

    }

/**
 * view a merchant stock order
 *
 * @param string merchant stock order id
 */
    public function view($id) {
        // get the merchant stock order
        $order = $this->__getOrderDetailsAndItems($id);
        $this->set('data', $order);

        $inventories = $this->__getOutletInventories($order['MerchantStockOrder']['outlet_id']);
        $this->set('inventories', $inventories);
    }

    public function saveItem() {
        $result = array(
            'success' => false
        );
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
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
        $this->serialize($result);
    }

    public function saveItems() {
        $result = array(
            'success' => false
        );
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                if (isset($data['MerchantStockOrderItem']) && is_array($data['MerchantStockOrderItem'])) {
                    $this->MerchantStockOrderItem->saveMany($data['MerchantStockOrderItem']);
                }
                $dataSource->commit();

                $result['success'] = true;
                $result['data'] = $data;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }

/**
 * 1) update the merchant order status to 'SENT' &
 * 2) log into 'merchant_product_logs'
 *
 * @param string merchant stock id
 */
    public function markSent($id) {
        $result = array(
            'success' => false
        );
        $user = $this->Auth->user();

        if ($this->request->is('get') || $this->request->is('post')) {
            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                $orderDetails = $this->__getOrderDetails($id);
                if (isset($orderDetails['MerchantStockOrder']) && is_array($orderDetails['MerchantStockOrder'])) {
                    if ('OPEN' == $orderDetails['MerchantStockOrder']['status']) {
                        // mark as sent
                        $data['MerchantStockOrder']['status'] = 'SENT';
                        $this->MerchantStockOrder->id = $id;
                        $this->MerchantStockOrder->save($data);

                        if ('OUTLET' == $orderDetails['MerchantStockOrder']['type']) {
                            $action_type = 'transfer_placed';
                        } else {
                            $action_type = 'order_placed';
                        }

                        // save stock order logs
                        $result['data'] = $this->__saveOrderItemLogs($id, $user['merchant_id'], $user['id'], $orderDetails['MerchantStockOrder']['outlet_id'], $action_type);

                        $dataSource->commit();
                        $result['success'] = true;
                   }
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
        }
        $this->serialize($result);
    }

    public function export() {
    }

    public function import() {
    }

    public function searchProduct() {
        $result = array(
            'success' => false
        );
        $user = $this->Auth->user();
        $keyword = null;

        if ($this->request->is('get')) {
            $keyword = $this->get('keyword');
        } elseif ($this->request->is('post')) {
            $keyword = $this->post('keyword');
        }

        $products = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $user['merchant_id'],
                'MerchantProduct.is_active = 1',
                'OR' => array(
                    'MerchantProduct.name LIKE' => '%' . $keyword . '%',
                    'MerchantProduct.sku LIKE' => '%' . $keyword . '%'
                )
            )
        ));

        $products = Hash::map($products, "{n}", function($array) {
            $newArray = $array['MerchantProduct'];

            if ('Composite' === $newArray['stock_type']) {
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
 * list the order status for 'select' form
 *
 * @return array the list
 */
    private function __listOrderStatus() {
        $this->loadModel('OrderStatus');

        $status = $this->OrderStatus->find('list', array(
            'fields' => array(
                'OrderStatus.status',
                'OrderStatus.description'
            ),
            'conditions' => array(
                'OrderStatus.type' => 'ORDER'
            ),
            'order' => array(
                'FIELD(status, "ALL", "OPEN", "SENT", "RECEIVED", "OVERDUE", "CANCELLED", "RECEIVE_FAIL")'
            )
        ));
        return $status;
    }

/**
 * list the merchant outlets for 'select' form
 *
 * @param string merchant id
 * @return array the list
 */
    private function __listMerchantOutlets($merchant_id) {
        $this->loadModel('MerchantOutlet');

        $outlets = $this->MerchantOutlet->find('list', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $merchant_id
            )
        ));
        return $outlets;
    }

/**
 * list the merchant suppliers for 'select' form 
 *
 * @param string merchant id
 * @return array the list
 */
    private function __listMerchantSuppliers($merchant_id) {
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
 * list the merchant orders
 *
 * @param string merchant id
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
    private function __getMerchantOrders($merchant_id, $status, $keyword, $date_from, $date_to, $due_date_from, $due_date_to, $supplier_invoice, $outlet_id, $supplier_id) {
        $this->loadModel('MerchantStockOrder');

        $conditions = array(
            'MerchantStockOrder.merchant_id' => $merchant_id
        );

        $joins = array(
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

        if ($status !== 'ALL') {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.status' => $status
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

        $this->MerchantStockOrder->virtualFields['order_item_count'] = 'SUM(MerchantStockOrderItem.count)';

        $orders = $this->MerchantStockOrder->find('all', array(
            'fields' => array(
                'MerchantStockOrder.id',
                'MerchantStockOrder.name',
                'MerchantStockOrder.type',
                'MerchantStockOrder.date',
                'MerchantStockOrder.due_date',
                'MerchantOutlet.name',
                'MerchantSourceOutlet.name',
                'MerchantSupplier.name',
                'MerchantStockOrder.order_item_count',
                'MerchantStockOrder.status'
            ),
            'conditions' => $conditions,
            'joins' => $joins,
            'group' => 'MerchantStockOrder.id',
            'order' => array(
                'MerchantStockOrder.created' => 'DESC'
            )
        ));

        //reset virtual field so it won't mess up subsequent finds
        unset($this->MerchantStockOrder->virtualFields['order_item_count']);

        return $orders;
    }

/**
 * list the outlet inventories
 *
 * @param string outlet id
 * @return array the outlet inventories
 */
    private function __getOutletInventories($outlet_id) {
        $this->loadModel('MerchantProductInventory');

        $inventories = $this->MerchantProductInventory->find('all', array(
            'conditions' => array(
                'MerchantProductInventory.outlet_id' => $outlet_id
            )
        ));

        $outletInventories = array();
        foreach ($inventories as $inventory) {
            $outletInventories = Hash::insert($outletInventories, $inventory['MerchantProductInventory']['product_id'], $inventory['MerchantProductInventory']);
        }
        return $outletInventories;
    }

/**
 * list the merchant's product stock count
 *
 * @param string merchant id
 * @param array product ids
 * @return array stock count
 */
    private function __getMerchantStockCount($merchant_id, $product_id) {
        $this->loadModel('MerchantProduct');

        $this->MerchantProduct->virtualFields['stock_count'] = 'SUM(MerchantProductInventory.count)';

        $product = $this->MerchantProduct->find('first', array(
            'fields' => array(
                'MerchantProduct.id',
                'MerchantProduct.stock_count'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantProductInventory.product_id = MerchantProduct.id'
                    )
                ),
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantOutlet.id = MerchantProductInventory.outlet_id',
                        'MerchantOutlet.merchant_id' => $merchant_id
                    )
                )
            ),
            'conditions' => array(
                'MerchantProduct.id' => $product_id
            ),
            'group' => 'MerchantProduct.id'
        ));
        unset($this->MerchantProduct->virtualFields['stock_count']);

        return $product;
    }

/**
 * get auto-fill list from the reorder point of the merchant products
 *
 * @param string order id
 * @param string outlet id
 * @return array the order items
 */
    private function __autoFillProducts($order_id, $outlet_id) {
        $this->loadModel('MerchantProductInventory');

        $inventories = $this->MerchantProductInventory->find('all', array(
            'fields' => array(
                'MerchantProductInventory.*',
                'MerchantProduct.*'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_products',
                    'alias' => 'MerchantProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProduct.id = MerchantProductInventory.product_id',
                        'MerchantProduct.is_active = 1'
                    )
                )
            ),
            'conditions' => array(
                'MerchantProductInventory.outlet_id' => $outlet_id,
                'MerchantProductInventory.count < MerchantProductInventory.reorder_point'
            )
        ));

        $orderItems = array();
        foreach ($inventories as $array) {
            $orderItems = array_merge($orderItems, array(
                array(
                    'MerchantStockOrderItem' => array(
                        'order_id'              => $order_id,
                        'product_id'            => $array['MerchantProduct']['id'],
                        'name'                  => $array['MerchantProduct']['name'],
                        'count'                 => $array['MerchantProductInventory']['restock_level'],
                        'supply_price'          => $array['MerchantProduct']['supply_price'],
                        'total_cost'            => $array['MerchantProduct']['supply_price'] * $array['MerchantProductInventory']['restock_level'],
                        'price_include_tax'     => $array['MerchantProduct']['price_include_tax'],
                        'total_price_incl_tax'  => $array['MerchantProduct']['price_include_tax'] *$array['MerchantProductInventory']['restock_level']
                    )
                )
            ));
        }
        return $orderItems;
    }

/**
 * get the order details
 *
 * @param string order id
 * @return array the order datails
 */
    private function __getOrderDetails($order_id) {
        $this->loadModel('MerchantStockOrder');

        $orderDetails = $this->MerchantStockOrder->find('first', array(
            'fields' => array(
                'MerchantStockOrder.*',
                'MerchantOutlet.id',
                'MerchantOutlet.name',
                'MerchantSourceOutlet.id',
                'MerchantSourceOutlet.name',
                'MerchantSupplier.id',
                'MerchantSupplier.name'
            ),
            'joins' => array(
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
        return $orderDetails;
    }

/**
 * get the order details and items
 *
 * @param string order id
 * @return array the order datails and items
 */
    private function __getOrderDetailsAndItems($order_id) {
        $this->loadModel('MerchantStockOrder');
        $this->loadModel('MerchantStockOrderItem');

        $this->MerchantStockOrderItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->MerchantStockOrder->bindModel(array(
            'hasMany' => array(
                'MerchantStockOrderItem' => array(
                    'className' => 'MerchantStockOrderItem',
                    'foreignKey' => 'order_id'
                )
            )
        ));

        $order = $this->MerchantStockOrder->find('first', array(
            'fields' => array(
                'MerchantStockOrder.*',
                'MerchantOutlet.id',
                'MerchantOutlet.name',
                'MerchantSourceOutlet.id',
                'MerchantSourceOutlet.name',
                'MerchantSupplier.id',
                'MerchantSupplier.name'
            ),
            'joins' => array(
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
            ),
            'recursive' => 2
        ));

        $order['MerchantStockOrderItem'] = Hash::map($order['MerchantStockOrderItem'], "{n}", function($array) {
            $product = $array['MerchantProduct'];

            if ('Composite' === $product['stock_type']) {
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
                        'MerchantProductComposite.parent_id' => $product['id']
                    )
                ));
                $array['MerchantProduct']['subitems'] = Hash::map($subitems, "{n}", function($array) {
                    $array['quantity'] = $array['MerchantProductComposite']['quantity'];
                    unset($array['MerchantProductComposite']);
                    return $array;
                });
            }
            return $array;
        });
        return $order;
    }

    private function __saveOrderItemLogs($order_id, $merchant_id, $user_id, $outlet_id, $action_type) {
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductLog');

        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $products = $this->MerchantProduct->find('all', array(
            'fields' => array(
                'MerchantProduct.*',
                'MerchantProductInventory.*',
                'MerchantStockOrderItem.*'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_stock_order_items',
                    'alias' => 'MerchantStockOrderItem',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantStockOrderItem.product_id = MerchantProduct.id',
                        'MerchantStockOrderItem.order_id' => $order_id
                    )
                ),
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantProductInventory.product_id = MerchantProduct.id',
                        'MerchantProductInventory.outlet_id' => $outlet_id
                    )
                )
            )
        ));

        $productLogs = array();
        $referer_url = '/stock/' . $order_id;

        foreach ($products as $product) {
            if ('order_received' == $action_type || 'transfer_received' == $action_type) {
                $change = $products['MerchantStockOrderItem']['received'];
            } else {
                $change = 0;
            }

            $stock_count = $this->__getMerchantStockCount($merchant_id, $product['MerchantProduct']['id']);
            if (isset($stock_count['MerchantProduct'])) {
                $quantity = $stock_count['MerchantProduct']['stock_count'];
            } else {
                $quantity = null;
            }

            $productLogs = array_merge($productLogs, array(
                array(
                    'product_id' => $product['MerchantProduct']['id'],
                    'user_id' => $user_id,
                    'outlet_id' => $outlet_id,
                    'quantity' => $quantity,
                    'outlet_quantity' => $product['MerchantProductInventory']['count'],
                    'change' => $change,
                    'action_type' => $action_type,
                    'referer_url' => $referer_url
                )
            ));
        }

        $this->MerchantProductLog->saveMany($productLogs);
        return $productLogs;
    }

    private function __makeProductLogs($merchant_stock_order_id, $action_type) {
        $this->loadModel('MerchantStockOrder');
        $this->MerchantStockOrder->bindModel(array(
            'hasMany' => array(
                'MerchantStockOrderItem' => array(
                    'className' => 'MerchantStockOrderItem',
                    'foreignKey' => 'order_id'
                )
            )
        ));

        $order = $this->MerchantStockOrder->find('first', array(
            'conditions' => array(
                'MerchantStockOrder.id' => $merchant_stock_order_id
            )
        ));

        $this->loadModel('MerchantProduct');
        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $products = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $order['MerchantStockOrder']['merchant_id']
            )
        ));

        $product_logs = array();
        foreach ($order['MerchantStockOrderItem'] as $idx => $item) {
            if ( $action_type == 'order_placed' ) {
                $change = $item['count'];
            } elseif ( $action_type == 'order_received' ) {
                $change = $item['received'];
            } else {
                $change = '0';
            }

            $product_logs[$idx]['MerchantProductLog'] = array(
                'product_id'        => $item['product_id'],
                'user_id'           => $this->Auth->user()['id'],
                'outlet_id'         => $order['MerchantStockOrder']['outlet_id'],
                'quantity'          => '0',
                'outlet_quantity'   => '0',
                'change'            => $change,
                'action_type'       => $action_type,
                'referer_url'       => '/stock/view/' . $order['MerchantStockOrder']['id']
            );

            // quantity & outlet_quantity
            foreach ($products as $product) {
                if (
                    $product['MerchantProduct']['merchant_id'] == $order['MerchantStockOrder']['merchant_id'] &&
                    $product['MerchantProduct']['id'] == $item['product_id']
                ) {
                    foreach ($product['MerchantProductInventory'] as $inventory) {
                        if ( $inventory['outlet_id'] == $order['MerchantStockOrder']['outlet_id'] ) {
                            $product_logs[$idx]['MerchantProductLog']['outlet_quantity'] += $inventory['count']; 
                        }
                        $product_logs[$idx]['MerchantProductLog']['quantity'] += $inventory['count']; 
                    }
                }
            }

        }

        return $product_logs;
    }

    /**
     * get the selected order
     *
     * @param string order id
     * @param string outlet id
     * @reutrn array the order
     */
    private function __stockOrder($order_id, $outlet_id) {
        $this->MerchantStockOrder->bindModel(array(
            'belongsTo' => array(
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                ),
                'MerchantSourceOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'source_outlet_id'
                ),
                'MerchantSupplier' => array(
                    'className' => 'MerchantSupplier',
                    'foreignKey' => 'supplier_id'
                )
            ),
            'hasMany' => array(
                'MerchantStockOrderItem' => array(
                    'className' => 'MerchantStockOrderItem',
                    'foreignKey' => 'order_id'
                )
            )
        ));

        $this->MerchantStockOrderItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->loadModel('MerchantProduct');
        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id',
                    'conditions' => array(
                        'MerchantProductInventory.outlet_id' => $outlet_id
                    )
                )
            )
        ));

        $order = $this->MerchantStockOrder->find('first', array(
            'recursive' => 3,
            'conditions' => array(
                'MerchantStockOrder.id' => $order_id
            )
        ));

        return $order;
    }

    /**
     * get the merchant products
     *
     * @param string merchant id
     * @param string outlet id
     * @return array the merchant products
     */
    private function __merchantProducts($merchant_id, $outlet_id) {
        $this->loadModel('MerchantProduct');

        $products = $this->MerchantProduct->find('all', array(
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
                'MerchantProduct.merchant_id' => $merchant_id
            )
        ));

        return $products;
    }

    public function saveSentItems() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/stock');
        }

        $result = array(
            'success' => false
        );

        try {
            $order = $this->MerchantStockOrder->findById($this->request->data['MerchantStockOrder']['id']);

            $data = isset($this->request->data['MerchantStockOrderItem'])
                ? $this->request->data['MerchantStockOrderItem']
                : array();

            // if the order is transfer then handle inventory ...
            if ( $order['MerchantStockOrder']['type'] == 'OUTLET' ) {
                /*
                $inventory = array();
                $this->loadModel['MerchantProductInventory'];
                $this->MerchantProductInventory->bindModel(array(
                    'belongsTo' => array(
                        'MerchantProduct' => array(
                            'className' => 'MerchantProduct',
                            'foreignKey' => 'product_id'
                        )
                    )
                ));
                
                $this->loadModel('MerchantProduct');
                foreach ($data as $d) {
                    $product = $this->MerchantProduct->find('first', array(
                        'fields' => array('MerchantProduct.*', 'MerchantProductInventory.*'),
                        'joins' => array(
                            array(
                                'table' => 'merchant_product_inventories',
                                'alias' => 'MerchantProductInventory',
                                'type' => 'LEFT',
                                'conditions' => array(
                                    'MerchantProduct.id = MerchantProductInventory.product_id',
                                    'MerchantProductInventory.outlet_id' => $order['MerchantStockOrder']['outlet_id']
                                )
                            )
                        ),
                        'conditions' => array(
                            'MerchantProduct.merchant_id' => $order['MerchantStockOrder']['merchant_id'],
                            'MerchantProduct.id' => $d['product_id']
                        )
                    ));

                    if ( $product['MerchantProduct']['track_inventory'] == '1' ) {
                        $product['MerchantProductInventory']['count'] -= $d['received'];
                        $inventory[] = $product['MerchantProductInventory'];
                    }
                }
                 */
                $inventory = array();
                $inventory = $this->__inventory($order['MerchantStockOrder']['merchant_id'], $order['MerchantStockOrder']['outlet_id'], $data, '-');
            }

            $items = $this->__saveItems($data);

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            if ( $items ) {
                $this->MerchantStockOrderItem->saveMany($items);
            }

            if ( $inventory ) {
                $this->MerchantProductInventory->saveMany($inventory);
            }

            $dataSource->commit();

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
    }

    public function saveReceivedItems() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/stock');
        }

        $result = array(
            'success' => false
        );

        try {
            $order = $this->MerchantStockOrder->findById($this->request->data['MerchantStockOrder']['id']);

            $data = isset($this->request->data['MerchantStockOrderItem']) ? $this->request->data['MerchantStockOrderItem'] : array();

            // handle inventory ...
            $inventory = array();
            $this->loadModel('MerchantProductInventory');
            $this->MerchantProductInventory->bindModel(array(
                'belongsTo' => array(
                    'MerchantProduct' => array(
                        'className' => 'MerchantProduct',
                        'foreignKey' => 'product_id'
                    )
                )
            ));

            $this->loadModel('MerchantProduct');
            foreach ($data as $d) {
                $product = $this->MerchantProduct->find('first', array(
                    'fields' => array('MerchantProduct.*', 'MerchantProductInventory.*'),
                    'joins' => array(
                        array(
                            'table' => 'merchant_product_inventories',
                            'alias' => 'MerchantProductInventory',
                            'type' => 'LEFT',
                            'conditions' => array(
                                'MerchantProduct.id = MerchantProductInventory.product_id',
                                'MerchantProductInventory.outlet_id' => $order['MerchantStockOrder']['outlet_id']
                            )
                        )
                    ),
                    'conditions' => array(
                        'MerchantProduct.merchant_id' => $order['MerchantStockOrder']['merchant_id'],
                        'MerchantProduct.id' => $d['product_id']
                    )
                ));

                if ( $product['MerchantProduct']['track_inventory'] == '1' ) {
                    $product['MerchantProductInventory']['count'] += $d['received'];
                    $inventory[] = $product['MerchantProductInventory'];
                }
            }

            // for total_cost, total_price_incl_tax
            foreach ($data as $i => $d) {
                $total_cost = round($d['received'] * $d['supply_price'], 2);
                $data[$i]['total_cost'] = $total_cost;
                $data[$i]['total_price_incl_tax'] = round($d['received'] * $d['price_include_tax'], 2);
            }

            $items = array();
            foreach ($data as $d) {
                $items[]['MerchantStockOrderItem'] = $d;
            }

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            if ( $items ) {
                $this->MerchantStockOrderItem->saveMany($items);
            }

            if ( $inventory ) {
                $this->MerchantProductInventory->saveMany($inventory);
            }

            $dataSource->commit();

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
            $result['message'] .= json_encode($this->request->data);
        }
        $this->serialize($result);
    }

    /**
     * 1) update the merchant order status to 'SENT' &
     * 2) log into 'merchant_product_logs'
     * 3) send an email
     */
    public function sentEmail() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/stock');
        }

        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockOrder->getDataSource();
        $dataSource->begin();

        try {
            $data = $this->request->data;

            // 1)
            $this->loadModel('MerchantStockOrder');
            $data['MerchantStockOrder']['status'] = 'SENT';
            $this->MerchantStockOrder->id = $data['order_id'];
            $this->MerchantStockOrder->save($data);

            // 2)
            $logs = $this->__makeProductLogs($data['order_id'], 'order_placed');

            $this->loadModel('MerchantProductLog');
            $this->MerchantProductLog->create();
            $this->MerchantProductLog->saveMany($logs);

            $dataSource->commit();

            // 3)

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
    }

    /**
     * 1) update the merchant order status to 'RECEIVED' &
     * 2) log into 'merchant_product_logs'
     * 3) send an email
     */
    public function receivedEmail() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/stock');
        }

        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockOrder->getDataSource();
        $dataSource->begin();

        try {
            $data = $this->request->data;

            // 1)
            $this->loadModel('MerchantStockOrder');
            $data['MerchantStockOrder']['status'] = 'RECEIVED';
            $this->MerchantStockOrder->id = $data['order_id'];
            $this->MerchantStockOrder->save($data);

            // 2)
            $logs = $this->__makeProductLogs($data['order_id'], 'order_received');

            $this->loadModel('MerchantProductLog');

            if ( $logs ) {
                $this->MerchantProductLog->create();
                $this->MerchantProductLog->saveMany($logs);
            }

            $dataSource->commit();

            // 3)

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
    }

    private function __fullCount($outlet_id, $show_inactive) {
        $this->loadModel('MerchantProductInventory');

        if ( $show_inactive == '1' ) {
            $conditions = array();
        } else {
            $conditions = array('MerchantProduct.is_active' => '1');
        }

        $this->MerchantProductInventory->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id',
                    'conditions' => $conditions
                )
            )
        ));

        $inventories = $this->MerchantProductInventory->find('all', array(
            'conditions' => array(
                'MerchantProductInventory.outlet_id' => $outlet_id,
            )
        ));

        return $inventories;
    }

    /**
     * 1) update the merchant order status to 'SENT' &
     * 2) log into 'merchant_product_logs'
     * 3) if 'transfer', then handle inventory
     * 4) send email, optional, if form data passed
     */
    public function send() {
        if ( !$this->request->is('ajax') || !$this->request->is('post') ) {
            $this->redirect('/stock');
        }

        $result = array(
            'success' => false
        );

        $id = $this->request->data['MerchantStockOrder']['id'];

        $order = $this->MerchantStockOrder->findById($id);

        $inventory = array();
        if ( $order['MerchantStockOrder']['type'] == 'OUTLET' ) {
            $items = $this->MerchantStockOrderItem->find('all', array(
                'conditions' => array(
                    'MerchantStockOrderItem.order_id' => $order['MerchantStockOrder']['id']
                )
            ));

            $inventory = $this->__inventory($order['MerchantStockOrder']['merchant_id'], $order['MerchantStockOrder']['source_outlet_id'], $items, '-');
        }

        $dataSource = $this->MerchantStockOrder->getDataSource();
        $dataSource->begin();

        try {
            // 1)
            $data['MerchantStockOrder']['status'] = 'SENT';
            $this->MerchantStockOrder->id = $id;
            $this->MerchantStockOrder->save($data);

            // 2)
            if ( $order['MerchantStockOrder']['type'] == 'OUTLET' ) {
                $product_action_type = 'transfer_placed';
            } else {
                $product_action_type = 'order_placed';
            }

            $logs = $this->__makeProductLogs($id, $product_action_type);
            if ( $logs ) {
                $this->loadModel('MerchantProductLog');
                $this->MerchantProductLog->saveMany($logs);
            }

            // 3)
            if ( $inventory ) {
                $this->loadModel('MerchantProductInventory');
                $this->MerchantProductInventory->saveMany($inventory); 
            }

            // 4)
            if ( isset($this->request->data['Email']) ) {

            }

            $dataSource->commit();

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }

        $this->serialize($result);
    }

    /**
     * 1) update the merchant order status to 'RECEIVED' &
     * 2) log into 'merchant_product_logs'
     * 3) handle inventory
     * 4) send email, optional, if form data passed
     */
    public function sendReceive() {
        if ( !$this->request->is('ajax') || !$this->request->is('post') ) {
            $this->redirect('/stock');
        }

        $result = array(
            'success' => false
        );

        $id = $this->request->data['MerchantStockOrder']['id'];

        $order = $this->MerchantStockOrder->findById($id);

        $items = $this->MerchantStockOrderItem->find('all', array(
            'conditions' => array(
                'MerchantStockOrderItem.order_id' => $order['MerchantStockOrder']['id']
            )
        ));

        $inventory = $this->__inventory($order['MerchantStockOrder']['merchant_id'], $order['MerchantStockOrder']['outlet_id'], $items, '+');

        $dataSource = $this->MerchantStockOrder->getDataSource();
        $dataSource->begin();

        try {
            // 1)
            $data['MerchantStockOrder']['status'] = 'RECEIVED';
            $this->MerchantStockOrder->id = $id;
            $this->MerchantStockOrder->save($data);

            // 2)
            if ( $order['MerchantStockOrder']['type'] == 'OUTLET' ) {
                $product_action_type = 'transfer_received';
            } else {
                $product_action_type = 'order_received';
            }

            $logs = $this->__makeProductLogs($id, $product_action_type);
            if ( $logs ) {
                $this->loadModel('MerchantProductLog');
                $this->MerchantProductLog->saveMany($logs);
            }

            // 3)
            if ( $inventory ) {
                $this->loadModel('MerchantProductInventory');
                $this->MerchantProductInventory->saveMany($inventory);
            }

            // 4)
            if ( isset($this->request->data['Email']) ) {

            }

            $dataSource->commit();

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $reuslt['message'] = $e->getMessage();
        }

        $this->serialize($result);
    }

/**
 * Inventory count implementation
 *
 */
    public function inventoryCount() {
        $user = $this->Auth->user();

        // get the stock take list
        $stockTakes = $this->MerchantStockTake->find('all', array(
            'fields' => array(
                'MerchantStockTake.*',
                'MerchantOutlet.*'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantOutlet.id = MerchantStockTake.outlet_id'
                    )
                )
            ),
            'conditions' => array(
                'MerchantStockTake.type' => 'STOCKTAKE',
                'MerchantStockTake.merchant_id' => $user['merchant_id']
            ),
            'order' => array(
                'MerchantStockTake.created DESC'
            )
        ));

        $inventoryCounts = array();
        foreach ($stockTakes as $stockTake) {
            $count['id'] = $stockTake['MerchantStockTake']['id'];
            $count['name'] = $stockTake['MerchantStockTake']['name'];
            $count['status'] = $stockTake['MerchantStockTake']['status'];
            $count['start_date'] = $stockTake['MerchantStockTake']['start_date'];
            $count['outlet'] = $stockTake['MerchantOutlet']['name'];
            $count['count'] = $stockTake['MerchantStockTake']['full_count'] == 1 ? 'Full' : 'Partial';

            if ($count['status'] == 'STOCKTAKE_CANCELLED') {
                $inventoryCounts['cancelled'][] = $count;
            } elseif ($count['status'] == 'STOCKTAKE_COMPLETE') {
                $inventoryCounts['completed'][] = $count;
            } else {
                $inventoryCounts['due'][] = $count;
            }
        }
        $this->set('inventoryCounts', $inventoryCounts);
    }

    public function newInventoryCount() {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $this->set('data', $data);

            $dataSource = $this->MerchantStockTake->getDataSource();
            $dataSource->begin();

            try {
                $stock_take_id = $data['id'];
                $name = $data['name'];
                $outlet_id = $data['outlet_id'];
                $show_inactive = isset($data['show_inactive']) ? $data['show_inactive'] : '0';
                $full_count = $data['full_count'];
                $filters = $data['filters'];
                $start_date = date('Y-m-d h:i:s', strtotime($data['start_date'] . ' ' . $data['start_time']));

                $stock_take_id = $this->__saveInventoryCount($user['merchant_id'], $stock_take_id, $name,
                    $outlet_id, $show_inactive, $full_count, $filters, $start_date, 'STOCKTAKE_SCHEDULED');

                $dataSource->commit();

                if (!empty($stock_take_id)) {
                    $this->redirect('/inventory_count');
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        $outlets = $this->__listMerchantOutlets($user['merchant_id']);
        $this->set('outlets', $outlets);
    }

    public function editInventoryCount($id) {
        if (empty($id)) {
            $this->redirect('/inventory_count');
        }
        $user = $this->Auth->user();

        if ($this->request->is('')) {
            $data = $this->request->data;
            $this->set('data', $data);

            $dataSource = $this->MerchantStockTake->getDataSource();
            $dataSource->begin();

            try {
                $stock_take_id = $data['id'];
                $name = $data['name'];
                $outlet_id = $data['outlet_id'];
                $show_inactive = isset($data['show_inactive']) ? $data['show_inactive'] : '0';
                $full_count = $data['full_count'];
                $filters = $data['filters'];
                $start_date = date('Y-m-d h:i:s', strtotime($data['start_date'] . ' ' . $data['start_time']));

                $stock_take_id = $this->__saveInventoryCount($user['merchant_id'], $stock_take_id, $name,
                    $outlet_id, $show_inactive, $full_count, $filters, $start_date, 'STOCKTAKE_SCHEDULED');

                $dataSource->commit();

                if (!empty($stock_take_id)) {
                    $this->redirect('/inventory_count');
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        $stockTake = $this->MerchantStockTake->find('first', array(
            'fields' => array(
                'MerchantStockTake.*',
                'MerchantOutlet.name'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantOutlet.id = MerchantStockTake.outlet_id'
                    )
                )
            ),
            'conditions' => array(
                'MerchantStockTake.id' => $id
            )
        ));
        if (empty($stockTake) || !is_array($stockTake)) {
            $this->redirect('/inventory_count');
        }

        $data = $stockTake['MerchantStockTake'];
        $data['outlet_name'] = $stockTake['MerchantOutlet']['name'];
        $products = array();

        if (0 == $data['full_count']) {
            $filters = json_decode($data['filters'], true);
            $showInactive = $data['show_inactive'];

            foreach ($filters as $filter) {
                $joins = array();
                $conditions = array();

                if ('brands' === $filter['type']) {
                    $joins = array(
                        array(
                            'table' => 'merchant_product_brands',
                            'alias' => 'MerchantProductBrand',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantProductBrand.id = MerchantProduct.product_brand_id'
                            )
                        )
                    );

                    $conditions = array(
                        'MerchantProductBrand.id' => $filter['value']
                    );
                } elseif ('tags' === $filter['type']) {
                    $joins = array(
                        array(
                            'table' => 'merchant_product_categories',
                            'alias' => 'MerchantProductCategory',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantProductCategory.product_id = MerchantProduct.id'
                            )
                        ),
                        array(
                            'table' => 'merchant_product_tags',
                            'alias' => 'MerchantProductTag',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantProductTag.id = MerchantProductCategory.product_tag_id'
                            )
                        )
                    );

                    $conditions = array(
                        'MerchantProductTag.id' => $filter['value']
                    );
                } elseif ('types' === $filter['type']) {
                    $joins = array(
                        array(
                            'table' => 'merchant_product_types',
                            'alias' => 'MerchantProductType',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantProductType.id = MerchantProduct.product_type_id'
                            )
                        )
                    );

                    $conditions = array(
                        'MerchantProductType.id' => $filter['value']
                    );
                } elseif ('suppliers' === $filter['type']) {
                    $joins = array(
                        array(
                            'table' => 'merchant_suppliers',
                            'alias' => 'MerchantSupplier',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantSupplier.id = MerchantProduct.supplier_id'
                            )
                        )
                    );

                    $conditions = array(
                        'MerchantSupplier.id' => $value
                    );
                } elseif ('products' === $filter['type']) {
                    $conditions = array(
                        'MerchantProduct.id' => $filter['value']
                    );
                }

                $conditions = array_merge($conditions, array(
                    'MerchantProduct.track_inventory = 1',
                    'MerchantProduct.stock_type = "Standard"',
                ));

                if (0 == $showInactive) {
                    $conditions = array_merge($conditions, array(
                        'MerchantProduct.is_active = 1',
                    ));
                }

                $items = $this->MerchantProduct->find('all', array(
                    'joins' => $joins,
                    'conditions' => $conditions
                ));

                $items = Hash::map($items, "{n}", function($array) {
                    return $array['MerchantProduct'];
                });
                $products = array_merge($products, $items);
            }
        }
        $data['products'] = $products;
        $this->set('data', $data);
    }

    public function saveInventoryCount() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/inventory_count');
        }

        $user = $this->Auth->user();
        $data = $this->request->data;
        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockTake->getDataSource();
        $dataSource->begin();

        try {
            $stock_take_id = $data['id'];
            $name = $data['name'];
            $outlet_id = $data['outlet_id'];
            $show_inactive = isset($data['show_inactive']) ? $data['show_inactive'] : '0';
            $full_count = $data['full_count'];
            $filters = $data['filters'];
            $start_date = date('Y-m-d h:i:s', strtotime($data['start_date'] . ' ' . $data['start_time']));

            $stock_take_id = $this->__saveInventoryCount($user['merchant_id'], $stock_take_id, $name,
                $outlet_id, $show_inactive, $full_count, $filters, $start_date, 'STOCKTAKE_SCHEDULED');

            $dataSource->commit();

            $result['success'] = true;
            $result['id'] = $stock_take_id;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }

        $this->serialize($result);
    }

    public function startInventoryCount() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/inventory_count');
        }

        $user = $this->Auth->user();
        $data = $this->request->data;
        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockTake->getDataSource();
        $dataSource->begin();

        try {
            $stock_take_id = $data['id'];
            $name = $data['name'];
            $outlet_id = $data['outlet_id'];
            $show_inactive = isset($data['show_inactive']) ? $data['show_inactive'] : '0';
            $full_count = $data['full_count'];
            $filters = $data['filters'];
            $start_date = date('Y-m-d h:i:s', strtotime($data['start_date'] . ' ' . $data['start_time']));

            $stock_take_id = $this->__saveInventoryCount($user['merchant_id'], $stock_take_id, $name,
                $outlet_id, $show_inactive, $full_count, $filters, $start_date, 'STOCKTAKE_IN_PROGRESS_PROCESSED');

            $products_ids = array();
            foreach (json_decode($data['products']) as $id => $product) {
                $products_ids = array_merge($products_ids, array($id));
            }

            $stock_take_items = $this->__getStockTakeItems($stock_take_id, $outlet_id, $show_inactive, $full_count, $products_ids);
            $this->__saveStockTakeItems($stock_take_items);

            $dataSource->commit();

            $result['success'] = true;
            $result['id'] = $stock_take_id;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }

        $this->serialize($result);
    }

    public function searchInventoryCount() {
        $result = array(
            'success' => false
        );
        $user = $this->Auth->user();

        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            $keyword = $data['keyword'];
            $showInactive = $data['show_inactive'];

            $conditions = array();
            if (!$showInactive) {
                $conditions = array(
                    'MerchantProduct.is_active' => '1'
                );
            }

            $this->MerchantSupplier->bindModel(array(
                'hasMany' => array(
                    'MerchantProduct' => array(
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'supplier_id',
                        'conditions' => $conditions
                    )
                )
            ));

            $suppliers = $this->MerchantSupplier->find('all', array(
                'conditions' => array(
                    'MerchantSupplier.merchant_id' => $user['merchant_id'],
                    'MerchantSupplier.name LIKE' => '%' . $keyword . '%'
                )
            ));

            $suppliers = Hash::map($suppliers, "{n}", function($array) {
                $newArray = $array['MerchantSupplier'];
                $newArray['MerchantProduct'] = $array['MerchantProduct'];
                return $newArray;
            });
            $result['suppliers'] = $suppliers;

            $this->MerchantProductBrand->bindModel(array(
                'hasMany' => array(
                    'MerchantProduct' => array(
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_brand_id',
                        'conditions' => $conditions
                    )
                )
            ));

            $brands = $this->MerchantProductBrand->find('all', array(
                'conditions' => array(
                    'MerchantProductBrand.merchant_id' => $user['merchant_id'],
                    'MerchantProductBrand.name LIKE' => '%' . $keyword . '%'
                )
            ));

            $brands = Hash::map($brands, "{n}", function($array) {
                $newArray = $array['MerchantProductBrand'];
                $newArray['MerchantProduct'] = $array['MerchantProduct'];
                return $newArray;
            });
            $result['brands'] = $brands;

            $this->MerchantProductType->bindModel(array(
                'hasMany' => array(
                    'MerchantProduct' => array(
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_type_id',
                        'conditions' => $conditions
                    )
                )
            ));

            $types = $this->MerchantProductType->find('all', array(
                'conditions' => array(
                    'MerchantProductType.merchant_id' => $user['merchant_id'],
                    'MerchantProductType.name LIKE' => '%' . $keyword . '%'
                )
            ));

            $types = Hash::map($types, "{n}", function($array) {
                $newArray = $array['MerchantProductType'];
                $newArray['MerchantProduct'] = $array['MerchantProduct'];
                return $newArray;
            });
            $result['types'] = $types;

            $this->MerchantProductCategory->bindModel(array(
                'belongsTo' => array(
                    'MerchantProduct' => array(
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_id',
                        'conditions' => $conditions
                    )
                )
            ));

            $this->MerchantProductTag->bindModel(array(
                'hasMany' => array(
                    'MerchantProductCategory' => array(
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_tag_id'
                    )
                )
            ));

            $tags = $this->MerchantProductTag->find('all', array(
                'conditions' => array(
                    'MerchantProductTag.merchant_id' => $user['merchant_id'],
                    'MerchantProductTag.name LIKE' => '%' . $keyword . '%'
                ),
                'recursive' => 2
            ));

            $tags = Hash::map($tags, "{n}", function($array) {
                $newArray = $array['MerchantProductTag'];
                $newArray['MerchantProduct'] = Hash::map($array['MerchantProductCategory'], "{n}", function($array) {
                    return $array['MerchantProduct'];
                });
                return $newArray;
            });
            $result['tags'] = $tags;

            $products = $this->MerchantProduct->find('all', array(
                'conditions' => array_merge($conditions,
                    array(
                        'MerchantProduct.merchant_id' => $user['merchant_id'],
                        'MerchantProduct.track_inventory = 1',
                        'MerchantProduct.stock_type = "Standard"',
                        'OR' => array(
                            'MerchantProduct.name LIKE' => '%' . $keyword . '%',
                            'MerchantProduct.sku LIKE' => '%' . $keyword . '%'
                        )
                    )
                )
            ));

            $products = Hash::map($products, "{n}", function($array) {
                $newArray = $array['MerchantProduct'];
                return $newArray;
            });
            $result['products'] = $products;
            $result['success'] = true;
        }
        $this->serialize($result);
    }

    public function saveInventoryCount2() {
        if ( !$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/inventory_count');
        }

        $result = array(
            'success' => false
        );

        $data = $this->request->data;
        $data = $this->__saveInventoryCount2($data, 'STOCKTAKE_SCHEDULED');

        /*
        $data['MerchantStockTake']['show_inactive'] = isset($data['MerchantStockTake']['show_inactive']) ? '1' : '0';
        $data['MerchantStockTake']['merchant_id'] = $this->Auth->user()['merchant_id'];
        $data['MerchantStockTake']['type'] = 'STOCKTAKE';
        $data['MerchantStockTake']['status'] = 'STOCKTAKE_SCHEDULED';
        $data['MerchantStockTake']['start_date'] = date('Y-m-d h:i:s', strtotime($data['MerchantStockTake']['start_date'] . ' ' . $data['MerchantStockTake']['start_time']));
        if ( $data['MerchantStockTake']['full_count'] == '0' && isset($data['MerchantStockTakeItem']) ) {
            $data['MerchantStockTake']['filters'] = json_encode($data['MerchantStockTakeItem']);
        }
         */

        $this->loadModel('MerchantStockTake');
        $dataSource = $this->MerchantStockTake->getDataSource();
        $dataSource->begin();

        try {
            if ( isset($data['MerchantStockTake']['id']) ) {
                $this->MerchantStockTake->id = $data['MerchantStockTake']['id'];
            } else {
                $this->MerchantStockTake->create();
            }
            $this->MerchantStockTake->save($data);

            //$take_id = $this->MerchantStockTake->id;

            // check 'full count'
            /*
            if ( $data['MerchantStockTake']['full_count'] == '1' ) {
                $products = $this->__fullCount($data['MerchantStockTake']['outlet_id'], $data['MerchantStockTake']['show_inactive']);
                $items = array();
                foreach ($products as $p) {
                    $items[]['MerchantStockTakeItem'] = array(
                        'stock_take_id'         => $take_id,
                        'product_id'            => $p['MerchantProduct']['id'],
                        'name'                  => $p['MerchantProduct']['name'],
                        'sku'                   => $p['MerchantProduct']['sku'],
                        'expected'              => $p['MerchantProductInventory']['count'],
                        'counted'               => '0',
                        'supply_price'          => $p['MerchantProduct']['supply_price'],
                        'total_cost'            => '0.00000',
                        'price_include_tax'     => $p['MerchantProduct']['price_include_tax'],
                        'total_price_incl_tax'  => '0.00000'
                    );
                }

                // save stock take items...
                $this->MerchantStockTakeItem->saveMany($items);
            } else {

            }
             */


            $dataSource->commit();

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }

        $this->serialize($result);
    }

    public function startInventoryCount2() {
        if ( !$this->request->is('ajax') || !$this->request->is('post') ) {
            $this->redirect('/inventory_count');
        }

        $result = array(
            'success' => false
        );

        $user = $this->Auth->user();

        $dataSource = $this->MerchantStockTake->getDataSource();
        $dataSource->begin();

        try {
            $data = $this->request->data;
            $data = $this->__saveInventoryCount2($data, 'STOCKTAKE_IN_PROGRESS_PROCESSED');

            if ( isset($data['MerchantStockTake']['id']) ) {
                $this->MerchantStockTake->id = $data['MerchantStockTake']['id'];
            } else {
                $this->MerchantStockTake->create();
            }
            $this->MerchantStockTake->save($data);

            if (!isset($data['MerchantStockTake']['id']) || empty($data['MerchantStockTake']['id'])) {
                $data['MerchantStockTake']['id'] = $this->MerchantStockTake->id;
            }

            $items = $this->__saveStockTakeItems2($data['MerchantStockTake']);
            $this->MerchantStockTakeItem->saveMany($items);

            $dataSource->commit();

            $result['success'] = true;
            $result['id'] = $data['MerchantStockTake']['id'];
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }

        $this->serialize($result);
    }

    public function viewInventoryCount($id) {
        $this->loadModel('MerchantStockTake');

        $stockTake = $this->MerchantStockTake->findById($id);

        /*
        $this->MerchantStockTake->bindModel(array(
            'belongsTo' => array(
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                )
            ),
            'hasMany' => array(
                'MerchantStockTakeItem' => array(
                    'className' => 'MerchantStockTakeItem',
                    'foreignKey' => 'stock_take_id'
                ),
                'MerchantStockTakeCount' => array(
                    'className' => 'MerchantStockTakeCount',
                    'foreignKey' => 'stock_take_id'
                )
            )
        ));

        $this->loadModel('MerchantStockTakeItem');
        $this->MerchantStockTakeItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->loadModel('MerchantStockTakeCount');
        $this->MerchantStockTakeCount->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->loadModel('MerchantProduct');
        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id',
                    'conditions' => array(
                        'MerchantProductInventory.outlet_id' => $stockTake['MerchantStockTake']['outlet_id']
                    )
                )
            )
        ));

        $take = $this->MerchantStockTake->find('first', array(
            'recursive' => 3,
            'conditions' => array(
                'MerchantStockTake.id' => $id
            )
        ));
         */

        $take = $this->__stockTake($stockTake['MerchantStockTake']['id'], $stockTake['MerchantStockTake']['outlet_id']);
        $this->set('take', $take);

        // get the list of products
        /*
        $products = $this->MerchantProduct->find('all', array(
            'fields' => array('MerchantProduct.*', 'MerchantProductInventory.*'),
            'joins' => array(
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'MerchantProduct.id = MerchantProductInventory.product_id',
                        'MerchantProductInventory.outlet_id' => $take['MerchantStockTake']['outlet_id']
                    )
                )
            ),
            'conditions' => array(
                'MerchantProduct.merchant_id' => $take['MerchantStockTake']['merchant_id']
            )
        ));
         */
        $products = $this->__merchantProducts($this->Auth->user()['merchant_id'], $stockTake['MerchantStockTake']['outlet_id']);
        $this->set('products', $products);
    }

    public function performInventoryCount($id) {
        $user = $this->Auth->user();

        $stockTake = $this->MerchantStockTake->find('first', array(
            'fields' => array(
                'MerchantStockTake.*',
                'MerchantOutlet.*'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'foreignKey' => 'outlet_id'
                )
            ),
            'conditions' => array(
                'MerchantStockTake.id' => $id
            )
        ));

        /*
        $stockTakeItems = $this->MerchantStockTakeItem->find('all', array(
            'fields' => array(
                'MerchantStockTakeItem.*',
                'MerchantProductInventory.*'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProductInventory.product_id = MerchantStockTakeItem.product_id',
                        'MerchantProductInventory.outlet_id' => $stockTake['MerchantStockTake']['outlet_id']
                    )
                )
            ),
            'conditions' => array(
                'MerchantStockTakeItem.stock_take_id' => $id
            )
        ));

        //call the noop function callback on every element of $data
        $stockTakeItems = Hash::map($stockTakeItems, "{n}", function($array) {
            $newArray = $array['MerchantStockTakeItem'];
            $newArray['MerchantProductInventory'] = $array['MerchantProductInventory'];
            return $newArray;
        });
        $stockTake['MerchantStockTakeItem'] = $stockTakeItems;
        */

        $this->set('stockTake', $stockTake);

        /*
        $this->loadModel('MerchantProduct');
        $this->loadModel('MerchantProductInventory');
        $this->loadModel('MerchantStockTake');
        $this->loadModel('MerchantStockTakeItem');

        $this->MerchantStockTake->bindModel(array(
            'belongsTo' => array(
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                )
            ),
            'hasMany' => array(
                'MerchantStockTakeItem' => array(
                    'className' => 'MerchantStockTakeItem',
                    'foreignKey' => 'stock_take_id'
                )
            )
        ));

        $this->MerchantStockTakeItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id',
                    'conditions' => array(
                        'MerchantProductInventory.outlet_id' => $user['outlet_id']
                    )
                )
            )
        ));

        $take = $this->MerchantStockTake->find('first', array(
            'conditions' => array(
                'MerchantStockTake.id' => $id
            ),
            'recursive' => 3
        ));
        $this->set('take', $take);
        */
    }

    public function reviewInventoryCount() {
    }

    public function getStockTakeItems($id) {
        $result = array(
            'success' => false
        );
        $user = $this->Auth->user();

        if ($this->request->is('ajax')) {
            try {
                $stockTake = $this->MerchantStockTake->find('first', array(
                    'fields' => array(
                        'MerchantStockTake.*',
                        'MerchantOutlet.*'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'merchant_outlets',
                            'alias' => 'MerchantOutlet',
                            'type' => 'INNER',
                            'foreignKey' => 'outlet_id'
                        )
                    ),
                    'conditions' => array(
                        'MerchantStockTake.id' => $id
                    )
                ));

                $stockTakeItems = $this->MerchantStockTakeItem->find('all', array(
                    'fields' => array(
                        'MerchantStockTakeItem.*',
                        'MerchantProductInventory.*'
                    ),
                    'joins' => array(
                        array(
                            'table' => 'merchant_product_inventories',
                            'alias' => 'MerchantProductInventory',
                            'type' => 'INNER',
                            'conditions' => array(
                                'MerchantProductInventory.product_id = MerchantStockTakeItem.product_id',
                                'MerchantProductInventory.outlet_id' => $stockTake['MerchantStockTake']['outlet_id']
                            )
                        )
                    ),
                    'conditions' => array(
                        'MerchantStockTakeItem.stock_take_id' => $id
                    )
                ));

                //call the noop function callback on every element of $data
                $stockTakeItems = Hash::map($stockTakeItems, "{n}", function($array) {
                    $newArray = $array['MerchantStockTakeItem'];
                    $newArray['MerchantProductInventory'] = $array['MerchantProductInventory'];
                    return $newArray;
                });

                $result['items'] = $stockTakeItems;
                $result['success'] = true;
            } catch (Exception $e) {
                $result['message'] = $e.getMessage();
            }
        }
        $this->serialize($result);
    }

/*
    public function merchantProducts() {
        if ( !$this->request->is('ajax') ) {
            $this->redirect('/stock');
        }

        $search_str = $_GET['search_str'];

        $this->loadModel('MerchantProduct');
        $products = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $this->Auth->user()['merchant_id'],
                'MerchantProduct.name LIKE' => "%$search_str%"
            )
        ));

        $this->serialize($products);
    }
*/

    public function test() {
        /*
        $this->MerchantStockOrder->bindModel(array(
            'hasMany' => array(
                'MerchantStockOrderItem' => array(
                    'className' => 'MerchantStockOrderItem',
                    'foreignKey' => 'order_id',
                    'conditions' => array(
                        'MerchantStockOrderItem.name' => 'jase'
                    )
                )
            )
        ));

        $orders = $this->MerchantStockOrder->find('all', array(
        ));
         */

        /*
        $orders = $this->MerchantStockOrder->find('all', array(
            'joins' => array(
                array(
                    'table' => 'merchant_stock_order_items',
                    'alias' => 'MerchantStockOrderItem',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantStockOrderItem.order_id = MerchantStockOrder.id',
                        'MerchantStockOrderItem.name' => 'jase'
                    )
                )
            )
        ));
         */


/*
$result = $this->Project->find('all', array(
    'conditions'=>array(
        'Project.id'=>implode(",", $projectTimeArray)
    ),
    'joins'=>array(
        array(
            'table'=>'project_times',
            'alias'=>'ProjectTime',
            'type'=>'INNER',
            'conditions'=>array(
                'ProjectTime.project_id = Project.id',
                'ProjectTime.user_id'=>$this->Auth->user('id'),
                'ProjectTime.date_entry >='=>$firstDay
                'ProjectTime.date_entry <=' => $lastDay
            ),
            'order'=>array('ProjectTime.date_entry'=>'ASC'),
            'group'=>array('ProjectTime.date_entry')
        )
    )
));
*/

        /*
        $orders = $this->MerchantStockOrder->find('all', array(
            'fields' => array('MerchantStockOrder.name', 'COUNT(MerchantStockOrderItem.*) AS items'),
            //'fields' => array('MerchantStockOrder.*', 'MerchantStockOrderItem.*'),
            'joins' => array(
                array(
                    'table' => 'merchant_stock_order_items',
                    'alias' => 'MerchantStockOrderItem',
                    'type' => 'INNER',
                    'group' => 'MerchantStockorderItem.order_id'
                )
            ),
            'conditions' => array(
                'MerchantStockOrder.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
         */
        /*
        $orders = $this->MerchantStockOrder->query("
            SELECT
                MerchantStockOrder.id,
                MerchantStockOrder.name,
                MerchantStockOrder.type,
                MerchantStockOrder.status,
                count(*) as items
            FROM
                merchant_stock_orders AS MerchantStockOrder
                LEFT JOIN merchant_stock_order_items AS MerchantStockOrderItem
                    ON (MerchantStockOrderItem.order_id = MerchantStockOrder.id)
            WHERE
                MerchantStockOrder.merchant_id = '" . $this->Auth->user()['merchant_id'] . "'
            GROUP BY MerchantStockOrder.id
        ");
         */

        $orders = $this->MerchantStockOrder->find('all', array(
            'fields' => array('MerchantStockOrder.*', 'COUNT(*) AS count'),
            'joins' => array(
                array(
                    'table' => 'merchant_stock_order_items',
                    'alias' => 'MerchantStockOrderItem',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantStockOrderItem.order_id = MerchantStockOrder.id'
                    )
                )
            ),
            'conditions' => array(
                'MerchantStockOrder.merchant_id' => $this->Auth->user()['merchant_id']
            ),
            'group' => 'MerchantStockOrder.id'
        ));
        debug($orders);

        /*
        $items = $this->MerchantStockOrderItem->find('all', array(
            'fields' => array('MerchantStockorderItem.order_id', 'COUNT(*) AS count'),
            'group' => 'MerchantStockOrderItem.order_id'
        ));
        debug($items);
         */

        exit;
    }

    /**
     * get the selected stock take order
     *
     * @param string stock take id
     * @param string outlet id
     * @return array the stock take
     */
    private function __stockTake($take_id, $outlet_id) {
        $this->loadModel('MerchantStockTake');
        $this->MerchantStockTake->bindModel(array(
            'belongsTo' => array(
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                )
            ),
            'hasMany' => array(
                'MerchantStockTakeItem' => array(
                    'className' => 'MerchantStockTakeItem',
                    'foreignKey' => 'stock_take_id'
                ),
                'MerchantStockTakeCount' => array(
                    'className' => 'MerchantStockTakeCount',
                    'foreignKey' => 'stock_take_id'
                )
            )
        ));

        $this->loadModel('MerchantStockTakeItem');
        $this->MerchantStockTakeItem->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->loadModel('MerchantStockTakeCount');
        $this->MerchantStockTakeCount->findModel(array(
            'belongsTo' => array(
                'className' => 'MerchantProduct',
                'foreignKey' => 'product_id'
            )
        ));

        $this->loadModel('MerchantProduct');
        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id',
                    'conditions' => array(
                        'MerchantProductInventory.outlet_id' => $outlet_id
                    )
                )
            )
        ));

        $take = $this->MerchantStockTake->find('first', array(
            'recursive' => 3,
            'conditions' => array(
                'MerchantStockTake.id' => $take_id
            )
        ));

        return $take;
    }

    /**
     * save order items 
     *
     * @param array request form data
     * @param string mode (send | receive)
     * @return array the items formatted for 'saveMany'
     */
    private function __saveItems($data, $mode) {
        if ( !$data ) {
            return $data;
        }

        // total_cost, total_price_incl_tax
        foreach ($data as $i => $d) {
            $count = ($mode == 'send') ? $d['count'] : $d['received'];
            $total_cost = round($count * $d['supply_price'], 2);
            $data[$i]['total_cost'] = $total_cost;
            $data[$i]['total_price_incl_tax'] = round($count * $d['price_include_tax'], 2);
        }

        $items = array();
        foreach ($data as $d) {
            $items[]['MerchantStockOrderItem'] = $d;
        }

        return $items;
    }

    /**
     * increase or decrease inventory count
     *
     * @param string merchant id
     * @param string outlet id
     * @param array the items
     * @param char '+' | '-'
     * @return array the inventory
     */
    private function __inventory($merchant_id, $outlet_id, $data, $operand) {
        $inventory = array();

        $this->loadModel('MerchantProduct');
        foreach ($data as $d) {
            $product = $this->MerchantProduct->find('first', array(
                'fields' => array('MerchantProduct.*', 'MerchantProductInventory.*'),
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
                    'MerchantProduct.merchant_id' => $merchant_id,
                    'MerchantProduct.id' => $d['MerchantStockOrderItem']['product_id']
                )
            ));

            if ( $product['MerchantProduct']['track_inventory'] == '1' ) {
                if ( $operand == '+' ) {
                    $product['MerchantProductInventory']['count'] += $d['MerchantStockOrderItem']['received'];
                } else if ( $operand == '-' ) {
                    $product['MerchantProductInventory']['count'] -= $d['MerchantStockOrderItem']['count'];
                }
                $inventory[]['MerchantProductInventory'] = $product['MerchantProductInventory'];
            }
        }

        return $inventory;
    }

    private function __extractFilters($data, $merchant_id) {
        $this->loadModel('MerchantProduct');

        $extracted = json_decode($data, true);

        $items = array();
        foreach ($extracted as $item) {
            $product = $this->MerchantProduct->findById($item['id']);
            $items[] = array(
                'id' => $product['MerchantProduct']['id'],
                'name' => $product['MerchantProduct']['name'],
                'sku' => $product['MerchantProduct']['sku']
            );
        }

        return $items;
    }

    private function __saveInventoryCount($merchant_id, $stock_take_id, $name, $outlet_id, $show_inactive, $full_count, $filters, $start_date, $status) {
        $stock_take = array();
        $stock_take['merchant_id'] = $merchant_id;
        $stock_take['name'] = $name;
        $stock_take['type'] = 'STOCKTAKE';
        $stock_take['outlet_id'] = $outlet_id;
        $stock_take['show_inactive'] = empty($show_inactive) ? 0 : $show_inactive;
        $stock_take['full_count'] = empty($full_count) ? 0 : $full_count;
        $stock_take['filters'] = $filters;
        $stock_take['start_date'] = $start_date;
        $stock_take['status'] = $status;

        if (empty($stock_take_id)) {
            $this->MerchantStockTake->create();
        } else {
            $this->MerchantStockTake->id = $stock_take_id;
        }
        $this->MerchantStockTake->save(array('MerchantStockTake' => $stock_take));

        return $this->MerchantStockTake->id;
    }

    private function __getStockTakeItems($stock_take_id, $outlet_id, $show_inactive, $full_count, $product_ids) {
        $conditions = array(
        );

        if ($show_inactive == '0') {
            $conditions = array_merge($conditions, array(
                'MerchantProduct.is_active' => '1'
            ));
        }

        if ($full_count == '0') {
            $conditions = array_merge($conditions, array(
                'MerchantProduct.id' => $product_ids
            ));
        }

        $list = $this->MerchantProduct->find('all', array(
            'fields' => array(
                'MerchantProduct.*',
                'MerchantProductInventory.*'
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProductInventory.outlet_id' => $outlet_id,
                        'MerchantProductInventory.product_id = MerchantProduct.id'
                    )
                )
            ),
            'conditions' => $conditions
        ));

        $result = array();
        foreach ($list as $item) {
            $result = array_merge($result, array(
                array(
                    'stock_take_id' => $stock_take_id,
                    'product_id' => $item['MerchantProduct']['id'],
                    'name' => $item['MerchantProduct']['name'],
                    'sku' => $item['MerchantProduct']['sku'],
                    'expected' => $item['MerchantProductInventory']['count'],
                    'supply_price' => $item['MerchantProduct']['supply_price'],
                    'price_include_tax' => $item['MerchantProduct']['price_include_tax'],
                )
            ));
        }
        return $result;
    }

    private function __saveStockTakeItems($stock_take_items) {
        foreach ($stock_take_items as $item) {
            if (!isset($item['id']) || empty($item['id'])) {
                $this->MerchantStockTakeItem->create();
            } else {
                $this->MerchantStockTakeItem->id = $item['id'];
            }
            $this->MerchantStockTakeItem->save(array('MerchantStockTakeItem' => $item));
            $item['id'] = $this->MerchantStockTakeItem->id;
        }
    }

    private function __saveInventoryCount1($stock_take_id, $name, $outlet_id, $show_inactive, $full_count, $filters, $start_date, $status) {
        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockTake->getDataSource();
        $dataSource->begin();

        try {
            $stock_take = array();
            $stock_take['merchant_id'] = $this->Auth->user()['merchant_id'];
            $stock_take['name'] = $name;
            $stock_take['type'] = 'STOCKTAKE';
            $stock_take['outlet_id'] = $outlet_id;
            $stock_take['show_inactive'] = empty($show_inactive) ? 0 : $show_inactive;
            $stock_take['full_count'] = empty($full_count) ? 0 : $full_count;
            $stock_take['filters'] = $filters;
            $stock_take['start_date'] = $start_date;
            $stock_take['status'] = $status;

            if (empty($stock_take_id)) {
                $this->MerchantStockTake->create();
                $stock_take_id = $this->MerchantStockTake->id;
            } else {
                $this->MerchantStockTake->id = $stock_take_id;
            }
            $this->MerchantStockTake->save(array('MerchantStockTake' => $stock_take));

            $dataSource->commit();

            $result['success'] = true;
            $result['id'] = $stock_take_id;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }
        
        return $result;
    }

    private function __saveInventoryCount2($data, $status) {
        $data['MerchantStockTake']['show_inactive'] = isset($data['MerchantStockTake']['show_inactive']) ? '1' : '0';
        $data['MerchantStockTake']['merchant_id'] = $this->Auth->user()['merchant_id'];
        $data['MerchantStockTake']['type'] = 'STOCKTAKE';
        $data['MerchantStockTake']['status'] = $status;
        $data['MerchantStockTake']['start_date'] = date('Y-m-d h:i:s', strtotime($data['MerchantStockTake']['start_date'] . ' ' . $data['MerchantStockTake']['start_time']));
        if ( $data['MerchantStockTake']['full_count'] == '0' && isset($data['MerchantStockTakeItem']) ) {
            $data['MerchantStockTake']['filters'] = json_encode($data['MerchantStockTakeItem']);
        } else {
            $data['MerchantStockTake']['filters'] = 'jase';
        }

        return $data;
    }

    private function __saveStockTakeItems2($stockTake) {
        $items = array();

        if ( $stockTake['full_count'] == '1' ) {
            $products = $this->__fullCount($stockTake['outlet_id'], $stockTake['show_inactive']);
            foreach ($products as $p) {
                $items[]['MerchantStockTakeItem'] = array(
                    'stock_take_id'         => $stockTake['id'],
                    'product_id'            => $p['MerchantProduct']['id'],
                    'name'                  => $p['MerchantProduct']['name'],
                    'sku'                   => $p['MerchantProduct']['sku'],
                    'expected'              => $p['MerchantProductInventory']['count'],
                    'counted'               => '0',
                    'supply_price'          => $p['MerchantProduct']['supply_price'],
                    'total_cost'            => '0.00000',
                    'price_include_tax'     => $p['MerchantProduct']['price_include_tax'],
                    'total_price_incl_tax'  => '0.00000'
                );
            }
        } else {
            $extracted = json_decode($stockTake['filters'], true);

            $this->loadModel('MerchantProduct');
            $this->MerchantProduct->bindModel(array(
                'hasMany' => array(
                    'MerchantProductInventory' => array(
                        'className' => 'MerchantProductInventory',
                        'foreignKey' => 'product_id',
                        'conditions' => array(
                            'MerchantProductInventory.outlet_id' => $stockTake['outlet_id']
                        )
                    )
                )
            ));

            foreach ($extracted as $item) {
                $product = $this->MerchantProduct->findById($item['id']);
                $items[]['MerchantStockTakeItem'] = array(
                    'stock_take_id'         => $stockTake['outlet_id']['id'],
                    'product_id'            => $product['MerchantProduct']['id'],
                    'name'                  => $product['MerchantProduct']['name'],
                    'sku'                   => $product['MerchantProduct']['sku'],
                    'expected'              => isset($product['MerchantProductInventory'][0]['count']) ? $product['MerchantProductInventory'][0]['count'] : '0',
                    'counted'               => '0',
                    'supply_price'          => $product['MerchantProduct']['supply_price'],
                    'total_cost'            => '0.00000',
                    'price_include_tax'     => $product['MerchantProduct']['price_include_tax'],
                    'total_price_incl_tax'  => '0.00000'
                );
            }
        }

        return $items;
    }

}
