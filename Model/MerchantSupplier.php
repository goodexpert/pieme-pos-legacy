<?php

App::uses('AppModel', 'Model');

/**
 * MerchantSupplier model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantSupplier extends AppModel {

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
    public $useTable = "merchant_suppliers";

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
    public $name = "MerchantSupplier";

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
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            ),
        ),
    );

}
