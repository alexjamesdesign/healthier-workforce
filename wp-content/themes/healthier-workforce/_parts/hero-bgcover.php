<?php

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
			.hero {
				background-image: url(<?php echo $thumb_url_small; ?>);
			}
			@media (min-width: 600px) {
				.hero {
					background-image: url(<?php echo $thumb_url; ?>);
				}
			}
			@media (min-width: 1200px) {
				.hero {
					background-image: url(<?php echo $thumb_url_large; ?>);
				}
			}
		</style>

	<?php else : ?>

		<style scoped>
			.hero {
				background-color: #eee;
			}
		</style>

	<?php endif; ?>

<?php

 if (is_singular('case_studies')) { ?>

	<?php /* Single news post hero */ ?>

	<div class="hero hero-singular">

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

<?php } else { ?>

	<div class="container hero-container">

	<div class="hero-content">

	<?php if (get_field('hero_primary_line')) : ?>

		<p class="primary"><?php the_field('hero_primary_line'); ?></p>
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
		$buttonclass = get_sub_field('button_class');

	?>

	 <a class="<?php echo $buttonclass; ?>" href="<?php echo ($siteurl . get_sub_field('page_link')); ?>">

		 <?php echo $displaytext; ?>

	</a>

<?php endwhile; ?>

</div>	

</div>

<?php } ?>

</div>