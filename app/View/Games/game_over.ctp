<div class="games view">

	<?php if (!$partner_story_started || !$my_story_started) {?>
	<div class="row">
		<div class="span8">
			<h3>Welcome to your game!</h3>			
			<?php if (!$partner_story_started) {?>
			To get started, please enter a beginning sentence for your partner:
			<div class="games form">
				<?php echo $this->Form->create('Story'); ?>
				<?php echo $this->Form->input('first_sentence', array('label' => '', 'type' => 'text', 'style' => 'width: 450px;'));?>
				<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn', 'div' => false)); ?>
			</div>
			<br /><br />
			<?php }?>
			<?php if (!$my_story_started) {?>
				Waiting for a starting sentence from your partner.
			<?php } else {?>

			<h4><small>First sentence:</small></h4>
			<?php echo $first_sentence?>

			<?php }?>
		</div>
		<?php echo $this->element('player_board');?>
	</div>

	<?php } else {?>
	<div class="row">
		<div class="span8 min_height">
			<h4><small>First sentence:</small></h4>
			<?php 
			echo $first_sentence;
			?>
			<br /><br />
			Story <?php echo ($finished == 1) ? "(finished)" : "" ?>:  <?php echo ($submitted == 0) ? $this->Html->link('[edit]', '/stories/edit/'.$my_story_id) : '';?>
			<br />
			<?php echo (empty($my_story_text)) ? $first_sentence : $my_story_text;?>
			<br />
			<?php 
			if ($submitted == 0) {
				if ($finished == 1) {
					echo $this->Form->postLink('[mark unfinished]', '/stories/unfinished/'.$my_story_id, null, 'Are you sure you want to mark this story unfinished?');
				} else {
					echo $this->Form->postLink('[mark finished]', '/stories/finished/'.$my_story_id, null, 'Are you sure you want to mark this story finished?');
				}
			}
			?>
		</div>
		<?php echo $this->element('player_board');?>
		<?php echo $this->element('submit');?>
		<?php echo $this->element('comments');?>
	</div>
	<?php }?>
</div>
