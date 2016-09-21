	<?php if (isset($story_comments) && count($story_comments) > 0 && count($partner_story_comments) > 0) {?>
		<div class="span4 well">
			<?php
			$ip     = $_SERVER['REMOTE_ADDR'];
			$json   = @file_get_contents( 'http://smart-ip.net/geoip-json/' . $ip);

			$ipData = json_decode( $json, true);

			$server_tz = date("T");

			if ($ipData['timezone']) {
			    $tz = new DateTimeZone( $ipData['timezone']);
			} else {
			    $tz = new DateTimeZone(date_default_timezone_get());
			}

			foreach ($story_comments as $comment): ?>
				<strong>
					<?php 
						$date = new DateTime($comment['StoryComment']['created'].' '.$server_tz);
						$date->setTimeZone($tz);
						echo $date->format('n/j/Y g:ia T');
					?>
				</strong>
				<br />
				<?php echo $comment['StoryComment']['comment']?>
				<hr />
			<?php endforeach; ?>

		</div>
	<?php }?>
