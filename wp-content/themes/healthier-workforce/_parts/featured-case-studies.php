
<?php 

	$args = array(
		'post_type' => 'case_studies',
		'posts_per_page' => -1,
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) : ?>


	<div class="container">

	    <div class="grid grid12_12 box-padding">

	        <div class="case-study-archive-wrapper">

	    		<?php while ( $query->have_posts() ) : $query->the_post(); ?>

	    			<?php if (get_field("featured")) : ?>

	                <div class="case-study-archive box-padding" id="case-study-<?php the_ID(); ?>">

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
	                            #case-study-<?php the_ID(); ?>:before {
	                              background-image: url(<?php echo $thumb_url_small; ?>);
	                            }
	                            @media (min-width: 600px) {
	                                #case-study-<?php the_ID(); ?>:before {
	                                   background-image: url(<?php echo $thumb_url; ?>);
	                                }
	                            }
	                            @media (min-width: 1200px) {
	                                #case-study-<?php the_ID(); ?>:before {
	                                  background-image: url(<?php echo $thumb_url_large; ?>);
	                                }
	                            }
	                        </style>

	                <?php else : ?>

	                    <style scoped>
	                        #case-study-<?php the_ID(); ?>:before {
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

	                    <a class="btn btn-logomidblue" href="<?php the_permalink(); ?>">Read More</a>

	                </div>

	            <?php endif; ?>

	                <?php endwhile; ?>

	        </div>

	    </div>

<?php endif; wp_reset_query(); ?>