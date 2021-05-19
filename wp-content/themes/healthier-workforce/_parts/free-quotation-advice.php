			<div class="free-quotation-advice">

				<p class="title">Free quotation &amp; advice</p>

				<p>Interested? Get in touch with us today to find out how we can help you.</p>

				<?php if ( ( do_shortcode('[ctm_set]')  )) : ?>
			        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <strong><?php echo do_action('ctm_location'); ?> <?php do_action('ald_default'); ?></strong></p>
			    <?php else: ?>
			        <p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <strong><?php do_action('ald_default'); ?></strong></p>
			    <?php endif; ?>

				<a class="btn btn-logodeepblue" href="<?php echo site_url(); ?>/contact/">Contact Us</a>

			</div>