
<?php
	// Get Number of Buckets
	$bucketCount = count(get_field('buckets'));

	// Get Bucket Layout Choice
	if (get_field('buckets_layout') == 'No Margins') { $bucketsLayout = 'no-margins'; }
	elseif (get_field('buckets_layout') == 'Margins in-between buckets') { $bucketsLayout = 'in-between'; }
	elseif (get_field('buckets_layout') == 'Margins in-between buckets & container') { $bucketsLayout = 'in-between-cont'; }

	// Get Image Type Choice (background image or HTML image)
	if (get_field('buckets_image_type') == "Background Image") { $imageType = "imagebg"; }
	elseif (get_field('buckets_image_type') == "HTML Image") { $imageType = "imagehtml"; }
?>


<div class="wrapper buckets num-<?php echo $bucketCount." ".$bucketsLayout." ".$imageType; ?>">
	<ul class="container">

		<?php
		
		while( has_sub_field('buckets') ): ?>

			<?php

				// Take display text, make it CSS friendly
	 			$displayTextCondensed = str_replace(" ", "-", strtolower(get_sub_field('bucket_display_text')));

	 			// Get image field
				$image = get_sub_field('bucket_image');

				// Choose image size
				$size = 'square-350';

				// Get image
				$thumb = $image['sizes'][ $size ];

			


			// Buckets with background images
			// ------------------------------------------------------------------------------------
			if($imageType == 'imagebg'): ?>
			<style>
				.buckets .<?php echo $displayTextCondensed; ?> {
					background-image: url("<?php echo $thumb; ?>");
				}
			</style>

	 		<li class="<?php echo $displayTextCondensed; ?>">
	 			<a href="<?php the_sub_field('bucket_link') ?>">

					<p class="title"><?php the_sub_field('bucket_display_text') ?></p>

					<?php if((get_sub_field('bucket_description'))): ?>
						<p class="desc"><?php the_sub_field('bucket_description'); ?></p>
					<?php endif; ?>

					<?php if((get_sub_field('button_text'))): ?>
						<span class="btn btn-blanc"><?php the_sub_field('button_text'); ?></span>
					<?php endif; ?>

	 			</a>
	 		</li>




	 		<?php
			// Buckets with HTML images
			// ------------------------------------------------------------------------------------
			elseif($imageType == 'imagehtml'): ?>

	 		<li class="<?php echo $displayTextCondensed; ?>">
	 			<a href="<?php the_sub_field('bucket_link') ?>">
	 				
					<p class="title"><?php the_sub_field('bucket_display_text') ?></p>

					<?php if((get_sub_field('bucket_description'))): ?>
						<p class="desc"><?php the_sub_field('bucket_description'); ?></p>
					<?php endif; ?>

					<?php if((get_sub_field('button_text'))): ?>
						<span class="btn btn-blanc"><?php the_sub_field('button_text'); ?></span>
					<?php endif; ?>

	 				<img src="<?php echo $thumb; ?>" alt="<?php the_sub_field('bucket_display_text') ?>">

	 			</a>
	 		</li>
	 		<?php endif; ?>





		<?php endwhile; ?>

	 </ul>
 </div>