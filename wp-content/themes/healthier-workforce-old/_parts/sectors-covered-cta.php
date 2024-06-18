<div class="sectors-covered-cta box-padding">

    <?php

    /* This uses the featured image as a background. Takes the featured image, and applies the different sizes to varying breakpoints. */
    $image = get_field( 'sectors_image', 'options' );
    $size = 'hero-600';
    
    $sectors_background_image = wp_get_attachment_image( $image, $size ); ?>

    <style scoped>
        .sectors-covered-cta:before {
            background-image: url(<?php echo $image['sizes']['hero-600']; ?>);
        }
        @media (min-width: 600px) {
            .sectors-covered-cta:before {
                background-image: url(<?php echo $image['sizes']['hero-600']; ?>);
            }
        }
        @media (min-width: 1200px) {
            .sectors-covered-cta:before {
                background-image: url(<?php echo $image['sizes']['hero-600']; ?>);
            }
        }
    </style>

    <h1><?php the_field('sectors_title', 'options'); ?></h1>

    <p><?php the_field('sectors_text', 'options'); ?></p>

    <?php if( have_rows('sectors_list', 'options') ): ?>

    <ul>

    <?php while( have_rows('sectors_list', 'options') ): the_row(); 

        // vars
        $content = get_sub_field('sector'); ?>

        <li><?php the_field('why_choose_us_icon', 'option'); ?> <?php echo $content; ?></li>

    <?php endwhile; ?>

    </ul>

    <?php endif; ?>

    <a class="btn btn-logomidblue" href="<?php echo site_url(); ?>/sectors">Read More</a>

</div>