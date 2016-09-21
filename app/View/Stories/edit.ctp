<?php
$this->TinyMCE->editor(
		array(
			'theme' => 'advanced',
			'theme_advanced_toolbar_location' => 'top',
			'theme_advanced_toolbar_align' => 'left',
	        'theme_advanced_statusbar_location' => 'bottom',
			'mode' => 'textareas',
			'plugins' => 'wordcount2,autolink,lists,spellchecker,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template',
	        'theme_advanced_buttons1' => 'bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect',
	        'theme_advanced_buttons2' => 'cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor',
	        'theme_advanced_buttons3' => 'tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl,|,fullscreen',
	        'theme_advanced_buttons4' => 'spellchecker,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,blockquote,pagebreak,|,insertfile,insertimage',
	        'wordcount_limit' => STORY_LENGTH_LIMIT
			)
	);
?>
<div class="stories view">
	<div class="row">
		<div class="span8">
			<h4><small>First sentence:</small></h4>
			<?php 
			echo $first_sentence;
			?>
			<br /><br />
			<div class="games form">
				<?php echo $this->Form->create('Story'); ?>
				<?php echo $this->Form->hidden('id');?>
				<?php echo $this->Form->input('story_text', array('rows' => '75'));?>
				<br />
				<?php echo $this->Form->end(array('label' => 'Save', 'class' => 'btn', 'div' => false)); ?>
			</div>
		</div>
		<?php echo $this->element('player_board');?>
		<?php echo $this->element('comments');?>
	</div>
</div>
