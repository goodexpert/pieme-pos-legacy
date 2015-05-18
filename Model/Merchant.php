<?php

App::uses('AppModel', 'Model');

/**
 * Merchant model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Merchant extends AppModel {

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
    public $useTable = "merchants";

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
    public $name = "Merchant";

/**
 * belongsTo property
 *
 * @var array
 */
    public $belongsTo = array('Subscriber', 'Plan');

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
        )
    );

}
