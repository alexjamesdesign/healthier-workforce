		<p class="title">UK-Wide Coverage</p>

		<ul>
			<li><i class="fa fa-check"></i> Birmingham</li>
			<li><i class="fa fa-check"></i> Bristol</li>
			<li><i class="fa fa-check"></i> London</li>
			<li><i class="fa fa-check"></i> Manchester</li>
			<li><i class="fa fa-check"></i> Liverpool</li>
			<li><i class="fa fa-check"></i> Nottingham</li>
		</ul>

		
		<?php if ( ( do_shortcode('[ctm_set]') )) : ?>
			<p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i><strong> <?php echo do_action('ctm_location'); ?> <?php do_action('ald_default'); ?></strong></p>
		<?php else: ?>
			<p class="phone"><i class="fa fa-mobile" aria-hidden="true"></i> <strong><?php do_action('ald_default'); ?></strong></p>
		<?php endif; ?>
		
