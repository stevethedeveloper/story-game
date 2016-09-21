<div class="stories view">
<h2><?php echo __('Story'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($story['Story']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Game'); ?></dt>
		<dd>
			<?php echo $this->Html->link($story['Game']['id'], array('controller' => 'games', 'action' => 'view', $story['Game']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User'); ?></dt>
		<dd>
			<?php echo $this->Html->link($story['User']['id'], array('controller' => 'users', 'action' => 'view', $story['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Sentence'); ?></dt>
		<dd>
			<?php echo h($story['Story']['first_sentence']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Story Text'); ?></dt>
		<dd>
			<?php echo h($story['Story']['story_text']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Submitted'); ?></dt>
		<dd>
			<?php echo h($story['Story']['submitted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Front Page'); ?></dt>
		<dd>
			<?php echo h($story['Story']['front_page']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($story['Story']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($story['Story']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Story'), array('action' => 'edit', $story['Story']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Story'), array('action' => 'delete', $story['Story']['id']), array(), __('Are you sure you want to delete # %s?', $story['Story']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Stories'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Games'), array('controller' => 'games', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Game'), array('controller' => 'games', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Story Comments'), array('controller' => 'story_comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story Comment'), array('controller' => 'story_comments', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Story Comments'); ?></h3>
	<?php if (!empty($story['StoryComment'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Story Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Comment'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($story['StoryComment'] as $storyComment): ?>
		<tr>
			<td><?php echo $storyComment['id']; ?></td>
			<td><?php echo $storyComment['story_id']; ?></td>
			<td><?php echo $storyComment['user_id']; ?></td>
			<td><?php echo $storyComment['comment']; ?></td>
			<td><?php echo $storyComment['created']; ?></td>
			<td><?php echo $storyComment['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'story_comments', 'action' => 'view', $storyComment['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'story_comments', 'action' => 'edit', $storyComment['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'story_comments', 'action' => 'delete', $storyComment['id']), array(), __('Are you sure you want to delete # %s?', $storyComment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Story Comment'), array('controller' => 'story_comments', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
