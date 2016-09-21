<div class="emails index">
	<h2><?php echo __('Emails'); ?></h2>
	<table cellpadding="0" cellspacing="0" class="table table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('subject'); ?></th>
			<th><?php echo $this->Paginator->sort('date_sent'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($emails as $email): ?>
	<tr>
		<td><?php echo h($email['SystemEmail']['subject']); ?>&nbsp;</td>
		<td><?php echo ($email['SystemEmail']['date_sent'] != '0000-00-00 00:00:00') ? date('m-d-Y h:i:sA', strtotime($email['SystemEmail']['date_sent'])) : ''; ?>&nbsp;</td>
		<td><?php echo date('m-d-Y h:i:sA', strtotime($email['SystemEmail']['created'])); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $email['SystemEmail']['id'])); ?>
			<br />
			<?php echo $this->Form->postLink(__('Send'), array('action' => 'send', $email['SystemEmail']['id']), array(), __('Are you sure you want to send "%s"?', $email['SystemEmail']['subject'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<?php echo $this->Paginator->pagination(array(
	    'div' => 'pagination'
	)); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Email'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('Export Email List'), array('action' => 'export')); ?></li>
	</ul>
</div>
