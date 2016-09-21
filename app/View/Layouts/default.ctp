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
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('bootstrap-responsive.min');
		echo $this->Html->css('font-awesome.min');
		echo $this->Html->css('style');

		echo $this->Html->script("jquery.min");
		echo $this->Html->script("bootstrap.min");

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
	  <!-- Navbar -->
	 <div class="navbar navbar-fixed-top">
	   <div class="navbar-inner">
	     <div class="container">
	       <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
	         <span class="icon-bar"></span>
	         <span class="icon-bar"></span>
	         <span class="icon-bar"></span>
	       </a>
	       <a class="brand" href="/">Story Game</a>
	       <div class="nav-collapse collapse" id="main-menu">
	       	<?php
	       	if ($loggedIn) {
	       		?>
	        <ul class="nav" id="main-menu-left">
	          <li class="dropdown">
	            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Games <b class="caret"></b></a>
	            <ul class="dropdown-menu" id="swatch-menu">
	              <li><?php echo $this->Html->link('My Games', '/games')?></li>
	              <li class="divider"></li>
	              <li><?php echo $this->Html->link('New Game with Random Partner', '/games/random')?></li>
	              <li><?php echo $this->Html->link('New Game with Friend', '/users/search')?></li>
	            </ul>
	          </li>
	          <?php if (isset($is_admin) && $is_admin === true) {?>
	          <li class="dropdown">
	            <a class="dropdown-toggle" data-toggle="dropdown" href="#">Admin <b class="caret"></b></a>
	            <ul class="dropdown-menu" id="swatch-menu">
	              <li><?php echo $this->Html->link('Submissions', '/admin/stories/submissions')?></li>
	              <li><?php echo $this->Html->link('Emails', '/admin/system_emails/index')?></li>
	            </ul>
	          </li>
	          <?php }?>
	        </ul>
	        <ul class="nav pull-right" id="main-menu-right">
	          <li><?php echo $this->Html->link('Sign Out', '/logout')?></li>
	        </ul>
	        <ul class="nav pull-right" id="main-menu-right">
	          <li><?php echo $this->Html->link('Profile', '/users/edit')?></li>
	        </ul>
	        <?php } else {?>
	        <ul class="nav pull-right" id="main-menu-right">
	          <li><?php echo $this->Html->link('Sign In', '/login')?></li>
	        </ul>
	        <ul class="nav pull-right" id="main-menu-right">
	          <li><?php echo $this->Html->link('Sign Up', '/register')?></li>
	        </ul>
	        <?php }?>
	        <ul class="nav pull-right" id="main-menu-right">
	          <li><?php echo $this->Html->link('Contact', '/contact')?></li>
	        </ul>
	       </div>
	     </div>
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
