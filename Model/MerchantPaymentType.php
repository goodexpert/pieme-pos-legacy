<?php

App::uses('AppModel', 'Model');

/**
 * MerchantPaymentType model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantPaymentType extends AppModel {

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
    public $useTable = "merchant_payment_types";

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
    public $name = "MerchantPaymentType";

/**
 * belongsTo property
 *
 * @var array
 */
    public $belongsTo = array('PaymentType');

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
