<!DOCTYPE html>
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
<?php if (strpos($_SERVER['SERVER_NAME'],'alexjamesdesign.co.uk') !== false) : ?>
<meta name="robots" content="noindex">
<?php endif; ?>
<script async src="//275768.tctm.co/t.js"></script>
</head>

<body <?php body_class(); ?>>

<div class="wrapper">

	<?php get_template_part('_parts/phone-nav-top'); ?>

	<div class="sticky-bar">

		<div class="container">

			<div class="phone-top-right">

			<?php 
				$ld_location = get_field('location');
				if($ld_location) : ?>

					<?php if ( ( do_shortcode('[ctm_set]') )) : ?>
		                <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo do_action('ctm_location'); ?> <?php do_action('ald_single', $ld_location, false); ?></p>
		            <?php else: ?>
		                <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_single', $ld_location, false); ?></p>
		            <?php endif; ?>

				<?php else: ?>

				

				<?php if ( ( do_shortcode('[ctm_set]') )) : ?>
	                <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo do_action('ctm_location'); ?> <?php do_action('ald_default'); ?></p>
	            <?php else: ?>
	                <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_default'); ?></p>
	            <?php endif; ?>
					
			<?php endif; ?>

			</div>

			<nav role="top-navigation">
				<?php wp_nav_menu( array('menu' => 'Top Nav', 'menu_class' => "main-navigation", 'container' => '' )); ?>
			</nav>

		</div>

	</div>

	<?php
		global $term;

		if ( is_front_page() || is_singular('locations')) {

			$heroType = "hero-home";

		} elseif(is_page('contact')) {

			$heroType = "hero-contact";

		} elseif ( is_page() && ($post->post_parent)) {

			$heroType = "hero-child";

		} elseif ( is_archive('case-studies')) {

			$heroType = "hero-case-study-archive";
		
		} elseif (is_singular('case_studies')) {

			$heroType = "hero-case-study";

		} elseif ( is_home() || is_single()) {

			$heroType = "hero-archive";

		} else {

			$heroType = "hero-parent";

		}
	?>

	<div class="hero <?php echo $heroType?>">

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