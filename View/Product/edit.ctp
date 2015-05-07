<style>
.line-box-stitle {
    padding: 8px 20px;
}
.help-block {
    padding-left: 14px;
}
.variant_add {
    float: left;
    padding-top: 12px;
    margin-left: 29px;
    font-size: 12px;
    color: blue;
    text-decoration: underline;
}
.variant_max {
    float: left;
    padding-top: 12px;
    margin-left: 29px;
    font-size: 12px;
}
.variant_add:hover {
    cursor: pointer;
}
</style>

<link href="/css/dropzone.css" rel="stylesheet" type="text/css"/>
<link href="/css/loader.css" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" type="text/css" href="/assets/global/plugins/select2/select2.css"/>
<div class="clearfix"> </div>
<!-- BEGIN CONTAINER -->
<div class="page-container">
    <div id="loader-wrapper" style="display:none">
        <div id="loader"></div>
    </div>
  <div id="notify"></div>
  <!-- BEGIN SIDEBAR -->
  <div class="page-sidebar-wrapper"> 
    <!-- BEGIN HORIZONTAL RESPONSIVE MENU --> 
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing --> 
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
      <ul class="page-sidebar-menu" data-slide-speed="200" data-auto-scroll="true">
        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element --> 
        <!-- DOC: This is mobile version of the horizontal menu. The desktop version is defined(duplicated) in the header above -->
        <li class="sidebar-search-wrapper"> 
          <!-- BEGIN RESPONSIVE QUICK SEARCH FORM --> 
          <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box --> 
          <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
          <form class="sidebar-search sidebar-search-bordered" action="extra_search.html" method="POST">
            <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
              <button class="btn submit"><i class="icon-magnifier"></i></button>
              </span> </div>
          </form>
          <!-- END RESPONSIVE QUICK SEARCH FORM --> 
        </li>
        <li> <a href="index"> Sell </a> </li>
        <li> <a href="history"> History </a> </li>
        <li class="active"> <a href="history"> Product <span class="selected"></span> </a> </li>
      </ul>
    </div>
    <!-- END HORIZONTAL RESPONSIVE MENU --> 
  </div>
  <!-- END SIDEBAR --> 
  <!-- BEGIN CONTENT -->
  <div class="page-content-wrapper">
    <div class="page-content">
      <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
        <h2 class="pull-left col-md-7 col-xs-7 col-sm-7 col-alpha col-omega"> Edit Product </h2>
      </div>
      <input type="hidden" id="parent_id" value="<?php if(!empty($product['MerchantProduct']['parent_id'])){echo $product['MerchantProduct']['parent_id'];}?>"/>
      <form action="<?php echo $_SERVER['REQUEST_URI'];?>" class="portlet box product-add product-form" method="post" id="product-form" enctype="multipart/form-data">
        <div class="portlet-body form"> 
          <!-- BEGIN FORM-->
          <div class="form-horizontal">
            <?php if(!empty($product['MerchantProduct']['parent_id'])) { ?>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Variants</div>
            <!-- START col-md-12-->
            <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega" style="padding:0;padding-bottom:15px;"> 
                <!-- START col-md-12-->
                <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega variant_attr">
                    <div id="first_variant_attr" class="col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <table class="col-md-5 col-sm-5">
                            	<tr>
                            		<th>Attribute</th><th>Value</th>
                            	</tr>
                            	<?php if(!empty($product['MerchantProduct']['variant_option_one_name'])) { ?>
                            	<input type="hidden" class="variant_value_1" value="<?php echo $product['MerchantProduct']['variant_option_one_name'];?>">
                            	<tr>
                            		<td><?php echo $product['MerchantProduct']['variant_option_one_name'];?></td><td><input type="text" class="variant_default_1" value="<?php echo $product['MerchantProduct']['variant_option_one_value'];?>"></td>
                            	</tr>
                            	<?php } ?>
                            	<?php if(!empty($product['MerchantProduct']['variant_option_two_name'])) { ?>
                            	<input type="hidden" class="variant_value_2" value="<?php echo $product['MerchantProduct']['variant_option_two_name'];?>">
                            	<tr>
                            		<td><?php echo $product['MerchantProduct']['variant_option_two_name'];?></td><td><input type="text" class="variant_default_2" value="<?php echo $product['MerchantProduct']['variant_option_two_value'];?>"></td>
                            	</tr>
                            	<?php } ?>
                            	<?php if(!empty($product['MerchantProduct']['variant_option_three_name'])) { ?>
                            	<input type="hidden" class="variant_value_3" value="<?php echo $product['MerchantProduct']['variant_option_three_name'];?>">
                            	<tr>
                            		<td><?php echo $product['MerchantProduct']['variant_option_three_name'];?></td><td><input type="text" class="variant_default_3" value="<?php echo $product['MerchantProduct']['variant_option_three_value'];?>"></td>
                            	</tr>
                            	<?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- END col-md-12-->
            </div>
            <?php } ?>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title" <?php if(!empty($product['MerchantProduct']['parent_id'])) {echo 'style="display: none;"';} ?>>Detail</div>
            <!-- START col-md-12-->
            <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega" <?php if(!empty($product['MerchantProduct']['parent_id'])) {echo 'style="display: none;"';} ?>>
              <div class="col-md-6">
                  <dl class="form-group">
                    <dt class="col-md-3">Product name</dt>
                    <dd class="col-md-9">
                      <input type="text" class="form-control required" id="product_name" value="<?=$product['MerchantProduct']['name'];?>">
                      <span class="help-block">
                      <input type="checkbox" id="availability" value="1" <?php if($product['MerchantProduct']['is_active'] == 1){echo "checked";}?>>
                      This product can be sold </span> </dd>
                  </dl>
                </div>
                <div class="col-md-6">
                  <dl class="form-group">
                    <dt class="col-md-3">Product handle</dt>
                    <dd class="col-md-9">
                      <input type="text" class="form-control required" id="product_handle" value="<?=$product['MerchantProduct']['handle'];?>">
                      <span class="help-block"> A unique identifier for this product </span> </dd>
                  </dl>
                </div> 
              <!-- START col-md-12-->
              <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega"> 
                <!-- START col-md-6-->
                <div class="col-md-6">
                  <dl class="form-group">
                    <dt class="col-md-3">Product type</dt>
                    <dd class="col-md-9">
                      <select class="form-control" id="product_type_id">
                          <option value=""></option>
                        <?php foreach($types as $type){?>
                            <option value="<?=$type['MerchantProductType']['id'];?>" <?php if($type['MerchantProductType']['id'] == $product['MerchantProduct']['product_type_id']){echo "selected";}?>><?=$type['MerchantProductType']['name'];?></option>
                        <?php } ?>
                        <option value="add-type">+ Add type</option>
                      </select>
                    </dd>
                  </dl>
                  <dl class="form-group">
                    <dt class="col-md-3">Supplier</dt>
                    <dd class="col-md-9">
                      <select class="form-control" id="product_supplier_id">
                        <option></option>
                        <?php foreach($suppliers as $supplier){?>
                            <option value="<?=$supplier['MerchantSupplier']['id'];?>" <?php if($supplier['MerchantSupplier']['id'] == $product['MerchantProduct']['supplier_id']){echo "selected";}?>><?=$supplier['MerchantSupplier']['name'];?></option>
                        <?php } ?>
                        <option value="add-supplier">+ Add supplier</option>
                      </select>
                    </dd>
                  </dl>
                </div>
                <!-- END col-md-6--> 
                <!-- START col-md-6-->
                <div class="col-md-6">
                  <dl class="form-group">
                    <dt class="col-md-3">Product brand</dt>
                    <dd class="col-md-9">
                      <select class="form-control" id="product_brand_id">
                          <option value=""></option>
                          <?php foreach($brands as $brand){?>
                            <option value="<?=$brand['MerchantProductBrand']['id'];?>" <?php if($brand['MerchantProductBrand']['id'] == $product['MerchantProduct']['product_brand_id']){echo "selected";}?>><?=$brand['MerchantProductBrand']['name'];?></option>
                        <?php } ?>
                        <option value="add-brand">+ Add brand</option>
                      </select>
                    </dd>
                  </dl>
                  <dl class="form-group">
                    <dt class="col-md-3">Supplier code</dt>
                    <dd class="col-md-9">
                      <input type="text" class="form-control" id="supplier_code" value="<?=$product['MerchantProduct']['supplier_code'];?>">
                    </dd>
                  </dl>
                  <dl class="form-group">
                    <dt class="col-md-3">Unit</dt>
                    <dd class="col-md-9">
                      <select id="product_uom">
                          <option selected></option>
                          <?php foreach($uoms as $uom) { ?>
                            <optgroup label="<?php echo $uom['ProductUomCategory']['name'];?>">
                                <?php foreach($uom['ProductUom'] as $unit) { ?>
                                    <option value="<?php echo $unit['id'];?>"><?php echo $unit['name'].' ('.$unit['symbol'].')';?></option>
                                <?php }
                          } ?>
                      </select>
                    </dd>
                  </dl>
                </div>
                <!-- END col-md-6--> 
              </div>
              <!-- END col-md-12-->
              <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega dashed-line-gr"></div>
              <!-- START col-md-12-->
              <div class="col-md-6 col-xs-6 col-sm-6 col-alpha col-omega margin-top-20"> 
                <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                  <dl>
                    <dt class="col-md-4 height-inherit">Description</dt>
                    <dd class="col-md-8 height-inherit">
                      <textarea id="product_description" style="width:100%" rows="5"><?php echo $product['MerchantProduct']['description'];?></textarea>
                    </dd>
                  </dl>
                </div>
              </div>
              <div class="col-md-6 col-xs-6 col-sm-6 margin-top-20">
                  <dl class="form-group">
                    <dt class="col-md-4">Images</dt>
                    <dd class="col-md-8">
                        <input name="file" type="file">
<!--
                        <div class="dropzone" id="drop-file">
                          <div class="fallback">
                            <input name="file" type="file">
                          </div>
                        </div>
-->
                    </dd>
                  </dl>
              </div>
              <!-- END col-md-12-->
              <div class="dashed-line-gr"></div>
              <div class="col-md-12 col-alpha col-omega">
                  <dl>
                    <dt class="col-md-2">Product tags</dt>
                    <input type="hidden" id="tag_list" value='<?php echo json_encode($tags);?>'>
                    <dd class="col-md-10 col-alpha">
                      <input type="hidden" class="form-control select2_sample3 product_tag" value="<?php 
                      $i=0;
                      foreach($categories as $category){
                          if($i == 0){
                              echo $category['MerchantProductTag']['name'];
                              $i++;
                          } else {
                              echo ','.$category['MerchantProductTag']['name'];
                          }
                      }?>">
                    </dd>
                  </dl>
              </div>
              <!-- END col-md-12-->
            </div>
            <!-- END col-md-12-->
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Pricing</div>
            <!-- START col-md-12-->
            <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega"> 
              <!-- START col-md-12-->
              <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega"> 
                  <div class="set-price col-md-12">
                    <div class="set-price-box col-md-2 col-xs-2 col-sm-2 col-alpha">
                        <h5><strong>Supply price</strong></h5>
                      <input type="text" id="supply_price" value="<?=number_format($product['MerchantProduct']['supply_price'],2,'.','');?>">
                      <div class="info">Excluding tax</div>
                    </div>
                    <div class="set-price-box col-md-2 col-xs-2 col-sm-2 col-alpha">
                        <h5><strong>x Markup (%)</strong></h5>
                      <input type="text" id="markup" value="<?=number_format($product['MerchantProduct']['markup']*100,0);?>">
                    </div>
                    <div class="set-price-box col-md-2 col-xs-2 col-sm-2 col-alpha">
                        <h5><strong> = Retail price</strong></h5>
                      <input type="text" id="retail_price_exclude" value="<?=number_format($product['MerchantProduct']['price'],2,'.','');?>">
                      <div class="info">Excluding tax</div>
                    </div>
                    <div class="set-price-box col-md-3 col-xs-3 col-sm-3 col-alpha">
                        <h5><strong>+ Sales tax</strong></h5>
                      <select id="sales_tax">
                          <?php foreach($taxes as $tax){ ?>
                        <option tax-id="<?=$tax['MerchantTaxRate']['id'];?>" value="<?=$tax['MerchantTaxRate']['rate'];?>" <?php if($tax['MerchantTaxRate']['id'] == $product['MerchantProduct']['tax_id']){echo "selected";}?>><?=$tax['MerchantTaxRate']['name'];?></span></option>
                        <?php } ?>
                      </select>
                      <input type="text" id="sales_tax_calc" class="textOnly" value="<?=number_format($product['MerchantProduct']['tax'],2,'.','');?>" disabled>
                      <div class="tax_info">Currenty, GST (15%)</div>
                    </div>
                    <div class="set-price-box col-md-3 col-xs-3 col-sm-3 col-alpha col-omega">
                        <h5><strong>= Retail price</strong></h5>
                      <input type="text" id="retail_price_include" value="<?=number_format($product['MerchantProduct']['price']+$product['MerchantProduct']['tax'],2,'.','');?>">
                      <div class="info">Including tax</div>
                    </div>
                  </div>
              </div>
              <!-- END col-md-12-->
            </div>
            <!-- END col-md-12-->
            <?php if(empty($product['MerchantProduct']['parent_id'])) { ?>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Variants</div>
            <!-- START col-md-12-->
            <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega" style="padding:0;padding-bottom:15px;"> 
              <!-- START col-md-12-->
              <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega variant_attr"> 
                <div class="line-box-stitle">Variants allow you to specify the different attributes of your product, such as size or color. You can define up to three attributes for this product (e.g. color), and each attribute can have many values (e.g. black, green, etc).
                </div>
                <span class="help-block">
                  <input type="checkbox" name="variant" id="variant" <?php if($product['MerchantProduct']['has_variants'] == 1){echo "checked";}?>>
                  <label for="variant">This product has variants</label>
                </span>
                <?php if(empty($product['MerchantProduct']['variant_option_one_name'])){ ?>
                <div id="first_variant_attr" class="col-md-12 col-sm-12 col-xs-12" style="display:<?php if($product['MerchantProduct']['has_variants'] == 1){echo "block";} else {echo "none";}?>">
                    <div class="dashed-line-gr"></div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <h5><strong>Attribute</strong></h5>
                            <div class="info"><select class="variant_value_1"><option></option><option value="variant_value_add">+ Add new attribute</option>
                            <?php foreach($variants as $variant){ ?>
                            <option value="<?=$variant['MerchantProductVariant']['name'];?>"><?=$variant['MerchantProductVariant']['name'];?></option>
                            <?php } ?>
                            
                            </select></div>
                        </div>
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <h5><strong>Default value</strong></h5>
                            <div class="info"><input type="text" class="variant_default_1"></div>
                        </div>
                    </div>
                    <span class="variant_add">Add Another Attribute</span>
                </div>
                <?php }else{ ?>
                <div id="first_variant_attr" class="col-md-12 col-sm-12 col-xs-12" style="display:block;">
                    <div class="dashed-line-gr"></div>
                    <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <h5><strong>Attribute</strong></h5>
                            <div class="info"><select class="variant_value_1"><option></option><option value="variant_value_add">+ Add new attribute</option>
                            <?php foreach($variants as $variant){ ?>
                            <option value="<?=$variant['MerchantProductVariant']['name'];?>" <?php if($product['MerchantProduct']['variant_option_one_name'] == $variant['MerchantProductVariant']['name']){echo "selected";}?>><?=$variant['MerchantProductVariant']['name'];?></option>
                            <?php } ?>
                            
                            </select></div>
                        </div>
                        <div class="col-md-3 col-xs-3 col-sm-3">
                            <h5><strong>Default value</strong></h5>
                            <div class="info"><input type="text" class="variant_default_1" value="<?php echo $product['MerchantProduct']['variant_option_one_value'];?>"></div>
                        </div>
                    </div>
                    <span class="variant_add" <?php if(!empty($product['MerchantProduct']['variant_option_two_name'])){echo "style='display:none;'";}?>>Add Another Attribute</span>
                </div>
                <?php } ?>
                <?php if(!empty($product['MerchantProduct']['variant_option_two_name'])){ ?>
                <div class="col-md-12 col-sm-12 col-xs-12 variant_attr variant_added" style="margin-top:15px;">
                    <div class="col-md-12 col-xs-12 col-sm-12"><div class="col-md-3 col-xs-3 col-sm-3">
                        <div class="info">
                            <select class="variant_value_2">
                                <option></option>
                                <option value="variant_value_add">+ Add new attribute</option>
                                <?php foreach($variants as $variant){ ?>
                                    <option value="<?=$variant['MerchantProductVariant']['name'];?>" <?php if($product['MerchantProduct']['variant_option_two_name'] == $variant['MerchantProductVariant']['name']){echo "selected";}?>><?=$variant['MerchantProductVariant']['name'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-3 col-sm-3">
                        <div class="info"><input type="text" class="variant_default_2" value="<?php echo $product['MerchantProduct']['variant_option_two_value'];?>"></div>
                    </div>
                    <div class="col-md-2 col-xs-2 col-sm-2">
                        <button class="btn remove remove_variant_attr" style="padding:0"><i class="glyphicon glyphicon-remove"></i></button>
                    </div>
                </div>
                <?php if(empty($product['MerchantProduct']['variant_option_three_name'])){ ?>
                <div><span class="variant_add">Add Another Attribute</span></div>
                <?php } ?>
                </div>
                <?php } ?>
                <?php if(!empty($product['MerchantProduct']['variant_option_three_name'])){ ?>
                <div class="col-md-12 col-sm-12 col-xs-12 variant_attr variant_added" style="margin-top:15px;">
                    <div class="col-md-12 col-xs-12 col-sm-12"><div class="col-md-3 col-xs-3 col-sm-3">
                        <div class="info">
                            <select class="variant_value_3">
                                <option></option>
                                <option value="variant_value_add">+ Add new attribute</option>
                                <?php foreach($variants as $variant){ ?>
                                    <option value="<?=$variant['MerchantProductVariant']['name'];?>" <?php if($product['MerchantProduct']['variant_option_three_name'] == $variant['MerchantProductVariant']['name']){echo "selected";}?>><?=$variant['MerchantProductVariant']['name'];?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 col-xs-3 col-sm-3">
                        <div class="info"><input type="text" class="variant_default_3" value="<?php echo $product['MerchantProduct']['variant_option_three_value'];?>"></div>
                    </div>
                    <div class="col-md-2 col-xs-2 col-sm-2">
                        <button class="btn remove remove_variant_attr" style="padding:0"><i class="glyphicon glyphicon-remove"></i></button>
                    </div>
                </div>
                <div><span class="variant_max">A product has a maximum of three variants.</span></div>
                </div>
                <?php } ?>
              </div>
              <!-- END col-md-12-->
            </div>
            <!-- END col-md-12-->
            <?php } ?>
            <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega form-title margin-top-20">Inventory</div>
            <!-- START col-md-12-->
            <div class="form-body line-box line-box-content col-md-12 col-xs-12 col-sm-12 col-alpha col-omega"> 
              <!-- START col-md-12-->
              <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega"> 
                <!-- START col-md-6-->
                <div class="col-md-6">
                  <dl class="form-group">
                    <dt class="col-md-3">Stock keeping unit</dt>
                    <dd class="col-md-9">
                        <input type="text" class="form-control" id="sku" value="<?=$product['MerchantProduct']['sku'];?>">
                    </dd>
                  </dl>
                  <dl class="form-group" <?php if(!empty($product['MerchantProduct']['parent_id'])){echo 'style="display:none;"';}?>>
                    <dt class="col-md-3">Stock type</dt>
                    <dd class="col-md-9">
                      <select class="form-control" id="stock_type">
                        <option value="standard" <?php if($product['MerchantProduct']['stock_type'] == "Standard"){echo "selected";}?>>Standard</option>
                        <option value="composite" <?php if($product['MerchantProduct']['stock_type'] == "Composite"){echo "selected";}?>>Composite</option>
                      </select>
                    </dd>
                  </dl>
                </div>
                <!-- END col-md-6--> 
              </div>
              <div class="col-md-12 col-xs-12 col-sm-12" id="type_standard" style="display: <?php if($product['MerchantProduct']['stock_type'] == "Composite"){echo "none";} else {echo "block";}?>">
                  <div class="line-box-stitle col-md-12 col-xs-12 col-sm-12">
                  <dl class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                    <dt class="col-md-2">Stock Tracking</dt>
                    <dd class="col-md-10">
                      <input id="track_inventory" type="checkbox" value="1" <?php if($product['MerchantProduct']['track_inventory'] == 1){echo "checked";}?>>
                      Track stock levels with onzsa
                    </dd>
                  </dl>
                  <div class="dashed-line-gr"></div>
                  <div class="col-md-12 col-sm-12 col-xs-12 stock-tracking-header" style="display: <?php if($product['MerchantProduct']['track_inventory'] == 1){echo "block";}else{echo "none";}?>">
                      <div class="col-md-4 col-xs-4 col-sm-4 col-omega col-alpha">
                        <h5><strong>Store</strong></h5>
                      </div>
                      <div class="col-md-2 col-xs-4 col-sm-4">
                        <h5><strong>Current stock</strong></h5>
                      </div>
                      <div class="col-md-3 col-xs-4 col-sm-4">
                        <h5><strong>Re-order point</strong></h5>
                      </div>
                      <div class="col-md-3 col-xs-4 col-sm-4">
                        <h5><strong>Re-order amount</strong></h5>
                      </div>
                  </div>
                  
                  <?php foreach($outlets as $outlet) { ?>
                  <div class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega stock-tracking" style="display: <?php if($product['MerchantProduct']['track_inventory'] == 1){echo "block";}else{echo "none";}?>">
                      <input type="hidden" class="stock-outlet_id" value="<?php echo $outlet['MerchantOutlet']['id'];?>">
                      <div class="col-md-4 col-xs-4 col-sm-4 col-omega col-alpha">
                        <div class="info"><?php echo $outlet['MerchantOutlet']['name'];?></div>
                      </div>
                      <div class="col-md-2 col-xs-4 col-sm-4">
                        <input type="text" class="form-control stock_count" value="<?php if(!empty($outlet['MerchantProductInventory'])){echo $outlet['MerchantProductInventory']['count'];}?>" placeholder="0">
                      </div>
                      <div class="col-md-3 col-xs-4 col-sm-4">
                        <input type="text" class="form-control stock_reorder_point" value="<?php if(!empty($outlet['MerchantProductInventory'])){echo $outlet['MerchantProductInventory']['reorder_point'];}?>" placeholder="0">
                      </div>
                      <div class="col-md-3 col-xs-4 col-sm-4">
                        <input type="text" class="form-control stock_reorder_amount" value="<?php if(!empty($outlet['MerchantProductInventory'])){echo $outlet['MerchantProductInventory']['restock_level'];}?>" placeholder="0">
                      </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
              <div class="col-md-12 col-xs-12 col-sm-12" id="type_composite" style="display: <?php if($product['MerchantProduct']['stock_type'] == "Composite"){echo "block";} else {echo "none";}?>">
                  <div class="line-box-stitle col-md-12 col-xs-12 col-sm-12">
                  <dl class="col-md-12 col-xs-12 col-sm-12 col-alpha col-omega">
                    <dt class="col-md-12">Composite products contained specified quantities of one or more standard products.</dt>
                  </dl>
                  <div class="col-md-4 col-xs-4 col-sm-4">
                    <h5><strong>Product:</strong></h5>
                    <input type="search" id="composite_search" placeholder="Search Products">
                    <input type="hidden" id="selected_composite_id">
                    <div class="search_result">
                        <span class="search-tri"></span>
                        <div class="search-default"> No Result </div>
                        <?php foreach($items as $item){ ?>
                    
                        <button type="button" data-id="<?=$item['MerchantProduct']['id'];?>" class="data-found"><?=$item['MerchantProduct']['name'];?></button>
                        <?php } ?>
                    </div>
                  </div>
                  <div class="col-md-2 col-xs-2 col-sm-2">
                    <h5><strong>Quantity:</strong></h5>
                    <div class="input-group">
                        <input type="number" id="composite_qty" placeholder="1">
                        <span class="input-group-btn">
                            <button type="button" id="composite_attr_add" class="btn btn-default" style="height:29px;padding-top:4px;">Add</button>
                        </span>
                    </div>
                  </div>
                  <div class="dashed-line-gr"></div>
                  <div id="composite_added_list" class="col-md-12 col-sm-12 col-xs-12 col-alpha col-omega">
                  <?php foreach($composites as $composite) { ?>
                        <div class="col-md-12 col-sm-12 col-xs-12 composite-attr" data-id="<?php echo $composite['MerchantProductComposite']['product_id'];?>">
                            <div class="col-md-4 col-sm-4 col-xs-4"><?php echo $composite['MerchantProduct']['name'];?></div>
                            <div class="col-md-2 col-xs-2 col-sm-2 col-alpha"><input type="number" class="form-control composite_quantity" value="<?php echo $composite['MerchantProductComposite']['quantity'];?>">
                                <button type="button" class="btn remove remove_composite_attr" style="padding:0">
                                    <i class="glyphicon glyphicon-remove"></i>
                                </button>
                            </div>
                        </div>
                  <?php } ?>
                  </div>
                  
                </div>
              </div>
              <!-- END col-md-12-->
            </div>
            <!-- END col-md-12-->
          </div>
          <div class="form-actions fluid">
            <div class="col-md-12 margin-top-20 col-omega">
              <div class="pull-right">
                <button type="button" class="btn btn-default btn-wide cancel margin-right-10">Cancel</button>
                <button type="button" class="btn btn-primary btn-wide editProduct">Save</button>
              </div>
            </div>
          </div>
        </div>
        <!-- END FORM--> 
      </form>
    </div>
    <input type="hidden" id="created">
    <!-- BEGIN QUICK SIDEBAR --> 
    <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
    <div class="page-quick-sidebar-wrapper">
      <div class="page-quick-sidebar">
        <div class="nav-justified">
          <ul class="nav nav-tabs nav-justified">
            <li class="active"> <a href="#quick_sidebar_tab_1" data-toggle="tab"> Users <span class="badge badge-danger">2</span> </a> </li>
            <li> <a href="#quick_sidebar_tab_2" data-toggle="tab"> Alerts <span class="badge badge-success">7</span> </a> </li>
            <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> More<i class="fa fa-angle-down"></i> </a>
              <ul class="dropdown-menu pull-right" role="menu">
                <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-bell"></i> Alerts </a> </li>
                <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-info"></i> Notifications </a> </li>
                <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-speech"></i> Activities </a> </li>
                <li class="divider"> </li>
                <li> <a href="#quick_sidebar_tab_3" data-toggle="tab"> <i class="icon-settings"></i> Settings </a> </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- END QUICK SIDEBAR --> 
</div>
<!-- END CONTAINER -->
</div>
<!-- BEGIN JAVASCRIPTS(Load javascripts at bottom, this will reduce page load time) --> 
<!-- BEGIN CORE PLUGINS --> 
<!--[if lt IE 9]>
<script src="/assets/global/plugins/respond.min.js"></script>
<script src="/assets/global/plugins/excanvas.min.js"></script> 
<![endif]--> 
<script src="/assets/global/plugins/jquery-1.11.0.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery-migrate-1.2.1.min.js" type="text/javascript"></script> 
<!-- IMPORTANT! Load jquery-ui-1.10.3.custom.min.js before bootstrap.min.js to fix bootstrap tooltip conflict with jquery ui tooltip --> 
<script src="/assets/global/plugins/jquery-ui/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/bootstrap-hover-dropdown/bootstrap-hover-dropdown.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery.cokie.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/uniform/jquery.uniform.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS --> 
<!-- BEGIN PAGE LEVEL PLUGINS --> 
<script src="/assets/global/plugins/jqvmap/jqvmap/jquery.vmap.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.russia.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.world.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.europe.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.germany.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/maps/jquery.vmap.usa.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jqvmap/jqvmap/data/jquery.vmap.sampledata.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/flot/jquery.flot.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/flot/jquery.flot.resize.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/flot/jquery.flot.categories.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery.pulsate.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/bootstrap-daterangepicker/moment.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/bootstrap-daterangepicker/daterangepicker.js" type="text/javascript"></script> 
<!-- IMPORTANT! fullcalendar depends on jquery-ui-1.10.3.custom.min.js for drag & drop support --> 
<script src="/assets/global/plugins/fullcalendar/fullcalendar/fullcalendar.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/jquery.sparkline.min.js" type="text/javascript"></script> 
<script src="/assets/global/plugins/gritter/js/jquery.gritter.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL PLUGINS --> 
<!-- BEGIN PAGE LEVEL SCRIPTS --> 
<script src="/assets/global/scripts/metronic.js" type="text/javascript"></script> 
<script src="/assets/admin/layout/scripts/layout.js" type="text/javascript"></script> 
<script src="/assets/admin/layout/scripts/quick-sidebar.js" type="text/javascript"></script> 
<script src="/assets/admin/pages/scripts/index.js" type="text/javascript"></script>
<script type="text/javascript" src="/assets/global/plugins/select2/select2.min.js"></script>
<script src="/js/dropzone.js"></script> 
<script src="/js/jquery.popupoverlay.js"></script>
<script type="text/javascript" src="/js/jquery.confirm.js"></script> 
<!-- END PAGE LEVEL SCRIPTS --> 
<script>
jQuery(document).ready(function() {    
   Metronic.init(); // init metronic core componets
   Layout.init(); // init layout
   QuickSidebar.init() // init quick sidebar
   Index.init();
});
</script> 
<script>
$(document).ready(function(){
    $(document).on("keyup", "#supply_price", function(key){
         var code = key.keyCode || key.which;
         var clean = $(this).val().replace(/[^\d\.]/g, '');
         $(this).val(clean);
         if (code >= "48" && code <= "57" || code >= "96" && code <= "105" || code == "8") {
             $("#markup").val(($("#retail_price_exclude").val() - $(this).val()) / ($(this).val()) * 100);
         }
    });

    $(document).on("keyup", "#markup", function(key){
         var code = key.keyCode || key.which;
         var clean = $(this).val().replace(/[^\d\.]/g, '');
         $(this).val(clean);
         if(code >= "48" && code <= "57" || code >= "96" && code <= "105" || code == "8"){
             var retail_exclude = parseFloat($("#supply_price").val()) * ($(this).val() / 100) + parseFloat($("#supply_price").val());
             $("#retail_price_exclude").val(retail_exclude.toFixed(2));
             $("#retail_price_include").val(parseFloat(retail_exclude * $("#sales_tax").val() + retail_exclude).toFixed(2));
             $("#sales_tax_calc").val(parseFloat(retail_exclude * $("#sales_tax").val()).toFixed(2));
         }
    });

    $(document).on("keyup", "#retail_price_exclude", function(key){
         var code = key.keyCode || key.which;
         var clean = $(this).val().replace(/[^\d\.]/g, '');
         $(this).val(clean);
         if(code >= "48" && code <= "57" || code >= "96" && code <= "105" || code == "8"){
             var sales_tax = $(this).val() * $("#sales_tax").val();
             $("#markup").val(parseFloat(($("#retail_price_exclude").val() - $("#supply_price").val()) * 100 / $("#supply_price").val()).toFixed(2));
             $("#sales_tax_calc").val(parseFloat(sales_tax).toFixed(2));
             $("#retail_price_include").val(parseFloat(sales_tax + parseFloat($(this).val())).toFixed(2));
         }
    });

    $(document).on("change", "#sales_tax", function(){
        $("#sales_tax_calc").val(parseFloat($("#retail_price_exclude").val() * $(this).val()).toFixed(2));
        $("#retail_price_include").val(parseFloat($("#retail_price_exclude").val() * $(this).val() + parseFloat($("#retail_price_exclude").val())).toFixed(2));
        if($(".default_tax").is(":selected")){
            $(".tax_info").show('slow');
        } else {
            $(".tax_info").hide('slow');
        }
    });
});
</script>

<script>
$(document).ready(function(){
    var variant_count = 2;
    $(document).on('click','.variant_add',function(){
        $(this).parent().parent().parent().append('<div class="col-md-12 col-sm-12 col-xs-12 variant_attr variant_added" style="margin-top:15px;"><div class="col-md-12 col-xs-12 col-sm-12"><div class="col-md-3 col-xs-3 col-sm-3"><div class="info"><select class="variant_value_'+variant_count+'"><option></option><option value="variant_value_add">+ Add new attribute</option><?php foreach($variants as $variant){ ?><option value="<?=$variant['MerchantProductVariant']['name'];?>"><?=$variant['MerchantProductVariant']['name'];?></option><?php } ?></select></div></div><div class="col-md-3 col-xs-3 col-sm-3"><div class="info"><input type="text" class="variant_default_'+variant_count+'"></div></div><div class="col-md-2 col-xs-2 col-sm-2"><button class="btn remove remove_variant_attr" style="padding:0"><i class="glyphicon glyphicon-remove"></i></button></div></div><div>'+ ($(".variant_attr").length >= 2 ? '<span class="variant_max">A product has a maximum of three variants.</span><span class="variant_add" style="display:none;">Add Another Attribute</span>':'<span class="variant_add">Add Another Attribute</span>') +'</div></div>');
        $(this).hide();
        variant_count++;
    });
    
    $(document).on('click','.remove_variant_attr',function(){
        $(this).parent().parent().parent().remove();
        $(".variant_max").remove();
        $(".variant_attr:last").children().children(".variant_add").show();
        variant_count--;
    });

    $(document).on('click','.remove_composite_attr',function(){
        $(this).parent().parent().remove();
    });
    
    $(document).on('change','#variant',function(){
        
        if($(this).is(":checked")){
            $("#first_variant_attr").show();
            $(".variant_add").show();
        } else {
            $("#first_variant_attr").hide();
            $(".variant_added").remove();
            $(".variant_value").val('');
        }
        
    });

    $(document).on('click','.type-add',function(){
        $.ajax({
            url: "/product/type.json",
            type: "POST",
            data: {
                product_type_name: $(".type-name").val(),
            }
        }).done(function(result){
            $("#product_type_id").append('<option value="'+result['id']+'">'+result['name']+'</option>');
            $("#product_type_id").val(result['id']);
        });
    });

    $(document).on('click','.brand-add',function(){
        $.ajax({
            url: "/product/brand.json",
            type: "POST",
            data: {
                product_brand_name: $(".brand-name").val(),
                product_brand_desc: $(".brand-description").val()
            }
        }).done(function(result){
            $("#product_brand_id").append('<option value="'+result['id']+'">'+result['name']+'</option>');
            $("#product_brand_id").val(result['id']);
        });
    });



    /* DYNAMIC TAG SETTING */
    var FormSamples = function () {
        return {
            //main function to initiate the module
            init: function () {
                var tags = [];
                var tag_array = $("#tag_list").val();
                tag_array = JSON.parse(tag_array);
                $.each(tag_array, function(value){
                    tags.push($(this)[0]['MerchantProductTag']['name']);
                });
                $(".select2_sample3").select2({
                    tags: tags
                });
            }
        };
    }();
    FormSamples.init();

    /* DYNAMIC PROUCT SEARCH START */
    
    var $cells = $(".data-found");
    $(".search_result").hide();
    $(".search-default").hide();

    $(document).on("keyup","#composite_search",function() {
        var val = $.trim(this.value).toUpperCase();
        if (val === ""){
            $(".search_result").hide();
        }
        else {
            $cells.hide();
            $(".search_result").show();
            var coffee = 0;
            $cells.filter(function() {
                return -1 != $(this).text().toUpperCase().indexOf(val);
            }).show("fast",function(){
                $(".search-default").hide();
            });

            if($(".search_result").height() == 0){
                $(".search-default").show();
            }
        }
        $cells.click(function(){
           $("#composite_search").val($(this).text());
           $("#selected_composite_id").val($(this).attr('data-id'));
           $(".search_result").hide();
        });
    });
    /* DYNAMIC PRODUCT SEARCH END */


    // PRODUCT Edit 
    $(document).on('click','.editProduct',function(){
        $("#loader-wrapper").show();
        var parent_id = $("#parent_id").val();
        var name = $("#product_name").val();
        var handle = $("#product_handle").val();
        var type = $("#product_type_id").val();
        var brand = $("#product_brand_id").val();
        var description = $("#product_description").val();
        var image = "/img/no-image.png";
        var sku = $("#sku").val();
        var supplier_id = $("#product_supplier_id").val();
        /*
        if($("#product_supplier").val() !== ""){
            var supplier = $("#product_supplier").val();
        } else {
            var supplier;
        }
        */
        var product_uom = $("#product_uom").val();
        
        var supplier_code = $("#supplier_code").val();
        var supply_price = $("#supply_price").val();
        var retail_price = $("#retail_price_exclude").val();
        var price_include_tax = $("#retail_price_include").val();
        var tax_rate = $("#sales_tax").val();
        var tax = $("#sales_tax_calc").val();
        var markup = $("#markup").val();
        var tax_id = $('option:selected',"#sales_tax").attr("tax-id");
        if($("#tag_list").length > 0) {
            var tags = $("input[type=hidden]").val().split(",");
        }
        var stock_type = $("#stock_type").val();
        
        var variant_option_one_name = $(".variant_value_1").val();
        var variant_option_one_value = $(".variant_default_1").val();
        var variant_option_two_name = '';
        var variant_option_two_value = '';
        var variant_option_three_name = '';
        var variant_option_three_value = '';
        
        if($(".variant_value_2").val() !== undefined){
            variant_option_two_name = $(".variant_value_2").val();
            variant_option_two_value = $(".variant_default_2").val();
        }
        if($(".variant_value_3").val() !== undefined){
            variant_option_three_name = $(".variant_value_3").val();
            variant_option_three_value = $(".variant_default_3").val();
        }
        
        $(".incorrect-message").remove();
        $(".required").each(function(){
            if($(this).val() == ""){
                $(this).parent().addClass("incorrect");
                $('<h5 class="incorrect-message"><i class="glyphicon glyphicon-remove-circle margin-right-5"></i>This field is required.</h5>').insertAfter($(this));
            } else {
                $(this).parent().removeClass("incorrect");
            }
        });
        
        if($(".incorrect").length == 0) {
            var created = moment().format("YYYY-MM-DD HH:mm");
            var availability;
            if($("#availability").attr('checked')){
                availability = 1;
            } else {
                availability = 0;
            }
            var has_variants;
            if($("#variant").is(":checked")){
                has_variants = 1;
            } else {
                has_variants = 0;
            }
            var track_inventory;
            if($("#track_inventory").is(':checked')){
                if($(".composite-attr").length == 0){
                    track_inventory = 1;
                } else {
                    track_inventory = 0;
                }
            } else {
                track_inventory = 0;
            }

            var category;
            var inventories = [];
            $(".stock-tracking").each(function(){
               inventories.push({outlet_id: $(this).find(".stock-outlet_id").val(), count: $(this).find(".stock_count").val(), reorder_point: $(this).find(".stock_reorder_point").val(), restock_level: $(this).find(".stock_reorder_amount").val()}) 
            });
            var composite = [];
            $(".composite-attr").each(function(){
                composite.push({product_id: $(this).attr("data-id"), quantity: $(this).find(".composite_quantity").val()});
            });
            
            if($("#tag_list").length > 0) {
                var tagArray = $("input:hidden.product_tag").val().split(",");
                if(tagArray[0] == ''){
                    tagArray = '';
                } else {
                    tagArray = JSON.stringify(tagArray);
                }
            }
            
            var formData = new FormData(document.getElementById('product-form'));
            formData.append('name', name);
            formData.append('parent_id', parent_id);
            formData.append('handle', handle);
            formData.append('product_type_id', type);
            formData.append('product_brand_id', brand);
            formData.append('supplier_id', supplier_id);
            formData.append('supplier_code', supplier_code);
            formData.append('supply_price', supply_price);
            formData.append('price', retail_price);
            formData.append('tax', tax);
            formData.append('price_include_tax', price_include_tax);
            formData.append('markup', markup / 100);
            formData.append('tax_id', tax_id);
            formData.append('description', description);
            formData.append('image', image);
            formData.append('stock_type', stock_type);
            formData.append('sku', sku);
            formData.append('is_active', availability);
            formData.append('product_uom', product_uom);
            formData.append('has_variants', has_variants);
            formData.append('variant_option_one_name', variant_option_one_name);
            formData.append('variant_option_one_value', variant_option_one_value);
            formData.append('variant_option_two_name', variant_option_two_name);
            formData.append('variant_option_two_value', variant_option_two_value);
            formData.append('variant_option_three_name', variant_option_three_name);
            formData.append('variant_option_three_value', variant_option_three_value);
            formData.append('track_inventory', track_inventory);
            formData.append('inventories', JSON.stringify(inventories));
            formData.append('tags', tagArray);
            formData.append('composite', JSON.stringify(composite));

            $.ajax({
                url: window.location+'.json',
                type: "POST",
                cache: false,
                contentType: false,
                processData: false,
                mimeType: "multipart/form-data",
                data: formData,
                success: function(data){
                    var result = JSON.parse(data);
                    if (result.success) {
                        if($("#parent_id").val().length > 0) {
                            window.location.href = "/product/"+$("#parent_id").val();
                        } else {
                            window.location.href = "/product/"+result.product_id;
                        }
                    } else {
                        $("#loader-wrapper").hide();
                        console.log(result);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $("#loader-wrapper").hide();
                    console.log(textStatus, errorThrown);
                }
            });
            
        } else {
            $("#loader-wrapper").hide();
            $("html, body").animate({ scrollTop: 0 }, "slow");
        }
    });

    $(document).on("change","select",function(){

        if($("select option[value=add-type]").attr("selected")){
            $.confirm({
                title:'Add Product Type',
                text:'<input type="text" class="type-name" placeholder="Type Name">',
                confirmButton: "Add",
                cancelButton: "Cancel",
                cancel: function(button){
                    $("#product_type_id").val('');
                },
                confirmButtonClass: "type-add"
            });
        }
        
        if($("select option[value=add-brand]").attr("selected")){
            $.confirm({
                title:'Add Product Brand',
                text:'<input type="text" class="brand-name" placeholder="Brand Name"><textarea placeholder="Brand Description" style="width:100%;" class="brand-description"></textarea>',
                confirmButton: "Add",
                cancelButton: "Cancel",
                cancel: function(button){
                    $("#product_brand_id").val('');
                },
                confirmButtonClass: "brand-add"
            });
        }
        
        if($("select option[value=add-supplier]").attr("selected")){
            $.confirm({
                title:'Add Supplier',
                text:'<input type="text" class="type-name" placeholder="Supplier Name">',
                confirmButton: "Add",
                cancelButton: "Cancel",
                cancel: function(button){
                    $("#product_supplier_id").val('');
                },
                confirmButtonClass: "supplier-add"
            });
        }
        
        if($("select option[value=variant_value_add]").attr("selected")){
            var selection = $(this);
            $.confirm({
                title:'Add Variant',
                text:'<input type="text" class="variant-name" placeholder="Variant Name"><br><input type="text" class="variant-default_value" placeholder="Default Value">',
                confirmButton: "Add",
                cancelButton: "Cancel",
                cancel: function(button){
                    selection.val('');
                },
                confirmButtonClass: "variant-add btn-success"
            });
        }
        
        if($("#stock_type").val() == 'standard'){
            $("#type_standard").show();
            $("#type_composite").hide();
        } else {
            $("#type_standard").hide();
            $("#type_composite").show();
        }
        
    });
    
    $(".cancel").click(function(){
        parent.history.back();
    });
    
    $(document).on('click','#track_inventory',function(){
        if($(this).is(':checked')){
           $(".stock-tracking").show();
           $(".stock-tracking-header").show();
        } else {
           $(".stock-tracking").hide();
           $(".stock-tracking-header").hide();
        }
    });

    $(".cancel").click(function(){
        parent.history.back();
    });
    
    $("#composite_attr_add").click(function(){
        if($("#composite_qty").val() > 0){
            var quantity = $("#composite_qty").val();
        } else {
            var quantity = 1;
        }
        if($("#composite_search").val().length > 0){
            $("#composite_added_list").prepend('<div class="col-md-12 col-sm-12 col-xs-12 composite-attr" data-id="'+$("#selected_composite_id").val()+'"><div class="col-md-4 col-sm-4 col-xs-4">'+$("#composite_search").val()+'</div><div class="col-md-2 col-xs-2 col-sm-2 col-alpha"><input type="number" class="form-control composite_quantity" value="'+quantity+'"><button type="button" class="btn remove remove_composite_attr" style="padding:0"><i class="glyphicon glyphicon-remove"></i></button></div></div>');
            $("#composite_search").val('');
            $("#composite_qty").val('');
        }
    });

});
</script> 
<!-- END JAVASCRIPTS --> 
