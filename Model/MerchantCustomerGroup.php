<?php

App::uses('AppModel', 'Model');

/**
 * MerchantCustomerGroup model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantCustomerGroup extends AppModel {

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
    public $useTable = "merchant_customer_groups";

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
    public $name = "MerchantCustomerGroup";

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
        'group_code' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            ),
        ),
        'name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            ),
        ),
    );

}
