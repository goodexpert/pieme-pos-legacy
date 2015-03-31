<?php

App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

/**
 * MerchantUser model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantUser extends AppModel {

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
	public $useTable = "merchant_users";

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
	public $name = "MerchantUser";

	public function beforeSave($options = array()) {
		if (!empty($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher(array('hashType' => 'sha256'));
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
			);
		}
		return true;
	}

/**
 * belongsTo property
 *
 * @var array
 */
	public $belongsTo = array('Merchant');

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
		),
		'password' => array(
			'minLength' => array(
				'rule' => array('minLength', 6)
			),
		),
		'display_name' => array(
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
