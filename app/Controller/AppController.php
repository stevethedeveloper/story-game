<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array(
		'Session',
		//'DebugKit.Toolbar',
		'Auth' => array(
			'flash' => array(
				'element' => 'alert',
				'key' => 'auth',
				'params' => array(
					'plugin' => 'BoostCake',
					'class' => 'alert-danger'
				)
			),
            'loginRedirect' => '/',
            'logoutRedirect' => '/',
        	'authorize' => array('Controller')
		)
	);
	public $helpers = array(
		'Html' => array('className' => 'BoostCake.BoostCakeHtml'),
		'Form' => array('className' => 'BoostCake.BoostCakeForm'),
		'Paginator' => array('className' => 'BoostCake.BoostCakePaginator'),
	);

	public function beforeFilter() {
	    $this->Auth->allow('login', 'index');
	    $this->set( 'loggedIn', $this->Auth->loggedIn() );
	    $this->set('is_admin', false);
	    if ($this->Auth->loggedIn()) {
			$admin = $this->Auth->user('admin');
			if ((int)$admin === 1) {
	    		$this->set('is_admin', true);
	    		if (0 && array_key_exists('prefix', $this->request->params) && $this->request->params['prefix'] == 'admin') {
	    			$this->layout = 'admin';
	    		} else {
	    			$this->layout = 'default';
	    		}
	    	}

	    }
	}

	public function isAuthorized($user) {
		$admin = $this->Auth->user('admin');
		if ((int)$admin === 1) {
        	return true;
    	}
	     
	    return false;
	}
}
