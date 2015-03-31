<?php

App::uses('AppModel', 'Model');

/**
 * MerchantProductCategory model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantProductCategory extends AppModel {

/**
 * The name of the database connection to use bind this model class.
 *
 * @var string
 */
	public $useDbConfig = "default";

/**
 * The name of the database table.
 *
 * @var string
 */
	public $useTable = "merchant_product_categories";

/**
 * Primary key of the database table.
 *
 * @var string
 */
	public $primaryKey = "id";

/**
 * Name of the Model.
 *
 * @var string
 */
	public $name = "MerchantProductCategory";

/**
 * belongsTo property
 *
 * @var array
 */
	public $belongsTo = array();

/**
 * Validation rules.
 *
 * @var array
 */
	public $validate = array(
	);

}
