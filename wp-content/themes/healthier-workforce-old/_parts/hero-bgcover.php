<?php

	global $term;

	/* This uses the featured image as a background. Takes the featured image, and applies the different sizes to varying breakpoints. */

	$thumb_id = get_post_thumbnail_id();

	$thumb_url_array_small = wp_get_attachment_image_src($thumb_id, 'hero-600', true);
	$thumb_url_small = $thumb_url_array_small[0];

	$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'hero-1200', true);
	$thumb_url = $thumb_url_array[0];

	$thumb_url_array_large = wp_get_attachment_image_src($thumb_id, 'hero-2000', true);
	$thumb_url_large = $thumb_url_array_large[0];

	if ( $thumb_id ) : ?>

		<style scoped>
			.hero.lazyloaded {
				background-image: url(<?php echo $thumb_url_small; ?>);
			}
			@media (min-width: 600px) {
				.hero.lazyloaded {
					background-image: url(<?php echo $thumb_url; ?>);
				}
			}
			@media (min-width: 1200px) {
				.hero.lazyloaded {
					background-image: url(<?php echo $thumb_url_large; ?>);
				}
			}
		</style>

	<?php else : ?>


	<?php endif; ?>

<?php

 if (is_singular('case_studies')) { ?>

	<?php /* Single news post hero */ ?>

	<div class="hero lazyload hero-singular">

		<div class="container">

			<div class="hero-content">

			<?php /* Hero text */ ?>

				<?php $logoimage = get_field('logo');

                    if( !empty($logoimage) ): ?>

                    <p><?php the_field('leading_line'); ?></p>

                    <img src="<?php echo $logoimage['url']; ?>" />

                <?php endif; ?>

			<?php /* Hero CTAs */ ?>

			<?php while( has_sub_field('hero_ctas') ): ?>

				<?php

					$displaytext = get_sub_field('display_text');
					$pagelink = get_sub_field('page_link');
					$buttonclass = get_sub_field('button_class');

				?>

		 		<a class="<?php echo $buttonclass; ?>" href="<?php echo ($siteurl . get_sub_field('page_link')); ?>">

		 			<?php echo $displaytext; ?>

				</a>

			<?php endwhile; ?>

			</div>	

		</div>

	</div>
	


<?php } elseif (is_page('contact') || is_page('contact-us')) { ?>

	<?php /* Contact page hero */ ?>

<?php } elseif (is_tax('resource_centre')) {

/* -----------------------------------------------------------------
Taxonomy
----------------------------------------------------------------- */

?>

<div class="hero no-bg resources">
	<div class="container">
		<div class="hero-content fadeLeft fadeLeft__4">
			<h1><?php single_term_title(); ?></h1>
			<p><?php echo term_description(); ?></p>
		</div>
	</div>
</div>

<?php } elseif (is_post_type_archive('resource_centre')) {

/* -----------------------------------------------------------------
Resource centre
----------------------------------------------------------------- */

?>

<div class="hero no-bg resources">
	<div class="container">
		<div class="hero-content fadeLeft fadeLeft__4">
			<h1>Resource Centre</h1>
			<p class="secondary">Welcome to our information hub. Guides, advice, FAQs and much more are just a few clicks away.</p>
		</div>
	</div>
</div>


<?php } else { ?>

	<div class="hero-outer">

	<div class="container hero-container">

	<div class="hero-content">

	<?php if (get_field('hero_primary_line')) : ?>

		<?php if  ( do_shortcode('[ctm_set]') && get_field('location') == 'Yes' ) : ?>
			<p class="primary"><?php the_field('hero_primary_line'); ?><span> in <?php echo do_action('ctm_location'); ?></span></p>
		<?php else : ?>
			<p class="primary"><?php the_field('hero_primary_line'); ?></p>
		<?php endif; ?>

		<?php if (get_field('hero_secondary_line')) : ?>
			<p class="secondary"><?php the_field('hero_secondary_line'); ?></p>
		<?php endif; ?>

	<?php else : ?>

		<p class="primary"><?php the_title(); ?></p>

	<?php endif; ?>

<?php while( has_sub_field('hero_ctas') ): ?>

	<?php

		$displaytext = get_sub_field('display_text');
		$pagelink = get_sub_field('page_link');
		$permalink = get_permalink( $pagelink->ID );
		$buttonclass = get_sub_field('button_class');

	?>

	<a class="<?php echo $buttonclass; ?>" style="margin: 0 30px 10px 0;" href="<?php echo esc_html( $permalink ); ?>">
		<?php echo $displaytext; ?>
	</a>

<?php endwhile; ?>

<?php if (is_page('management-referral') || (is_page('sickness-absence-management') || is_single('3076')))  : ?>
	<script src="https://fast.wistia.com/embed/medias/0km7664rii.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><span class="wistia_embed wistia_async_0km7664rii popover=true popoverContent=link" style="display:block;position:relative;margin-bottom:10px;margin-right:30px;float:left;"><a href="#" class="btn btn-sandyyellow">Watch how the process works</a></span>
<?php endif; ?>

<?php if (!is_front_page() && !is_page('associates') && !is_page('management-referral')) : ?>
	<a class="btn btn-sandyyellow" style="margin: 0 30px 10px 0;" href="<?php echo site_url(); ?>/contact">Contact Us</a>
<?php endif; ?>

<?php 
$link = get_field('custom_button');
if( $link ): 
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
    <a class="btn btn-sandyyellow" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
<?php endif; ?>

<?php if( is_page( array('health-surveillance', 'audiometry-hearing-tests', 'drug-alcohol-testing', 'hand-arm-vibration-havs-tests', 'musculoskeletal', 'skin-assessments', 'spirometry-lung-function-tests', 'vision-screening' ) ) ) : ?>
	<a class="btn btn-corona btn-sandyyellow" href="<?php echo site_url(); ?>/coronavirus-remote-surveillance-process">Coronavirus Health Surveillance Process</a>
</div>	

<?php endif ; ?>

</div>	

</div>

</div>

<?php } ?>

</div>