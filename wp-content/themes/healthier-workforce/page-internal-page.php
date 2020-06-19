<?php
	// Template Name: Internal Page
	get_header();
	get_template_part('_parts/hero-bgcover');
?>

<div class="separator page-icon">

	<?php $logoimage = get_field('page_icon');

        if( !empty($logoimage) ): ?>

        <img class="animated rubberBand" src="<?php echo $logoimage['url']; ?>" />

	<?php endif; ?>

	<?php get_template_part('_parts/theme-parts/hero-usps'); ?>

</div>

<?php get_template_part('_parts/theme-parts/callback'); ?>

<div class="container flexbox800" role="main">

	<article class="grid grid6_12 box box-fadedsandyyellow">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<?php the_content(); ?>

		<?php endwhile; ?>

	</article>

	<div class="grid grid6_12 independent-image independent-image-1">

		<?php 

		$secondaryimage = get_field( 'secondary_image' );

		?>

			<style scoped>
				.independent-image-1 {
					background-image: url("<?php echo $secondaryimage['sizes']['large']; ?>"); 
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
