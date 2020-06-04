<?php if (get_field('tf_opening_hours', 'option')) : ?>

	<div class="opening-hours">

		<p class="title"><?php the_field('opening_hours_title', 'option') ?></p>

		<?php /* <ul class="opening-hours">

			<li><span>Monday</span> <?php the_field('opening_hours_monday', 'option') ?></li>
			<li><span>Tuesday</span> <?php the_field('opening_hours_tuesday', 'option') ?></li>
			<li><span>Wednesday</span> <?php the_field('opening_hours_wednesday', 'option') ?></li>
			<li><span>Thursday</span> <?php the_field('opening_hours_thursday', 'option') ?></li>
			<li><span>Friday</span> <?php the_field('opening_hours_friday', 'option') ?></li>
			<li><span>Saturday</span> <?php the_field('opening_hours_saturday', 'option') ?></li>
			<li><span>Sunday</span> <?php the_field('opening_hours_sunday', 'option') ?></li>

		</ul> -->
		*/ ?>

		<?php 
		 	$weekdays = array(
		 		'monday',
		 		'tuesday',
		 		'wednesday',
		 		'thursday',
		 		'friday',
		 		'saturday',
		 		'sunday'
		 	);
		 ?>	
		<ul>
			<?php foreach ($weekdays as $weekday) : ?>
				<?php $time = get_field("opening_hours_$weekday", "option"); ?>
				<li><span><?php echo ucwords($weekday); ?></span> <?php echo $time; ?></li>
			<?php endforeach; ?>
		</ul>

	</div>			

<?php endif; ?>