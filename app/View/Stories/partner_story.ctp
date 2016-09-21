<?php
$this->TinyMCE->editor(
		array(
			'theme' => 'advanced',
			'theme_advanced_toolbar_location' => 'top',
			'theme_advanced_toolbar_align' => 'left',
	        'theme_advanced_statusbar_location' => 'bottom',
			'mode' => 'textareas',
			'plugins' => 'autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
	        'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect',
	        'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
	        'theme_advanced_buttons3' => 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl,|,fullscreen',
	        'theme_advanced_buttons4' => 'spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,blockquote,pagebreak,|,insertfile,insertimage'
			)
	);
?>
<div class="stories view">
	<div class="row">
		<div class="span8">
			<h4><small>First sentence:</small></h4>
			<?php echo $story['Story']['first_sentence'];?>
			<br /><br />
			<?php echo $story['Story']['story_text'];?>
			<br /><br />
			<div class="games form">
				<?php echo $this->Form->create('StoryComment'); ?>
				<?php echo $this->Form->hidden('id');?>
				<?php echo $this->Form->input('comment', array('rows' => '25', 'label' => 'Make Comment'));?>
				<br />
				<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn', 'div' => false)); ?>
			</div>
		</div>
		<div class="span4 well">
			<small><?php echo $this->Html->link('<< return to game', '/games/view/'.$game['Game']['id'])?></small>
		</div>
		<?php echo $this->element('player_board');?>
		<?php echo $this->element('comments');?>
	</div>
</div>
