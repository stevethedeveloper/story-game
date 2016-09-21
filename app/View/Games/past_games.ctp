<div class="games index">
	<h2><?php echo __('My Games'); ?></h2>

	<div class="row">  
		<div class="span12">  
			<ul class="nav nav-pills">  
				<li><?php echo $this->Html->link('Active ('.$counts['active'].')', '/games')?></li>   
				<li><?php echo $this->Html->link('Invitations Sent ('.$counts['invitations_sent'].')', '/games/invitations_sent')?></li>  
				<li><?php echo $this->Html->link('Invitations Received ('.$counts['invitations_received'].')', '/games/invitations_received')?></li>   
				<li class="active"><?php echo $this->Html->link('Past Games ('.$counts['past_games'].')', '/games/past_games')?></li>   
			</ul>  
		</div>  
	</div>  

	<div class="row">  
		<div class="span12">  
			<table class="table table-striped table-bordered">
			<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('User1.username', 'Player 1'); ?></th>
					<th><?php echo $this->Paginator->sort('User2.username', 'Player 2'); ?></th>
					<th><?php echo $this->Paginator->sort('accepted_date', 'Date Started'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
			</tr>
			<?php foreach ($games as $game): ?>
			<tr>
				<td><?php echo h($game['Game']['id']); ?>&nbsp;</td>
				<td><?php echo h($game['User1']['username']); ?>&nbsp;</td>
				<td><?php echo h($game['User2']['username']); ?>&nbsp;</td>
				<td><?php echo h($game['Game']['accepted_date']); ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $game['Game']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
			</table>
			<?php echo $this->Paginator->pagination(array(
			    'div' => 'pagination'
			)); ?>
		</div>  
	</div>  


