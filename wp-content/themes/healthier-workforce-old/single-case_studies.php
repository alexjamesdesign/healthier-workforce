<?php
    get_header();
    get_template_part('_parts/hero-bgcover');
?>

<div class="container" role="main">

	<div class="grid grid7_12 box-padding">

		<article class="box">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	            <h1><?php the_title(); ?></h1>

				<?php the_content(); ?>

			<?php endwhile; ?>

		</article>

	</div>

	<?php if (get_field('testimonial')) : ?>

		<aside class="grid grid5_12 box box-sandyyellow testimonial">

			<?php the_field("testimonial"); ?>

			<p class="title"><?php the_field("testimonial_name"); ?></p>

		</aside>

	<?php else : ?>

		<aside class="grid grid5_12">

			<div class="box box-logodeepblue">

				<?php get_template_part('_parts/theme-parts/why-choose-us'); ?>

			</div>

			<div class="box box-sandyyellow">

				<?php get_template_part('_parts/free-quotation-advice'); ?>

			</div>

		</aside>

	<?php endif; ?>

    <div class="prev-next flexbox800">

        <div class="prev-posts"><?php previous_post_link('%link', '&laquo; %title'); ?></div>
        <div class="next-posts"><?php next_post_link('%link', '%title &raquo;'); ?></div>

    </div>

<?php get_template_part('_parts/separator'); ?>

    <div class="flexbox800">

		<div class="grid grid6_12 box box-logomidblue get-in-touch">

			<?php get_template_part('_parts/cta-bottom'); ?>

		</div>

		<div class="grid grid6_12 box box-logodeepblue map">

		<?php get_template_part('_parts/map'); ?>

		</div>

	</div>

</div><!-- /.main-->

<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>

<?php if (is_single()) {   //  displaying a single blog post ?>
<script type="text/javascript">
  jQuery("a[href$='case-studies/']").parent().addClass('current-menu-item');
</script>
<?php } ?>
