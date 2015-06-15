<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class StockTakesController extends AppController {

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
        'MerchantProductBrand',
        'MerchantProductType',
        'MerchantProductTag',
        'MerchantProductCategory',
        'MerchantSupplier',
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
 * Index function.
 *
 * @return void
 */
    public function index() {
        $user = $this->Auth->user();

        $stocktakes = $this->_getStockTakes($user['merchant_id'], $user['retailer_id']);
        $this->set('data', $stocktakes);
    }
        
/**
 * Create a stocktake.
 *
 * @return void
 */
    public function create() {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $result = $this->_saveStockTake($user['merchant_id'], $user['retailer_id']);

            if ($result['success'] && isset($result['id'])) {
                if (isset($data['save-start']) && $data['save-start'] == 1) {
                    $this->redirect('/stock_takes/' . $result['id'] . '/perform');
                } else {
                    $this->redirect('/stock_takes/');
                }
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
    }

/**
 * Edit a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function edit($id) {
        $user = $this->Auth->user();

        if ($this->request->is('post')) {
            $data = $this->request->data;

            $result = $this->_saveStockTake($user['merchant_id'], $user['retailer_id']);

            if ($result['success'] && isset($result['id'])) {
                if (isset($data['save-start']) && $data['save-start'] == 1) {
                    $this->redirect('/stock_takes/' . $result['id'] . '/start');
                } else {
                    $this->redirect('/stock_takes/');
                }
            } else {
                $this->Session->setFlash($result['message']);
            }
        }

        if (empty($this->request->data)) {
            $data = $this->_getStockTake($id, $user['merchant_id'], $user['retailer_id']);
            $this->request->data = $data;
        }

        if (empty($user['retailer_id'])) {
            // get the list of merchant's outlets
            $outlets = $this->_getOutletByMerchantId($user['merchant_id']);
        } else {
            // get the list of retail's outlets
            $outlets = $this->_getOutletByRetailerId($user['retailer_id']);
        }
        $this->set('outlets', $outlets);
    }

/**
 * Cancel a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function cancel($id) {
        $user = $this->Auth->user();
    }

/**
 * Perform a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function perform($id) {
        $user = $this->Auth->user();

        $stockTake = $this->_getStockTake($id, $user['merchant_id'], $user['retailer_id']);
        if ($stockTake['MerchantStockTake']['order_status_id'] === 'stock_take_status_open') {
            $this->MerchantStockTake->id = $stockTake['MerchantStockTake']['id'];
            $this->MerchantStockTake->saveField('order_status_id', 'stock_take_status_progressed');
        }
        $this->set('stockTake', $stockTake);
    }

/**
 * Pause a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function pause($id) {
        $user = $this->Auth->user();
    }

/**
 * Review a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function review($id) {
        $user = $this->Auth->user();
    }

/**
 * Search a product.
 *
 * @return void
 */
    public function search() {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $user = $this->Auth->user();
        $result = array(
            'success' => false
        );

        try {
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
                        'MerchantProduct.track_inventory' => 1,
                        'MerchantProduct.stock_type' => 'STANDARD',
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
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
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
 * Validate the stocktake id.
 *
 * @param string stocktake id
 * @return boolean return true if the stocktake id exists.
 */
    protected function _isValidId($id) {
        $order = $this->MerchantStockTake->findById($id);
        return !empty($order) && is_array($order);
    }

/**
 * Validate the stocktake item id.
 *
 * @param string stocktake item id
 * @return boolean return true if the stocktake id exists.
 */
    protected function _isValidItemId($id) {
        $item = $this->MerchantStockTakeItem->findById($id);
        return !empty($item) && is_array($item);
    }

/**
 * Save a stocktake.
 *
 * @param string merchant id
 * @param string retailer id
 * @return array
 */
    protected function _saveStockTake($merchant_id, $retailer_id) {
        $result = array(
            'success' => false
        );

        $dataSource = $this->MerchantStockTake->getDataSource();
        $dataSource->begin();

        try {
            $data = $this->request->data;

            if (isset($data['MerchantStockTake']['id']) && !empty($data['MerchantStockTake']['id'])) {
                $this->MerchantStockTake->id = $data['MerchantStockTake']['id'];
            } else {
                $data['MerchantStockTake']['merchant_id'] = $merchant_id;
                $data['MerchantStockTake']['retailer_id'] = $retailer_id;
                $data['MerchantStockTake']['order_type_id'] = 'stock_order_type_stocktake';
                $data['MerchantStockTake']['order_status_id'] = 'stock_take_status_open';

                $this->MerchantStockTake->create();
            }
            if (isset($data['save-start']) && $data['save-start'] == 1) {
                $data['MerchantStockTake']['order_status_id'] = 'stock_take_status_progressed';
            }
            $this->MerchantStockTake->save($data);

            $dataSource->commit();

            $result['success'] = true;
            $result['id'] = $this->MerchantStockTake->id;
        } catch (Exception $e) {
            $dataSource->rollback();
            $result['message'] = $e->getMessage();
        }
        return $result;
    }

/**
 * Get the stocktake.
 *
 * @param string stocktake id
 * @param string merchant id
 * @param string retailer id
 * @return false|array the stock order datails and items
 */
    protected function _getStockTake($stocktake_id, $merchant_id, $retailer_id) {
        $conditions = array(
            'MerchantStockTake.id' => $stocktake_id,
            'MerchantStockTake.merchant_id' => $merchant_id
        );

        if (!empty($retailer_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockTake.retailer_id' => $retailer_id,
            ));
        }

        $stocktake = $this->MerchantStockTake->find('first', array(
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
            'conditions' => $conditions
        ));

        if (empty($stocktake) || !is_array($stocktake)) {
            return false;
        }

        if ($stocktake['MerchantStockTake']['full_count'] == 0) {
            $filters = json_decode($stocktake['MerchantStockTake']['filters'], true);
            $show_inactive = $stocktake['MerchantStockTake']['show_inactive'];

            $stocktake['products'] = $this->_searchByFilters($merchant_id, $retailer_id, $filters, $show_inactive);
        }
        return $stocktake;
    }

/**
 * Get the stocktakes.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string outlet id
 * @return array
 */
    protected function _getStockTakes($merchant_id, $retailer_id, $outlet_id = null) {
        $conditions = array(
            'MerchantStockTake.merchant_id' => $merchant_id
        );

        if (!empty($retailer_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockTake.retailer_id' => $retailer_id
            ));
        }

        if (!empty($outlet_id)) {
            $conditions = array_merge($conditions, array(
                'MerchantStockTake.outlet_id' => $outlet_id
            ));
        }

        // get the stock take list
        $stocktakes = $this->MerchantStockTake->find('all', array(
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
            'conditions' => $conditions,
            'order' => array(
                'MerchantStockTake.created DESC'
            )
        ));

        $counts = Hash::map($stocktakes, "{n}", function($array) {
            $newArray= $array['MerchantStockTake'];
            $newArray['outlet_name'] = $array['MerchantOutlet']['name'];
            return $newArray;
        });
        /*
        $counts = array();
        foreach ($stocktakes as $stocktake) {
            $item = $stocktake['MerchantStockTake'];
            $item['outlet_name'] = $stocktake['MerchantOutlet']['name'];

            if ($item['order_status_id'] === 'stock_take_status_cancelled') {
                $counts['cancelled'][] = $item;
            } elseif ($item['order_status_id'] === 'stock_take_status_completed') {
                $counts['completed'][] = $item;
            } else {
                $counts['progress'][] = $item;
            }
        }
         */
        return $counts;
    }

/**
 * Search a product by filters.
 *
 * @param string merchant id
 * @param string retailer id
 * @param array filter array
 * @param int   show inactive flag
 * @return void
 */
    protected function _searchByFilters($merchant_id, $retailer_id, $filters, $show_inactive) {
        $products = array();

        if (!empty($filters) && is_array($filters)) {
            foreach ($filters as $filter) {
                $joins = array();
                $conditions = array();

                if ($filter['type'] === 'brands') {
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
                } elseif ($filter['type'] === 'tags') {
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
                } elseif ($filter['type'] === 'types') {
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
                } elseif ($filter['type'] === 'suppliers') {
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
                } elseif ($filter['type'] === 'products') {
                    $conditions = array(
                        'MerchantProduct.id' => $filter['value']
                    );
                }

                $conditions = array_merge($conditions, array(
                    'MerchantProduct.merchant_id' => $merchant_id,
                    'MerchantProduct.track_inventory' => 1,
                    'MerchantProduct.stock_type' => 'STANDARD'
                ));

                if ($show_inactive == 0) {
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

                foreach ($items as $item) {
                    $product_id = $item['id'];

                    if (!isset($products[$product_id])) {
                        $products[$product_id] = array(
                            'product' => $item,
                            'types' => array()
                        );
                    }
                    array_push($products[$product_id]['types'], array(
                        'type' => $filter['type'],
                        'value' => $filter['value']
                    ));
                }
            }
        }
        return json_encode($products, false);
    }

}
