<?php if (get_field('tf_credit_cards', 'option')) : ?>

	<div class="credit-cards">

		<p class="title"><?php the_field('credit_cards_title', 'option') ?></p>

		<ul>

			<?php while( has_sub_field('credit_cards', 'options') ): ?>

				<?php // Check if it is in use
				if (get_sub_field('tf_credit_card_logo_used', 'option')) : ?>

				<li><img src="<?php the_sub_field('credit_card_logo') ?>" alt="Major Card" /></li>

		 		<?php endif; ?>

			<?php endwhile; ?>

		 </ul>

	</div>

<?php endif; ?>