<div class="stories index">
	<h2><?php echo __('Submitted Stories'); ?></h2>

	<div class="row">  
		<div class="span12">  
			<table class="table table-bordered">
			<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('User.username', 'User'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($stories as $story): ?>
			<tr>
				<td><?php echo h($story['Story']['id']); ?>&nbsp;</td>
				<td><?php echo h($story['User']['username']); ?>&nbsp;</td>
				<td class="actions">
					<a href="#myModal<?php echo h($story['Story']['id']); ?>" role="button" class="btn" data-toggle="modal">Read Story</a>
					<br />
					<br />
					<?php echo $this->Html->link(__('Approve'), array('action' => 'admin_approve_front_page', $story['Story']['id']), array('class' => 'btn'), 'Approve this story?'); ?>
					<br />
					<br />
					<?php echo $this->Html->link(__('Decline'), array('action' => 'admin_decline_front_page', $story['Story']['id']), array('class' => 'btn'), 'Decline this story?'); ?>
					<?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $game['Game']['id'])); ?>
					<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $game['Game']['id']), array(), __('Are you sure you want to delete # %s?', $game['Game']['id'])); ?>
				</td>
			</tr>

			<div id="myModal<?php echo h($story['Story']['id']); ?>" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-header">
			    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			    <h3 id="myModalLabel"><?php echo h($story['User']['username']); ?>'s Story</h3>
			  </div>
			  <div class="modal-body">
			    <?php echo $story['Story']['story_text']?>
			  </div>
			  <div class="modal-footer">
			    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			  </div>
			</div>

		<?php endforeach; ?>
			</table>
			<?php echo $this->Paginator->pagination(array(
			    'div' => 'pagination'
			)); ?>
		</div>  
	</div>  


