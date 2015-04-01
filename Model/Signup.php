<?php

App::uses('AppModel', 'Model');

/**
 * Signup model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Signup extends AppModel {

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
    public $useTable = "signups";

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
    public $name = "Signup";

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
                'rule' => 'notEmpty',
                'message' => 'Please enter your store name.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 4),
                'message' => 'Your store name must be at least 4 characters.'
            ),
        ),
        'domain_prefix' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a private web address.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 5),
                'message' => 'Your web address must be at least 5 characters.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This web address is unavailable.'
            ),
        ),
        'username' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your email address.'
            ),
            'email' => array(
                'rule' => 'email',
                'message' => 'Please enter a valid email address.'
            ),
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'This email address is already registered.'
            ),
        ),
        'password' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter a password.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 6),
                'message' => 'Your password must be at least 6 characters.'
            ),
        ),
        'first_name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your first name.'
            ),
        ),
        'last_name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your last name.'
            ),
        ),
        'physical_city' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please enter your city and select from the list.'
            ),
        ),
        'default_currency' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Please choose your currency.'
            ),
        ),
    );

}
