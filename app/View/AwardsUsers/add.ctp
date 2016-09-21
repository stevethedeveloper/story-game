<div class="awardsUsers form">
<?php echo $this->Form->create('AwardsUser'); ?>
	<fieldset>
		<legend><?php echo __('Add Awards User'); ?></legend>
	<?php
		echo $this->Form->input('award_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Awards Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
