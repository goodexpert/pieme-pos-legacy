<?php

App::uses('AppModel', 'Model');

/**
 * Zone model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Zone extends AppModel {

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
	public $useTable = "zones";

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
	public $name = "Zone";

/**
 * Validation rules.
 *
 * @var array
 */
	public $validate = array(
	);

}
