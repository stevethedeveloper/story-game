<?php
App::uses('AppController', 'Controller');
/**
 * StoryComments Controller
 *
 * @property StoryComment $StoryComment
 * @property PaginatorComponent $Paginator
 */
class StoryCommentsController extends AppController {

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
		$this->StoryComment->recursive = 0;
		$this->set('storyComments', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->StoryComment->exists($id)) {
			throw new NotFoundException(__('Invalid story comment'));
		}
		$options = array('conditions' => array('StoryComment.' . $this->StoryComment->primaryKey => $id));
		$this->set('storyComment', $this->StoryComment->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->StoryComment->create();
			if ($this->StoryComment->save($this->request->data)) {
				$this->Session->setFlash(__('The story comment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The story comment could not be saved. Please, try again.'));
			}
		}
		$stories = $this->StoryComment->Story->find('list');
		$users = $this->StoryComment->User->find('list');
		$this->set(compact('stories', 'users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->StoryComment->exists($id)) {
			throw new NotFoundException(__('Invalid story comment'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->StoryComment->save($this->request->data)) {
				$this->Session->setFlash(__('The story comment has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The story comment could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('StoryComment.' . $this->StoryComment->primaryKey => $id));
			$this->request->data = $this->StoryComment->find('first', $options);
		}
		$stories = $this->StoryComment->Story->find('list');
		$users = $this->StoryComment->User->find('list');
		$this->set(compact('stories', 'users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->StoryComment->id = $id;
		if (!$this->StoryComment->exists()) {
			throw new NotFoundException(__('Invalid story comment'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->StoryComment->delete()) {
			$this->Session->setFlash(__('The story comment has been deleted.'));
		} else {
			$this->Session->setFlash(__('The story comment could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
