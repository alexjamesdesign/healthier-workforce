<?php
	// Template Name: No Hero
	get_header();
	get_template_part('_parts/hero-bgcover');
?>
<div class="container flexbox800" role="main">

	<div class="grid grid6_12 flexbox800">

		<div class="grid grid12_12 independent-image independent-image-1">

			<?php 

			$thumb_id = get_post_thumbnail_id();

			$thumb_url_array = wp_get_attachment_image_src($thumb_id, 'large', true);
			$thumb_url = $thumb_url_array[0];

			?>

				<style scoped>
					.independent-image-1 {
						background-image: url("<?php echo $thumb_url; ?>"); 
					}
				</style>		

		</div>

		<article class="grid grid12_12 box box-lightoffwhite">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

				<p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <span class="ld-calltag"><?php the_field('default_phone_tag', 'option'); ?></span> <?php do_action('ald_default'); ?></p>

				<p>Email: <a href="mailto:<?php the_field('company_email_address', 'option'); ?>"><?php the_field('company_email_address', 'option'); ?></a></p>

			<?php endwhile; ?>

		</article>

	</div>

	<div class="grid grid6_12 box box-logodeepblue">

		<?php if (is_page('contact')) : ?>

			<?php get_template_part('_includes/forms/contact-form-ninja'); ?>

		<?php endif; ?>

	</div>

</div>

<?php get_template_part('_parts/featured-case-studies'); ?>


<section>

	<div class="container flexbox800">

		<div class="grid grid6_12 box box-logodeepblue get-in-touch">

			<?php get_template_part('_parts/cta-bottom'); ?>

		</div>

		<div class="grid grid6_12 box box-logodeepblue map">

			<?php get_template_part('_parts/map'); ?>

		</div>

	</div>

</section>

<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>
