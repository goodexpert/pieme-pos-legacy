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
        /*
        'username' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your email address.'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address.'
            ),
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a password.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 4),
                'message' => 'Your password must be at least 4 characters.'
            ),
        ),
        'display_name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your full name.'
            ),
        ),
        'email' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your email address.'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address.'
            ),
        ),
         */
    );

}
