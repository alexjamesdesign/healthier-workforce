<ul class="hero-usps">

    <?php if( have_rows('cta_bar_resource_centre') ): ?>

        <?php while( have_rows('cta_bar_resource_centre') ): the_row(); 

            // vars
            $CTAimage = get_sub_field('cta_custom_icon');
            $CTAtext = get_sub_field('cta_text');

            ?>

            <li>
                <?php if( $CTAimage ): ?>
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $CTAimage['alt'] ?>" /> 
                <?php else : ?>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/_static/images/check.svg" alt="EDS Logo Icon" /> 
                <?php endif; ?>

                <span><?php echo $CTAtext; ?></span>
            </li>

        <?php endwhile; ?>

    <?php elseif( have_rows('cta_bar_resource_centre', 'option') ): ?>

        <?php while( have_rows('cta_bar_resource_centre', 'option') ): the_row(); 

            // vars
            $CTAimage = get_sub_field('cta_custom_icon');
            $CTAtext = get_sub_field('cta_text');

            ?>

            <li>
                <?php if( $CTAimage ): ?>
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $CTAimage['alt'] ?>" /> 
                <?php else : ?>
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/_static/images/check.svg" alt="EDS Logo Icon" /> 
                <?php endif; ?>

                <span><?php echo $CTAtext; ?></span>
            </li>

        <?php endwhile; ?>

    <?php endif; ?>

</ul>