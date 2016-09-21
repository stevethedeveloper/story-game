<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Stories Controller
 *
 * @property Story $Story
 * @property PaginatorComponent $Paginator
 */
class StoriesController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Game', 'User', 'Story', 'StoryComment');
	public $helpers = array('Html', 'Form', 'TinyMCE.TinyMCE');


/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->set('stories', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->Story->exists($id)) {
			throw new NotFoundException(__('Invalid story'));
		}
		$options = array('conditions' => array('Story.' . $this->Story->primaryKey => $id));
		$this->set('story', $this->Story->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Story->create();
			if ($this->Story->save($this->request->data)) {
				$this->Session->setFlash(__('The story has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The story could not be saved. Please, try again.'));
			}
		}
		$games = $this->Story->Game->find('list');
		$users = $this->Story->User->find('list');
		$this->set(compact('games', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Story->exists($id)) {
			throw new NotFoundException(__('Invalid story'));
		}

		$options = array('conditions' => array('Story.' . $this->Story->primaryKey => $id));
		$story = $this->Story->find('first', $options);
		$game = $this->Story->Game->getGame($story['Story']['game_id']);	

		//$game = $this->Game->find('first', array('conditions' => 'Game.id = '.$story['Story']['game_id']));

		if ($story['Story']['submitted'] == 1) {
	        $this->Session->setFlash('You have submitted your story for review, and it can no longer be edited.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			return $this->redirect('/games/view/'.$game['Game']['id']);
		}

		$this->set('game', $game);
		$this->set('first_sentence', $story['Story']['first_sentence']);
		$this->set('story_comments', $this->StoryComment->getStoryComments($id));
		$this->set('partner_story_comments', $this->StoryComment->getStoryComments($game['Partner']['Story']['id']));

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Story->save($this->request->data)) {
		        $this->Session->setFlash('Your changes have been saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
				return $this->redirect('/games/view/'.$game['Game']['id']);
			} else {
		        $this->Session->setFlash('Your changes could not be saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			}
		} else {
			$this->request->data = $story;
			if (empty($this->request->data['Story']['story_text'])) {
				$this->request->data['Story']['story_text'] = '<p>'.$this->request->data['Story']['first_sentence'].'</p>';
			}
		}
	}

	public function first_sentence($id) {
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['Story']['id'] = $id;
			if ($this->Story->save($this->request->data)) {
		        
		        $game = $this->Story->Game->getGame($this->request->data['Story']['game_id']);
		        $user_id = $game['Partner']['id'];

		        if ($this->Story->Game->updateUserStatus($this->request->data['Story']['game_id'], $user_id, 'writing')) {
			        $this->__send_email($game['Partner']['email'], $game['Me']['username'].' has entered your first sentence!', $game['Me']['username'].' has entered your first sentence!  Click below to get started.<br /><br /><a href="http://'.env('SERVER_NAME').'/games/view/'.$game['Game']['id'].'">http://'.env('SERVER_NAME').'/games/view/'.$game['Game']['id'].'</a>');
			        $this->Session->setFlash('Your changes have been saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
					return $this->redirect('/games/view/'.$this->request->data['Story']['game_id']);
		        } else {
		        	die('There was an error updating the user status');
		        }

			} else {
		        $this->Session->setFlash('Your changes could not be saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			}
		} else {
			$this->request->data = $story;
		}
	}

	public function add_genre($id = null) {
		if (!$this->Story->exists($id)) {
			throw new NotFoundException(__('Invalid story'));
		}

		if ($this->request->is(array('post', 'put'))) {
			if ($this->Story->save($this->request->data)) {
		        $this->Session->setFlash('Your genre has been saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
				return $this->redirect('/stories/edit/'.$id);
			} else {
		        $this->Session->setFlash('Your genre could not be saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			}
		} else {
	        $this->Session->setFlash('Your genre could not be saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			return $this->redirect($this->referer());
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->Story->id = $id;
		if (!$this->Story->exists()) {
			throw new NotFoundException(__('Invalid story'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Story->delete()) {
			$this->Session->setFlash(__('The story has been deleted.'));
		} else {
			$this->Session->setFlash(__('The story could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

    public function finished($id) {
    	$story = $this->Story->read('game_id', $id);
    	$this->Story->saveField('finished', '1');
    	
    	$game = $this->Story->Game->getGame($story['Story']['game_id']);
    	$index = $game['Me']['user_index'];
    	$this->Story->Game->id = $story['Story']['game_id'];
    	$this->Story->Game->saveField('user_'.$index.'_status', 'finished');

        $this->__send_email($game['Partner']['email'], $game['Me']['username'].' has finished their story!', $game['Me']['username'].' has finished their story!  Click below to read it and make comments.<br /><br /><a href="http://'.env('SERVER_NAME').'/stories/partner_story/'.$game['Me']['Story']['id'].'">http://'.env('SERVER_NAME').'/stories/partner_story/'.$game['Me']['Story']['id'].'</a>');

		$this->Session->setFlash('Your story has been marked finished.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		$this->redirect('/games/view/'.$story['Story']['game_id']);
    }

    public function unfinished($id) {
    	$story = $this->Story->read('game_id', $id);
    	$this->Story->saveField('finished', '0');

    	$game = $this->Story->Game->getGame($story['Story']['game_id']);
    	$index = $game['Me']['user_index'];
    	$this->Story->Game->id = $story['Story']['game_id'];
    	$this->Story->Game->saveField('user_'.$index.'_status', 'writing');

		$this->Session->setFlash('Your story has been marked unfinished.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		$this->redirect('/games/view/'.$story['Story']['game_id']);
    }
    
    public function partner_story($id) {
		$user_id = $this->Auth->user('id');
		$options = array('conditions' => array('Story.' . $this->Story->primaryKey => $id));
		$story = $this->Story->find('first', $options);
		
		$game = $this->Game->getGame($story['Story']['game_id']);

		if ($game['Game']['game_status'] == 'completed') {
	        $this->Session->setFlash('This game is over.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			return $this->redirect('/games/view/'.$game['Game']['id']);
		}


		$this->set('story', $story);
		$this->set('game', $game);
		$this->set('story_comments', $this->StoryComment->getStoryComments($id));
		$this->set('partner_story_comments', $this->StoryComment->getStoryComments($game['Partner']['Story']['id']));
	
		if ($this->request->is('post')) {
			$this->request->data['StoryComment']['story_id'] = $id;
			$partner_id = $game['Partner']['id'];
			$this->request->data['StoryComment']['user_id'] = $partner_id;
			$this->StoryComment->create();
			if ($this->StoryComment->save($this->request->data)) {
		        $this->__send_email($game['Partner']['email'], $game['Me']['username'].' has commented on your story!', $game['Me']['username'].' has commented on your story story!  Click below to read their comments.<br /><br /><a href="http://'.env('SERVER_NAME').'/stories/edit/'.$game['Partner']['Story']['id'].'">http://'.env('SERVER_NAME').'/stories/edit/'.$game['Partner']['Story']['id'].'</a>');
		        $this->Session->setFlash('Your comment has been saved.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
				return $this->redirect('/stories/partner_story/'.$id);
			} else {
		        $this->Session->setFlash('Your comment could not be saved. Please try again.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
				return $this->redirect('/stories/partner_story/'.$id);
			}
		}

	}

	public function submit($id) {
		$this->Story->read(null, $id);
		$this->Story->set('submitted', '1');
		$this->Story->save();

		$options = array('conditions' => array('Story.' . $this->Story->primaryKey => $id));
		$story = $this->Story->find('first', $options);

        $this->Session->setFlash('Your story has been submitted to be reviewed for the front page.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		return $this->redirect('/games/view/'.$story['Story']['game_id']);
	}

	public function admin_submissions() {
		$this->Story->recursive = 0;
		$this->Story->recursive = 0;
		$this->paginate = array('limit' => 10,
            'conditions' => array('(submitted = 1 AND front_page = 0)')
        );
		$this->set('stories', $this->Paginator->paginate('Story'));
	}

    public function admin_approve_front_page($id) {
    	$story = $this->Story->read('id', $id);
    	$this->Story->saveField('front_page', '1');
    	$this->Story->saveField('front_page_date', date('Y-m-d H:i:s'));
		$this->Session->setFlash('Story has been approved for front page.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		$this->redirect('/admin/stories/submissions');
    }

    public function admin_decline_front_page($id) {
    	$story = $this->Story->read('id', $id);
    	$this->Story->saveField('front_page', '-1');
    	$this->Story->saveField('front_page_date', date('Y-m-d H:i:s'));
		$this->Session->setFlash('Story has been declined for front page.', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		$this->redirect('/admin/stories/submissions');
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
        
		if (in_array($this->action, array('edit', 'finished', 'unfinished', 'submit', 'add_genre'))) {
			$storyId = (int) $this->request->params['pass'][0];
			if ($this->Story->isOwnedBy($storyId, $user['id'])) {
				return true;
			}
		}

		if (in_array($this->action, array('first_sentence'))) {
			$storyId = (int) $this->request->params['pass'][0];
			if ($this->Story->isOwnedByPartner($storyId, $user['id'])) {
				return true;
			}
		}

		if (in_array($this->action, array('partner_story'))) {
			$storyId = (int) $this->request->params['pass'][0];
			$options = array('conditions' => array('Story.' . $this->Story->primaryKey => $storyId));
			$story = $this->Story->find('first', $options);
			if ($story['Story']['finished'] == 1 && $this->Game->isParticipant($story['Story']['game_id'], $user['id'])) {
				return true;
			}
		}

        return parent::isAuthorized($user);
    }

}
