<?php
    get_header();
    get_template_part('_parts/hero-bgcover');
?>

<div class="container flexbox800" role="main">

	<div class="grid grid8_12 box box-lightoffwhite">

		<article>

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

                <?php $vacancy_key_job_info = get_field('vacancy_key_job_info'); ?>

                <?php if (!empty($vacancy_key_job_info)) : ?>
                    <div class="vacancy-key-job-info box box-fadedsandyyellow">
                        <p class="title">Role Details</p>
                        <?php echo wp_kses_post($vacancy_key_job_info); ?>
                    </div>
                <?php endif; ?>

	            <h1><?php the_title(); ?></h1>

                <div class="post-info">
                    <span><?php echo get_the_date(); ?></span>
                </div>

				<?php the_content(); ?>

			<?php endwhile; ?>

		</article>

        <div class="prev-next">

            <div class="prev-posts"><?php previous_post_link('%link', '&laquo; %title'); ?></div>
            <div class="next-posts"><?php next_post_link('%link', '%title &raquo;'); ?></div>

        </div>

	</div>

	<aside class="grid grid4_12 news-aside">
		<?php get_sidebar('vacancies'); ?>
	</aside>

</div>
	
<?php get_footer(); ?>

<?php if (is_singular('vacancies')) { ?>
<script type="text/javascript">
  jQuery("a[href$='vacancies/']").parent().addClass('current-menu-item');
</script>
<?php } ?>
