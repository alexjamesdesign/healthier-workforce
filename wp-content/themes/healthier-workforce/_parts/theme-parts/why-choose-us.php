<?php if (get_field('tf_why_choose_us', 'option')) : ?>

	<div class="why-choose-us">

		<p class="title"><?php the_field('why_choose_us_title', 'option') ?></p>

		<ul>

			<?php while( has_sub_field('why_choose_us', 'options') ): ?>

				<li><?php the_field('why_choose_us_icon', 'option'); ?> <?php the_sub_field('why_choose_us_item', 'option'); ?> 

			<?php endwhile; ?>

		</ul>

	</div>		

<?php endif; ?>