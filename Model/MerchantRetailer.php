<?php

App::uses('AppModel', 'Model');

/**
 * MerchantRetailer model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantRetailer extends AppModel {

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
    public $useTable = "merchant_retailers";

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
    public $name = "MerchantRetailer";

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
    );

}
