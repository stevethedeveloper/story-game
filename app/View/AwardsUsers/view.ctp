<div class="awardsUsers view">
<h2><?php echo __('Awards User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($awardsUser['AwardsUser']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Award Id'); ?></dt>
		<dd>
			<?php echo h($awardsUser['AwardsUser']['award_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('User Id'); ?></dt>
		<dd>
			<?php echo h($awardsUser['AwardsUser']['user_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Awards User'), array('action' => 'edit', $awardsUser['AwardsUser']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Awards User'), array('action' => 'delete', $awardsUser['AwardsUser']['id']), array(), __('Are you sure you want to delete # %s?', $awardsUser['AwardsUser']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Awards Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Awards User'), array('action' => 'add')); ?> </li>
	</ul>
</div>
