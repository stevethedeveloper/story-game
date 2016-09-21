<div class="users form">
<?php echo $this->Form->create('User', array(
	'url' => '/register',
	'inputDefaults' => array(
		'div' => 'form-group',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'well'
)); ?>

	<fieldset>
		<legend><?php echo __('Sign Up'); ?></legend>
	<?php
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('username');
		echo $this->Form->input('email');
		echo $this->Form->input('password');
		echo $this->Form->input('password_confirm', array('label' => 'Confirm Password', 'maxLength' => 255, 'title' => 'Confirm password', 'type'=>'password'));
		echo $this->Form->input('age');
		echo $this->Form->input('location');
	?>
	</fieldset>
<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn', 'div' => false)); ?>
</div>
<?php
if($this->Session->check('Auth.User')){
	echo $this->Html->link( "Return to Dashboard",   array('action'=>'index') );
	echo "<br>";
	echo $this->Html->link( "Logout",   array('action'=>'logout') );
}else{
	echo $this->Html->link( "Return to Login Screen",   array('action'=>'login') );
}
?>