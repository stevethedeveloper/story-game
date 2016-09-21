<div class="storyComments index">
	<h2><?php echo __('Story Comments'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('story_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('comment'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($storyComments as $storyComment): ?>
	<tr>
		<td><?php echo h($storyComment['StoryComment']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($storyComment['Story']['id'], array('controller' => 'stories', 'action' => 'view', $storyComment['Story']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($storyComment['User']['id'], array('controller' => 'users', 'action' => 'view', $storyComment['User']['id'])); ?>
		</td>
		<td><?php echo h($storyComment['StoryComment']['comment']); ?>&nbsp;</td>
		<td><?php echo h($storyComment['StoryComment']['created']); ?>&nbsp;</td>
		<td><?php echo h($storyComment['StoryComment']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $storyComment['StoryComment']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $storyComment['StoryComment']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $storyComment['StoryComment']['id']), array(), __('Are you sure you want to delete # %s?', $storyComment['StoryComment']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Story Comment'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Stories'), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story'), array('controller' => 'stories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>
