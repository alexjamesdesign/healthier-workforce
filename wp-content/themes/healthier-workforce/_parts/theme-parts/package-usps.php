<div class="package-usps-container">

    <p class="package-usps-heading">All Our Packages Include</p>

    <ul class="package-usps">

    <?php if( have_rows('package_usps') ): ?>

    <?php while( have_rows('package_usps') ): the_row(); 

        // vars
        $CTAheading = get_sub_field('package_usp_heading');
        $CTAhtext = get_sub_field('package_usp_text');

        ?>

        <li>
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/_static/images/check.svg" alt="EDS Logo Icon" /> 
            <span class="package-usp-heading"><?php echo $CTAheading; ?></span>
            <span class="package-usp-text"><?php echo $CTAhtext; ?></span>
        </li>

    <?php endwhile; ?>

    <?php endif; ?>

    </ul>
    
    <a class="btn btn-logodeepblue package-button" href="#packages">View Our Packages</a>

</div>