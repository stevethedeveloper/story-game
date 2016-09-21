<?php
App::uses('AppController', 'Controller');
/**
 * AwardsUsers Controller
 *
 * @property AwardsUser $AwardsUser
 * @property PaginatorComponent $Paginator
 */
class AwardsUsersController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->AwardsUser->recursive = 0;
		$this->set('awardsUsers', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->AwardsUser->exists($id)) {
			throw new NotFoundException(__('Invalid awards user'));
		}
		$options = array('conditions' => array('AwardsUser.' . $this->AwardsUser->primaryKey => $id));
		$this->set('awardsUser', $this->AwardsUser->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->AwardsUser->create();
			if ($this->AwardsUser->save($this->request->data)) {
				$this->Session->setFlash(__('The awards user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The awards user could not be saved. Please, try again.'));
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
		if (!$this->AwardsUser->exists($id)) {
			throw new NotFoundException(__('Invalid awards user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->AwardsUser->save($this->request->data)) {
				$this->Session->setFlash(__('The awards user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The awards user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('AwardsUser.' . $this->AwardsUser->primaryKey => $id));
			$this->request->data = $this->AwardsUser->find('first', $options);
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
		$this->AwardsUser->id = $id;
		if (!$this->AwardsUser->exists()) {
			throw new NotFoundException(__('Invalid awards user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->AwardsUser->delete()) {
			$this->Session->setFlash(__('The awards user has been deleted.'));
		} else {
			$this->Session->setFlash(__('The awards user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
