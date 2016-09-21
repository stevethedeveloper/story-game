<?php
App::uses('AppModel', 'Model');
/**
 * Story Model
 *
 * @property Game $Game
 * @property User $User
 * @property StoryComment $StoryComment
 */
class Story extends AppModel {
	
/**
 * Validation rules
 *
 * @var array
 */
	
	public $validate = array(
		'game_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'first_sentence' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Please enter a sentence',
				'allowEmpty' => false,
			),
		),
		'story_text' => array(
            'storyLimit' => array(
                'rule'    => array('storyLimit'),
                'message' => 'You have exceeded the maximum number of words.',
                'allowEmpty' => true,
                'required' => false,
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
		'Game' => array(
			'className' => 'Game',
			'foreignKey' => 'game_id',
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
		),
		'Genre' => array(
			'className' => 'Genre',
			'foreignKey' => 'genre_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)		
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'StoryComment' => array(
			'className' => 'StoryComment',
			'foreignKey' => 'story_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	public function storyStarted($game_id, $user_id) {
		$count = $this->find('count',
            array('conditions' => array('user_id = '.$user_id.' AND game_id = '.$game_id))
        );
        if ($count > 0) {
        	return true;
        }
        return false;
	}

	public function getMyFirstSentence($game_id, $user_id) {
		$sentence = $this->find('first',
            array('conditions' => array('user_id = '.$user_id.' AND game_id = '.$game_id))
        );
		return $sentence['Story']['first_sentence'];
	}

	public function storyLimit($check) {
		
        $value = array_values($check);
        $value = $value[0];
        //$value = strip_tags($value);
        //$value = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $value);

		// Strip HTML Tags
		$clear = strip_tags($value);
		// Clean up things like &amp;
		$clear = html_entity_decode($clear);
		// Strip out any url-encoded stuff
		$clear = urldecode($clear);
		// Replace non-AlNum characters with space
		$clear = preg_replace('/[^A-Za-z0-9\']/', ' ', $clear);
		// Replace Multiple spaces with single space
		$clear = preg_replace('/ +/', ' ', $clear);
		// Trim the string of leading/trailing space
		$clear = trim($clear);

		$count = str_word_count($clear);
		
		return $count <= STORY_LENGTH_LIMIT;
		
		echo $count."<br />";
		echo $clear;
		die;
 
    }
    
    public function getGameId($id) {
		$story = $this->find('first',
            array('conditions' => array('Story.id = '.$id))
        );
		return $story['Story']['game_id'];
	}

	public function addStoriesForGame($game_id, $user_1_id, $user_2_id) {
		$story = array();
		$story['Story']['id'] = null;
		$story['Story']['game_id'] = $game_id;
		$story['Story']['user_id'] = $user_1_id;
		if (!$this->save($story)) {
			return false;
		}
		$story = array();
		$story['Story']['id'] = null;
		$story['Story']['game_id'] = $game_id;
		$story['Story']['user_id'] = $user_2_id;
		if (!$this->save($story)) {
			return false;
		}
		return true;
	}
	
	public function isOwnedBy($story, $user) {
		return $this->field('id', array('id' => $story, 'user_id' => $user)) !== false;
	}

	public function isOwnedByPartner($story, $user) {
		$game_id = $this->getGameId($story);
		App::import('model', 'Game');
		$game = new Game();
		$game_object = $game->getGame($game_id);
		if ($game_object['Partner']['Story']['id'] == $story) {
			return true;
		}
		return false;
	}

}
