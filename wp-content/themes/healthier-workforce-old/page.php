<?php
    get_header();
?>
<div class="container flexbox800" role="main">

	<div class="grid grid6_12 flexbox800">

		<article class="grid grid12_12 box box-lightoffwhite">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php the_content(); ?>

				<p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <span class="ld-calltag"><?php the_field('default_phone_tag', 'option'); ?></span> <?php do_action('ald_default'); ?></p>

				<p>Email: <a href="mailto:<?php the_field('company_email_address', 'option'); ?>"><?php the_field('company_email_address', 'option'); ?></a></p>

			<?php endwhile; ?>

		</article>

	</div>

</div>

<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>
