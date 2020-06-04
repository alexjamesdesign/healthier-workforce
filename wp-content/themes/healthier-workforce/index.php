<?php
    get_header();
    get_template_part('_parts/hero-bgcover');
?>

<div class="container" role="main">

    <div class="grid grid8_12 box-padding">

		<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

            <article class="post" id="post-<?php the_ID(); ?>">

                <h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>

                <?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); }  ?>

                <div class="post-info">

                    <?php the_category('&middot;'); ?> &middot; <?php echo get_the_date(); ?>

                </div>

                <?php the_excerpt(); ?>

            </article>

            <?php endwhile; ?>

            <div class="navigation">
                <div class="prev-posts"><?php previous_posts_link(); ?></div>
                <div class="next-posts"><?php next_posts_link(); ?></div>
            </div>

            <?php else : ?>

            <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                <h1>No news posts found</h1>
                <p>There are currently no news posts, please check back soon for updates.</p>
            </article>

            <?php endif; ?>
    </div>

    <aside class="grid grid4_12">

        <?php get_sidebar(); ?>

    </aside>

</div><!-- /.main-->
	
<?php get_footer(); ?>
