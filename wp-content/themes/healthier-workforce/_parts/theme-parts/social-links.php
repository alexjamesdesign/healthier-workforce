<?php if (get_field('tf_social_links', 'option')) : ?>

		<?php while( has_sub_field('social_links', 'options') ): ?>

	 		<li class="social-nav-item"><a target="_blank" href="<?php the_sub_field('social_url', 'option') ?>">
	 			<?php the_sub_field('fontawesome_code', 'option') ?>
	 		</a></li>

		<?php endwhile; ?>

<?php endif; ?>