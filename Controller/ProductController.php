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
 * This controller uses MerchantProduct, MerchantProductType, MerchantProductBrand, MerchantProductTag,
 *  MerchantTaxRate, MerchantSupplier, MerchantProductTag, MerchantVariant and MerchantProductInventory models.
 *
 * @var array
 */
    public $uses = array('MerchantProduct', 'MerchantProductType', 'MerchantProductBrand', 'MerchantProductTag',
        'MerchantTaxRate', 'MerchantSupplier', 'MerchantProductCategory', 'MerchantPriceBookEntry', 'MerchantVariant', 'MerchantProductInventory', 'MerchantOutlet', 'MerchantProductComposite');

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
        
        $this->MerchantProduct->bindModel(array(
            'belongsTo' => array(
                'MerchantProductBrand' => array(
                    'className' => 'MerchantProductBrand',
                    'foreignKey' => 'product_brand_id'
                )
            )
        ));
        
        $this->MerchantProduct->bindModel(array(
            'belongsTo' => array(
                'MerchantProductType' => array(
                    'className' => 'MerchantProductType',
                    'foreignKey' => 'product_type_id'
                )
            )
        ));
        
        if (empty($_GET['supplier'])) {
            $items = $this->MerchantProduct->find('all', array(
                'conditions' => array(
                    'MerchantProduct.merchant_id' => $user['merchant_id']
                ),
            ));
        } else {
            $items = $this->MerchantProduct->find('all', array(
                'conditions' => array(
                    'MerchantProduct.merchant_id' => $user['merchant_id'],
                    'MerchantProduct.supplier_id' => $_GET['supplier']
                ),
            ));
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

        $this->set('items', $items);
        $this->set('suppliers',$suppliers);
        $this->set('types', $types);
        $this->set('brands', $brands);
    }

    public function add() {
        $user = $this->Auth->user();
        
        $this->loadModel("MerchantOutlet");
        $outlets = $this->MerchantOutlet->find('all', array(
            'conditions' => array(
                'MerchantOutlet.merchant_id' => $this->Auth->user()['merchant_id']
            )
        ));
        $this->set("outlets",$outlets);

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
                     $inventories = $data['inventories'];
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
                         $inventory['MerchantProductInventory']['outlet_id'] = $inventory['outlet_id'];
                         $inventory['MerchantProductInventory']['product_id'] = $this->MerchantProduct->id;
                         $inventory['MerchantProductInventory']['count'] = $inventory['count'];
                         $inventory['MerchantProductInventory']['reorder_point'] = $inventory['reorder_point'];
                         $inventory['MerchantProductInventory']['restock_level'] = $inventory['restock_level'];
                         $this->MerchantProductInventory->save($inventory);
                     }
                }
                
                if(json_decode($data['tags'])[0] !== "") {
                    // Step 4: Save Tags
                    $savedTag = array();
                    
                    foreach(json_decode($data['tags']) as $tag) {
                        $tag_exist = $this->MerchantProductTag->find('first', array(
                            'conditions' => array(
                                'MerchantProductTag.name' => $tag,
                                'MerchantProductTag.merchant_id' => $user['merchant_id']
                            )
                        ));
                        $this->MerchantProductTag->id = $tag_exist['MerchantProductTag']['id'];
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
                if($data['stock_type'] == 'composite') {
                    foreach($data['composite'] as $composite) {
                        $this->MerchantProductComposite->create();
                        $saveComposite['MerchantProductComposite']['parent_id'] = $this->MerchantProduct->id;
                        $saveComposite['MerchantProductComposite']['product_id'] = $composite['product_id'];
                        $saveComposite['MerchantProductComposite']['quantity'] = $composite['quantity'];
                        $this->MerchantProductComposite->save($saveComposite);
                    }
                }
                
                $result['success'] = true;
                $result['product_id'] = $this->MerchantProduct->id;
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }

            $this->serialize($result);
            return;
        }

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

        $variants = $this->MerchantVariant->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'MerchantVariant.merchant_id IS NULL',
                    'MerchantVariant.merchant_id' => $user['merchant_id']
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
    }

    public function edit($id) {
        $user = $this->Auth->user();

        if ($this->request->is('ajax') || $this->request->is('put')) {
            $result = array(
                'success' => false
            );

            $dataSource = $this->MerchantProduct->getDataSource();
            $dataSource->begin();

            try {
                // Step 1: update the product.
                $data = $this->request->data;
                $data['merchant_id'] = $user['merchant_id'];

                $this->MerchantProduct->id = $id;
                $this->MerchantProduct->save(array('MerchantProduct' => $data));

                // Step 2: update the price of the product in the default price book.
                $priceBookEntry = $this->MerchantPriceBookEntry->find('first', array(
                    'conditions' => array(
                        'price_book_id' => $user['Merchant']['default_price_book_id'],
                        'product_id' => $id
                    )
                ));
                $priceBookEntry['MerchantPriceBookEntry']['markup'] = $data['markup'];
                $priceBookEntry['MerchantPriceBookEntry']['price'] = $data['price'];
                $priceBookEntry['MerchantPriceBookEntry']['price_include_tax'] = $data['price_include_tax'];
                $priceBookEntry['MerchantPriceBookEntry']['tax'] = $data['tax'];
                $this->MerchantPriceBookEntry->save($priceBookEntry);

                // Step 3: If track_inventory is active, update the stock of product in the inventory of each outlet.
                if ($data['track_inventory']) {
                    $inventories = $data['inventories'];
                    foreach ($inventories as $inventory) {
                        $notNull = $this->MerchantProductInventory->find('first', array(
                            'conditions' => array (
                                'MerchantProductInventory.outlet_id' => $inventory['outlet_id'],
                                'MerchantProductInventory.product_id' => $id
                            )
                        ));
                        $this->MerchantProductInventory->id = $notNull['MerchantProductInventory']['id'];
                        $inventory['MerchantProductInventory']['outlet_id'] = $inventory['outlet_id'];
                        $inventory['MerchantProductInventory']['product_id'] = $id;
                        $inventory['MerchantProductInventory']['count'] = $inventory['count'];
                        $inventory['MerchantProductInventory']['reorder_point'] = $inventory['reorder_point'];
                        $inventory['MerchantProductInventory']['restock_level'] = $inventory['restock_level'];
                        $this->MerchantProductInventory->save($inventory);
                    }
                } else {
                }

                // Step 4: Save Tags
                if(json_decode($data['tags'])[0] !== ""){
                    $savedTag = array();
                    foreach(json_decode($data['tags']) as $tag) {
                        $tag_exist = $this->MerchantProductTag->find('first', array(
                            'conditions' => array(
                                'MerchantProductTag.name' => $tag,
                                'MerchantProductTag.merchant_id' => $user['merchant_id']
                            )
                        ));
                        $this->MerchantProductTag->id = $tag_exist['MerchantProductTag']['id'];
                        $saveTag['MerchantProductTag']['merchant_id'] = $user['merchant_id'];
                        $saveTag['MerchantProductTag']['name'] = $tag;
                        $this->MerchantProductTag->save($saveTag);
                        array_push($savedTag, $this->MerchantProductTag->id);
                    }
    
                    // Setp 5: Save Category
                    foreach($savedTag as $category) {
                        $category_exist = $this->MerchantProductCategory->find('first',array(
                            'conditions' => array(
                                'MerchantProductCategory.product_tag_id' => $category,
                                'MerchantProductCategory.product_id' => $id
                            )
                        ));
                        $this->MerchantProductCategory->id = $category_exist['MerchantProductCategory']['id'];
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
                    foreach($category_exist as $toDelete) {
                        $this->MerchantProductCategory->delete($toDelete['MerchantProductCategory']['id']);
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
                        $this->MerchantProductComposite->id = $composite_exist['MerchantProductComposite']['id'];
                        $saveComposite['MerchantProductComposite']['parent_id'] = $this->MerchantProduct->id;
                        $saveComposite['MerchantProductComposite']['product_id'] = $composite['product_id'];
                        $saveComposite['MerchantProductComposite']['quantity'] = $composite['quantity'];
                        $this->MerchantProductComposite->save($saveComposite);
                    }
                }

                $result['success'] = true;
                $result['data'] = $data['composite'];
                $result['product_id'] = $this->MerchantProduct->id;
                $dataSource->commit();
            } catch (Exception $e) {
                $dataSource->rollback();
                $result['message'] = $e->getMessage();
            }
            

            $this->serialize($result);
            return;
        }
        
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

        $variants = $this->MerchantVariant->find('all', array(
            'conditions' => array(
                'OR' => array(
                    'MerchantVariant.merchant_id IS NULL',
                    'MerchantVariant.merchant_id' => $user['merchant_id']
                )
            ),
        ));
        $this->set("variants", $variants);
        
    }

    public function view($id) {
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
    
        $this->MerchantProductTag->bindModel(array(
            'hasMany' => array(
                'MerchantProudctCategory' => array(
                    'className' => 'MerchantProductCategory',
                    'foreignKey' => 'product_tag_id'
                )
            ),
        ));
        $tags = $this->MerchantProductTag->find('all', array(
            'conditions' => array(
                'MerchantProductTag.merchant_id' => $this->Auth->user()['merchant_id']
            ),
        ));
        $this->set('tags',$tags);
        
    }
    
    function addpics() {
        $tempFile = $_FILES['file']['tmp_name'];
        $targetPath = getcwd() . '/test/';
        $targetFile =  $targetPath. $FILES['file']['name'];
        move_uploaded_file($tempFile,$targetFile);
    }

    public function add_variants() {
        $this->loadModel('MerchantVariant');
        $result = array();
        if($this->request->is('post')) {

            try {
                $data = $this->request->data;
                $this->MerchantVariant->create();
                $data['merchant_id'] = $this->Auth->user()['merchant_id'];
                $this->MerchantVariant->save($data);
                $result['id'] = $this->MerchantVariant->id;
                $result['name'] = $data['name'];
                $result['default_value'] = $data['default_value'];
            } catch  (Exception $e) {
                $result['message'] = $e->getMessage();
            }
            $this->serialize($result);
        }
    }

}
