<?php

App::uses('AppModel', 'Model');

/**
 * MerchantReceiptTemplate model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantReceiptTemplate extends AppModel {

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
    public $useTable = "merchant_receipt_templates";

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
    public $name = "MerchantReceiptTemplate";

/**
 * belongsTo property
 *
 * @var array
 */
    public $belongsTo = array('ReceiptStyle');

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
