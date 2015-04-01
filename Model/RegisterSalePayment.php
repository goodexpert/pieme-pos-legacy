<?php

App::uses('AppModel', 'Model');

/**
 * RegisterSalePayment model for ONZSA.
 *
 * @package       onzsa.Model
 */
class RegisterSalePayment extends AppModel {

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
    public $useTable = "register_sale_payments";

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
    public $name = "RegisterSalePayment";

/**
 * belongsTo property
 *
 * @var array
 */
    public $belongsTo = array('MerchantPaymentType');

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
    );

}
