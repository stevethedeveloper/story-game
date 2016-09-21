<div class="users form">
<?php echo $this->Form->create('User', array(
	'url' => '/users/reset',
	'inputDefaults' => array(
		'div' => 'form-group',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'well'
)); ?>

	<fieldset>
		<legend><?php echo __('Reset Password'); ?></legend>
	<?php
        echo $this->Form->hidden('id', array('value' => $this->data['User']['id']));
        echo $this->Form->hidden('password_token', array('value' => $this->data['User']['password_token']));
        echo $this->Form->input('password_update', array( 'label' => 'New Password *', 'maxLength' => 255, 'title' => 'Confirm New password', 'type'=>'password'));
        echo $this->Form->input('password_confirm_update', array('label' => 'Confirm New Password *', 'maxLength' => 255, 'title' => 'Confirm New password', 'type'=>'password'));
         
        echo $this->Form->submit('Reset Password', array('class' => 'form-submit',  'title' => 'Click here to reset your password') );
	?>
	</fieldset>
<?php echo $this->Form->end(); ?>
</div>
