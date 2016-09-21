<?php
App::uses('AppModel', 'Model');
/**
 * Email Model
 *
 */
class SystemEmail extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'subject' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
			),
		),
	);
}
