<div class="content">

	<p class="title">Get in touch and find out how we can help your people and business</p>


	<?php if ( ( do_shortcode('[ctm_set]') )) : ?>
        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <strong><?php echo do_action('ctm_location'); ?> <?php do_action('ald_default'); ?></strong></p>
    <?php else: ?>
        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <strong><?php do_action('ald_default'); ?></strong></p>
    <?php endif; ?>

</div>