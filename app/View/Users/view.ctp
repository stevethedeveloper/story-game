<div class="users view">
<h2><?php echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Screen Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['screen_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Age'); ?></dt>
		<dd>
			<?php echo h($user['User']['age']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Location'); ?></dt>
		<dd>
			<?php echo h($user['User']['location']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($user['User']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), array(), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stories'), array('controller' => 'stories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story'), array('controller' => 'stories', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Story Comments'), array('controller' => 'story_comments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Story Comment'), array('controller' => 'story_comments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Awards'), array('controller' => 'awards', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Award'), array('controller' => 'awards', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Stories'); ?></h3>
	<?php if (!empty($user['Story'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Game Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('First Sentence'); ?></th>
		<th><?php echo __('Story Text'); ?></th>
		<th><?php echo __('Submitted'); ?></th>
		<th><?php echo __('Front Page'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Story'] as $story): ?>
		<tr>
			<td><?php echo $story['id']; ?></td>
			<td><?php echo $story['game_id']; ?></td>
			<td><?php echo $story['user_id']; ?></td>
			<td><?php echo $story['first_sentence']; ?></td>
			<td><?php echo $story['story_text']; ?></td>
			<td><?php echo $story['submitted']; ?></td>
			<td><?php echo $story['front_page']; ?></td>
			<td><?php echo $story['created']; ?></td>
			<td><?php echo $story['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'stories', 'action' => 'view', $story['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'stories', 'action' => 'edit', $story['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'stories', 'action' => 'delete', $story['id']), array(), __('Are you sure you want to delete # %s?', $story['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Story'), array('controller' => 'stories', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Story Comments'); ?></h3>
	<?php if (!empty($user['StoryComment'])): ?>
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
	<?php foreach ($user['StoryComment'] as $storyComment): ?>
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
<div class="related">
	<h3><?php echo __('Related Awards'); ?></h3>
	<?php if (!empty($user['Award'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Description'); ?></th>
		<th><?php echo __('Image'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($user['Award'] as $award): ?>
		<tr>
			<td><?php echo $award['id']; ?></td>
			<td><?php echo $award['name']; ?></td>
			<td><?php echo $award['description']; ?></td>
			<td><?php echo $award['image']; ?></td>
			<td><?php echo $award['created']; ?></td>
			<td><?php echo $award['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'awards', 'action' => 'view', $award['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'awards', 'action' => 'edit', $award['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'awards', 'action' => 'delete', $award['id']), array(), __('Are you sure you want to delete # %s?', $award['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Award'), array('controller' => 'awards', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
