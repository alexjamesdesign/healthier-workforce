<?php
    //if this page is a subpage page
    global $post;
    $currentPage = $post->ID;
    if( is_page() && $post->post_parent ) : $parent = $post->post_parent;
?>

<?php
    $args = array(
        'post_parent' => $parent,
        'post_type' => 'page',
        'posts_per_page' => -1,
        'child_of' => $parent
    );

    $query = new WP_Query( $args );

    // The Loop
    if ( $query->have_posts() ) : ?>

        <div class="container">
           
            <h2>Additional services: </h2>

             <ul>

                <?php while ( $query->have_posts() ) : $query->the_post(); ?>
                    
                    <li class="<?php echo $post->post_name; ?> <?php if($currentPage == $post->ID) : ?>current-child-item<?php endif; ?>">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo get_the_post_thumbnail($query->ID, 'square-350'); ?>
                            <?php the_title() ?>
                            <?php
                                $excerpt = get_the_excerpt();
                                $tags = array('<p>', '</p>');
                                $excerpt = str_replace($tags, "", $excerpt);
                                echo $excerpt;
                            ?>
                        </a>
                    </li>

                <?php endwhile; ?>

            </ul><!-- /child-nav-->

        </div>

    <?php endif; ?>

<?php 
    //else the page is a parent
    else :
?>

<?php
    $args = array(
        'post_parent' => $post->ID,
        'post_type' => 'page',
        'posts_per_page' => -1
    );

    $query = new WP_Query( $args );

    // The Loop
    if ( $query->have_posts() ) : ?>

        <div class="container">
           
            <h2>Additional services: </h2>

            <ul>

                <?php while ( $query->have_posts() ) : $query->the_post(); ?>

                    <li class="<?php echo $post->post_name; ?> <?php if($currentPage == $post->ID) : ?>current-child-item<?php endif; ?>">
                        <a href="<?php the_permalink(); ?>">
                            <?php echo get_the_post_thumbnail($query->ID, 'square-350'); ?>
                            <?php the_title() ?>
                            <?php
                                $excerpt = get_the_excerpt();
                                $tags = array('<p>', '</p>');
                                $excerpt = str_replace($tags, "", $excerpt);
                                echo $excerpt;
                            ?>
                        </a>
                    </li>

                <?php endwhile; ?>

            </ul><!-- /child-nav-->

        </div>

    <?php endif; ?>           

<?php endif; wp_reset_postdata(); ?>

