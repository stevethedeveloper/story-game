<div class="users form">
<?php echo $this->Form->create('User', array(
	'action' => 'search',
	'inputDefaults' => array(
		'div' => 'form-group',
		'wrapInput' => false,
		'class' => 'form-control'
	),
	'class' => 'well'
)); ?>

	<fieldset>
		<legend><?php echo __('Search for Partner'); ?></legend>
	<?php
		echo $this->Form->input('username');
	?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => 'Search', 'class' => 'btn', 'div' => false)); ?>

<?php
if (isset($users) && !empty($users)) {
?>


	<h1>Search Results</h1>
	<table class="table table-striped table-bordered">
	<tr>
			<th><?php echo $this->Paginator->sort('username'); ?></th>
			<th><?php echo $this->Paginator->sort('age'); ?></th>
			<th><?php echo $this->Paginator->sort('location'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['age']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['location']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('Start Game'), array('controller' => 'games', 'action' => 'friend', $user['User']['id']), array(), __('Are you sure you want to start a game with %s?', $user['User']['username'])); ?>
		</td>
	</tr>
	<?php endforeach; ?>
		</table>
	<?php echo $this->Paginator->pagination(array(
	    'div' => 'pagination'
	)); ?>
<?php }?>

<?php
echo $this->Html->link( "Return to Dashboard",   array('controller' => 'dashboard') );
?>

</div>
