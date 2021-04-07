<div class="content">

	<p class="title">Get in touch and find out how we can help your people and business</p>


	<?php if ( (isset($_COOKIE['area']) && $_COOKIE['area'] !='uk') || (isset($_GET['a']) && $_GET['a'] !='uk')) : ?>
        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <strong><?php echo do_action('ctm_location'); ?> <?php do_action('ald_default'); ?></strong></p>
    <?php else: ?>
        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <strong><?php do_action('ald_default'); ?></strong></p>
    <?php endif; ?>

</div>