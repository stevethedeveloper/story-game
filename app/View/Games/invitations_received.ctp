<div class="games index">
	<h2><?php echo __('My Games'); ?></h2>

	<div class="row">  
		<div class="span12">  
			<ul class="nav nav-pills">  
				<li><?php echo $this->Html->link('Active ('.$counts['active'].')', '/games')?></li>   
				<li><?php echo $this->Html->link('Invitations Sent ('.$counts['invitations_sent'].')', '/games/invitations_sent')?></li>  
				<li class="active"><?php echo $this->Html->link('Invitations Received ('.$counts['invitations_received'].')', '/games/invitations_received')?></li>   
				<li><?php echo $this->Html->link('Past Games ('.$counts['past_games'].')', '/games/past_games')?></li>   
			</ul>  
		</div>  
	</div>  

	<div class="row">  
		<div class="span12">  
			<table class="table table-striped table-bordered">
			<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('User1.username', 'Received From'); ?></th>
					<th><?php echo $this->Paginator->sort('created', 'Date Received'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($games as $game): ?>
			<tr>
				<td><?php echo h($game['Game']['id']); ?>&nbsp;</td>
				<td><?php echo h($game['User1']['username']); ?>&nbsp;</td>
				<td><?php echo h($game['Game']['created']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Form->postLink(__('Accept'), array('controller' => 'games', 'action' => 'accept_invitation', $game['Game']['id']), array(), __('Are you sure you want to accept the invitation from %s?', $game['User1']['username'])); ?>
					 - 
					<?php echo $this->Form->postLink(__('Decline'), array('controller' => 'games', 'action' => 'decline_invitation', $game['Game']['id']), array(), __('Are you sure you want to decline the invitation from %s?', $game['User1']['username'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</table>
			<?php echo $this->Paginator->pagination(array(
			    'div' => 'pagination'
			)); ?>
		</div>  
	</div>  


