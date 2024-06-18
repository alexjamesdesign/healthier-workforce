<?php
	/* The search form by default only searches blog posts, not the full site. If you wish to search the whole site, remove the if statement on lines 16 and 28. */
    get_header();
?>

<div class="container" role="main">

	<div class="grid grid8_12 box-padding">

		<?php if ( have_posts() ) : ?>

			<h1>Results for <?php the_search_query(); ?> </h1>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php /* Check if it is a post, not a page - remove this if you want to have site-wide search */ if ( 'post' == get_post_type() ) : ?>

					<article>

						<?php the_post_thumbnail('medium'); ?>

						<h2><?php the_title( sprintf( '<a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a>' ); ?></h2>

						<?php the_excerpt(); ?>

					</article>

				<?php endif;
				
			endwhile; ?>

			<div class="navigation">
	            <div class="next-posts"><?php next_posts_link(); ?></div>
	            <div class="prev-posts"><?php previous_posts_link(); ?></div>
	        </div>

	    <?php else : ?>

			<h1>Sorry, no results found</h1>

		<?php endif; ?>

	</div>

</div><!-- /.main-->
	
<?php get_footer(); ?>

