<?php
	if(!isset($_SESSION)) {
	    session_start();
	}
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="x-ua-compatible" content="IE=Edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title('&raquo;','true','right'); ?><?php bloginfo('name'); ?></title>
<?php wp_head(); ?>
<script src="https://use.typekit.net/wfr3tiw.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script>
<?php /* Include marketing fields */ the_field('google_analytics', 'options'); the_field('schema', 'options'); the_field('kenshoo', 'options'); ?>
</head>

<body <?php body_class( $class ); ?>>

<div class="wrapper">

	<?php get_template_part('_parts/phone-nav-top'); ?>

	<div class="sticky-bar">

		<div class="container">

			<div class="phone-top-right">

		        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <span class="ld-calltag"><?php the_field('default_phone_tag', 'option'); ?></span> <span class="ld-phonenumber"><?php the_field('default_phone_number', 'option'); ?></span></p>

			</div>

			<nav role="top-navigation">
				<?php wp_nav_menu( array('menu' => 'Top Nav', 'menu_class' => "main-navigation", 'container' => '' )); ?>
			</nav>

		</div>

	</div>

	<div class="index-hero">

		<header role="banner">

			<div class="container">

				<div class="logo-wrapper">
					<a href="<?php echo home_url(); ?>">
						<img class="logo" src="<?php echo get_stylesheet_directory_uri(); ?>/_static/images/logo.svg" alt="<?php the_field('company_name', 'option'); ?> Logo" />
					</a>
				</div>

				<nav role="navigation">
					<?php wp_nav_menu( array('menu' => 'Main Nav', 'menu_class' => "main-navigation", 'container' => '' )); ?>
				</nav>

			</div><!-- /.container-->

		</header>

		<?php /* Mobile nav */ ?>

		<div id="mmenu">
			<div>
			<?php wp_nav_menu( array('menu' => 'Main Nav', 'menu_class' => "mobile-navigation", 'container' => '' )); ?>
			<?php wp_nav_menu( array('menu' => 'Top Nav', 'menu_class' => "mobile-navigation", 'container' => '' )); ?>
			</div>
		</div>