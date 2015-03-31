<?php

App::uses('AppModel', 'Model');

/**
 * User model for ONZSA.
 *
 * @package       onzsa.Model
 */
class User extends AppModel {

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
	public $useTable = "users";

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
	public $name = "User";

/**
 * belongsTo property
 *
 * @var array
 */
	public $belongsTo = array('Group');

/**
 * Validation rules.
 *
 * @var array
 */
	public $validate = array(
		'username' => array(
			'email' => array(
				'rule' => 'email'
			),
			'isUnique' => array(
				'rule' => 'isUnique'
			),
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', 6)
			),
		),
		'first_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
		),
		'last_name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
		),
		'email' => array(
			'email' => array(
				'rule' => 'email'
			),
			'notEmpty' => array(
				'rule' => 'notEmpty'
			),
		),
	);

}
