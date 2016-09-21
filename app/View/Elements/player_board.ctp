		<div class="span4 well pull-right">
			<h4>
			<small>Partner:</small>
			<br />
			<?php echo $game['Partner']['username']?>
			<br /><br />
			<small>Started:</small>
			<br />
			<?php echo date('n/j/Y', strtotime($game['Game']['created']))?>
			<br /><br />
			<small>Game Status:</small>
			<br />
			<?php echo  Inflector::humanize($game['Game']['game_status'])?>
			</h4>
			<?php if (!($this->params['controller'] == 'stories') && !($this->params['action'] == 'edit' || $this->params['action'] == 'partner_story')) {?>
				<br /><br />
				<?php if (($game['Partner']['status'] == 'finished' && $game['Me']['status'] == 'finished') && $game['Game']['game_status'] != 'completed') {?>
					<h3>Your partner has finished!</h3>
					<h4><?php echo $this->Html->link('Click here to read and make comments.', '/stories/partner_story/'.$game['Partner']['Story']['id'])?></h4>
				<?php }?>
				<?php if ($game['Game']['game_status'] != 'completed') {?>
					<br />
					<h3>Is this game over?<br /><?php echo $this->Html->link('Click here to close the game.', '/games/finished/'.$game['Game']['id'], null, 'Are you sure you want to mark this game over?  This cannot be undone!')?></h3>
				<?php }?>
			<?php }?>
		</div>

