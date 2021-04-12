<?php
	// Template Name: Full Width
    get_header();
?>
<div class="container flexbox800" role="main">

	<div class="grid grid12_12 flexbox800 bg-white box">

		<article class="grid grid12_12">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; ?>

		</article>

	</div>

</div>

<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>
