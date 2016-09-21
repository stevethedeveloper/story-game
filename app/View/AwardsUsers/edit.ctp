<div class="awardsUsers form">
<?php echo $this->Form->create('AwardsUser'); ?>
	<fieldset>
		<legend><?php echo __('Edit Awards User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('award_id');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('AwardsUser.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('AwardsUser.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Awards Users'), array('action' => 'index')); ?></li>
	</ul>
</div>
