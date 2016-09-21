<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Emails Controller
 *
 * @property Email $Email
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class SystemEmailsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');
	public $helpers = array('Html', 'Form', 'TinyMCE.TinyMCE');
	public $uses = array('SystemEmail', 'User');

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->SystemEmail->recursive = 0;
		$this->paginate = array(
	        'limit' => 25,
	        'order' => array(
	            'Post.created' => 'desc'
	        )
	    );
		$this->set('emails', $this->Paginator->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		if (!$this->SystemEmail->exists($id)) {
			throw new NotFoundException(__('Invalid email'));
		}
		$options = array('conditions' => array('Email.' . $this->SystemEmail->primaryKey => $id));
		$this->set('email', $this->SystemEmail->find('first', $options));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->SystemEmail->create();
			if ($this->SystemEmail->save($this->request->data)) {
				$this->Session->setFlash(__('The email has been saved.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email could not be saved. Please, try again.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		if (!$this->SystemEmail->exists($id)) {
			throw new NotFoundException(__('Invalid email'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->SystemEmail->save($this->request->data)) {
				$this->Session->setFlash(__('The email has been saved.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The email could not be saved. Please, try again.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			}
		} else {
			$options = array('conditions' => array('SystemEmail.' . $this->SystemEmail->primaryKey => $id));
			$this->request->data = $this->SystemEmail->find('first', $options);
		}
	}

/**
 * admin_delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		$this->SystemEmail->id = $id;
		if (!$this->SystemEmail->exists()) {
			throw new NotFoundException(__('Invalid email'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->SystemEmail->delete()) {
			$this->Session->setFlash(__('The email has been deleted.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		} else {
			$this->Session->setFlash(__('The email could not be deleted. Please, try again.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_send($id = null) {
        $this->autoRender = false;

        $system_email = $this->SystemEmail->find('first', array('conditions' => 'id = '.$id));

        $recipients = $this->User->find('all', array('fields' => 'email', 'conditions' => 'status = 1 AND receive_emails = 1'));

        foreach ($recipients as $recipient) {
        	//$this->__send_email($recipient['User']['email'], $system_email['SystemEmail']['subject'], $system_email['SystemEmail']['content']);
         	$this->__send_email('llamaspit@gmail.com', $system_email['SystemEmail']['subject'], $system_email['SystemEmail']['content']);
	       	$this->__send_email('richie.reitzfeld@gmail.com', $system_email['SystemEmail']['subject'], $system_email['SystemEmail']['content']);
        }

		$this->SystemEmail->read(null, $id);
		$this->SystemEmail->set('date_sent', date('Y-m-d H:i:s'));
		$this->SystemEmail->save();

		$this->Session->setFlash(__('The email has been sent.'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_export() {
        $this->response->download("email_export.csv");
        $data = $this->User->find('all', array('fields' => 'User.email', 'conditions' => 'status = 1 AND receive_emails = 1'));
		$this->set(compact('data'));
 		$this->layout = 'ajax';
 		return;
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
}
