<?php

App::uses('AppModel', 'Model');

/**
 * BookingStatus model for ONZSA.
 *
 * @package       onzsa.Model
 */
class BookingStatus extends AppModel {

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
    public $useTable = "booking_status";

/**
 * Primary key of the database table.
 *
 * @var string
 */
    public $primaryKey = "status";

/**
 * Name of the Model.
 *
 * @var string
 */
    public $name = "BookingStatus";

/**
 * belongsTo property
 *
 * @var array
 */
    public $belongsTo = array();

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
    );

}
