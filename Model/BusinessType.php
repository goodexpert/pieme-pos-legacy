<?php

App::uses('AppModel', 'Model');

/**
 * BusinessType model for ONZSA.
 *
 * @package       onzsa.Model
 */
class BusinessType extends AppModel {

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
    public $useTable = "business_types";

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
    public $name = "BusinessType";

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
    );

}
