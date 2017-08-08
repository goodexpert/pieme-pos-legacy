<?php

App::uses('AppModel', 'Model');

/**
 * Subscriber model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Subscriber extends AppModel {

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
    public $useTable = "subscribers";

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
    public $name = "Subscriber";

/**
 * belongsTo property
 *
 * @var array
 */
    public $belongsTo = array('Contact');

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
        'username' => array(
            'notBlank' => array(
                'rule' => 'notBlank',
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
            'notBlank' => array(
                'rule' => 'notBlank',
                'message' => 'Please enter a password.'
            ),
            'minLength' => array(
                'rule' => array('minLength', 6),
                'message' => 'Your password must be at least 6 characters.'
            ),
        ),
    );

}
