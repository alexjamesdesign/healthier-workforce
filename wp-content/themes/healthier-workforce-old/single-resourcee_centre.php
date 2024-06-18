<?php
    get_header();
    get_template_part('_parts/hero-bgcover');
?>

<div class="separator page-icon">

	<?php $logoimage = get_field('page_icon', 'options');

        if( !empty($logoimage) ): ?>

        <img class="animated rubberBand" src="<?php echo $logoimage['url']; ?>" />

	<?php endif; ?>

	<?php get_template_part('_parts/theme-parts/hero-usps-resource-centre'); ?>

</div>

<div class="container flexbox800" role="main">

	<div class="grid grid8_12 box box-lightoffwhite">

		<article>

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

	            <h1><?php the_title(); ?></h1>

                <div class="post-info">

					<span><?php the_terms( $post->ID, 'resource_centre_taxonomy'); ?></span> &middot; <span><?php echo get_the_date(); ?></span>

                </div>

				<?php the_content(); ?>

			<?php endwhile; ?>

		</article>

        <div class="prev-next">

            <div class="prev-posts"><?php previous_post_link('%link', '&laquo; %title'); ?></div>
            <div class="next-posts"><?php next_post_link('%link', '%title &raquo;'); ?></div>

        </div>

	</div>

	<aside class="grid grid4_12 news-aside">

		<?php get_sidebar(); ?>

	</aside>

</div><!-- /.main-->
	
<?php get_footer(); ?>

<?php if (is_single()) {   //  displaying a single blog post ?>
<script type="text/javascript">
  jQuery("a[href$='news/']").parent().addClass('current-menu-item');
</script>
<?php } ?>
