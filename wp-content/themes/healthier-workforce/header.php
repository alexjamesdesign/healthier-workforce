<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="x-ua-compatible" content="IE=Edge"> 
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title('&raquo;','true','right'); ?></title>
<?php wp_head(); ?>
<!-- <script src="https://use.typekit.net/wfr3tiw.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script> -->

<link rel="stylesheet" href="https://use.typekit.net/wfr3tiw.css">



<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-80484431-1', 'auto');
ga('require', 'displayfeatures');
ga('require', 'linkid', 'linkid.js');
  ga('send', 'pageview');
</script>
<meta name="google-site-verification" content="yLnj_B5DVAB3ZwUsA-3kIhqbEO2ilzYK47EPye7Pi3I" />

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-R58ZRXT50S"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-R58ZRXT50S');
</script>

<script type="application/ld+json">

// Business name, address, opening hours, logo social profiles

{
  "@context" : "http://schema.org",
  "@type": "Organization",
  "name" : "Healthier Workforce",
  "logo" : "https://www.healthier-workforce.co.uk/wp-content/themes/healthier-workforce/_static/images/logo.svg",
  "url": "https://www.healthier-workforce.co.uk",
      "sameAs" : 
  [ 
    "https://plus.google.com/+"
  ],
    "description": "Healthier Workforce provides professional services which help improve and motivate your employees. We operate in many areas including Essex, Chelmsford and Colchester."
}

</script>

 <script type="application/ld+json">

 	// Colloquial site name - for mobile SERPs
{  
    "@context" : "http://schema.org",
       "@type" : "WebSite",
       "name" : "Healthier Workforce",
       "url" : "https://www.healthier-workforce.co.uk"
}

</script>


<!-- <script async src="//275768.tctm.co/t.js"></script> -->
</head>

<body <?php body_class(); ?>>

<div class="wrapper">

	<?php get_template_part('_parts/phone-nav-top'); ?>

	<div class="sticky-bar">

		<div class="container">

			<?php get_template_part('_parts/notification'); ?>

			<div class="phone-top-right">

			<?php 
			$ld_location = get_field('location_name');
			if($ld_location) : ?>
			

				<?php if ( ( do_shortcode('[ctm_set]') )) : ?>
					<p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo ucfirst($ld_location); ?> <?php do_action('ald_single', $ld_location, false); ?></p>
				<?php else: ?>
					<p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_single', $ld_location, false); ?></p>
				<?php endif; ?>


			<?php else : ?>
				

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

	<div class="hero lazyload <?php echo $heroType?>">

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