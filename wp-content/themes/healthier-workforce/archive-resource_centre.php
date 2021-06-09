<?php
    get_header();
    get_template_part('_parts/hero-bgcover');
?>

<div class="container flexbox800" role="main">

    <div class="grid grid8_12 box box-lightoffwhite resource-centre">

		<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

            <article class="post" id="post-<?php the_ID(); ?>">
                <div class="resource-centre-image">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); }  ?>
                </div>

                <p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>

                <div class="post-info">

                <span><?php the_terms( $post->ID, 'resource_centre_taxonomy'); ?></span><span><?php echo get_the_date(); ?></span>

                </div>

                <!-- <?php the_excerpt(); ?> -->

            </article>

            <?php endwhile; ?>

            <div class="navigation">
                <div class="prev-posts"><?php previous_posts_link(); ?></div>
                <div class="next-posts"><?php next_posts_link(); ?></div>
            </div>

            <?php else : ?>

            <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                <h1>No news posts found (index)</h1>
                <p>There are currently no news posts, please check back soon for updates.</p>
            </article>

            <?php endif; ?>
    </div>

    <aside class="grid grid4_12 news-aside">

        <?php get_sidebar(); ?>

    </aside>

</div><!-- /.main-->
	
<?php get_footer(); ?>
