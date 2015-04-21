<?php

App::uses('AppModel', 'Model');

/**
 * ProductUom model for ONZSA.
 *
 * @package       onzsa.Model
 */
class ProductUom extends AppModel {

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
    public $useTable = "product_uom";

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
    public $name = "ProductUom";

/**
 * belongsTo property
 *
 * @var array
 */
    public $belongsTo = array(
        'ProductUomCategory' => array(
            'className' => 'ProductUomCategory',
            'foreignKey' => 'category_id'
        )
    );

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
    );

}
