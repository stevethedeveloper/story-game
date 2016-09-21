<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Games Controller
 *
 * @property Game $Game
 * @property PaginatorComponent $Paginator
 */
class GamesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Game', 'User', 'Story', 'StoryComment');
	public $helpers = array('Html', 'Form', 'TinyMCE.TinyMCE');

	public $counts;

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('random', 'search');
        $this->Auth->deny('index');

		//$this->loginRequired();

		if ($this->Auth->user()) {
        	$this->counts = $this->Game->getGameCounts($this->Auth->user('id'));
        }
    }

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Game->recursive = 0;
		$this->set('games', $this->Paginator->paginate());
	}

	public function index() {
		$id = $this->Auth->user('id');

        $this->paginate = array('limit' => 10,
            'conditions' => array('(user_1_id = '.$id.' OR user_2_id = '.$id.') AND game_status = \'active\'')
        );
        $games = $this->paginate('Game');
        $this->set(compact('games'));

        $this->set('counts', $this->counts);
	}

	public function invitations_sent() {
		$id = $this->Auth->user('id');

        $this->paginate = array('limit' => 10,
            'conditions' => array('(user_1_id = '.$id.') AND game_status = \'invitation_sent\' AND user_1_status = \'invitation_sent\'')
        );
        $games = $this->paginate('Game');
        $this->set(compact('games'));

        $this->set('counts', $this->counts);
	}

	public function invitations_received() {
		$id = $this->Auth->user('id');

        $this->paginate = array('limit' => 10,
            'conditions' => array('(user_2_id = '.$id.') AND game_status = \'invitation_sent\' AND user_2_status = \'invitation_received\'')
        );
        $games = $this->paginate('Game');
        $this->set(compact('games'));

        $this->set('counts', $this->counts);
	}

	public function past_games() {
		$id = $this->Auth->user('id');

        $this->paginate = array('limit' => 10,
            'conditions' => array('(user_1_id = '.$id.' OR user_2_id = '.$id.') AND game_status = \'completed\'')
        );
        $games = $this->paginate('Game');
        $this->set(compact('games'));

        $this->set('counts', $this->counts);
	}

	public function cancel_invitation($game_id) {
		$id = $this->Auth->user('id');

		$canceled = $this->Game->cancelInvitation($id, $game_id);

		if ($canceled === true) {
	        $this->Session->setFlash('Invitation canceled.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		} else {
	        $this->Session->setFlash('Sorry, this invitation could not be canceled.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
		}
	
		$this->redirect('/games/invitations_sent');
	}

	public function accept_invitation($game_id) {
		$my_user_id = $this->Auth->user('id');

		$game = $this->Game->getGame($game_id);

		$partner_user_id = $game['Partner']['id'];

		$accepted = $this->Game->acceptInvitation($my_user_id, $partner_user_id, $game_id);

		if ($accepted === true) {
            $this->__send_email($game['Partner']['email'], $game['Me']['username'].' has accepted your Story Game invitation!', $game['Me']['username'].' has accepted your invitation to play a game on The Story Game!  Click below to play.<br /><br /><a href="http://'.env('SERVER_NAME').'/games/view/'.$game_id.'">http://'.env('SERVER_NAME').'/games/view/'.$game_id.'</a>');
	        $this->Session->setFlash('Invitation accepted.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		} else {
	        $this->Session->setFlash('Sorry, this invitation could not be accepted.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
		}
	
		$this->redirect('/games');
	}

	public function decline_invitation($game_id) {
		$id = $this->Auth->user('id');

		$canceled = $this->Game->declineInvitation($id, $game_id);

		if ($canceled === true) {
	        $this->Session->setFlash('Invitation declined.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		} else {
	        $this->Session->setFlash('Sorry, this invitation could not be declined.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
		}
	
		$this->redirect('/games/invitations_received');
	}
/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Game->exists($id)) {
			throw new NotFoundException(__('Invalid game'));
		}

		$user_id = $this->Auth->user('id');

		$game = $this->Game->getGame($id);

		//if either player is awaiting first sentence, render first sentence view
		$render_first_sentence = false;
		if ($game['Game']['user_1_status'] == 'first_sentence' || $game['Game']['user_2_status'] == 'first_sentence') {
			$render_first_sentence = true;
		}

		if (!$game['Me']['Story']['genre_id']) {
			$genres = $this->Story->Genre->find('list');
		}

		$story_comments = $this->StoryComment->getStoryComments($game['Me']['Story']['id']);
		$partner_story_comments = $this->StoryComment->getStoryComments($game['Partner']['Story']['id']);

		$can_submit = false;
		if (count($story_comments) > 0 && count($partner_story_comments) > 0 && $game['Me']['Story']['finished'] == 1 && $game['Me']['Story']['front_page'] != -1) {
			$can_submit = true;
		}

		$this->set(compact('game', 'render_first_sentence', 'genres', 'story_comments', 'partner_story_comments', 'can_submit'));
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Game->create();
			if ($this->Game->save($this->request->data)) {
				$this->Session->setFlash(__('The game has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The game could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Game->exists($id)) {
			throw new NotFoundException(__('Invalid game'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Game->save($this->request->data)) {
				$this->Session->setFlash(__('The game has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The game could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Game.' . $this->Game->primaryKey => $id));
			$this->request->data = $this->Game->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Game->id = $id;
		if (!$this->Game->exists()) {
			throw new NotFoundException(__('Invalid game'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Game->delete()) {
			$this->Session->setFlash(__('The game has been deleted.'));
		} else {
			$this->Session->setFlash(__('The game could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function random() {
		$id = $this->Auth->user('id');
		$username = $this->Auth->user('username');
		$partner = $this->User->getRandomPartner($id);
		if (!empty($partner[0]['User']['id'])) {
			$this->Game->initGame($id, $partner[0]['User']['id']);
	        $this->Session->setFlash('An invitation has been sent to '. $partner[0]['User']['username'], 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            $this->__send_email($partner[0]['User']['email'], $username.' has invited you to play a Story Game!', 'You have been invited by '.$username.' to a game on The Story Game!  Click below to view your open invitations.<br /><br /><a href="http://'.env('SERVER_NAME').'/games/invitations_received">http://'.env('SERVER_NAME').'/games/invitations_received</a>');
		} else {
	        $this->Session->setFlash('Sorry, there are no available partners at this time.  Please try again later. ', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
		}
        $this->redirect('/games/invitations_sent');
	}

	public function friend($friend_id = null) {
		if (empty($friend_id)) {
	        $this->Session->setFlash('Invalid friend id', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
		}

		$id = $this->Auth->user('id');
		$username = $this->Auth->user('username');
		$partner = $this->User->getFriendPartner($id, $friend_id);
		if (!empty($partner[0]['User']['id'])) {
			$this->Game->initGame($id, $partner[0]['User']['id']);
	        $this->Session->setFlash('An invitation has been sent to '. $partner[0]['User']['username'], 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            $this->__send_email($partner[0]['User']['email'], $username.' has invited you to play a Story Game!', 'You have been invited by '.$username.' to a game on The Story Game!  Click below to view your open invitations.<br /><br /><a href="http://'.env('SERVER_NAME').'/games/invitations_received">http://'.env('SERVER_NAME').'/games/invitations_received</a>');
		} else {
	        $this->Session->setFlash('Sorry, unable to start game with that partner.  Do you have an active game or invitation with them?', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
	        $this->redirect('/games');
		}
        $this->redirect('/games/invitations_sent');
	}

	public function finished($id) {
		$this->Game->id = $id;
		if (!$this->Game->exists()) {
			throw new NotFoundException(__('Invalid game'));
		}
		
		$options = array('conditions' => array('Game.' . $this->Game->primaryKey => $id));
		$games = $this->Game->find('first', $options);

		$user_id = $this->Auth->user('id');
		$partner_username = $this->Game->getPartnerUsername($id, $user_id);

		$this->Game->query("update games set finished = 1, game_status = 'completed' where id = $id");
        $this->Session->setFlash('Play again?', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
        $this->redirect('/users/search/'.$partner_username);
	}

    function __send_email($to, $subject, $body) {
        $send_email = $this->User->canSendToUser($to);
        if ($send_email === false) {
        	return null;
        }

        $email = new CakeEmail();
        $email->config('gmail');
        $email->from(array('noreply@'.env('SERVER_NAME') =>  'The Story Game'));
        $email->to($to);
        $email->subject($subject);
        $email->template('main_template');
        $email->emailFormat('html');
        $email->viewVars(array('email_content' => $body));
        return $email->send();      
    }

	public function isAuthorized($user) {
        
        if (in_array($this->action, array('edit', 'invitations_sent', 'invitations_received', 'past_games', 'index', 'cancel_invitation', 'accept_invitation', 'decline_invitation', 'random', 'friend'))) {
            return true;
        }

	    if (in_array($this->action, array('view', 'finished'))) {
	        $gameId = (int) $this->request->params['pass'][0];
	        if ($this->Game->isParticipant($gameId, $user['id'])) {
	            return true;
	        }
	    }

        return parent::isAuthorized($user);
    }

}
