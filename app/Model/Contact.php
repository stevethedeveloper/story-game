<?php
App::uses('AppModel', 'Model');
/**
 * Contact Model
 *
 * @property User $User
 */
class Contact extends AppModel {

	var $captcha = '';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Please enter your email address',
			),
		),
		'content' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
			),
		),
		'captcha'=>array(
				'rule' => array('matchCaptcha'),
				'message'=>'Failed validating human check.'
		),
	);

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	function matchCaptcha($inputValue)	{
		return $inputValue['captcha']==$this->getCaptcha(); //return true or false after comparing submitted value with set value of captcha
	}

	function setCaptcha($value)	{
		$this->captcha = $value; //setting captcha value
	}

	function getCaptcha()	{
		return $this->captcha; //getting captcha value
	}
}
