<div class="stories form">
<?php echo $this->Form->create('Story'); ?>
	<fieldset>
		<legend><?php echo __('Add Story'); ?></legend>
	<?php
		echo $this->Form->input('game_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('first_sentence');
		echo $this->Form->input('story_text');
		echo $this->Form->input('submitted');
		echo $this->Form->input('front_page');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Stories'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Story Comments'), array('controller' => 'story_comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story Comment'), array('controller' => 'story_comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
