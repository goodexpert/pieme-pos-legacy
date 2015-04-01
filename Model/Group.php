<?php

App::uses('AppModel', 'Model');

/**
 * Group model for ONZSA.
 *
 * @package       onzsa.Model
 */
class Group extends AppModel {

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
    public $useTable = "groups";

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
    public $name = "Group";

/**
 * Validation rules.
 *
 * @var array
 */
    public $validate = array(
        'group_name' => array(
            'notEmpty' => array(
                'rule' => 'notEmpty'
            ),
            'isUnique' => array(
                'rule' => 'isUnique'
            ),
        ),
    );

}
