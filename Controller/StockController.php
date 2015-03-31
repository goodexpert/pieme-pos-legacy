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
 * This controller uses MerchantStockOrder, MerchantStockOrderItem and MerchantStockTakeItem models.
 *
 * @var array
 */
    public $uses = array('MerchantStockOrder', 'MerchantStockOrderItem', 'MerchantStockTakeItem');

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        // bind model on the fly ...
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

        if(!empty($_GET['from']) and $_GET['from'] !== ''){
        	$orders = $this->MerchantStockOrder->find('all', array(
	            'conditions' => array(
	                'MerchantStockOrder.date' > $_GET['from']
	            ),
	        ));
        } else {
	        $orders = $this->MerchantStockOrder->find('all', array(
	            'conditions' => array(
	                'MerchantStockOrder.merchant_id' => $this->Auth->user()['merchant_id']
	            ),
	        ));
	    }
        $this->set('orders', $orders);
        //debug($orders);
    }

    /**
     * save the merchant stock order and items into 'merchant_stock_order' table and
     * 'merchant_stock_order_items' 
     * log to the 'merchant_product_logs' table when the order sent or received ...
     */
    public function newOrder() {
        // get the list of merchant suppliers
        $this->loadModel('MerchantSupplier');
        $suppliers = $this->MerchantSupplier->find('list', array(
            'fields' => array('MerchantSupplier.id', 'MerchantSupplier.name'),
            'conditions' => array('MerchantSupplier.merchant_id' => $this->Auth->user()['merchant_id']),
            'recursive' => 0
        ));
        $this->set('suppliers', $suppliers);

        // get the list of merchant outlets
        $this->loadModel('MerchantOutlet');
        $outlets = $this->MerchantOutlet->find('list', array(
            'fields' => array('MerchantOutlet.id', 'MerchantOutlet.name'),
            'conditions' => array('MerchantOutlet.merchant_id' => $this->Auth->user()['merchant_id']),
            'recursive' => 0
        ));
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
                if ( !is_null($data['order-auto'] && $data['order-auto'] == '1') ) {
                    $autoFillProducts = $this->__autoFill($data['MerchantStockOrder']['outlet_id']);
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
                    $this->MerchantStockOrderItem->saveMany($items);
                }               

                $dataSource->commit();

                // redirect to edit
                $this->redirect('/stock/edit/' . $order_id);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
                debug($e->getMessage());
            }
        }
    
    }

    public function newTransfer() {
        // get the list of merchant outlets
        $this->loadModel('MerchantOutlet');
        $outlets = $this->MerchantOutlet->find('list', array(
            'fields' => array('MerchantOutlet.id', 'MerchantOutlet.name'),
            'conditions' => array('MerchantOutlet.merchant_id' => $this->Auth->user()['merchant_id']),
            'recursive' => 0
        ));
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
                if ( !is_null($data['order-auto'] && $data['order-auto'] == '1') ) {
                    $autoFillProducts = $this->__autoFill($data['MerchantStockOrder']['outlet_id']);
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
                    $this->MerchantStockOrderItem->saveMany($items);
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


        // get the merchant stock order
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
        $order = $this->MerchantStockOrder->find('first', array(
            'recursive' => 2,
            'conditions' => array(
                'MerchantStockOrder.id' => $id
            )
        ));
        $this->set('order', $order);

        // get the list of products
        /*
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
        $this->set('products', $products);
         */
        $this->loadModel('MerchantProductInventory');
        $this->MerchantProductInventory->bindModel(array(
            'belongsTo' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_id'
                )
            )
        ));
        $products = $this->MerchantProductInventory->find('all', array(
            'conditions' => array(
                'MerchantProductInventory.outlet_id' => $order['MerchantStockOrder']['outlet_id']
            )
        ));
        $this->set('products', $products);

        if ( !$this->request->data ) {
            $this->request->data = $order;
        }
    }

    public function saveSentItems() {
        if (!$this->request->is('ajax') || !$this->request->is('post')) {
            $this->redirect('/stock');
        }

        $result = array(
            'success' => false
        );

        try {
            $data = $this->request->data['MerchantStockOrderItem'];

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

            $this->MerchantStockOrderItem->saveMany($data);

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

            $this->MerchantStockOrderItem->saveMany($data);

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
     * edit a merchant stock order & merchant stock order item
     *
     * @param string merchant stock order id
     */
    public function edit1($id, $auto_fill = null) {
        if ( $this->request->is('post') ) {
            $data = $this->request->data['MerchantStockOrderItem'];

            // for total_cost, total_price_incl_tax
            foreach ($data as $i => &$d) {
                $total_cost = round($d['count'] * $d['supply_price'], 2);
                $data[$i]['total_cost'] = $total_cost;
                $data[$i]['total_price_incl_tax'] = round($d['count'] * $d['price_include_tax'], 2);
            }

            $dataSource = $this->MerchantStockOrderItem->getDataSource();
            $dataSource->begin();

            try {
                $this->MerchantStockOrderItem->saveMany($data);
                //$this->MerchantStockOrderItem->saveMany($this->request->data);
/*
                $this->MerchantStockOrderItem->saveMany(array(
                    array('MerchantStockOrderItem' => $data[0])
                ));
*/

                $dataSource->commit();

                $this->redirect('/stock/view/' . $id);
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
                debug($e->getMessage());
            }
        }

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

        $merchantStockOrder = $this->MerchantStockOrder->find('first', array(
            'recursive' => 4,
            'conditions' => array(
                'MerchantStockOrder.id' => $id
            )
        ));
        $this->set('order', $merchantStockOrder);
        //debug($merchantStockOrder); exit;

        // handle auto fill ...
        if ( !is_null($auto_fill) || $auto_fill == '0' ) {
            $auto_fill_products = $this->__autoFill($merchantStockOrder['MerchantStockOrder']['outlet_id']);
            $nextIdx = count($merchantStockOrder['MerchantStockOrderItem']);
            foreach ($auto_fill_products as $p) {
                $merchantStockOrder['MerchantStockOrderItem'][$nextIdx]['id'] = null;
                $merchantStockOrder['MerchantStockOrderItem'][$nextIdx]['order_id'] = $merchantStockOrder['MerchantStockOrder']['id'];
                $merchantStockOrder['MerchantStockOrderItem'][$nextIdx]['product_id'] = $p['MerchantProduct']['id'];
                $merchantStockOrder['MerchantStockOrderItem'][$nextIdx]['product_id'] = $p['MerchantProduct']['id'];
            }
        }


        $this->loadModel('MerchantProduct');
        $products = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.merchant_id' => $merchantStockOrder['MerchantStockOrder']['merchant_id']
            )
        ));
        $this->set('products', $products);


        if ( !$this->request->data ) {
            $this->request->data = $merchantStockOrder;
        }

    }

    private function __autoFill($outlet_id) {
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
        $this->loadModel('MerchantStockOrder');

        $order = $this->MerchantStockOrder->findById($id);

        $this->MerchantStockOrder->bindModel(array(
            'belongsTo' => array(
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                ),
                'MerchantSupplier' => array(
                    'className' => 'MerchantSupplier',
                    'foreignKey' => 'supplier_id'
                ),
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
                        'MerchantProductInventory.outlet_id' => $order['MerchantStockOrder']['outlet_id']
                    )
                )
            )
        ));

        /*
        $this->loadModel('MerchantOutlet');
        $this->MerchantOutlet->bindModel(array(
            'hasMany' => array(
                'className' => 'MerchantProductInventory',
                'foreignKey' => 'outlet_id'
            )
        ));
         */
    
        $merchantStockOrder = $this->MerchantStockOrder->find('first', array(
            'recursive' => 5,
            'conditions' => array(
                'MerchantStockOrder.id' => $id
            )
        ));

        $this->set('order', $merchantStockOrder);
        //debug($merchantStockOrder);

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

    public function send() {
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
            $this->MerchantProductLog->create();
            $this->MerchantProductLog->saveMany($logs);

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
            $product_logs[$idx]['MerchantProductLog'] = array(
                'product_id'        => $item['product_id'],
                'user_id'           => $this->Auth->user()['id'],
                'outlet_id'         => $order['MerchantStockOrder']['outlet_id'],
                'quantity'          => '0',
                'outlet_quantity'   => '0',
                'change'            => '0',
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

        $order = $this->MerchantStockOrder->find('first', array(
            'recursive' => 2,
            'conditions' => array(
                'MerchantStockOrder.id' => $id
            )
        ));
        $this->set('order', $order);


        // get the list of products
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
        $this->set('products', $products);


        if ( !$this->request->data ) {
            $this->request->data = $order;
        }

    }

    public function inventoryCount() {
    }

    public function newInventoryCount() {
    }

    public function viewInventoryCount() {
    }

    public function performInventoryCount() {
    }

    public function reviewInventoryCount() {
    }

}
