<div class="stories index">
	<h2><?php echo __('Stories'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('game_id'); ?></th>
			<th><?php echo $this->Paginator->sort('user_id'); ?></th>
			<th><?php echo $this->Paginator->sort('first_sentence'); ?></th>
			<th><?php echo $this->Paginator->sort('story_text'); ?></th>
			<th><?php echo $this->Paginator->sort('submitted'); ?></th>
			<th><?php echo $this->Paginator->sort('front_page'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($stories as $story): ?>
	<tr>
		<td><?php echo h($story['Story']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($story['Game']['id'], array('controller' => 'games', 'action' => 'view', $story['Game']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($story['User']['id'], array('controller' => 'users', 'action' => 'view', $story['User']['id'])); ?>
		</td>
		<td><?php echo h($story['Story']['first_sentence']); ?>&nbsp;</td>
		<td><?php echo h($story['Story']['story_text']); ?>&nbsp;</td>
		<td><?php echo h($story['Story']['submitted']); ?>&nbsp;</td>
		<td><?php echo h($story['Story']['front_page']); ?>&nbsp;</td>
		<td><?php echo h($story['Story']['created']); ?>&nbsp;</td>
		<td><?php echo h($story['Story']['modified']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $story['Story']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $story['Story']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $story['Story']['id']), array(), __('Are you sure you want to delete # %s?', $story['Story']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Story'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Story Comments'), array('controller' => 'story_comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story Comment'), array('controller' => 'story_comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
