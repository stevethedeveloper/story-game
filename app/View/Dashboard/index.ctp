<div class="dashboard index">
<h1>Welcome</h1>
<h4>Latest Stories</h4>

	<div class="row">
		<div class="span10">

		<?php foreach ($stories as $story): ?>
			<div class="row well">
				<div class="span9">
					Author: <?php echo $story['User']['username']; ?>
					<br /><br />
					<?php echo $story['Story']['story_text']; ?>
				</div>
			</div>
		<?php endforeach; ?>
		<?php echo $this->Paginator->pagination(array(
		    'div' => 'pagination'
		)); ?>
		</div>
		<div class="span2 well" align="center">
			<?php if (count($awards) > 0) {?>
				<?php foreach ($awards as $award) {?>
					<?php echo $this->Html->image($award['Award']['image']);?>
					<br />
					<strong><?php echo $award['Award']['name'];?></strong>
					<br />
					<?php echo $award['Award']['description'];?>
					<br />
					<br />
				<?php }?>
			<?php }?>
		</div>
	</div>
</div>