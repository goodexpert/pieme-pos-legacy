<?php

App::uses('AppModel', 'Model');

/**
 * MerchantPriceBookEntry model for ONZSA.
 *
 * @package       onzsa.Model
 */
class MerchantPriceBookEntry extends AppModel {

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
    public $useTable = "merchant_price_book_entries";

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
    public $name = "MerchantPriceBookEntry";

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
    );

}
