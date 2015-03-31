<?php

App::uses('AppModel', 'Model');

/**
 * Plan model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Plan extends AppModel {

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
	public $useTable = "plans";

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
	public $name = "Plan";

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
			'isUnique' => array(
				'rule' => 'isUnique'
			),
		),
	);

}
