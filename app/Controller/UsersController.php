<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 */
class UsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public $uses = array('User', 'Game', 'Award', 'UserAward', 'Story', 'Genre');
     
    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'logout', 'verify', 'forgot', 'reset', 'populate');
    }

    public function login() {
         
        // if we get the post information, try to authenticate
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                if ($this->Auth->user('status') != 1) {
                    $this->Session->setFlash(__('Invalid email or password'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-danger'));
                    return $this->redirect($this->Auth->logout());
                }
                $this->User->checkAwards($this->Auth->user('id'));
                return $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash(__('Invalid screen name or password'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            }
        }
    }

    public function admin_login() {
        $this->redirect('/users/login');
    }
 
    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    public function populate() {
        $id = 23;
        $first_sentence = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $text = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec egestas nibh vel placerat tempus. Maecenas ante risus, scelerisque scelerisque varius sed, lacinia vitae lacus. Nam sodales, enim in convallis pulvinar, magna lacus eleifend felis, volutpat mattis diam est a est. Aenean lobortis risus eros, quis ullamcorper odio viverra in. Morbi interdum leo quis posuere ullamcorper. Aliquam id dolor non augue euismod dictum et facilisis lacus. In sed sodales nunc, mattis commodo nunc. Ut scelerisque libero a convallis pulvinar. Pellentesque vehicula, odio rhoncus facilisis eleifend, risus risus pellentesque ligula, sit amet gravida quam justo et dolor. Aenean congue consequat fringilla. Nulla placerat, dui eget lacinia convallis, felis sapien vestibulum odio, id tincidunt magna massa at magna. In ac risus rhoncus, suscipit dui ac, sagittis ante. Pellentesque vitae nisl ante. Nunc pellentesque tempus libero, id tempus dui. Nullam egestas est non nibh facilisis, in pretium metus gravida.</p>';
        for($i = 1;$i <= 1000;$i++) {
            $user_number = rand(1, 2);
            $partner_user_number = ($user_number == 1) ? 2 : 1;
            $this->User->recursive = -1;
            $partner = $this->User->find('first', array( 
                'conditions' => 'User.id != '.$id,
                'order' => 'rand()',
            ));

            $data = array();
            $data['Game']['user_'.$user_number.'_id'] = $id;
            $data['Game']['user_'.$partner_user_number.'_id'] = $partner['User']['id'];
            $data['Game']['user_1_status'] = 'finished';
            $data['Game']['user_2_status'] = 'finished';
            $data['Game']['game_status'] = 'completed';
            $data['Game']['finished'] = 1;
            $this->Game->create();
            $this->Game->save($data);
            $game_id = $this->Game->getLastInsertId();

            $story['Story']['game_id'] = $game_id;
            $story['Story']['user_id'] = $id;
            $genre = $this->Genre->find('first', array('order' => 'rand()'));
            $story['Story']['genre_id'] = $genre['Genre']['id'];
            $story['Story']['first_sentence'] = $first_sentence;
            $story['Story']['user_id'] = $id;
            $story['Story']['story_text'] = $text;
            $story['Story']['finished'] = 1;
            $story['Story']['submitted'] = 1;
            if ($game_id % 100 == 0) {
                $story['Story']['front_page'] = 1;
            } else {
                $story['Story']['front_page'] = 0;
            }
            $this->Story->create();
            $this->Story->save($story);
            $this->Story->clear();

            $story['Story']['user_id'] = $partner['User']['id'];
            $this->Story->create();
            $this->Story->save($story);
            $this->Story->clear();
            $this->Game->clear();
        }
        die('done');
    }

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
        $this->paginate = array(
            'limit' => 5,
        	'conditions' => array('status' => '1'),
            'order' => array('User.username' => 'asc' )
        );
        $users = $this->paginate('User');
        $this->set(compact('users'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
        if ($this->request->is('post')) {
                 
            $this->User->create();
            $token = md5(uniqid(mt_rand(), true));
            $this->request->data['User']['token'] = $token;
            if ($this->User->save($this->request->data)) {
                $id = $this->User->getLastInsertId();
                $user = $this->User->findById($id);
                
                $this->__send_email($this->request->data['User']['email'], 'Verify your email address', 'Thank you for signing up.  Please click the link below to complete your registration.<br /><br /><a href="http://'.env('SERVER_NAME').'/users/verify/'.$token.'">http://'.env('SERVER_NAME').'/users/verify/'.$token.'</a>');

                $this->Session->setFlash(__('Please check your email to complete registration'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect('/login');
            } else {
                $this->Session->setFlash(__('The user could not be created. Please try again.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            }  
        }
	}

    public function verify($token) {
        $user = $this->User->verify($token);
        if ($user !== false) {
            $this->Auth->login($user['User']);
            $this->Session->setFlash(__('Welcome, '. $this->Auth->user('first_name')), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            $this->redirect($this->Auth->redirectUrl());
        } else {
            $this->Session->setFlash(__('This account could not be verified.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            $this->redirect('/');
        }
    }

    public function reset($token = null) {
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->User->query('update users set password_token = \'\' where id = '.$this->request->data['User']['id']);
                $this->Session->setFlash(__('Your password has been reset.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect(array('action' => 'login'));
            }else{
                $this->Session->setFlash(__('Unable to reset your password'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            }
        }

        if (!$this->request->data) {
            $user = $this->User->findByPasswordToken($token);
            if (!$user) {
                $this->Session->setFlash('Invalid token', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
                $this->redirect('/');
            }
            $this->request->data = $user;
        }
    }

    public function forgot() {
        if ($this->request->is('post')) {
            $user = $this->User->createRecoverToken($this->request->data['User']['username_email']);
            if ($user !== false ) {
                $this->__send_email($user['User']['email'], 'Reset your password', 'Please click the link below to reset your password.<br /><br /><a href="http://'.env('SERVER_NAME').'/users/reset/'.$user['User']['password_token'].'">http://'.env('SERVER_NAME').'/users/reset/'.$user['User']['password_token'].'</a>');

                $this->Session->setFlash(__('Please check your email to reset your password'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect('/login');
            } else {
                $this->Session->setFlash(__('That username or email could not be found.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
                $this->redirect('/users/forgot');
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
	public function edit() {
        $id = $this->Auth->user('id');

        if (!$id) {
            $this->Session->setFlash('Invalid user id', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            $this->redirect(array('action'=>'index'));
        }

        $user = $this->User->findById($id);
        if (!$user) {
            $this->Session->setFlash('Invalid User ID Provided', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            $this->redirect(array('action'=>'index'));
        }

        if ($this->request->is('post') || $this->request->is('put')) {
            $this->User->id = $id;
            if ($this->User->save($this->request->data)) {
                $this->Session->write('Auth', $this->User->read(null, $this->Auth->User('id')));
                $this->Session->setFlash(__('Your changes have been saved'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
                $this->redirect(array('action' => 'edit', $id));
            }else{
                $this->Session->setFlash(__('Unable to save your changes'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            }
        }

        if (!$this->request->data) {
            $this->request->data = $user;
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
        if (!$id) {
            $this->Session->setFlash('Please provide a user id', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 0)) {
            $this->Session->setFlash(__('User deleted'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
        $this->redirect(array('action' => 'index'));
	}

    public function activate($id = null) {
         
        if (!$id) {
            $this->Session->setFlash('Please provide a user id', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            $this->redirect(array('action'=>'index'));
        }
         
        $this->User->id = $id;
        if (!$this->User->exists()) {
            $this->Session->setFlash('Invalid user id provided', 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
            $this->redirect(array('action'=>'index'));
        }
        if ($this->User->saveField('status', 1)) {
            $this->Session->setFlash(__('User re-activated'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not re-activated'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
        $this->redirect(array('action' => 'index'));
    }

    public function search($search_term = null) {

        $id = $this->Auth->user('id');

        if ($search_term === null) {
            if ($this->request->is(array('post'))) {
                if (!empty($this->request->data['User']['username'])) {
                    $this->redirect('/users/search/'.$this->request->data['User']['username']);
                }
            }
        } else {
                $this->paginate = array('limit' => 10,
                    'conditions' => array('username like \'%'.$search_term.'%\' and id != '.$id)
                );
                $users = $this->paginate('User');
                $this->set(compact('users'));
        }

    }

    function __send_email($to, $subject, $body) {
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
        
        if (in_array($this->action, array('edit', 'search'))) {
            return true;
        }

        return parent::isAuthorized($user);
    }
}
