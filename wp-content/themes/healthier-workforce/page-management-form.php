<?php
	// Template Name: Management Form
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

			<script src="https://fast.wistia.com/embed/medias/0km7664rii.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="clear:both;padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_0km7664rii videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/0km7664rii/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>

		</article>

		<div class="grid grid6_12 independent-image independent-image-1">

			<?php if(is_user_logged_in()) :
				global $wpdb;
				$current_user = wp_get_current_user();
				$is_management = in_array('Management', (array) $current_user->roles);
				$has_submission = (int) $wpdb->get_var($wpdb->prepare(
					"SELECT COUNT(*) FROM {$wpdb->prefix}rm_submissions WHERE form_id = %d AND user_email = %s AND child_id = 0",
					4,
					$current_user->user_email
				)) >= 1;
			?>

				<?php if($is_management && $has_submission) : ?>
					<div class="grid grid12_12 box box--registration">
						<p>To make additional management referrals, please log in to our Apollo system.</p>
						<a href="https://healthierworkforce.apollo.direct/dashboard/" class="btn btn-sandyyellow">Log in to Apollo</a>
						<br /><br />
						<h3>Apollo - How To</h3>
						<p><a href="https://www.healthier-workforce.co.uk/wp-content/uploads/2026/04/Submitting-a-New-Referral-on-Apollo.pdf" target="_blank">Submitting a New Referral on Apollo</a></p>
						<p><a href="https://www.healthier-workforce.co.uk/wp-content/uploads/2026/04/Accessing-Reports-on-Apollo.pdf" target="_blank">Accessing Reports on Apollo</a></p>
					</div>

				<?php else : ?>
					<div class="grid grid12_12 box box--registration">
						<h2>Management Application Form</h2>
						<?php echo do_shortcode("[RM_Form id='4']"); ?>
					</div>
				<?php endif; ?>

			<?php else : ?>

				<div class="grid grid12_12 box box--registration">

					<article>
					<?php the_field("secondary_content"); ?>

					<?php echo do_shortcode("[RM_Form id='3']"); ?>
					</article>
				</div>

			<?php endif; ?>

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
