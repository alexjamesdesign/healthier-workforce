<?php
    get_header();
    get_template_part('_parts/hero-bgcover');
?>

<div class="container" role="main">

    <div class="grid grid12_12 box-padding">

        <div class="case-study-archive-wrapper">

    		<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

                <div class="case-study-archive grid grid6_12 box-padding" id="case-study-<?php the_ID(); ?>">

                <?php

                    /* This uses the featured image as a background. Takes the featured image, and applies the different sizes to varying breakpoints. */

                    $thumb_id = get_post_thumbnail_id();

                    $thumb_url_array_small = wp_get_attachment_image_src($thumb_id, 'hero-600', true);
                    $thumb_url_small = $thumb_url_array_small[0];

                    $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'hero-1200', true);
                    $thumb_url = $thumb_url_array[0];

                    $thumb_url_array_large = wp_get_attachment_image_src($thumb_id, 'hero-2000', true);
                    $thumb_url_large = $thumb_url_array_large[0];

                if ( $thumb_id ) : ?>

                        <style scoped>
                            div#case-study-<?php the_ID(); ?>:before {
                              background-image: url(<?php echo $thumb_url_small; ?>);
                            }
                            @media (min-width: 600px) {
                                div#case-study-<?php the_ID(); ?>:before {
                                   background-image: url(<?php echo $thumb_url; ?>);
                                }
                            }
                            @media (min-width: 1200px) {
                                div#case-study-<?php the_ID(); ?>:before {
                                  background-image: url(<?php echo $thumb_url_large; ?>);
                                }
                            }
                        </style>

                <?php else : ?>

                    <style scoped>
                        div#case-study-<?php the_ID(); ?>:before {
                          background-color: #eee;
                        }
                    </style>

                <?php endif; ?>

                    <div class="logo">

                        <?php $logoimage = get_field('logo');

                            if( !empty($logoimage) ): ?>

                            <img src="<?php echo $logoimage['url']; ?>" />

                        <?php endif; ?>

                    </div>

                    <h1><?php the_title(); ?></h1>

                    <?php the_excerpt(); ?>

                    <a class="btn btn-logomidblue" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>

                </div>

                <?php endwhile; ?>

            </div>

            <div class="navigation">
                <div class="prev-posts"><?php previous_posts_link(); ?></div>
                <div class="next-posts"><?php next_posts_link(); ?></div>
            </div>

            <?php else : ?>

            <div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                <h1>No news posts found (news)</h1>
                <p>There are currently no news posts, please check back soon for updates.</p>
            </div>

            <?php endif; ?>
    </div>

</div><!-- /.main-->
	
<?php get_footer(); ?>
