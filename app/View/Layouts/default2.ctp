<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('style');

		echo $this->Html->script("jquery.min");

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
		
	?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <?php echo $this->Html->script("html5shiv"); ?>
    <![endif]-->  
</head>
<body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
	       <a class="navbar-brand" href="/">Story Game</a>
        </div>
        <div class="navbar-collapse collapse" id="main-menu">
	       	<?php
	       	if ($loggedIn) {
	       		?>
	        <ul class="nav navbar-nav" id="main-menu-left">
	          <li class="dropdown">
	            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Games <span class="caret"></span></a>
	            <ul class="dropdown-menu" role="menu" id="swatch-menu">
	              <li><?php echo $this->Html->link('My Games', '/games')?></li>
	              <li class="divider"></li>
	              <li><?php echo $this->Html->link('New Game with Random Partner', '/games/random')?></li>
	              <li><?php echo $this->Html->link('New Game with Friend', '/users/search')?></li>
	            </ul>
	          </li>
	          <?php if (isset($is_admin) && $is_admin === true) {?>
	          <li class="dropdown">
	            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin <span class="caret"></span></a>
	            <ul class="dropdown-menu" role="menu" id="swatch-menu">
	              <li><?php echo $this->Html->link('Submissions', '/admin/stories/submissions')?></li>
	              <li><?php echo $this->Html->link('Emails', '/admin/system_emails/index')?></li>
	            </ul>
	          </li>
	          <?php }?>
	        </ul>
			<ul class="nav navbar-nav navbar-right">
				<li><?php echo $this->Html->link('Sign Out', '/logout')?></li>
				<li><?php echo $this->Html->link('Profile', '/users/edit')?></li>
				<li><?php echo $this->Html->link('Contact', '/contact')?></li>
			</ul>
	        <?php } else {?>
			<ul class="nav navbar-nav navbar-right">
				<li><?php echo $this->Html->link('Sign In', '/login')?></li>
				<li><?php echo $this->Html->link('Sign Up', '/register')?></li>
				<li><?php echo $this->Html->link('Contact', '/contact')?></li>
			</ul>
	        <?php }?>
        </div><!--/.nav-collapse -->
      </div>
    </div>

	<div id="container">
		<div id="header">
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
	<?php
		echo $this->Html->script("bootstrap.min");
    ?>
</body>
</html>
