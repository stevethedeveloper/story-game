<div class="storyComments view">
<h2><?php echo __('Story Comment'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($storyComment['StoryComment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Story'); ?></dt>
		<dd>
			<?php echo $this->Html->link($storyComment['Story']['id'], array('controller' => 'stories', 'action' => 'view', $storyComment['Story']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($storyComment['User']['id'], array('controller' => 'users', 'action' => 'view', $storyComment['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Comment'); ?></dt>
		<dd>
			<?php echo h($storyComment['StoryComment']['comment']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($storyComment['StoryComment']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($storyComment['StoryComment']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Story Comment'), array('action' => 'edit', $storyComment['StoryComment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Story Comment'), array('action' => 'delete', $storyComment['StoryComment']['id']), array(), __('Are you sure you want to delete # %s?', $storyComment['StoryComment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Story Comments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story Comment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stories'), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story'), array('controller' => 'stories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
