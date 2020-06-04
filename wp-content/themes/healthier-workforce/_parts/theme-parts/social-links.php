<?php if (get_field('tf_social_links', 'option')) : ?>

		<?php if (get_field('google+_url', 'options')) : ?>

			<li>
				<a target="_blank" rel="publisher" href="<?php the_field('google+_url', 'options') ?>" rel="publisher">
					<?php the_field('google+_fontawesome_code', 'options') ?>
				</a>
			</li>

		<?php endif; ?>

		<?php while( has_sub_field('social_links', 'options') ): ?>

	 		<li><a target="_blank" href="<?php the_sub_field('social_url', 'option') ?>">
	 			<?php the_sub_field('fontawesome_code', 'option') ?>
	 		</a></li>

		<?php endwhile; ?>

<?php endif; ?>