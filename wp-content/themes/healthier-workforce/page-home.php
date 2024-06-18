<?php
	// Template Name: Home Page
    get_header();
    get_template_part('_parts/hero-bgcover');
	get_template_part('_parts/theme-parts/accreditations');
	get_template_part('_parts/theme-parts/buckets');
	get_template_part('_parts/separator');
	
	get_template_part('_parts/theme-parts/hero-usps');
	
	get_template_part('_parts/theme-parts/callback');
?>


<section>

	<div class="container flexbox800">

		<div class="grid grid6_12 independent-image independent-image-1 lazyload">

			<?php $image_1 = get_field('image_1'); $size = $image_1['sizes']['large']; ?>

				<style scoped>
					.independent-image-1.lazyloaded {
						background-image: url("<?php echo $size; ?>"); 
					}
				</style>		

		</div>

		<div class="grid grid6_12 flexbox800">

			<div class="grid grid6_12 box box-logodeepblue">

				<?php get_template_part('_parts/theme-parts/why-choose-us'); ?>

			</div>

			<div class="grid grid6_12 box box-sandyyellow">

				<?php get_template_part('_parts/free-quotation-advice'); ?>

			</div>

		</div>

	</div>

</section>

<?php get_template_part('_parts/separator'); ?>

<?php get_template_part('_parts/featured-case-studies'); ?>

<?php get_template_part('_parts/separator'); ?>

<div class="container flexbox800" role="main">

	<div class="grid grid6_12 box box-lightoffwhite">

		<article>

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<?php $ld_location = get_field('location_name');
				if($ld_location) : ?>
				
					<h1>Occupational Health Services in <?php echo ucfirst($ld_location); ?></h1>
				
				<?php else : ?>
					
					<h1>Occupational Health Services in the UK</h1>

				<?php endif; ?>

				<?php the_content(); ?>

			<?php endwhile; ?>
	        
		</article>
	

	</div>

	<div class="grid grid6_12 independent-image independent-image-2 lazyload">

		<?php $image_1 = get_field('image_2'); $size = $image_1['sizes']['large']; ?>

		<style scoped>
			.independent-image-2.lazyloaded {
				background-image: url("<?php echo $size; ?>"); 
			}
		</style>		

	</div>

</div><!-- /.main-->

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
