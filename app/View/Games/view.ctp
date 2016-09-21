<div class="games view">
	<div class="row">
		<div class="span8 min_height">
			<?php if ($render_first_sentence === true) {?>
				<?php echo $this->element('first_sentence');?>
			<?php } else {?>
				<?php 
					if ($game['Me']['Story']['genre_id']) {
						$my_genre_name = $game['Me']['Story']['genre_name'];
					?>
						Genre: <?php echo $my_genre_name?>
						<br /><br />
						<h4><small>First sentence:</small></h4>
						<?php 
						echo $game['Me']['Story']['first_sentence'];
						?>
						<br /><br />
						Story <?php echo ($game['Me']['status'] == 'finished') ? "(finished)" : "" ?>:  <?php echo ($game['Me']['Story']['submitted'] == 0) ? $this->Html->link('[edit]', '/stories/edit/'.$game['Me']['Story']['id']) : '';?>
						<br />
						<?php echo (empty($game['Me']['Story']['story_text'])) ? $game['Me']['Story']['first_sentence'] : $game['Me']['Story']['story_text'];?>
						<br />
						<?php 
						if ($game['Me']['Story']['submitted'] == 0) {
							if ($game['Me']['status'] != 'finished') {
								echo $this->Form->postLink('[mark finished and let your partner make comments]', '/stories/finished/'.$game['Me']['Story']['id'], null, 'Are you sure you want to mark this story finished?');
							}
						}
						?>
					<?php } else {?>
						<h4><small>First sentence:</small></h4>
						<?php 
						echo $game['Me']['Story']['first_sentence'];
						?>
						<br /><br />
						<?php echo $this->Form->create('Story', array(
							'url' => '/stories/add_genre/'.$game['Me']['Story']['id'],
							'inputDefaults' => array(
								'div' => 'form-group',
								'label' => false,
								'wrapInput' => false,
								'class' => 'form-control'
							),
							'class' => 'well'
						)); ?>
						<fieldset>
							<legend>You haven't selected a genre yet</legend>
							<?php
								echo $this->Form->hidden('id', array('value' => $game['Me']['Story']['id']));
								echo $this->Form->hidden('game_id', array('value' => $game['Game']['id']));
								echo $this->Form->input('genre_id', array('label' => 'Genre', 'values' => $genres));
								echo '<div id="genre-other">';
								echo $this->Form->input('genre_other', array('label' => 'Other'));
								echo '</div>';
							?>
							<script>
							jQuery(function() {
								jQuery("#StoryGenreId").change(function() {
									if (this.value == '14') {
										jQuery('#genre-other').show();
									} else {
										jQuery('#genre-other').hide();
									}
								});
							});
	   						</script>
						</fieldset>
						<?php echo $this->Form->submit('Submit', array(
							'div' => 'form-group',
							'class' => 'btn btn-default'
						)); ?>
						<?php echo $this->Form->end(); ?>
					<?php 
				}?>
			<?php }?>
		</div>
		<?php echo $this->element('player_board');?>
		<?php echo $this->element('submit');?>
		<?php echo $this->element('comments');?>
	</div>
</div>
