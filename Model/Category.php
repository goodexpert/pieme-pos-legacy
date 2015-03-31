<?php

App::uses('AppModel', 'Model');

/**
 * Category model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Category extends AppModel {

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
	public $useTable = "categories";

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
	public $name = "Category";

/**
 * Validation rules.
 *
 * @var array
 */
	public $validate = array(
	);

}
