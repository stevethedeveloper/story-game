<?php
App::uses('AppModel', 'Model');
/**
 * UserAward Model
 *
 * @property User $User
 * @property Award $Award
 */
class UserAward extends AppModel {


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Award' => array(
			'className' => 'Award',
			'foreignKey' => 'award_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
