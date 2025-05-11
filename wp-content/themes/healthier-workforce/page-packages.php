<?php
	// Template Name: Packages
    get_header();
    get_template_part('_parts/hero-bgcover');
?>
<div class="container flexbox800" role="main">

	<div class="grid grid12_12 flexbox800 bg-white box">

		<article class="grid grid9_12">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

			<?php endwhile; ?>

		</article>

	</div>

    <?php get_template_part('_parts/theme-parts/package-usps'); ?>

    <?php get_template_part('_parts/theme-parts/package-items'); ?>

    <?php get_template_part('_parts/theme-parts/package-table'); ?>

</div>

<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>
