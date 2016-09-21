	<div class="row">
		<div class="span8">
			<h3>Welcome to your game!</h3>			
			<?php if ($game['Partner']['status'] == 'first_sentence') {?>
				To get started, please enter a beginning sentence for your partner:
				<div class="games form">
					<?php echo $this->Form->create('Story', array('url' => '/stories/first_sentence/'.$game['Partner']['Story']['id'])); ?>
					<?php echo $this->Form->hidden('Story.game_id', array('value' => $game['Game']['id']));?>
					<?php echo $this->Form->input('first_sentence', array('label' => '', 'type' => 'text', 'style' => 'width: 450px;'));?>
					<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn', 'div' => false)); ?>
				</div>
				<br /><br />
			<?php }?>

			<?php if ($game['Me']['status'] == 'first_sentence') {?>
				Waiting for a starting sentence from your partner.
			<?php }?>
		</div>
	</div>
