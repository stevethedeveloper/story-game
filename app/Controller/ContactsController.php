<?php
App::uses('AppController', 'Controller');
App::uses('CakeEmail', 'Network/Email');

/**
 * Contacts Controller
 *
 * @property Contact $Contact
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 */
class ContactsController extends AppController {

	var $helpers = array('Html', 'Form', 'Captcha');

	public $to_email = 'rreitzfeld@playthestorygame.com';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('add', 'captcha');
    }

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Captcha'=> array('captchaType'=>'image', 'jquerylib'=>true, 'modelName'=>'Contact', 'fieldName'=>'captcha'));

/**
 * add method
 *
 * @return void
 */
	public function add() {
		 $this->Captcha = $this->Components->load('Captcha', array('captchaType'=>'math', 'jquerylib'=>true, 'modelName'=>'Contact', 'fieldName'=>'captcha')); //load it

		if ($this->request->is('post')) {
			$this->Contact->setCaptcha($this->Captcha->getVerCode());
			$this->Contact->create();
			$this->request->data['Contact']['user_id'] = (!empty($this->request->data['Contact']['user_id'])) ? $this->request->data['Contact']['user_id'] : 0;
			if ($this->Contact->save($this->request->data)) {
			    if ($this->Auth->loggedIn()) {
					$subject = 'Contact from '.$this->Auth->user('username').' ('.$this->request->data['Contact']['email'].')';
			    } else {
					$subject = 'Contact from '.$this->request->data['Contact']['email'];
			    }
				$this->__send_email($this->to_email, $this->request->data['Contact']['email'], $subject, nl2br($this->request->data['Contact']['content']));
				$this->Session->setFlash(__('Your message was sent'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-success'));
				return $this->redirect('/');
			} else {
                $this->Session->setFlash(__('Your message was not sent'), 'alert', array('plugin' => 'BoostCake', 'class' => 'alert-error'));
			}
		} else {
			$this->request->data['Contact']['email'] = $this->Auth->user('email');
		}
		$this->set('username', $this->Auth->user('username'));
		$this->request->data['Contact']['user_id'] = $this->Auth->user('id');
		$this->set('user_id', $this->Auth->user('user_id'));
	}

	function captcha()	{
		$this->autoRender = false;
		$this->layout='ajax';
		if(!isset($this->Captcha))	{
			$this->Captcha = $this->Components->load('Captcha', array(
				'width' => 150,
				'height' => 50,
				'theme' => 'random',
			));
			}
		$this->Captcha->create();
	}


	function __send_email($to, $from, $subject, $body) {
		$email = new CakeEmail();
		$email->config('gmail');
        $email->from(array('noreply@'.env('SERVER_NAME') =>  'The Story Game'));
        $email->replyTo($from);
        $email->to($to);
        $email->subject($subject);
        $email->template('main_template');
        $email->emailFormat('html');
        $email->viewVars(array('email_content' => $body));
        return $email->send();		
	}
}
