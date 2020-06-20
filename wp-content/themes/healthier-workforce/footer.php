<?php
/* The template for displaying the footer */
?>

<!-- Back to top arrow -->
<div class="back-top-wrap">
    <p id="back-top">
        <a><i class="fa fa-arrow-up fa-2x"></i> Top</a>
    </p>
</div>

<footer role="contentinfo">

    <div class="container">

        <div class="grid grid3_12">
            <p class="title">Our Services</p>
            <?php wp_nav_menu( array('menu' => 'Main Nav', 'menu_class' => '', 'container' => '' )); ?>
        </div>

        <div class="grid grid3_12">
            <p class="title">Further Information</p>
            <?php wp_nav_menu( array('menu' => 'Top Nav', 'menu_class' => '', 'container' => '' )); ?>
            <?php get_template_part('_parts/theme-parts/social-links'); ?>
        </div>

        <div class="grid grid3_12">
            <p class="title">Areas We Cover</p>
            <?php wp_nav_menu( array('menu' => 'Locations', 'menu_class' => '', 'container' => '' )); ?>
        </div>

        <div class="grid grid3_12">

            <p class="title">Healthier Workforce</p>

            <ul>

                <li><a href="<?php echo site_url(); ?>/cookies-privacy-policy/">Cookies &amp; Privacy Policy</a></li>
                <li>Email: <a href="mailto:<?php the_field('company_email_address', 'option'); ?>"><?php the_field('company_email_address', 'option'); ?></a></li>
                <li><i class="fa fa-mobile" aria-hidden="true"></i> <span class="ld-phonenumber"><?php the_field('default_phone_number', 'option'); ?></span></li>
                <li><?php the_field('company_name', 'option'); ?> is a registered company in England.</li>
                <li>&copy; <?php the_field('company_name', 'option'); ?> <?php echo date('Y'); ?>. All Rights Reserved</li>
                <li><a href="<?php echo site_url(); ?>/terms-of-contract">Terms of Contract</a></li>
                <li><a href="<?php echo site_url(); ?>/environmental-policy">Environmental Policy</a></li>


            </ul>

        </div>

        <ul class="grid grid3_12">

        </ul>
        
    </div><!--/.container-->

    <div class="container">

        <a class="adtrak" href="http://www.adtrak.co.uk"><img src="http://static.adtrak.co.uk/email/201504/svg/adtrak-logo-white.svg" alt="Adtrak" /></a>

    </div><!-- /.container -->

</footer>

<?php // Fixed footer for temporarily closed

if (get_field('temporarily_closed_message', 'option')) : ?>

    <div class="temporarily-closed">
        <?php if (the_field('temporarily_closed_message', 'option')) ?>
    </div>

<?php endif; ?>

</div><!--/.wrapper-->

<?php 
    wp_footer(); 
    get_template_part('_parts/ld');
?>

</body>
</html>
