<?php
App::uses('AppModel', 'Model');
/**
 * Game Model
 *
 * @property Story $Story
 */
class Game extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_1_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
		'user_2_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Story' => array(
			'className' => 'Story',
			'foreignKey' => 'game_id',
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

    public $belongsTo = array(
        'User1' => array(
            'className' => 'User',
            'foreignKey' => 'user_1_id'
        ),
        'User2' => array(
            'className' => 'User',
            'foreignKey' => 'user_2_id'
        )
    );

    private $game_status = array(
    		'active' => 'In Progress',
    		'deleted' => 'Deleted',
    		'completed' => 'Completed',
    		'invitation_sent' => 'Invitation Sent'
    	);

    private $user_status = array(
    		'invitation_sent' => 'Invitation Sent',
    		'invitation_received' => 'Invitation Pending',
    		'invitation_declined' => 'Declined Invitation',
    		'first_sentence' => 'Awaiting first sentence',
    		'writing' => 'Writing',
    		'revisions' => 'Accepting Comments/Making Revisions',
    		'finished' => 'Finished'
    	);

	public function getGameStatusArray() {
		return $this->$game_status;
	}

	public function getUserStatusArray() {
		return $this->$user_status;
	}

	public function initGame($user_1_id, $user_2_id) {
		$game = array();
		$game['Game']['user_1_id'] = $user_1_id;
		$game['Game']['user_2_id'] = $user_2_id;
		$game['Game']['user_1_status'] = 'invitation_sent';
		$game['Game']['user_2_status'] = 'invitation_received';
		$game['Game']['game_status'] = 'invitation_sent';
		$game['Game']['invitation_date'] = date("Y-m-d H:i:s");
		$this->save($game);

		$game_id = $this->getInsertId();
	}

	public function getGame($id) {
		$game = $this->find('first', array('conditions' => 'Game.id = '.$id));
		
		$user_id = CakeSession::read("Auth.User.id");
		
		if (empty($user_id)) {
			die('no record found in getGame()');
		}

		$my_user_index = $this->getUserRecord($game, $user_id);
		$partner_user_index = ($my_user_index == 1) ? 2 : 1;

		$return['Game'] = $game['Game'];
		$return['Me'] = $game['User'.$my_user_index];
		$return['Partner'] = $game['User'.$partner_user_index];
		$return['Me']['Story'] = array();
		$return['Partner']['Story'] = array();
		$return['Me']['user_index'] = $my_user_index;
		$return['Partner']['user_index'] = $partner_user_index;
		$return['Me']['status'] = $game['Game']['user_'.$my_user_index.'_status'];
		$return['Partner']['status'] = $game['Game']['user_'.$partner_user_index.'_status'];

		App::import('model', 'Story');
		$story = new Story();
		$stories = $story->find('all', array('conditions' => 'game_id = '.$id));
		foreach ($stories as $story) {
			if ($story['User']['id'] == $return['Me']['id']) {
				$return['Me']['Story'] = $story['Story'];
				$return['Me']['Story']['genre_name'] = ($story['Story']['genre_id'] == 14) ? $story['Story']['genre_other'] : $story['Genre']['name'];
			} else {
				$return['Partner']['Story'] = $story['Story'];
				$return['Partner']['Story']['genre_name'] = $story['Genre']['name'];
			}
		}

		return $return;
	}

	public function getGamesForUser($id) {
		return $this->query("SELECT * FROM games Game WHERE user_1_id = $id OR user_2_id = $id");
	}

	public function getGameCounts($id) {
		$return = array();

		$return['active'] = $this->find('count',
            array('conditions' => array('(user_1_id = '.$id.' OR user_2_id = '.$id.') AND game_status = \'active\''))
        );

        $return['invitations_sent'] = $this->find('count',
            array('conditions' => array('(user_1_id = '.$id.') AND game_status = \'invitation_sent\' AND user_1_status = \'invitation_sent\''))
        );

        $return['invitations_received'] = $this->find('count',
            array('conditions' => array('(user_2_id = '.$id.') AND game_status = \'invitation_sent\' AND user_2_status = \'invitation_received\''))
        );

        $return['past_games'] = $this->find('count',
            array('conditions' => array('(user_1_id = '.$id.' OR user_2_id = '.$id.') AND game_status = \'completed\''))
        );

        return $return;

	}

	public function cancelInvitation($id, $game_id) {
		$game_count = $this->find('count',
            array('conditions' => array('(user_1_id = '.$id.' AND Game.id = '.$game_id.') AND (game_status = \'invitation_sent\')'))
        );

		if ($game_count > 0) {
			$game = array();
			$game['Game']['id'] = $game_id;
			$game['Game']['user_1_status'] = 'invitation_canceled';
			$game['Game']['user_2_status'] = 'invitation_canceled';
			$game['Game']['game_status'] = 'deleted';
			$game['Game']['game_status_note'] = 'Invitation canceled by user';
			$this->save($game);
			return true;
		}

		return false;
	}

	public function acceptInvitation($user_2_id, $user_1_id, $game_id) {
		$game_count = $this->find('first',
            array('conditions' => array('(user_2_id = '.$user_2_id.' AND Game.id = '.$game_id.') AND (game_status = \'invitation_sent\')'))
        );

		if ($game_count > 0) {
			App::import('model', 'Story');
			$story = new Story();
			if (!$story->addStoriesForGame($game_id, $user_1_id, $user_2_id)) {
				return false;
			}

			$game = array();
			$game['Game']['id'] = $game_id;
			$game['Game']['user_1_status'] = 'first_sentence';
			$game['Game']['user_2_status'] = 'first_sentence';
			$game['Game']['game_status'] = 'active';
			$game['Game']['accepted_date'] = date("Y-m-d H:i:s");
			if (!$this->save($game)) {
				return false;
			}
			return true;
		}

		return false;
	}

	public function declineInvitation($id, $game_id) {
		$this->recursive = -1;
		$game_count = $this->find('count',
            array('conditions' => array('(user_2_id = '.$id.' AND Game.id = '.$game_id.') AND (game_status = \'invitation_sent\')'))
        );

		if ($game_count > 0) {
			$game = array();
			$game['Game']['id'] = $game_id;
			$game['Game']['user_1_status'] = 'invitation_declined';
			$game['Game']['user_2_status'] = 'invitation_declined';
			$game['Game']['game_status'] = 'deleted';
			$game['Game']['game_status_note'] = 'Invitation declined by user';
			$this->save($game);
			return true;
		}

		return false;
	}

	public function isParticipant($game, $user) {
    	if (($this->field('id', array('id' => $game, 'user_1_id' => $user)) !== false) || ($this->field('id', array('id' => $game, 'user_2_id' => $user)) !== false)) {
    		return true;
    	}
    	return false;
	}

	public function getUserRecord($game, $user_id) {
		if ($game['User1']['id'] == $user_id) {
			return '1';
		}
		return '2';
	}

	public function getPartnerId($game_id, $user_id) {
		$game = $this->find("first", array('conditions' => 'Game.id = '.$game_id));
		if ($game['User1']['id'] == $user_id) {
			return $game['User2']['id'];
		}
		return $game['User1']['id'];
	}

	public function getPartnerUsername($game_id, $user_id) {
		$game = $this->find("first", array('conditions' => 'Game.id = '.$game_id));
		if ($game['User1']['id'] == $user_id) {
			return $game['User2']['username'];
		}
		return $game['User1']['username'];
	}

	public function updateUserStatus($game_id, $user_id, $status) {
		$this->recursive = -1;

		$game_record = $this->find('first', array('conditions' => 'Game.id = '.$game_id));

		$player = ($game_record['Game']['user_1_id'] == $user_id) ? 'user_1_status' : 'user_2_status';

		$game = array();
		$game['Game']['id'] = $game_id;
		$game['Game'][$player] = 'writing';

		return $this->save($game);
	}

	public function getFinishedGames($user_id) {
		return $this->find('all', array('conditions' => "(Game.user_1_id = {$user_id} or Game.user_2_id = {$user_id}) and (user_1_status = 'finished' and user_2_status = 'finished' and game_status = 'completed')"));
	}

	public function getFinishedGameCount($user_id) {
		return $this->find('count', array('conditions' => "(Game.user_1_id = {$user_id} or Game.user_2_id = {$user_id}) and (user_1_status = 'finished' and user_2_status = 'finished' and game_status = 'completed')"));
	}
}
