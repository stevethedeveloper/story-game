<div class="storyComments form">
<?php echo $this->Form->create('StoryComment'); ?>
	<fieldset>
		<legend><?php echo __('Edit Story Comment'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('story_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('comment');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('StoryComment.id')), array(), __('Are you sure you want to delete # %s?', $this->Form->value('StoryComment.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Story Comments'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Stories'), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story'), array('controller' => 'stories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
