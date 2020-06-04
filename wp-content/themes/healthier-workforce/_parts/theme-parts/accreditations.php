<?php if (get_field('tf_accreditations', 'option')) : ?>

	<div class="accreditations">

		<p class="title"><?php the_field('accreditations_title', 'option') ?></p>

		<ul>

			<?php while( has_sub_field('accreditations', 'options') ): ?>

				<?php

					$image = get_sub_field('accreditation_logo');
					$size = 'thumbnail';
					$thumb = $image['sizes'][ $size ];

				?>

				<li>

				<?php // Check if link is set
				if (get_sub_field('accreditation_link', 'option')) : ?>
		 			<a href="<?php the_sub_field('accreditation_link', 'option') ?>">
		 		<?php endif; ?>

		 			<img src="<?php echo $thumb; ?>" alt="<?php the_sub_field('accreditation_name', 'option') ?>" />

				<?php // End the link if applicable
				if (get_sub_field('accreditation_link', 'option')) : ?>
					</a>
		 		<?php endif; ?>

		 		</li>

			<?php endwhile; ?>

		 </ul>

	</div>

<?php endif; ?>