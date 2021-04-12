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

        <?php if ( (isset($_COOKIE['area']) && $_COOKIE['area'] !='uk') || (isset($_GET['a']) && $_GET['a'] !='uk') ): ?>

        <?php else: ?>
            
            <div class="grid grid3_12">
                <p class="title">Areas We Cover</p>
                <?php wp_nav_menu( array('menu' => 'Locations', 'menu_class' => '', 'container' => '' )); ?>
                <ul>
                    <li>London</li>
                    <li>Manchester</li>
                    <li>Nottingham</li>
                    <li>Liverpool</li>
                </ul>  
            </div>
            
        <?php endif; ?>

        <div class="grid grid3_12">

            <p class="title">Healthier Workforce</p>

            <ul>

                <li><a href="<?php echo site_url(); ?>/cookies-privacy-policy/">Cookies &amp; Privacy Policy</a></li>
                <li><a href="mailto:<?php the_field('company_email_address', 'option'); ?>"><?php the_field('company_email_address', 'option'); ?></a></li>
                

                <?php if ( (isset($_COOKIE['area']) && $_COOKIE['area'] !='uk') || (isset($_GET['a']) && $_GET['a'] !='uk') ): ?>
                    <li><i class="fa fa-mobile" aria-hidden="true"></i> <?php echo do_action('ctm_location'); ?> <?php do_action('ald_default'); ?></li>
                <?php else: ?>
                    <li><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_default'); ?></li>
                    <li><?php address_stacked(); ?></li>
                <?php endif; ?>
                

            </ul>

        </div>

       

        
    </div><!--/.container-->

    <div class="container">
        <ul>
        <li><?php the_field('company_name', 'option'); ?> is a registered company in England.</li>
        <li>&copy; <?php the_field('company_name', 'option'); ?> <?php echo date('Y'); ?>. All Rights Reserved</li>
        <li><a href="<?php echo site_url(); ?>/terms-of-contract">Terms of Contract</a></li>
        <li><a href="<?php echo site_url(); ?>/environmental-policy">Environmental Policy</a></li>
        </ul>
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

<script>jQuery( document ).on( 'nfFormReady', function() {
	nfRadio.channel('forms').on('submit:response', function(form) {
		ga('send', 'event', 'Form', 'Submit', form.data.settings.title );
		console.log(form.data.settings.title + ' successfully submitted');
	});
});</script>

</body>
</html>
