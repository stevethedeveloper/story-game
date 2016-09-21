		<?php if ($can_submit == true) {?>
			<div class="span4 well pull-right">
				<?php if ($game['Me']['Story']['submitted'] == 0) {?>
					<h3>Think other Story Gamers will like your story?<br /><?php echo $this->Html->link('Submit it to the front page!', '/stories/submit/'.$game['Me']['Story']['id'], null, 'Are you sure you want to submit your story? You will no longer be able to edit your story after submitting.')?></h3>
				<?php } elseif ($game['Me']['Story']['submitted'] == 1 && $game['Me']['Story']['front_page'] == 0) {?>
					<h3>Your story has been submitted to be reviewed for the front page.</h3>
				<?php } elseif ($game['Me']['Story']['submitted'] == 1 && $game['Me']['Story']['front_page'] == 1) {?>
					<h3>Your story has made the front page!</h3>
				<?php }?>
			</div>
		<?php }?>
