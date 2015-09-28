<?php

App::uses('AppController', 'Controller');

/**
 * references : `http://book.cakephp.org/2.0/en/models.html`
 */
class ProductController extends AppController {

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
        'Merchant',
        'MerchantProduct',
        'MerchantProductComposite',
        'MerchantProductType',
        'MerchantProductBrand',
        'MerchantProductTag',
        'MerchantProductVariant',
        'MerchantProductCategory',
        'MerchantProductLog',
        'MerchantTaxRate',
        'MerchantPriceBook',
        'MerchantPriceBookEntry',
        'MerchantOutlet',
        'MerchantSupplier',
        'MerchantProductInventory'
    );

/**
 * Callback is called before any controller action logic is executed.
 *
 * @return void
 */
    public function beforeFilter() {
        parent::beforeFilter();
    }

    public function index() {
        $user = $this->Auth->user();

        $filter = array(
            'MerchantProduct.merchant_id' => $user['merchant_id'],
            'MerchantProduct.is_active' => 1
        );

        $discount_id = $this->Merchant->find('first', Array(
          'fields' => array('Merchant.discount_product_id'),
          'conditions' => array(
            'Merchant.id' => $user['merchant_id']
          )
        ));

        $discount_id = $discount_id['Merchant']['discount_product_id'];

        if(isset($_GET)) {
            foreach($_GET as $filtering_option_name => $filtering_option_value) {
                if($filtering_option_name == 'is_active') {
                    if($filtering_option_value == '0' || $filtering_option_value == '1') {
                        $filter['MerchantProduct.'.$filtering_option_name] = $filtering_option_value;
                    } else {
                        unset($filter['MerchantProduct.is_active']);
                    }
                } else {
                    if(!empty($filtering_option_value)) {
                        if($filtering_option_name == 'name') {
                            $filter['OR'] = array(
                                'MerchantProduct.name LIKE' => "%".$filtering_option_value."%",
                                'MerchantProduct.sku LIKE' => "%".$filtering_option_value."%",
                                'MerchantProduct.handle LIKE' => "%".$filtering_option_value."%"
                            );
                        } else if($filtering_option_name == 'tag') {
                            $product_ids = array();
                            foreach($filtering_option_value as $tagF) {
                                $tag_id = $this->MerchantProductTag->find('all', array(
                                    'conditions' => array(
                                        'MerchantProductTag.merchant_id' => $user['merchant_id'],
                                        'MerchantProductTag.name' => $tagF
                                    )
                                ))[0]['MerchantProductTag']['id'];
                                $categ = $this->MerchantProductCategory->find('all', array(
                                    'conditions' => array(
                                        'MerchantProductCategory.product_tag_id' => $tag_id
                                    )  
                                ));
                                foreach($categ as $ca) {
                                    array_push($product_ids, $ca['MerchantProductCategory']['product_id']);
                                }
                            }
                            $filter['MerchantProduct.id'] = $product_ids;
                        } else {
                            $filter['MerchantProduct.'.$filtering_option_name] = $filtering_option_value;
                        }
                    }
                }
            }
        }

        $filter['MerchantProduct.id <>'] = $discount_id;

        $categories = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('categories',$categories);

        $this->MerchantProduct->bindModel(array(
            'belongsTo' => array(
                'MerchantProductBrand' => array(
                    'className' => 'MerchantProductBrand',
                    'foreignKey' => 'product_brand_id'
                ),
                'MerchantProductType' => array(
                    'className' => 'MerchantProductType',
                    'foreignKey' => 'product_type_id'
                )
            )
        ));

        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductCategory' => array(
                    'className' => 'MerchantProductCategory',
                    'foreignKey' => 'product_id'
                )
            )
        ));

        $this->MerchantProductCategory->bindModel(array(
            'belongsTo' => array(
                'MerchantProductTag' => array(
                    'className' => 'MerchantProductTag',
                    'foreignKey' => 'product_tag_id'
                )
            )
        ));

        $this->MerchantProduct->recursive = 2;

        $items = $this->MerchantProduct->find('all', array(
            'conditions' => $filter
        ));
        $i = 0;
        foreach($items as $item) {
            $items[$i]['Variants'] = array();
            $variants = $this->MerchantProduct->find('all', array(
                'conditions' => array(
                    'MerchantProduct.parent_id' => $items[$i]['MerchantProduct']['id']
                )
            ));
            $items[$i]['Variants'] = $variants;
            $i++;
        }

        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            ),
        ));

        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            ),
        ));

        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            ),
        ));

        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));

        $this->set('items', $items);
        $this->set('suppliers',$suppliers);
        $this->set('types', $types);
        $this->set('brands', $brands);
        $this->set('tags', $tags);
    }

    protected function _uploadFile($id) {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $uploadedFile = $file['tmp_name'];

            if (!empty($uploadedFile)) {
                $ext = explode(".", $file['name']);
                $filename = '/files/products/' . $id . '.' . $ext[1];
                $filepath = WWW_ROOT . 'files/products/' . $id . '.' . $ext[1];
                move_uploaded_file($uploadedFile, $filepath);
                return $filename;
            }
        }
        return false;
    }

    public function add() {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            $dataSource = $this->MerchantProduct->getDataSource();
            $dataSource->begin();

            try {
                // Step 1: add a new product.
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];

                // Added 2015.08.28 (Git changeset : 0611ad8)
                //if($this->MerchantProduct->find('count', array( 'conditions' => array('id' => $data['id']))) > 0){
                //  return;
                //}

                if (isset($data['parent_id']) && empty($data['parent_id'])) {
                    unset($data['parent_id']);
                }

                if (isset($data['product_type_id']) && empty($data['product_type_id'])) {
                    unset($data['product_type_id']);
                }

                if (isset($data['product_brand_id']) && empty($data['product_brand_id'])) {
                    unset($data['product_brand_id']);
                }

                if (isset($data['resource_id']) && empty($data['resource_id'])) {
                    unset($data['resource_id']);
                }

                if (isset($data['supplier_id']) && empty($data['supplier_id'])) {
                    unset($data['supplier_id']);
                }

                if (isset($data['supplier_code']) && empty($data['supplier_code'])) {
                    unset($data['supplier_code']);
                }

                if (isset($data['product_uom']) && empty($data['product_uom'])) {
                    unset($data['product_uom']);
                }

                if (isset($data['supply_price']) && (empty($data['supply_price']) || !is_numeric($data['supply_price']))) {
                    unset($data['supply_price']);
                }

                if (isset($data['markup']) && (empty($data['markup']) || !is_numeric($data['markup']))) {
                    $data['markup'] = null;
                }

                if (isset($data['tax_id']) && empty($data['tax_id'])) {
                    $data['tax_id'] = $this->MerchantTaxRate->findByTaxRate($data['tax'])['MerchantTaxRate']['id'];
                }

                if (isset($data['has_variants']) && $data['has_variants'] == 0 && empty($data['parent_id'])) {
                    unset($data['variant_option_one_name']);
                    unset($data['variant_option_one_value']);
                    unset($data['variant_option_two_name']);
                    unset($data['variant_option_two_value']);
                    unset($data['variant_option_three_name']);
                    unset($data['variant_option_three_value']);
                }

                if (isset($data['stock_type']) && empty($data['stock_type'])) {
                    $data['stock_type'] = "standard";
                }
                
                //Step 1.5: Store the image file
                if ($filename = $this->_uploadFile($this->MerchantProduct->id)) {
                    $data['image'] = $filename;
                    $data['image_large'] = $filename;
                }

                $this->MerchantProduct->create();
                $this->MerchantProduct->save(array('MerchantProduct' => $data));

                // Step 2: add a price of the product to the default price book.
                $this->MerchantPriceBookEntry->create();
                $priceBookEntry['MerchantPriceBookEntry']['price_book_id'] = $user['Merchant']['default_price_book_id'];
                $priceBookEntry['MerchantPriceBookEntry']['product_id'] = $this->MerchantProduct->id;
                $priceBookEntry['MerchantPriceBookEntry']['markup'] = $data['markup'];
                $priceBookEntry['MerchantPriceBookEntry']['price'] = $data['price'];
                $priceBookEntry['MerchantPriceBookEntry']['price_include_tax'] = $data['price_include_tax'];
                $priceBookEntry['MerchantPriceBookEntry']['tax'] = $data['tax'];
                $this->MerchantPriceBookEntry->save($priceBookEntry);

                // Step 3: If track_inventory is active, add the stock of product to the inventory of each outlet.
                if ($data['track_inventory'] == 1) {
                     $inventories = json_decode($data['inventories'], true);
                     foreach ($inventories as $inventory) {
                         if($inventory['count'] == null) {
                             $inventory['count'] = 0;
                         }
                         if($inventory['reorder_point'] == null) {
                             $inventory['reorder_point'] = 0;
                         }
                         if($inventory['restock_level'] == null) {
                             $inventory['restock_level'] = 0;
                         }

                         $inventory['product_id'] = $this->MerchantProduct->id;

                         $this->MerchantProductInventory->create();
                         $this->MerchantProductInventory->save(array('MerchantProductInventory' => $inventory));
                     }
                }

                if(!empty($data['tags']) && isset($data['tags'])) {
                    // Step 4: Save Tags
                    $savedTag = array();
                    $tagArray = json_decode($data['tags'], true);
                    foreach($tagArray as $tag) {
                        $tag_exist = $this->MerchantProductTag->find('first', array(
                            'conditions' => array(
                                'MerchantProductTag.name' => $tag,
                                'MerchantProductTag.merchant_id' => $user['merchant_id']
                            )
                        ));
                        if(empty($tag_exist)) {
                            $this->MerchantProductTag->create();
                        } else {
                            $this->MerchantProductTag->id = $tag_exist['MerchantProductTag']['id'];
                        }
                        $saveTag['MerchantProductTag']['merchant_id'] = $this->Auth->user()['merchant_id'];
                        $saveTag['MerchantProductTag']['name'] = $tag;
                        $this->MerchantProductTag->save($saveTag);
                        array_push($savedTag, $this->MerchantProductTag->id);
                    }
                    
                    // Step 5: Save Category
                    foreach($savedTag as $category) {
                        $this->MerchantProductCategory->create();
                        $saveCategory['MerchantProductCategory']['product_id'] = $this->MerchantProduct->id;
                        $saveCategory['MerchantProductCategory']['product_tag_id'] = $category;
                        $this->MerchantProductCategory->save($saveCategory);
                    }
                }

                //Step 6: Save Composite Attributes
                if ($data['stock_type'] == 'composite') {
                    $products = json_decode($data['composite'], true);
                    foreach($products as $composite) {
                        $this->MerchantProductComposite->create();
                        $saveComposite['MerchantProductComposite']['parent_id'] = $this->MerchantProduct->id;
                        $saveComposite['MerchantProductComposite']['product_id'] = $composite['product_id'];
                        $saveComposite['MerchantProductComposite']['quantity'] = $composite['quantity'];
                        $this->MerchantProductComposite->save($saveComposite);
                    }
                }
                
                //Step 7: Increase SKU Sequence Number
                $this->Merchant->id = $user['merchant_id'];
                $increase->Merchant['sku_sequence'] = $this->Merchant->findById($user['merchant_id'])['Merchant']['sku_sequence'] + 1;
                $this->Merchant->save($increase);

                $dataSource->commit();
                
                if ($this->request->is('ajax')) {
                    $result['success'] = true;
                    $result['product_id'] = $this->MerchantProduct->id;
                } else {
                    $this->redirect('/product/'.$this->MerchantProduct->id);
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                if ($this->request->is('ajax')) {
                    $result['message'] = $e->getMessage();
                } else {
                    $this->Session->setFlash($e->getMessage());
                }
            }

            if ($this->request->is('ajax')) {
                $this->serialize($result);
                return;
            } else {
                $this->set('formData', $this->request->data);
            }
        }
        $this->loadModel("ProductUom");

        $uoms = $this->ProductUom->find('all',array(
                'conditions' =>array(
                    'ProductUom.is_active = 1'
                )
            )
        );
        $this->set('uoms',$uoms);

        
        $this->loadModel("MerchantOutlet");
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
        $this->set("outlets",$outlets);

        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('brands', $brands);

        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('types', $types);

        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('suppliers', $suppliers);

        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags', $tags);

        $taxes = $this->MerchantTaxRate->find('all', array(
            'conditions' => array(
                'MerchantTaxRate.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('taxes', $taxes);

        $variants = $this->MerchantProductVariant->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'MerchantProductVariant.merchant_id IS NULL',
                    'MerchantProductVariant.merchant_id' => $user['merchant_id']
                )
            ),
        ));
        $this->set("variants", $variants);
        
        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array (
                'MerchantProduct.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("items",$items);
        
        $merchant = $this->Merchant->findById($user['merchant_id']);
        $this->set('merchant',$merchant);
        if(isset($_GET['parent_id'])) {
            $parent = $this->MerchantProduct->findById($_GET['parent_id']);
            $this->set('parent', $parent);
        }
    }

    public function edit($id) {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('post')) {
            $result = array(
                'success' => false
            );

            $dataSource = $this->MerchantProduct->getDataSource();
            $dataSource->begin();

            try {
                // Step 1: update the product.
                $data = $this->request->data;
    
                if (isset($data['parent_id']) && empty($data['parent_id'])) {
                    unset($data['parent_id']);
                }

                if (isset($data['product_type_id']) && empty($data['product_type_id'])) {
                    unset($data['product_type_id']);
                }

                if (isset($data['product_brand_id']) && empty($data['product_brand_id'])) {
                    unset($data['product_brand_id']);
                }

                if (isset($data['resource_id']) && empty($data['resource_id'])) {
                    unset($data['resource_id']);
                }

                if (isset($data['supplier_id']) && empty($data['supplier_id'])) {
                    unset($data['supplier_id']);
                }

                if (isset($data['supplier_code']) && empty($data['supplier_code'])) {
                    unset($data['supplier_code']);
                }

                if (isset($data['product_uom']) && empty($data['product_uom'])) {
                    unset($data['product_uom']);
                }

                if (isset($data['supply_price']) && (empty($data['supply_price']) || !is_numeric($data['supply_price']))) {
                    unset($data['supply_price']);
                }

                if (isset($data['markup']) && (empty($data['markup']) || !is_numeric($data['markup']))) {
                    $data['markup'] = null;
                }

                if (isset($data['tax_id']) && empty($data['tax_id'])) {
                    $data['tax_id'] = $this->MerchantTaxRate->findByTaxRate($data['tax'])['MerchantTaxRate']['id'];
                }
                
                if (isset($data['has_variants']) && $data['has_variants'] == 0 && empty($data['parent_id'])) {
                    unset($data['variant_option_one_name']);
                    unset($data['variant_option_one_value']);
                    unset($data['variant_option_two_name']);
                    unset($data['variant_option_two_value']);
                    unset($data['variant_option_three_name']);
                    unset($data['variant_option_three_value']);
                }

                if (isset($data['stock_type']) && empty($data['stock_type'])) {
                    $data['stock_type'] = "standard";
                }
                
                //Step 1.5: Store the image file
                if ($filename = $this->_uploadFile($id)) {
                    $data['image'] = $filename;
                    $data['image_large'] = $filename;
                } else {
                    unset($data['image']);
                }

                $this->MerchantProduct->id = $id;
                $this->MerchantProduct->save(array('MerchantProduct' => $data));

                // Step 2: update the price of the product in the default price book.
                $priceBookEntry = $this->MerchantPriceBookEntry->find('first', array(
                    'conditions' => array(
                        'price_book_id' => $user['Merchant']['default_price_book_id'],
                        'product_id' => $id
                    )
                ));
                if(!empty($priceBookEntry)) {
                    $this->MerchantPriceBookEntry->create();
                } else {
                    $this->MerchantPriceBookEntry->id = $priceBookEntry['MerchantPriceBookEntry']['id'];
                }
                $priceBookEntry['MerchantPriceBookEntry']['markup'] = $data['markup'];
                $priceBookEntry['MerchantPriceBookEntry']['price'] = $data['price'];
                $priceBookEntry['MerchantPriceBookEntry']['price_include_tax'] = $data['price_include_tax'];
                $priceBookEntry['MerchantPriceBookEntry']['tax'] = $data['tax'];
                $this->MerchantPriceBookEntry->save($priceBookEntry);

                // Step 3: If track_inventory is active, update the stock of product in the inventory of each outlet.
                if ($data['track_inventory'] == 1) {
                    $inventories = json_decode($data['inventories'],true);
                    foreach ($inventories as $inventory) {
                        $notNull = $this->MerchantProductInventory->find('first', array(
                            'conditions' => array (
                                'MerchantProductInventory.outlet_id' => $inventory['outlet_id'],
                                'MerchantProductInventory.product_id' => $id
                            )
                        ));
                        if(empty($notNull)) {
                            $this->MerchantProductInventory->create();
                        } else {
                            $this->MerchantProductInventory->id = $notNull['MerchantProductInventory']['id'];
                        }
                        if($inventory['count'] == null) {
                            $inventory['count'] = 0;
                        }
                        if($inventory['reorder_point'] == null) {
                            $inventory['reorder_point'] = 0;
                        }
                        if($inventory['restock_level'] == null) {
                            $inventory['restock_level'] = 0;
                        }
                        $inventory['MerchantProductInventory']['outlet_id'] = $inventory['outlet_id'];
                        $inventory['MerchantProductInventory']['product_id'] = $id;
                        $inventory['MerchantProductInventory']['count'] = $inventory['count'];
                        $inventory['MerchantProductInventory']['reorder_point'] = $inventory['reorder_point'];
                        $inventory['MerchantProductInventory']['restock_level'] = $inventory['restock_level'];
                        $this->MerchantProductInventory->save($inventory);
                        
                        //Setp 3-2: Save log
                        $this->MerchantProductLog->create();
                        $log['MerchantProductLog']['product_id'] = $this->MerchantProduct->id;
                        $log['MerchantProductLog']['user_id'] = $user['id'];
                        $log['MerchantProductLog']['outlet_id'] = $inventory['outlet_id'];
                        $log['MerchantProductLog']['quantity'] = $inventory['count'];
                        $log['MerchantProductLog']['outlet_quantity'] = $inventory['count'];
                        $log['MerchantProductLog']['change'] = $inventory['count'];
                        $log['MerchantProductLog']['action_type'] = 'update';
                        $this->MerchantProductLog->save($log);
                    }
                }

                // Step 4: Save Tags
                if(!empty($data['tags']) && isset($data['tags'])){
                    $savedTag = array();
                    $tagArray = json_decode($data['tags'],true);
                    foreach($tagArray as $tag) {
                        $tag_exist = $this->MerchantProductTag->find('first', array(
                            'conditions' => array(
                                'MerchantProductTag.name' => $tag,
                                'MerchantProductTag.merchant_id' => $user['merchant_id']
                            )
                        ));
                        if(empty($tag_exist)) {
                            $this->MerchantProductTag->create();
                        } else {
                            $this->MerchantProductTag->id = $tag_exist['MerchantProductTag']['id'];
                        }
                        $saveTag['MerchantProductTag']['merchant_id'] = $user['merchant_id'];
                        $saveTag['MerchantProductTag']['name'] = $tag;
                        $this->MerchantProductTag->save($saveTag);
                        array_push($savedTag, $this->MerchantProductTag->id);
                    }
    
                    // Setp 5: Save Category
                    $category_refresh = $this->MerchantProductCategory->find('all',array(
                        'conditions' => array(
                            'MerchantProductCategory.product_id' => $id
                        )
                    ));
                    if(!empty($category_refresh) && is_array($category_refresh)) {
                        foreach($category_refresh as $toDelete) {
                            $this->MerchantProductCategory->delete($toDelete['MerchantProductCategory']['id']);
                        }
                    }
                    
                    foreach($savedTag as $category) {
                        $this->MerchantProductCategory->create();
                        $saveCategory['MerchantProductCategory']['product_id'] = $this->MerchantProduct->id;
                        $saveCategory['MerchantProductCategory']['product_tag_id'] = $category;
                        $this->MerchantProductCategory->save($saveCategory);
                    }
                } else {
                    $category_exist = $this->MerchantProductCategory->find('all',array(
                        'conditions' => array(
                            'MerchantProductCategory.product_id' => $id
                        )
                    ));
                    if(!empty($category_exist) && is_array($category_exist)) {
                        foreach($category_exist as $toDelete) {
                            $this->MerchantProductCategory->delete($toDelete['MerchantProductCategory']['id']);
                        }
                    }
                }

                //Step 6: Save Composite Attributes
                if($data['stock_type'] == 'composite') {
                    foreach($data['composite'] as $composite) {
                        $composite_exist = $this->MerchantProductComposite->find('first', array(
                            'conditions' => array(
                                'MerchantProductComposite.product_id' => $composite['product_id'],
                                'MerchantProductComposite.parent_id' => $id
                            )
                        ));
                        if(empty($composite_exist)) {
                            $this->MerchantProductComposite->create();
                        } else {
                            $this->MerchantProductComposite->id = $composite_exist['MerchantProductComposite']['id'];
                        }
                        $saveComposite['MerchantProductComposite']['parent_id'] = $this->MerchantProduct->id;
                        $saveComposite['MerchantProductComposite']['product_id'] = $composite['product_id'];
                        $saveComposite['MerchantProductComposite']['quantity'] = $composite['quantity'];
                        $this->MerchantProductComposite->save($saveComposite);
                    }
                }
                
                //Step 7: Update its own variants
                $variants = $this->MerchantProduct->find('all', array(
                    'conditions' => array(
                        'MerchantProduct.parent_id' => $id
                    )
                ));
                if(!empty($variants)) {
                    unset($data['supply_price']);
                    unset($data['markup']);
                    unset($data['price']);
                    unset($data['price_include_tax']);
                    unset($data['tax']);
                    unset($data['variant_option_one_value']);
                    unset($data['variant_option_two_value']);
                    unset($data['variant_option_three_value']);
                    unset($data['sku']);
                    unset($data['track_inventory']);
                    unset($data['stock_type']);
                    unset($data['is_active']);
                    if($data['variant_option_two_name'] == '') {
                        $data['variant_option_two_value'] = '';
                    }
                    if($data['variant_option_three_name'] == '') {
                        $data['variant_option_three_value'] = '';
                    }
                    if($data['has_variants'] == 0) {
                        foreach($variants as $variant) {
                            $this->MerchantProduct->delete($variant['MerchantProduct']['id']);
                        }
                    } else {
                        $data['has_variants'] = 0;
                        foreach($variants as $variant) {
                            $this->MerchantProduct->id = $variant['MerchantProduct']['id'];
                            $this->MerchantProduct->save($data);
                        }
                    }
                }
                
                $dataSource->commit();

                if ($this->request->is('ajax')) {
                    $result['success'] = true;
                    $result['product_id'] = $this->MerchantProduct->id;
                } else {
                    $this->redirect('/product/'.$id);
                }
            } catch (Exception $e) {
                $dataSource->rollback();
                if ($this->request->is('ajax')) {
                    $result['message'] = $e->getMessage();
                } else {
                    $this->Session->setFlash($e->getMessage());
                }
            }
            if ($this->request->is('ajax')) {
                $this->serialize($result);
                return;
            } else {
                $this->set('formData', $this->request->data);
            }
        }
        
        $this->loadModel("ProductUom");
        $this->loadModel("ProductUomCategory");
        
//        $this->ProductUomCategory->bindModel(array(
//            'hasMany' => array(
//                'ProductUom' => array(
//                    'className' => 'ProductUom',
//                    'foreignKey' => 'category_id'
//                )
//            )
//        ));
        $uoms = $this->ProductUom->find('all',array(
          'conditions' =>array(
            'ProductUom.is_active = 1'
            )
          )
        );
        $this->set('uoms',$uoms);
        
        $categories = $this->MerchantProductTag->find('all', array(
            'joins' => array(
                array(
                    'table' => 'merchant_product_categories',
                    'alias' => 'MerchantProductCategory',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProductCategory.product_tag_id = MerchantProductTag.id',
                        'MerchantProductCategory.product_id' => $id
                    )
                )
            )
        ));
        $this->set("categories", $categories);

        $composites = $this->MerchantProductComposite->find('all', array(
            'fields' => array(
                'MerchantProduct.*',
                'MerchantProductComposite.*'
            ),
            'conditions' => array(
                'MerchantProductComposite.parent_id' => $id
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
            )
        ));
        $this->set('composites',$composites);

        $product = $this->MerchantProduct->findById($id);
        $this->set('product', $product);
        $this->set('id', $id);

        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('brands', $brands);

        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('types', $types);

        $items = $this->MerchantProduct->find('all', array(
            'conditions' => array (
                'MerchantProduct.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set("items",$items);

        $this->MerchantOutlet->bindModel(array(
            'hasOne' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'outlet_id',
                    'conditions' => array (
                        'MerchantProductInventory.product_id' => $id
                    )
                )
            )
        ));
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array (
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);

        $suppliers = $this->MerchantSupplier->find('all', array(
            'conditions' => array(
                'MerchantSupplier.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('suppliers', $suppliers);

        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('tags', $tags);

        $taxes = $this->MerchantTaxRate->find('all', array(
            'conditions' => array(
                'MerchantTaxRate.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('taxes', $taxes);

        $variants = $this->MerchantProductVariant->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'MerchantProductVariant.merchant_id IS NULL',
                    'MerchantProductVariant.merchant_id' => $user['merchant_id']
                )
            ),
        ));
        $this->set("variants", $variants);

    }

    public function view($id) {
        $user = $this->Auth->user();
    
        $this->loadModel("RegisterSaleItem");
        $this->loadModel("RegisterSale");
        $this->loadModel("MerchantUser");
        
        $this->MerchantProductLog->bindModel(array(
            'belongsTo' => array(
                'MerchantUser' => array(
                    'className' => 'MerchantUser',
                    'foreignKey' => 'user_id'
                ),
                'MerchantOutlet' => array(
                    'className' => 'MerchantOutlet',
                    'foreignKey' => 'outlet_id'
                )
            )
        ));
        
        $criteria = array(
            'MerchantProductLog.product_id' => $id
        );
        
        if(isset($_GET)) {
            foreach($_GET as $key => $value) {
                if(!empty($value)) {
                    if($key == "from") {
                        $criteria['MerchantProductLog.created >='] = $value;
                    } else if($key == "to") {
                        $criteria['MerchantProductLog.created <='] = $value;
                    } else {
                        $criteria['MerchantProductLog.'.$key] = $value;
                    }
                }
            }
        }
        
        $logs = $this->MerchantProductLog->find('all', array(
            'conditions' => $criteria,
            'order' => array('MerchantProductLog.created DESC')
        ));
        $this->set('logs',$logs);

        $users = $this->MerchantUser->find('all', array(
            'conditions' => array(
                'MerchantUser.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('users',$users);
        
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $user['merchant_id']
            )
        ));
        $this->set('outlets',$outlets);

        $this->MerchantProduct->bindModel(array(
            'belongsTo' => array(
                'MerchantProductType' => array(
                    'className' => 'MerchantProductType',
                    'foreignKey' => 'product_type_id'
                ),
                'MerchantProductBrand' => array(
                    'className' => 'MerchantProductBrand',
                    'foreignKey' => 'product_brand_id'
                ),
                'MerchantSupplier' => array(
                    'className' => 'MerchantSupplier',
                    'foreignKey' => 'supplier_id'
                ),
            )
        ));

        $product = $this->MerchantProduct->findById($id);
        $this->set("product", $product);
        $this->set("id", $id);
        
        $this->MerchantProduct->bindModel(array(
            'hasMany' => array(
                'MerchantProductInventory' => array(
                    'className' => 'MerchantProductInventory',
                    'foreignKey' => 'product_id'
                )
            )
        ));
        
        $children = $this->MerchantProduct->find('all', array(
            'conditions' => array(
                'MerchantProduct.parent_id' => $id
            )
        ));
        $this->set("children",$children);
        
        $inventories = $this->MerchantProductInventory->find('all', array(
            'fields' => array(
                'MerchantProductInventory.*',
                'MerchantOutlet.*',
            ),
            'conditions' => array(
                'MerchantProductInventory.product_id' => $id
            ),
            'joins' => array(
                array(
                    'table' => 'merchant_outlets',
                    'alias' => 'MerchantOutlet',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProductInventory.outlet_id = MerchantOutlet.id',
                    )
                )
            )
        ));
        $this->set('inventories',$inventories);

        $tags = $this->MerchantProductTag->find('all', array(
            'joins' => array(
                array(
                    'table' => 'merchant_product_categories',
                    'alias' => 'MerchantProductCategory',
                    'type' => 'INNER',
                    'conditions' => array(
                        'MerchantProductCategory.product_tag_id = MerchantProductTag.id',
                        'MerchantProductCategory.product_id' => $id
                    )
                )
            )
        ));
        $this->set("tags", $tags);
    }

    public function delete($id) {

        $this->MerchantProduct->delete($id);

        header("Location: /product");
        die();

    }

    public function brand() {
        $brands = $this->MerchantProductBrand->find('all', array(
            'conditions' => array(
                'MerchantProductBrand.merchant_id' => $this->Auth->user()['merchant_id']
            ),
        ));
        $this->set('brands',$brands);

        if ($this->request->is('post') || $this->request->is('ajax')) {

            $this->layout = 'ajax';

            if($_POST['id']){
            
                if(count($this->request->data) > 1){
                    $this->MerchantProductBrand->id = $_POST['id'];
                    $productBrand['name'] = $_POST['product_brand_name'];
                    $productBrand['description'] = $_POST['product_brand_desc'];
                    $this->MerchantProductBrand->save($productBrand);
                } else {
                    $this->MerchantProductBrand->delete($_POST['id']);
                }
                
            } else {
                $this->MerchantProductBrand->create();
                $productBrand['merchant_id'] = $this->Auth->user()['merchant_id'];
                $productBrand['name'] = $_POST['product_brand_name'];
                $productBrand['description'] = $_POST['product_brand_desc'];
                $this->MerchantProductBrand->save($productBrand);
    
                $result = array();
                $result['id'] = $this->MerchantProductBrand->id;
                $result['name'] = $_POST['product_brand_name'];
                $this->serialize($result);
            }
        }
    }

    public function brand_quick() {
        if($this->request->is('post')){
            $result = array();
            try {
                $this->MerchantProductBrand->create();
                $productBrand['merchant_id'] = $this->Auth->user()['merchant_id'];
                $productBrand['name'] = $_POST['product_brand_name'];
                $productBrand['description'] = $_POST['product_brand_desc'];
                $this->MerchantProductBrand->save($productBrand);
                
                $result['id'] = $this->MerchantProductBrand->id;
                $result['name'] = $_POST['product_brand_name'];
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }
    
    public function type_edit(){
     
        if($this->request->is('post')) {
            $result = array();
            try {
                $this->MerchantProductType->id = $_POST['id'];
                $productType['name'] = $_POST['product_type_name'];
                $this->MerchantProductType->save($productType);
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
        
    }
    public function type_delete(){
    
        $result = array();
        try {
            $this->MerchantProductType->delete($_POST['to_delete']);
        } catch  (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);

    }

    public function type() {

        if ($this->request->is('post') || $this->request->is('ajax')) {

            $this->layout = 'ajax';

            $result = array();
            try {
                $this->MerchantProductType->create();
                $productType['merchant_id'] = $this->Auth->user()['merchant_id'];
                $productType['name'] = $_POST['product_type_name'];
                $this->MerchantProductType->save($productType);
                $result['id'] = $this->MerchantProductType->id;
                $result['name'] = $_POST['product_type_name'];
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
                
            return;

        }
        
        $this->MerchantProductType->bindModel(array(
            'hasMany' => array(
                'MerchantProduct' => array(
                    'className' => 'MerchantProduct',
                    'foreignKey' => 'product_type_id'
                )
            ),
        ));
    
        $types = $this->MerchantProductType->find('all', array(
            'conditions' => array(
                'MerchantProductType.merchant_id' => $this->Auth->user()['merchant_id']
            ),
        ));
        $this->set('types',$types);

    }

    public function type_quick() {
        $result = array();
        try {
            $this->MerchantProductType->create();
            $productType['merchant_id'] = $this->Auth->user()['merchant_id'];
            $productType['name'] = $_POST['product_type_name'];
            $this->MerchantProductType->save($productType);
            $result['id'] = $this->MerchantProductType->id;
            $result['name'] = $_POST['product_type_name'];
        } catch  (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        $this->serialize($result);
    }

    public function price_book() {
    }

    public function supplier() {
    }

    public function tag() {
        $user = $this->Auth->user();
    
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];
                $this->MerchantProductTag->create();
                $this->MerchantProductTag->save($data);
                
                $result['success'] = true;
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
            
            return;
        }
    
        $this->MerchantProductTag->bindModel(array(
            'hasMany' => array(
                'MerchantProductCategory' => array(
                    'className' => 'MerchantProductCategory',
                    'foreignKey' => 'product_tag_id'
                )
            ),
        ));
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $user['merchant_id']
            ),
        ));
        $this->set('tags',$tags);
        
    }
    
    public function tag_edit(){
        $user = $this->Auth->user();
        
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                
                $this->MerchantProductTag->id = $data['tag_id'];
                $this->MerchantProductTag->save($data);
                
                $result['success'] = true;
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }
    
    public function tag_delete() {
        $user = $this->Auth->user();
        
        if($this->request->is('post') || $this->request->is('ajax')) {
            $result = array(
                'success' => false
            );
            try {
                $data = $this->request->data;
                
                $this->MerchantProductTag->delete($data['tag_id']);
                
                $result['success'] = true;
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }
    
    function addpics() {
        $tempFile = $_FILES['file']['tmp_name'];
        $targetPath = getcwd() . '/test/';
        $targetFile =  $targetPath. $FILES['file']['name'];
        move_uploaded_file($tempFile,$targetFile);
    }
    
    public function change_status() {
        $user = $this->Auth->user();
        if($this->request->is('post')) {
            $data = $this->request->data;
            $result = array(
                'success' => false
            );
            try {
                $this->MerchantProduct->id = $data['product_id'];
                $this->MerchantProduct->save($data);
                
                $result['success'] = true;
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

    public function add_variants() {
        $result = array();
        if($this->request->is('post')) {

            try {
                $data = $this->request->data;
                $this->MerchantProductVariant->create();
                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                $this->MerchantProductVariant->save($data);
                $result['id'] = $this->MerchantProductVariant->id;
                $result['name'] = $data['name'];
                $result['default_value'] = $data['default_value'];
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }
    
    public function check_variants() {
        if($this->request->is('post')) {
            $result = array(
                'success' => false
            );
            try {
                $children = $this->MerchantProduct->find('all', array(
                    'conditions' => array(
                        'MerchantProduct.parent_id' => $_POST['product_id']
                    )
                ));
                $result['data'] = $children;
                $result['success'] = true;
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
