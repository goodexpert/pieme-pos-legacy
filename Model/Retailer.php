<?php

App::uses('AppModel', 'Model');

/**
 * Retailer model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Retailer extends AppModel {

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
    public $useTable = "retailers";

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
    public $name = "Retailer";

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
