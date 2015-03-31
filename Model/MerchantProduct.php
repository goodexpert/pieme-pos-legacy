<?php

App::uses('AppModel', 'Model');

/**
 * MerchantProduct model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantProduct extends AppModel {

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
	public $useTable = "merchant_products";

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
	public $name = "MerchantProduct";

/**
 * belongsTo property
 *
 * @var array
 */
	//public $belongsTo = array('Merchant', 'MerchantTaxRate');

/**
 * Validation rules.
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
		),
		'handle' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
		),
	);

}
