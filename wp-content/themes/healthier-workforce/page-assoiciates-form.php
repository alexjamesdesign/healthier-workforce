<?php
	// Template Name: Assoicates Form
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

<div class="container flexbox800" role="main">

	<div class="container flexbox800" role="main">

		<article class="grid grid6_12 box box--no-pad box-lightoffwhite">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php if(is_user_logged_in()) { ?>

					<div class="grid grid12_12 box box-fadedsandyyellow">

						<?php the_field("logged_in_content"); ?>

					</div>

					<div class="grid grid12_12 box box-lightoffwhite box--registration">

						<h3>Your Profile</h3>
						<br />

						<?php echo do_shortcode("[RM_Front_Submissions]"); ?>

					</div>

				<?php } else { ?>

					<div class="grid grid12_12 box box-fadedsandyyellow">

						<?php the_content(); ?>

					</div>

				<?php } ?>

			<?php endwhile; ?>

		</article>

		<div class="grid grid6_12 independent-image independent-image-1">

			<?php if(is_user_logged_in()) { ?>

				<div class="grid grid12_12 box box--registration">

					<h2>Assoicate Application Form</h2>

					<?php echo do_shortcode("[RM_Form id='2']"); ?>

				</div>

			<?php } else { ?>

				<div class="grid grid12_12 box box--registration">

					<?php the_field("secondary_content"); ?>

					<?php echo do_shortcode("[RM_Form id='1']"); ?>

				</div>

			<?php } ?>

		</div>

	</div>

</div>


<div class="container flexbox800">

	<div class="grid grid12_12 flexbox800">

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
