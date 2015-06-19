<?php

App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class StockTakesController extends AppController {

/**
 * Components property.
 *
 * @var array
 */
    public $components = ['RequestHandler'];

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
    public $uses = [
        'MerchantProduct',
        'MerchantProductBrand',
        'MerchantProductType',
        'MerchantProductTag',
        'MerchantProductCategory',
        'MerchantSupplier',
        'MerchantStockTake',
        'MerchantStockTakeCount',
        'MerchantStockTakeItem'
    ];

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

            $dataSource = $this->MerchantStockTake->getDataSource();
            $dataSource->begin();

            try {
                $merchant_id    = $user['merchant_id'];
                $retailer_id    = $user['retailer_id'];
                $name           = $data['MerchantStockTake']['name'];
                $outlet_id      = $data['MerchantStockTake']['outlet_id'];
                $filters        = $data['MerchantStockTake']['filters'];
                $show_inactive  = $data['MerchantStockTake']['show_inactive'];
                $full_count     = $data['MerchantStockTake']['full_count'];
                $due_date       = $data['MerchantStockTake']['due_date'];
                $stock_take_id  = $data['MerchantStockTake']['id'];
                $save_start     = $data['save-start'];
                $product_ids    = null;

                if ($full_count != 1 && !empty(json_decode($data['products'], true))) {
                    $product_ids = array_keys(json_decode($data['products'], true));
                }

                $result = $this->_saveStockTake($merchant_id, $retailer_id, $name, $outlet_id, $filters,
                    $show_inactive, $full_count, $due_date, $save_start, $stock_take_id);

                if ($result) {
                    if ($save_start == 1) {
                        $stock_take_items = $this->_getStockTakeItems($merchant_id, $result, $outlet_id, $show_inactive, $full_count, $product_ids);
                        if (is_array($stock_take_items)) {
                            $this->_saveStockTakeItems($stock_take_items);
                        }
                    }
                    $dataSource->commit();

                    if ($save_start == 1) {
                        return $this->redirect('/stock_takes/' . $result . '/perform');
                    } else {
                        return $this->redirect('/stock_takes/');
                    }
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        // get the list of outlets
        $outlets = $this->_getOutletList($user['merchant_id'], $user['retailer_id']);
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

        $stocktake = $this->_getStockTake($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif (!in_array($stocktake['MerchantStockTake']['order_status_id'],
            ['stock_take_status_open', 'stock_take_status_scheduled'])) {
            return $this->redirect('/stock_takes/');
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockTake->getDataSource();
            $dataSource->begin();

            try {
                $merchant_id    = $user['merchant_id'];
                $retailer_id    = $user['retailer_id'];
                $name           = $data['MerchantStockTake']['name'];
                $outlet_id      = $data['MerchantStockTake']['outlet_id'];
                $filters        = $data['MerchantStockTake']['filters'];
                $show_inactive  = $data['MerchantStockTake']['show_inactive'];
                $full_count     = $data['MerchantStockTake']['full_count'];
                $due_date       = $data['MerchantStockTake']['due_date'];
                $stock_take_id  = $data['MerchantStockTake']['id'];
                $save_start     = $data['save-start'];
                $product_ids    = null;

                if ($full_count == 0 && !empty(json_decode($data['products'], true))) {
                    $product_ids = array_keys(json_decode($data['products'], true));
                }

                $result = $this->_saveStockTake($merchant_id, $retailer_id, $name, $outlet_id, $filters,
                    $show_inactive, $full_count, $due_date, $save_start, $stock_take_id);

                if ($result) {
                    if ($save_start == 1) {
                        $stock_take_items = $this->_getStockTakeItems($merchant_id, $result, $outlet_id, $show_inactive, $full_count, $product_ids);
                        if (is_array($stock_take_items)) {
                            $this->_saveStockTakeItems($stock_take_items);
                        }
                    }
                    $dataSource->commit();

                    if ($save_start == 1) {
                        return $this->redirect('/stock_takes/' . $result . '/perform');
                    } else {
                        return $this->redirect('/stock_takes/');
                    }
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                $this->Session->setFlash($e->getMessage());
            }
        }

        if (empty($this->request->data)) {
            $this->request->data = $stocktake;
        }

        // get the list of outlets
        $outlets = $this->_getOutletList($user['merchant_id'], $user['retailer_id']);
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

        $stocktake = $this->_getStockTake($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif ($stocktake['MerchantStockTake']['order_status_id'] !== 'stock_take_status_progressed') {
            return $this->redirect('/stock_takes/');
        }

        $this->MerchantStockTake->id = $id;
        $this->MerchantStockTake->saveField('order_status_id', 'stock_take_status_cancelled');

        return $this->redirect('/stock_takes/');
    }

/**
 * Complete a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function complete($id) {
        $user = $this->Auth->user();

        $stocktake = $this->_getStockTakeAndItems($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif ($stocktake['MerchantStockTake']['order_status_id'] !== 'stock_take_status_progressed') {
            return $this->redirect('/stock_takes/');
        }

        $dataSource = $this->MerchantStockTake->getDataSource();
        $dataSource->begin();

        try {
            $totalCountGain = 0;
            $totalCountLoss = 0;
            $totalCostGain = 0;
            $totalCostLoss = 0;

            foreach ($stocktake['MerchantStockTakeItem'] as $item) {
                if ($item['excluded'] == 1) {
                    continue;
                }
                $expected = $item['expected'];
                $counted = empty($item['counted']) ? 0 : $item['counted'];

                if ($counted - $expected <= 0) {
                    $totalCountLoss += $expected - $counted;
                    $totalCostLoss += ($expected - $counted) * $item['supply_price'];
                } else {
                    $totalCountGain += $counted - $expected;
                    $totalCostGain += ($counted - $expected) * $item['supply_price'];
                }
            }

            $stocktake['MerchantStockTake']['order_status_id'] = 'stock_take_status_completed';
            $stocktake['MerchantStockTake']['total_cost_gain'] = $totalCostGain;
            $stocktake['MerchantStockTake']['total_cost_loss'] = $totalCostLoss;
            $stocktake['MerchantStockTake']['total_count_gain'] = $totalCountGain;
            $stocktake['MerchantStockTake']['total_count_loss'] = $totalCountLoss;

            $this->MerchantStockTake->id = $id;
            $this->MerchantStockTake->save($stocktake['MerchantStockTake']);

            $dataSource->commit();
        } catch (Exception $e) {
            $dataSource->rollback();
        }

        return $this->redirect('/stock_takes/' . $id);
    }

/**
 * Delete a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function delete($id) {
        $user = $this->Auth->user();
        $result = [
            'success' => false
        ];

        $stocktake = $this->_getStockTake($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif ($stocktake['MerchantStockTake']['order_status_id'] !== 'stock_take_status_open') {
            return $this->redirect('/stock_takes/');
        }

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $this->MerchantStockTake->delete($id);
            $result['success'] = true;
        }

        $this->serialize($result);
    }

/**
 * Perform a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function perform($id) {
        $user = $this->Auth->user();

        $stocktake = $this->_getStockTakeAndItems($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif ($stocktake['MerchantStockTake']['order_status_id'] !== 'stock_take_status_progressed') {
            return $this->redirect('/stock_takes/');
        }
        $this->set('stocktake', $stocktake);

        $inventory = $this->_getOutletInventories($stocktake['MerchantStockTake']['outlet_id']);
        $this->set('inventory', $inventory);
    }

/**
 * Pause a inventory count.
 *
 * @param string stocktake id
 * @return void
 */
    public function pause($id) {
        $user = $this->Auth->user();
        $result = [
            'success' => false
        ];

        $stocktake = $this->_getStockTakeAndItems($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif ($stocktake['MerchantStockTake']['order_status_id'] !== 'stock_take_status_progressed') {
            return $this->redirect('/stock_takes/');
        }

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;
            $result['data'] = $data;

            $dataSource = $this->MerchantStockTake->getDataSource();
            $dataSource->begin();

            try {
                $stockTakeCounts = json_decode($data['StockTakeCount'], true);
                $stockTakeItems = json_decode($data['StockTakeItem'], true);

                $this->MerchantStockTakeItem->saveMany($stockTakeItems);
                foreach ($stockTakeCounts as $count) {
                    if (empty($count['id'])) {
                        $this->MerchantStockTakeCount->create();
                    } else {
                        $this->MerchantStockTakeCount->id = $count['id'];
                    }
                    $this->MerchantStockTakeCount->save($count);
                }

                $dataSource->commit();
                $result['success'] = true;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
        } else {
            return $this->redirect($this->referer());
        }

        $this->serialize($result);
    }

/**
 * Review a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function review($id) {
        $user = $this->Auth->user();

        $stocktake = $this->_getStockTakeAndItems($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif ($stocktake['MerchantStockTake']['order_status_id'] !== 'stock_take_status_progressed') {
            return $this->redirect('/stock_takes/');
        }
        $this->set('stocktake', $stocktake);
    }

/**
 * View a stocktake.
 *
 * @param string stocktake id
 * @return void
 */
    public function view($id) {
        $user = $this->Auth->user();

        $stocktake = $this->_getStockTakeAndItems($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        } elseif (!in_array($stocktake['MerchantStockTake']['order_status_id'], ['stock_take_status_cancelled', 'stock_take_status_completed'])) {
            return $this->redirect('/stock_takes/');
        }
        $this->set('stocktake', $stocktake);
    }

/**
 * Add a stocktake item.
 *
 * @param string stocktake id
 * @return void
 */
    public function addItem($id) {
        $user = $this->Auth->user();
        $result = [
            'success' => false
        ];

        $stocktake = $this->_getStockTake($id, $user['merchant_id'], $user['retailer_id']);
        if (!$stocktake) {
            throw new NotFoundException();
        }

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $data = $this->request->data;

            $dataSource = $this->MerchantStockTakeItem->getDataSource();
            $dataSource->begin();

            try {
                $this->MerchantProduct->virtualFields['expected'] = 'MerchantProductInventory.count';

                $product = $this->MerchantProduct->find('first', [
                    'fields' => [
                        'MerchantProduct.id AS product_id',
                        'MerchantProduct.name',
                        'MerchantProduct.handle',
                        'MerchantProduct.sku',
                        'MerchantProduct.expected',
                        'MerchantProduct.supply_price',
                        'MerchantProduct.price_include_tax'
                    ],
                    'joins' => [
                        [
                            'table' => 'merchant_product_inventories',
                            'alias' => 'MerchantProductInventory',
                            'type' => 'LEFT',
                            'conditions' => [
                                'MerchantProductInventory.id' => $data['outlet_id'],
                                'MerchantProductInventory.product_id = MerchantProduct.id'
                            ]
                        ]
                    ],
                    'conditions' => [
                        'MerchantProduct.id' => $data['product_id']
                    ]
                ]);

                if (!empty($product) && is_array($product)) {
                    $item = $product['MerchantProduct'];
                    $item['stock_take_id'] = $id;

                    $this->MerchantStockTakeItem->create();
                    if (!$this->MerchantStockTakeItem->save(['MerchantStockTakeItem' => $item])) {
                        throw new Exception(json_encode($this->MerchantStockTakeItem->validateErrors));
                    }
                    $item['id'] = $this->MerchantStockTakeItem->id;

                    $result['item'] = $item;
                    $result['success'] = true;
                } else {
                    $result['message'] = 'Unknown error!';
                }

                // reset virtual field so it won't mess up subsequent finds
                unset($this->MerchantProduct->virtualFields['expected']);

                $dataSource->commit();
                $result['success'] = true;
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
        } else {
            return $this->redirect($this->referer());
        }

        $this->serialize($result);
    }

/**
 * Search a product.
 *
 * @return void
 */
    public function search() {
        $user = $this->Auth->user();
        $result = [
            'success' => false
        ];

        $keyword = null;
        $filter = null;
        $showInactive = null;

        if ($this->request->is('get')) {
            $keyword = $this->get('keyword');
            $filter = $this->get('filter');
            $showInactive = $this->get('show_inactive');
        } elseif ($this->request->is('ajax') || $this->request->is('post')) {
            $keyword = $this->post('keyword');
            $filter = $this->post('filter');
            $showInactive = $this->post('show_inactive');
        }

        try {
            $conditions = [];

            if (!$showInactive) {
                $conditions = [
                    'MerchantProduct.is_active' => '1'
                ];
            }

            if (empty($filter) || $filter === 'suppliers') {
                $this->MerchantSupplier->bindModel([
                    'hasMany' => [
                        'MerchantProduct' => [
                            'classModel' => 'MerchantProduct',
                            'foreignKey' => 'supplier_id',
                            'conditions' => $conditions
                        ]
                    ]
                ]);

                $suppliers = $this->MerchantSupplier->find('all', [
                    'conditions' => [
                        'MerchantSupplier.merchant_id' => $user['merchant_id'],
                        'MerchantSupplier.name LIKE' => '%' . $keyword . '%'
                    ]
                ]);

                $suppliers = Hash::map($suppliers, "{n}", function($array) {
                    $newArray = $array['MerchantSupplier'];
                    $newArray['MerchantProduct'] = $array['MerchantProduct'];
                    return $newArray;
                });
                $result['suppliers'] = $suppliers;
            }

            if (empty($filter) || $filter === 'brands') {
                $this->MerchantProductBrand->bindModel([
                    'hasMany' => [
                        'MerchantProduct' => [
                            'classModel' => 'MerchantProduct',
                            'foreignKey' => 'product_brand_id',
                            'conditions' => $conditions
                        ]
                    ]
                ]);

                $brands = $this->MerchantProductBrand->find('all', [
                    'conditions' => [
                        'MerchantProductBrand.merchant_id' => $user['merchant_id'],
                        'MerchantProductBrand.name LIKE' => '%' . $keyword . '%'
                    ]
                ]);

                $brands = Hash::map($brands, "{n}", function($array) {
                    $newArray = $array['MerchantProductBrand'];
                    $newArray['MerchantProduct'] = $array['MerchantProduct'];
                    return $newArray;
                });
                $result['brands'] = $brands;
            }

            if (empty($filter) || $filter === 'types') {
                $this->MerchantProductType->bindModel([
                    'hasMany' => [
                        'MerchantProduct' => [
                            'classModel' => 'MerchantProduct',
                            'foreignKey' => 'product_type_id',
                            'conditions' => $conditions
                        ]
                    ]
                ]);

                $types = $this->MerchantProductType->find('all', [
                    'conditions' => [
                        'MerchantProductType.merchant_id' => $user['merchant_id'],
                        'MerchantProductType.name LIKE' => '%' . $keyword . '%'
                    ]
                ]);

                $types = Hash::map($types, "{n}", function($array) {
                    $newArray = $array['MerchantProductType'];
                    $newArray['MerchantProduct'] = $array['MerchantProduct'];
                    return $newArray;
                });
                $result['types'] = $types;
            }

            if (empty($filter) || $filter === 'tags') {
                $this->MerchantProductCategory->bindModel([
                    'belongsTo' => [
                        'MerchantProduct' => [
                            'classModel' => 'MerchantProduct',
                            'foreignKey' => 'product_id',
                            'conditions' => $conditions
                        ]
                    ]
                ]);

                $this->MerchantProductTag->bindModel([
                    'hasMany' => [
                        'MerchantProductCategory' => [
                            'classModel' => 'MerchantProduct',
                            'foreignKey' => 'product_tag_id'
                        ]
                    ]
                ]);

                $tags = $this->MerchantProductTag->find('all', [
                    'conditions' => [
                        'MerchantProductTag.merchant_id' => $user['merchant_id'],
                        'MerchantProductTag.name LIKE' => '%' . $keyword . '%'
                    ],
                    'recursive' => 2
                ]);

                $tags = Hash::map($tags, "{n}", function($array) {
                    $newArray = $array['MerchantProductTag'];
                    $newArray['MerchantProduct'] = Hash::map($array['MerchantProductCategory'], "{n}", function($array) {
                        return $array['MerchantProduct'];
                    });
                    return $newArray;
                });
                $result['tags'] = $tags;
            }

            if (empty($filter) || $filter === 'products') {
                $conditions[] = [
                    'MerchantProduct.merchant_id' => $user['merchant_id'],
                    'MerchantProduct.track_inventory' => 1,
                    'MerchantProduct.stock_type' => 'STANDARD',
                    'OR' => [
                        'MerchantProduct.name LIKE' => '%' . $keyword . '%',
                        'MerchantProduct.sku LIKE' => '%' . $keyword . '%'
                    ]
                ];

                $products = $this->MerchantProduct->find('all', [
                    'conditions' => $conditions
                ]);

                $products = Hash::map($products, "{n}", function($array) {
                    $newArray = $array['MerchantProduct'];
                    return $newArray;
                });
                $result['products'] = $products;
            }

            $result['success'] = true;
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }

        $this->serialize($result);
    }

    public function search2() {
        if (!$this->request->is('ajax')) {
            throw new NotFoundException();
        }

        $user = $this->Auth->user();
        $result = [
            'success' => false
        ];

        try {
            $data = $this->request->data;
            $keyword = $data['keyword'];
            $showInactive = $data['show_inactive'];

            $conditions = [];
            if (!$showInactive) {
                $conditions = [
                    'MerchantProduct.is_active' => '1'
                ];
            }

            $this->MerchantSupplier->bindModel([
                'hasMany' => [
                    'MerchantProduct' => [
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'supplier_id',
                        'conditions' => $conditions
                    ]
                ]
            ]);

            $suppliers = $this->MerchantSupplier->find('all', [
                'conditions' => [
                    'MerchantSupplier.merchant_id' => $user['merchant_id'],
                    'MerchantSupplier.name LIKE' => '%' . $keyword . '%'
                ]
            ]);

            $suppliers = Hash::map($suppliers, "{n}", function($array) {
                $newArray = $array['MerchantSupplier'];
                $newArray['MerchantProduct'] = $array['MerchantProduct'];
                return $newArray;
            });
            $result['suppliers'] = $suppliers;

            $this->MerchantProductBrand->bindModel([
                'hasMany' => [
                    'MerchantProduct' => [
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_brand_id',
                        'conditions' => $conditions
                    ]
                ]
            ]);

            $brands = $this->MerchantProductBrand->find('all', [
                'conditions' => [
                    'MerchantProductBrand.merchant_id' => $user['merchant_id'],
                    'MerchantProductBrand.name LIKE' => '%' . $keyword . '%'
                ]
            ]);

            $brands = Hash::map($brands, "{n}", function($array) {
                $newArray = $array['MerchantProductBrand'];
                $newArray['MerchantProduct'] = $array['MerchantProduct'];
                return $newArray;
            });
            $result['brands'] = $brands;

            $this->MerchantProductType->bindModel([
                'hasMany' => [
                    'MerchantProduct' => [
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_type_id',
                        'conditions' => $conditions
                    ]
                ]
            ]);

            $types = $this->MerchantProductType->find('all', [
                'conditions' => [
                    'MerchantProductType.merchant_id' => $user['merchant_id'],
                    'MerchantProductType.name LIKE' => '%' . $keyword . '%'
                ]
            ]);

            $types = Hash::map($types, "{n}", function($array) {
                $newArray = $array['MerchantProductType'];
                $newArray['MerchantProduct'] = $array['MerchantProduct'];
                return $newArray;
            });
            $result['types'] = $types;

            $this->MerchantProductCategory->bindModel([
                'belongsTo' => [
                    'MerchantProduct' => [
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_id',
                        'conditions' => $conditions
                    ]
                ]
            ]);

            $this->MerchantProductTag->bindModel([
                'hasMany' => [
                    'MerchantProductCategory' => [
                        'classModel' => 'MerchantProduct',
                        'foreignKey' => 'product_tag_id'
                    ]
                ]
            ]);

            $tags = $this->MerchantProductTag->find('all', [
                'conditions' => [
                    'MerchantProductTag.merchant_id' => $user['merchant_id'],
                    'MerchantProductTag.name LIKE' => '%' . $keyword . '%'
                ],
                'recursive' => 2
            ]);

            $tags = Hash::map($tags, "{n}", function($array) {
                $newArray = $array['MerchantProductTag'];
                $newArray['MerchantProduct'] = Hash::map($array['MerchantProductCategory'], "{n}", function($array) {
                    return $array['MerchantProduct'];
                });
                return $newArray;
            });
            $result['tags'] = $tags;

            $conditions[] = [
                'MerchantProduct.merchant_id' => $user['merchant_id'],
                'MerchantProduct.track_inventory' => 1,
                'MerchantProduct.stock_type' => 'STANDARD',
                'OR' => [
                    'MerchantProduct.name LIKE' => '%' . $keyword . '%',
                    'MerchantProduct.sku LIKE' => '%' . $keyword . '%'
                ]
            ];

            $products = $this->MerchantProduct->find('all', [
                'conditions' => $conditions
            ]);

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
 * @param string retailer id
 * @return array the list
 */
    protected function _getOutletList($merchant_id, $retailer_id) {
        $this->loadModel('MerchantOutlet');

        $conditions = [
            'MerchantOutlet.merchant_id' => $merchant_id
        ];

        if (!empty($retailer_id)) {
            $conditions[] = [
                'MerchantOutlet.retailer_id' => $retailer_id
            ];
        }

        $outlets = $this->MerchantOutlet->find('list', [
            'conditions' => $conditions
        ]);
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

        $inventories = $this->MerchantProductInventory->find('all', [
            'conditions' => [
                'MerchantProductInventory.outlet_id' => $outlet_id
            ]
        ]);

        $inventories = Hash::map($inventories, "{n}", function($array) {
            return $array['MerchantProductInventory'];
        });
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
 * Get the stocktake.
 *
 * @param string stocktake id
 * @param string merchant id
 * @param string retailer id
 * @return false|array the stock order datails and items
 */
    protected function _getStockTake($stocktake_id, $merchant_id, $retailer_id) {
        $conditions = [
            'MerchantStockTake.id' => $stocktake_id,
            'MerchantStockTake.merchant_id' => $merchant_id
        ];

        if (!empty($retailer_id)) {
            $conditions[] = [
                'MerchantStockTake.retailer_id' => $retailer_id,
            ];
        }

        $stocktake = $this->MerchantStockTake->find('first', [
            'fields' => [
                'MerchantStockTake.*',
                'MerchantOutlet.name'
            ],
            'joins' => [
                [
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => [
                        'MerchantOutlet.id = MerchantStockTake.outlet_id'
                    ]
                ]
            ],
            'conditions' => $conditions
        ]);

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
 * Get the stocktake and items.
 *
 * @param string stocktake id
 * @param string merchant id
 * @param string retailer id
 * @return false|array the stock order datails and items
 */
    protected function _getStockTakeAndItems($stocktake_id, $merchant_id, $retailer_id) {
        $conditions = [
            'MerchantStockTake.id' => $stocktake_id,
            'MerchantStockTake.merchant_id' => $merchant_id
        ];

        if (!empty($retailer_id)) {
            $conditions[] = [
                'MerchantStockTake.retailer_id' => $retailer_id,
            ];
        }

        $this->MerchantStockTake->bindModel([
            'hasMany' => [
                'MerchantStockTakeItem' => [
                    'className' => 'MerchantStockTakeItem',
                    'foreignKey' => 'stock_take_id'
                ],
                'MerchantStockTakeCount' => [
                    'className' => 'MerchantStockTakeCount',
                    'foreignKey' => 'stock_take_id'
                ]
            ]
        ]);

        $this->MerchantStockTake->virtualFields['outlet_name'] = 'MerchantOutlet.name';

        $stocktake = $this->MerchantStockTake->find('first', [
            'joins' => [
                [
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => [
                        'MerchantOutlet.id = MerchantStockTake.outlet_id'
                    ]
                ]
            ],
            'conditions' => $conditions
        ]);

        // reset virtual field so it won't mess up subsequent finds
        unset($this->MerchantStockTake->virtualFields['outlet_name']);

        if (empty($stocktake) || !is_array($stocktake)) {
            return false;
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
        $conditions = [
            'MerchantStockTake.merchant_id' => $merchant_id
        ];

        if (!empty($retailer_id)) {
            $conditions[] = [
                'MerchantStockTake.retailer_id' => $retailer_id
            ];
        }

        if (!empty($outlet_id)) {
            $conditions[] = [
                'MerchantStockTake.outlet_id' => $outlet_id
            ];
        }

        // get the stock take list
        $stocktakes = $this->MerchantStockTake->find('all', [
            'fields' => [
                'MerchantStockTake.*',
                'MerchantOutlet.name'
            ],
            'joins' => [
                [
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => [
                        'MerchantOutlet.id = MerchantStockTake.outlet_id'
                    ]
                ]
            ],
            'conditions' => $conditions,
            'order' => [
                'MerchantStockTake.created DESC'
            ]
        ]);

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
 * Save a stocktake.
 *
 * @param string merchant id
 * @param string retailer id
 * @param string name
 * @param string outlet id
 * @param string filters
 * @param string show inactive flag
 * @param string full count flag
 * @param string due date
 * @param string start flags
 * @param string stocktake id
 * @return string
 */
    protected function _saveStockTake($merchant_id, $retailer_id, $name, $outlet_id, $filters, $show_inactive, $full_count, $due_date, $start = 0, $id = null) {
        $data = [];

        if (empty($id)) {
            $data['merchant_id'] = $merchant_id;
            $data['retailer_id'] = $retailer_id;
            $data['order_type_id'] = 'stock_order_type_stocktake';
            $data['order_status_id'] = 'stock_take_status_open';

            $this->MerchantStockTake->create();
        } else {
            $this->MerchantStockTake->id = $id;
        }

        $data['name'] = $name;
        $data['outlet_id'] = $outlet_id;
        $data['filters'] = $filters;
        $data['show_inactive'] = $show_inactive;
        $data['full_count'] = $full_count;
        $data['due_date'] = $due_date;

        if ($start == 1) {
            $data['order_status_id'] = 'stock_take_status_progressed';
        }
        $this->MerchantStockTake->save(['MerchantStockTake' => $data]);
        return $this->MerchantStockTake->id;
    }

/**
 * Get stocktake items.
 *
 * @param string merchant id
 * @param string stocktake id
 * @param string outlet id
 * @param string show inactive flag
 * @param string full count flag
 * @param array product ids
 * @return array
 */
    protected function _getStockTakeItems($merchant_id, $stock_take_id, $outlet_id, $show_inactive, $full_count, $product_ids) {
        $conditions = [
            'MerchantProduct.merchant_id' => $merchant_id
        ];

        if ($show_inactive == '0') {
            $conditions[] = [
                'MerchantProduct.is_active' => '1'
            ];
        }

        if ($full_count == '0') {
            $conditions[] = [
                'MerchantProduct.id' => $product_ids
            ];
        }

        $this->MerchantProduct->virtualFields['expected'] = 'MerchantProductInventory.count';

        $products = $this->MerchantProduct->find('all', [
            'fields' => [
                'MerchantProduct.id AS product_id',
                'MerchantProduct.name',
                'MerchantProduct.handle',
                'MerchantProduct.sku',
                'MerchantProduct.expected',
                'MerchantProduct.supply_price',
                'MerchantProduct.price_include_tax'
            ],
            'joins' => [
                [
                    'table' => 'merchant_product_inventories',
                    'alias' => 'MerchantProductInventory',
                    'type' => 'LEFT',
                    'conditions' => [
                        'MerchantProductInventory.outlet_id' => $outlet_id,
                        'MerchantProductInventory.product_id = MerchantProduct.id'
                    ]
                ]
            ],
            'conditions' => $conditions
        ]);

        $stock_take_items = [];
        foreach ($products as $product) {
            $data = $product['MerchantProduct'];
            $data['stock_take_id'] = $stock_take_id;
            $data['planned'] = 1;

            $stock_take_items[] = $data;
        }

        // reset virtual field so it won't mess up subsequent finds
        unset($this->MerchantProduct->virtualFields['expected']);

        return $stock_take_items;
    }

/**
 * Store stocktake items.
 *
 * @param array stocktake items
 * @return array
 */
    protected function _saveStockTakeItems($stock_take_items) {
        $save_ids = [];
        foreach ($stock_take_items as $item) {
            if (!isset($item['id']) || empty($item['id'])) {
                $this->MerchantStockTakeItem->create();
            } else {
                $this->MerchantStockTakeItem->id = $item['id'];
            }
            $this->MerchantStockTakeItem->save(['MerchantStockTakeItem' => $item]);
            $save_ids[] = $this->MerchantStockTakeItem->id;
        }
        return $save_ids;
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
        $products = [];

        if (!empty($filters) && is_array($filters)) {
            foreach ($filters as $filter) {
                $joins = [];
                $conditions = [];

                if ($filter['type'] === 'brands') {
                    $joins = [
                        [
                            'table' => 'merchant_product_brands',
                            'alias' => 'MerchantProductBrand',
                            'type' => 'INNER',
                            'conditions' => [
                                'MerchantProductBrand.id = MerchantProduct.product_brand_id'
                            ]
                        ]
                    ];

                    $conditions = [
                        'MerchantProductBrand.id' => $filter['value']
                    ];
                } elseif ($filter['type'] === 'tags') {
                    $joins = [
                        [
                            'table' => 'merchant_product_categories',
                            'alias' => 'MerchantProductCategory',
                            'type' => 'INNER',
                            'conditions' => [
                                'MerchantProductCategory.product_id = MerchantProduct.id'
                            ]
                        ],
                        [
                            'table' => 'merchant_product_tags',
                            'alias' => 'MerchantProductTag',
                            'type' => 'INNER',
                            'conditions' => [
                                'MerchantProductTag.id = MerchantProductCategory.product_tag_id'
                            ]
                        ]
                    ];

                    $conditions = [
                        'MerchantProductTag.id' => $filter['value']
                    ];
                } elseif ($filter['type'] === 'types') {
                    $joins = [
                        [
                            'table' => 'merchant_product_types',
                            'alias' => 'MerchantProductType',
                            'type' => 'INNER',
                            'conditions' => [
                                'MerchantProductType.id = MerchantProduct.product_type_id'
                            ]
                        ]
                    ];

                    $conditions = [
                        'MerchantProductType.id' => $filter['value']
                    ];
                } elseif ($filter['type'] === 'suppliers') {
                    $joins = [
                        [
                            'table' => 'merchant_suppliers',
                            'alias' => 'MerchantSupplier',
                            'type' => 'INNER',
                            'conditions' => [
                                'MerchantSupplier.id = MerchantProduct.supplier_id'
                            ]
                        ]
                    ];

                    $conditions = [
                        'MerchantSupplier.id' => $value
                    ];
                } elseif ($filter['type'] === 'products') {
                    $conditions = [
                        'MerchantProduct.id' => $filter['value']
                    ];
                }

                $conditions[] = [
                    'MerchantProduct.merchant_id' => $merchant_id,
                    'MerchantProduct.track_inventory' => 1,
                    'MerchantProduct.stock_type' => 'STANDARD'
                ];

                if ($show_inactive == 0) {
                    $conditions[] = [
                        'MerchantProduct.is_active = 1',
                    ];
                }

                $items = $this->MerchantProduct->find('all', [
                    'joins' => $joins,
                    'conditions' => $conditions
                ]);

                $items = Hash::map($items, "{n}", function($array) {
                    return $array['MerchantProduct'];
                });

                foreach ($items as $item) {
                    $product_id = $item['id'];

                    if (!isset($products[$product_id])) {
                        $products[$product_id] = [
                            'product' => $item,
                            'types' => array()
                        ];
                    }
                    array_push($products[$product_id]['types'], [
                        'type' => $filter['type'],
                        'value' => $filter['value']
                    ]);
                }
            }
        }
        return json_encode($products, false);
    }

}
