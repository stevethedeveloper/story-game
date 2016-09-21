<?php
App::uses('AppModel', 'Model');
/**
 * StoryComment Model
 *
 * @property Story $Story
 * @property User $User
 */
class StoryComment extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'story_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Story' => array(
			'className' => 'Story',
			'foreignKey' => 'story_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function getStoryComments($id) {
		return $this->find('all', array('conditions' => 'StoryComment.story_id = '.$id, 'order' => array('StoryComment.created DESC')));
	}
}
