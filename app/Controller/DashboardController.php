<?php
App::uses('AppController', 'Controller');
/**
 * Awards Controller
 *
 * @property Award $Award
 * @property PaginatorComponent $Paginator
 */
class DashboardController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
	public $uses = array('Story', 'UserAward');

/**
 * index method
 *
 * @return void
 */
	public function index() {
        $this->paginate = array('limit' => 10,
            'conditions' => array('front_page = 1'),
            'order' => 'front_page_date DESC'
        );
        $stories = $this->paginate('Story');
        //$this->UserAward->recursive = -1;
        $awards = array();
        if ($this->Auth->loggedIn()) {
            $awards = $this->UserAward->find('all', array('conditions' => 'UserAward.user_id = '.$this->Auth->user('id')));
        }
        $this->set(compact('stories', 'awards'));
	}

}
