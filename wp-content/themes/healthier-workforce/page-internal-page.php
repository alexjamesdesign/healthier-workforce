<?php
	// Template Name: Internal Page
    get_header();
?>

<div class="separator page-icon">

	<?php $logoimage = get_field('page_icon');

        if( !empty($logoimage) ): ?>

        <img class="animated rubberBand" src="<?php echo $logoimage['url']; ?>" />

	<?php endif; ?>

	<?php get_template_part('_parts/theme-parts/hero-usps'); ?>

</div>

<div class="container flexbox800" role="main">

	<article class="grid grid6_12 box box-fadedsandyyellow">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; ?>

	</article>

	<div class="grid grid6_12 independent-image independent-image-1">

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

</div>

<div class="container flexbox800">

	<article class="grid grid6_12 box box-lightoffwhite">

		<?php the_field("secondary_content"); ?>

	</article>

	<div class="grid grid6_12 flexbox800">

		<div class="grid grid6_12 box box-logodeepblue">

			<?php get_template_part('_parts/theme-parts/why-choose-us'); ?>

		</div>

		<div class="grid grid6_12 box box-sandyyellow">

			<?php get_template_part('_parts/free-quotation-advice'); ?>

		</div>

	</div>

</div>

<?php get_template_part('_parts/separator'); ?>

<div class="container flexbox800">

	<div class="grid grid6_12 box box-logodeepblue get-in-touch">

		<?php get_template_part('_parts/cta-bottom'); ?>

	</div>

	<div class="grid grid6_12 box box-logodeepblue map">

	<?php get_template_part('_parts/map'); ?>

	</div>

</div><!-- /.main-->

<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>
