<?php

App::uses('AppModel', 'Model');

/**
 * MerchantPriceBook model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantPriceBook extends AppModel {

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
	public $useTable = "merchant_price_books";

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
	public $name = "MerchantPriceBook";

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
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
		),
	);

}
