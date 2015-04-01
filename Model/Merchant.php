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
    public $belongsTo = array('Contact', 'Plan');

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
        ),
    );

}
