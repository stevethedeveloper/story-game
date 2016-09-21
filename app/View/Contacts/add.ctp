<div class="contacts form">
<?php echo $this->Form->create('Contact', array(
	'url' => '/contact',
	'inputDefaults' => array(
		'div' => 'form-group',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'well'
)); ?>
	<fieldset>
		<legend><?php echo __('Contact Us'); ?></legend>
	<?php
		echo $this->Form->input('user_id', array('type' => 'hidden'));
		if ($loggedIn) {
			echo 'From: '. $username;
		}
		echo $this->Form->input('email');
		echo $this->Form->input('content', array('style' => 'width: 400px;'));
		if (!$loggedIn) {
			$this->Captcha->render($captchaSettings);
		}
	?>
	</fieldset>
<?php echo $this->Form->end(array('label' => 'Send', 'class' => 'btn', 'div' => false)); ?>
</div>
