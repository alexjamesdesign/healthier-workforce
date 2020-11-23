<div class="phone-nav-top Fixed">

    <?php 
			$ld_location = get_field('location_name');
			if($ld_location) : ?>

        <span class="stickyheader-left stickyheader-btn"><i class="fa fa-mobile location-page-number" aria-hidden="true"></i> <?php do_action('ald_single', $ld_location, false); ?></span>

			<?php else: ?>

        <span class="stickyheader-left stickyheader-btn"><i class="fa fa-mobile" aria-hidden="true"></i> <?php do_action('ald_default'); ?></span>
			
      <?php endif;

    ?>

    <a class="stickyheader-right stickyheader-btn menu-btn" href="#mmenu"><i class="fa fa-bars"></i> Menu</a>

</div>