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
<?php if (is_page('occupational-health-referrals') || is_page('occupational-health-assessments')) : ?>
	<?php get_template_part('_parts/theme-parts/accreditations'); ?>
<?php else : ?>
	<?php get_template_part('_parts/theme-parts/callback'); ?>
<?php endif; ?>

<div class="container flexbox800" role="main">

	<article class="grid grid6_12 box box-fadedsandyyellow">

		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

		<?php $appendh1 = get_field('append_h1'); ?>

		<?php if  ( do_shortcode('[ctm_set]') && get_field('location') == 'Yes' ) : ?>
				
			<h1><?php the_field('h1'); ?><?php if( $appendh1 && in_array('yes', $appendh1) ) { ?> in <?php echo do_action('ctm_location'); ?><?php } ?></h1>
		
		<?php else : ?>
			
			<h1><?php the_field('h1'); ?><?php if( $appendh1 && in_array('yes', $appendh1) ) { ?> in the UK<?php } ?></h1>

		<?php endif; ?>

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

<?php if (get_field('faqs')) : ?>

<div class="container accordion-container">

	<p class="title">FAQs</p>
	<p class="sub-title">Frequently asked questions about <?php echo the_title(); ?></p>

	<div class="accordion flexbox800">

		<?php while( has_sub_field('faqs') ): ?>
			
			<a class="accordion-item" href="/cctv-drainage-survey/"><?php the_sub_field('question'); ?></a>
			<div class="accordion-content"><?php the_sub_field('answer'); ?></div>

		<?php endwhile; ?>

	</div>

</div>

<?php endif; ?>

<div class="container flexbox800">

	<?php if (is_page('sickness-absence-management')) : ?>

		<div class="grid grid6_12">

			<div class="video-cta" style="background-color:#004666;">

				<script src="https://fast.wistia.com/embed/medias/0km7664rii.jsonp" async></script><script src="https://fast.wistia.com/assets/external/E-v1.js" async></script><div class="wistia_responsive_padding" style="padding:56.25% 0 0 0;position:relative;"><div class="wistia_responsive_wrapper" style="height:100%;left:0;position:absolute;top:0;width:100%;"><div class="wistia_embed wistia_async_0km7664rii videoFoam=true" style="height:100%;position:relative;width:100%"><div class="wistia_swatch" style="height:100%;left:0;opacity:0;overflow:hidden;position:absolute;top:0;transition:opacity 200ms;width:100%;"><img src="https://fast.wistia.com/embed/medias/0km7664rii/swatch" style="filter:blur(5px);height:100%;object-fit:contain;width:100%;" alt="" aria-hidden="true" onload="this.parentNode.style.opacity=1;" /></div></div></div></div>

			</div>

		</div>

	<?php else : ?>

		<div class="grid grid6_12 box box-logodeepblue get-in-touch">

			<?php get_template_part('_parts/cta-bottom'); ?>

		</div>

	<?php endif; ?>

	<div class="grid grid6_12 box box-logodeepblue map">

		<?php get_template_part('_parts/map'); ?>

	</div>

</div><!-- /.main-->



<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>
