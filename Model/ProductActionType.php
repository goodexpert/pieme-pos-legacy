<?php

App::uses('AppModel', 'Model');

/**
 * ProductActionType model for ONZSA.
 *
 * @package       onzsa.Model
 */
class ProductActionType extends AppModel {

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
	public $useTable = "product_action_types";

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
	public $name = "ProductActionType";

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
