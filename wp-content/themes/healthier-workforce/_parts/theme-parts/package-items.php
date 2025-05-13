<ul class="package-items" id="packages">

<?php if( have_rows('package_items') ): ?>

<?php while( have_rows('package_items') ): the_row(); 

    // vars
    $PackageImage = get_sub_field('package_item_image');
    $PackageHeading = get_sub_field('package_item_heading');
    $PackageSubheading = get_sub_field('package_item_subheading');
    $PackageText = get_sub_field('package_item_text');

    ?>

    <li>
        <span class="heading-group">
            <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/_static/images/check.svg" alt="EDS Logo Icon" />  -->
            <?php if( $PackageImage ): ?>
                <img src="<?php echo $PackageImage['url']; ?>" alt="<?php echo $PackageImage['alt'] ?>" /> 
            <?php endif; ?>

            <div class="heading-group-right">
                <span class="package-usp-heading"><?php echo $PackageHeading; ?></span>
                <span class="package-usp-subheading"><?php echo $PackageSubheading; ?></span>
            </div>
        </span>

        <span class="package-usp-text"><?php echo $PackageText; ?></span>

        <div class="package-contact-link">
            <a class="btn btn-sandyyellow" href="<?php echo esc_url( home_url( '/contact' ) ); ?>">Get In Touch</a>
        </div>
    </li>

<?php endwhile; ?>

<?php endif; ?>

</ul>