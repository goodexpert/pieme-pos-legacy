<?php

App::uses('AppModel', 'Model');

/**
 * MerchantUserType model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantUserType extends AppModel {

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
    public $useTable = "merchant_user_types";

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
    public $name = "MerchantUserType";

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
        'user_type' => array(
            'notBlank' => array(
                'rule' => 'notBlank'
            ),
        ),
    );

}
