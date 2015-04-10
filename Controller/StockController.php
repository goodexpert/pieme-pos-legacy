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
        'MerchantStockOrder',
        'MerchantStockOrderItem',
        'MerchantStockTake',
        'MerchantStockTakeItem',
        'MerchantOutlet',
        'MerchantSupplier',
        'OrderStatus'
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
     * list of the merchant stock orders.
     *
     * @return void
     */
    public function index() {
        $user = $this->Auth->user();
        $conditions = array(
            'MerchantStockOrder.merchant_id' => $user['merchant_id']
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
                'type' => 'INNER',
                'conditions' => array(
                    'MerchantStockOrderItem.order_id = MerchantStockOrder.id'
                )
            )
        );

        $status = $this->get('status');
        if (empty($status)) {
            $status = 'ALL';
        } elseif ($status !== 'ALL') {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.status' => $status
            ));
        }
        $this->set('status', $status);

        $name = $this->get('name');
        if (!empty($name)) {
            $joins = array_merge($joins, array(
                array(
                    'table' => 'merchant_products',
                    'alias' => 'MerchantProduct',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProduct.id = MerchantStockOrderItem.product_id',
                        'MerchantProduct.name LIKE' => '%' . $name . '%'
                    )
                )
            ));
        }
        $this->set('name', $name);

        $date_from = $this->get('date_from');
        if (!empty($date_from)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.date) >=' => $date_from
            ));
        }
        $this->set('date_from', $date_from);

        $date_to = $this->get('date_to');
        if (!empty($date_to)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.date) >=' => $date_to
            ));
        }
        $this->set('date_to', $date_to);

        $due_date_from = $this->get('due_date_from');
        if (!empty($due_date_from)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.due_date) >=' => $due_date_from
            ));
        }
        $this->set('due_date_from', $due_date_from);

        $due_date_to = $this->get('date_to');
        if (!empty($due_date_to)) {
            $conditions = array_merge($conditions, array(
                'DATE(MerchantStockOrder.due_date) >=' => $due_date_to
            ));
        }
        $this->set('due_date_to', $due_date_to);

        $supplier_invoice = $this->get('supplier_invoice');
        if (!empty($supplier_invoice)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.supplier_invoice' => $supplier_invoice
            ));
        }
        $this->set('supplier_invoice', $supplier_invoice);

        $outlet_id = $this->get('outlet_id');
        if (!empty($outlet_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.outlet_id' => $outlet_id
            ));
        }
        $this->set('outlet_id', $outlet_id);

        $supplier_id = $this->get('supplier_id');
        if (!empty($supplier_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockOrder.supplier_id' => $supplier_id
            ));
        }
        $this->set('supplier_id', $supplier_id);

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
                'COUNT(*) AS items',
                'MerchantStockOrder.status'
            ),
            'conditions' => $conditions,
            'joins' => $joins,
            'group' => 'MerchantStockOrder.id',
            'order' => array(
                'MerchantStockOrder.created' => 'DESC'
            )
        ));
        $this->set('orders', $orders);

        $outlets = $this->MerchantOutlet->find('list', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets', $outlets);

        $suppliers = $this->MerchantSupplier->find('list', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('suppliers', $suppliers);
    }

    /**
     * save the merchant stock order and items into 'merchant_stock_order' table and
     * 'merchant_stock_order_items' 
     * log to the 'merchant_product_logs' table when the order sent or received ...
     */
    public function newOrder() {
        // get the list of merchant suppliers
        $suppliers = $this->__listMerchantSuppliers($this->Auth->user()['merchant_id']);
        $this->set('suppliers', $suppliers);

        // get the list of merchant outlets
        $outlets = $this->__listMerchantOutlets($this->Auth->user()['merchant_id']);
        $this->set('outlets', $outlets);
    

        // save the form data when submitted...
        if($this->request->is('post')) {
            $data = $this->request->data;

            // check 'supplier_id'
            // if the id is empty, unset it
            if ( $data['MerchantStockOrder']['supplier_id'] == '' ) {
                unset($data['MerchantStockOrder']['supplier_id']);
            }

            $data['MerchantStockOrder']['merchant_id'] = $this->Auth->user()['merchant_id'];
            //$data['MerchantStockOrder']['source_outlet_id'] = ''; // set null 
            $data['MerchantStockOrder']['type'] = 'SUPPLIER'; // ???
            $data['MerchantStockOrder']['status'] = 'OPEN'; // first time is 'OPEN'
            $data['MerchantStockOrder']['date'] = date('Y-m-d h:i:s');  // current time

            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                // create a merchant stock order
                $this->MerchantStockOrder->create();
                $this->MerchantStockOrder->save($data);

                $order_id = $this->MerchantStockOrder->id;
     
                // check 'auto_fill'
                if ( !is_null($data['order-auto']) && $data['order-auto'] == '1' ) {
                    $autoFillProducts = $this->__autoFillProducts($data['MerchantStockOrder']['outlet_id']);
                    $items = array();
                    foreach ($autoFillProducts as $p) {
                        $items[]['MerchantStockOrderItem'] = array(
                            'order_id'              => $order_id,
                            'product_id'            => $p['MerchantProduct']['id'],
                            'name'                  => $p['MerchantProduct']['name'],
                            'count'                 => '0',
                            'supply_price'          => $p['MerchantProduct']['supply_price'],
                            'total_cost'            => '0.00000',
                            'price_include_tax'     => $p['MerchantProduct']['price_include_tax'],
                            'total_price_incl_tax'  => '0.00000'
                        );
                    }
                    
                    // save order items ... 
                    if ( $items ) {
                        $this->MerchantStockOrderItem->saveMany($items);
                    }
                }               

                $dataSource->commit();

                // redirect to edit
                $this->redirect('/stock/edit/' . $order_id);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }
    
    }

    public function newTransfer() {
        // get the list of merchant outlets
        $outlets = $this->__listMerchantOutlets($this->Auth->user()['merchant_id']);
        $this->set('outlets', $outlets);

        // save the form data when sumitted ...
        if ( $this->request->is('post') ) {
            $data = $this->request->data;

            $data['MerchantStockOrder']['merchant_id'] = $this->Auth->user()['merchant_id'];
            $data['MerchantStockOrder']['type'] = 'OUTLET';
            $data['MerchantStockOrder']['status'] = 'OPEN';
            $data['MerchantStockOrder']['date'] = date('Y-m-d h:i:s');

            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                // create a merchant stock order
                $this->MerchantStockOrder->create();
                $this->MerchantStockOrder->save($data);

                $order_id = $this->MerchantStockOrder->id;
                
                // check 'auto_fill'
                if ( !is_null($data['order-auto']) && $data['order-auto'] == '1' ) {
                    $autoFillProducts = $this->__autoFillProducts($data['MerchantStockOrder']['outlet_id']);
                    $items = array();
                    foreach ($autoFillProducts as $p) {
                        $items[]['MerchantStockOrderItem'] = array(
                            'order_id'              => $order_id,
                            'product_id'            => $p['MerchantProduct']['id'],
                            'name'                  => $p['MerchantProduct']['name'],
                            'count'                 => '0',
                            'supply_price'          => $p['MerchantProduct']['supply_price'],
                            'total_cost'            => '0.00000',
                            'price_include_tax'     => $p['MerchantProduct']['price_include_tax'],
                            'total_price_incl_tax'  => '0.00000'
                        );
                    }
                    
                    // save order items ... 
                    if ( $items ) {
                        $this->MerchantStockOrderItem->saveMany($items);
                    }
                } 
                $dataSource->commit();

                // redirect to edit
                $this->redirect('/stock/edit/' . $order_id);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        
        }
    }

    /**
     * edit a merchant stock order & merchant stock order item
     *
     * @param string merchant stock order id
     */
    public function edit($id) {
        // update form data ...
        if ( $this->request->is('post') ) {
            $data = $this->request->data['MerchantStockOrderItem'];
            debug($data); exit;

            // for total_cost, total_price_incl_tax
            foreach ($data as $i => &$d) {
                $total_cost = round($d['count'] * $d['supply_price'], 2);
                $data[$i]['total_cost'] = $total_cost;
                $data[$i]['total_price_incl_tax'] = round($d['count'] * $d['price_include_tax'], 2);
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

        $stockOrder = $this->MerchantStockOrder->findById($id);

        $order = $this->__stockOrder($id, $stockOrder['MerchantStockOrder']['outlet_id']);
        $this->set('order', $order);

        // get the list of products
        $products = $this->__merchantProducts($this->Auth->user()['merchant_id'], $stockOrder['MerchantStockOrder']['outlet_id']);
        $this->set('products', $products);

        if ( !$this->request->data ) {
            $this->request->data = $order;
        }
    }

    public function saveItems() {
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

            $mode = ($order['MerchantStockOrder']['status'] == 'OPEN') ? 'send' : 'receive';
            $items = $this->__saveItems($data, $mode);

            if ( $items ) {
                $dataSource = $this->MerchantStockOrderItem->getDataSource();
                $dataSource->begin();

                $this->MerchantStockOrderItem->saveMany($items);

                $dataSource->commit();
            }

            $result['success'] = true;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
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

    private function __autoFillProducts($outlet_id) {
        $this->loadModel('MerchantProductInventory');

        $this->MerchantProductInventory->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id',
                    'conditions' => array(
                        'MerchantProduct.is_active' => '1'
                    )
                )
            )
        ));

        $inventories = $this->MerchantProductInventory->find('all', array(
            'conditions' => array(
                'MerchantProductInventory.outlet_id' => $outlet_id,
                'AND' => array(
                    'MerchantProductInventory.reorder_point IS NOT NULL',
                    'MerchantProductInventory.reorder_point != 0'
                )
            )
        ));

        return $inventories;
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
     *  edit a existing stock order
     *
     *  @param string merchant stock order id
     */
    public function editDetails($id) {
        // TODO: need to handle exception when id is null or id is not exists ...
        //
        
        // get the merchant stock order
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
        ));
    
        $merchantStockOrder = $this->MerchantStockOrder->find('first', array(
            'conditions' => array(
                'MerchantStockOrder.id' => $id
            )
        ));

        $this->loadModel('MerchantOutlet');
        $outlets = $this->MerchantOutlet->find('all');
        $this->set('outlets', $outlets);

    
        // update the form data when submitted ...
        if ( $this->request->is('post') ) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockOrder->getDataSource();
            $dataSource->begin();

            try {
                // update the merchant stock order
                $this->MerchantStockOrder->id = $id;
                $this->MerchantStockOrder->save($data);

                $dataSource->commit();

                // redirect to edit
                $this->redirect('/stock/edit/' . $id);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        if ( !$this->request->data ) {
            $this->request->data = $merchantStockOrder;
        }
    }

    /**
     * view a merchant stock order
     *
     * @param string merchant stock order id
     */
    public function view($id) {
        // get the merchant stock order
        $stockOrder = $this->MerchantStockOrder->findById($id);

        $order = $this->__stockOrder($id, $stockOrder['MerchantStockOrder']['outlet_id']);
        $this->set('order', $order);

        /*
        $this->loadModel('MerchantOutlet');
        $this->MerchantOutlet->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'outlet_id'
                )
            )
        ));

        $outlets = $this->MerchantOutlet->find('first', array(
            'recursive' => 3,
            'conditions' => array(
                'MerchantOutlet.id' => $merchantStockOrder['MerchantStockOrder']['outlet_id']
            )
        ));
        debug($outlets);
         */
    }

    public function export() {
    }

    public function import() {
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
     * 1) update the merchant order status to 'SENT' &
     * 2) log into 'merchant_product_logs'
     *
     * @param string merchant stock id
     */
    public function markSent($id) {
        $dataSource = $this->MerchantStockOrder->getDataSource();
        $dataSource->begin();

        try {
            // 1)
            $this->loadModel('MerchantStockOrder');
            $data['MerchantStockOrder']['status'] = 'SENT';
            $this->MerchantStockOrder->id = $id;
            $this->MerchantStockOrder->save($data);

            // 2)
            $logs = $this->__makeProductLogs($id, 'order_placed');

            $this->loadModel('MerchantProductLog');

            if ( $logs ) {
                $this->MerchantProductLog->create();
                $this->MerchantProductLog->saveMany($logs);
            }

            $dataSource->commit();

            // redirect to view
            $this->redirect('/stock/view/' . $id);
        } catch (Exception $e) {
            $dataSource->rollback();
            $this->Session->setFlash($e->getMessage());
        }
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
                'refer_url'         => '/stock/view/' . $order['MerchantStockOrder']['id']
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

    public function receive($id) {
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

        $stockOrder = $this->MerchantStockOrder->findById($id);

        $order = $this->__stockOrder($id, $stockOrder['MerchantStockOrder']['outlet_id']);
        $this->set('order', $order);

        // get the list of products
        $products = $this->__merchantProducts($this->Auth->user()['merchant_id'], $stockOrder['MerchantStockOrder']['outlet_id']);
        $this->set('products', $products);

        if ( !$this->request->data ) {
            $this->request->data = $order;
        }

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
        /*
        debug($inventoryCounts);

        // get the list 
        $this->loadModel('MerchantStockTake');
        $this->MerchantStockTake->bindModel(array(
            'belongsTo' => array(
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                )
            )
        ));

        $takes = $this->MerchantStockTake->find('all', array(
            'conditions' => array(
                'MerchantStockTake.type' => 'STOCKTAKE'
            )
        ));

        $inventoryCounts = array();
        foreach ($takes as $take) {
            $count = array(
                'id' => $take['MerchantStockTake']['id'],
                'name' => $take['MerchantStockTake']['name'],
                'status' => $take['MerchantStockTake']['status'],
                'outlet' => $take['MerchantOutlet']['name'],
                'count' => ($take['MerchantStockTake']['full_count'] == '1') ? 'Full' : 'Partial',
            );

            if ( $take['MerchantStockTake']['status'] == 'STOCKTAKE_SCHEDULED' || $take['MerchantStockTake']['status'] == 'STOCKTAKE_IN_PROGRESS_PROCESSED' ) {
                $inventoryCounts['Due'][] = $count;
            } elseif ( $take['MerchantStockTake']['status'] == 'STOCKTAKE_COMPLETE' ) {
                $inventoryCounts['Completed'][] = $count;
            } elseif ( $take['MerchantStockTake']['status'] == 'STOCKTAKE_CANCELLED' ) {
                $inventoryCounts['Cancelled'][] = $count;
            }
        }
        $this->set('inventoryCounts', $inventoryCounts);

        $this->set('takes', $takes);
        */
    }

    public function newInventoryCount() { 
        // create a merchant stock order
        if ( $this->request->is('post') ) {
            $data = $this->request->data;

            $data['MerchantStockTake']['show_inactive'] = isset($data['MerchantStockTake']['show_inactive']) ? '1' : '0';
            $data['MerchantStockTake']['merchant_id'] = $this->Auth->user()['merchant_id'];
            $data['MerchantStockTake']['type'] = 'STOCKTAKE';
            $data['MerchantStockTake']['status'] = 'STOCKTAKE_SCHEDULED';
            $data['MerchantStockTake']['date'] = date('Y-m-d h:i:s', strtotime($data['MerchantStockTake']['start_date'] . ' ' . $data['MerchantStockTake']['start_time']));

            $this->loadModel('MerchantStockTake');
            $dataSource = $this->MerchantStockTake->getDataSource();
            $dataSource->begin();

            try {
                // create a merchant stock order
                $this->MerchantStockTake->create();
                $this->MerchantStockTake->save($data);

                $take_id = $this->MerchantStockTake->id;

                // check 'full count'
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
                }

                $dataSource->commit();

                // redirect to index
                $this->redirect('/inventory_count');
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        // get the list of merchant outlets
        /*
        $this->loadModel('MerchantOutlet');
        $outlets = $this->MerchantOutlet->find('list', array(
            'fields' => array('MerchantOutlet.id', 'MerchantOutlet.name'),
            'conditions' => array('MerchantOutlet.merchant_id' => $this->Auth->user()['merchant_id']),
            'recursive' => 0
        ));
         */
        $outlets = $this->__listMerchantOutlets($this->Auth->user()['merchant_id']);
        $this->set('outlets', $outlets);
    }

    public function editInventoryCount($id) {
        $this->loadModel('MerchantStockTake');

        $take = $this->MerchantStockTake->findById($id);

        $take['MerchantStockTakeItem'] = $this->__extractFilters($take['MerchantStockTake']['filters'], $this->Auth->user()['merchant_id']);

        $outlets = $this->__listMerchantOutlets($this->Auth->user()['merchant_id']);
        $this->set('outlets', $outlets);

        if ( !$this->request->data ) {
            $this->request->data = $take;
            $this->request->data['MerchantStockTake']['start_date'] = date('Y-m-d', strtotime($take['MerchantStockTake']['start_date']));
            $this->request->data['MerchantStockTake']['start_time'] = date('h:i A', strtotime($take['MerchantStockTake']['start_date']));
        }
    }

    public function saveInventoryCount() {
        if ( !$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/inventory_count');
        }

        $result = array(
            'success' => false
        );

        $data = $this->request->data;
        $data = $this->__saveInventoryCount($data, 'STOCKTAKE_SCHEDULED');

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

    public function startInventoryCount() {
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
            $data = $this->__saveInventoryCount($data, 'STOCKTAKE_IN_PROGRESS_PROCESSED');

            if ( isset($data['MerchantStockTake']['id']) ) {
                $this->MerchantStockTake->id = $data['MerchantStockTake']['id'];
            } else {
                $this->MerchantStockTake->create();
            }
            $this->MerchantStockTake->save($data);

            if (!isset($data['MerchantStockTake']['id']) || empty($data['MerchantStockTake']['id'])) {
                $data['MerchantStockTake']['id'] = $this->MerchantStockTake->id;
            }

            $items = $this->__saveStockTakeItems($data['MerchantStockTake']);
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

    public function searchProduct() {
    	$result = array(
        	'success' => false
    	);
    	$user = $this->Auth->user();

    	if ($this->request->is('ajax')) {
        	$data = $this->request->data;

        	$products = $this->MerchantProduct->find('all', array(
        		'conditions' => array(
        			'MerchantProduct.merchant_id' => $user['merchant_id'],
        			'MerchantProduct.track_inventory = 1',
        			'MerchantProduct.name LIKE' => '%' .$data['q'] . '%'
        		)
        	));

        	$result['products'] = $products;
        	$result['success'] = true;
    	}
    	$this->serialize($result);
    }

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
     * list the merchant outlets for 'select' form
     *
     * @param string merchant id
     * @return array the list
     */
    private function __listMerchantOutlets($merchant_id) {
        $this->loadModel('MerchantOutlet');

        $outlets = $this->MerchantOutlet->find('list', array(
            'recursive' => 0,
            'fields' => array(
                'MerchantOutlet.id',
                'MerchantOutlet.name'
            ),
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $merchant_id
            )
        ));

        return $outlets;
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

    private function __saveInventoryCount($data, $status) {
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

    private function __saveStockTakeItems($stockTake) {
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
