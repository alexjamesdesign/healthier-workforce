<?php
	// Template Name: Employee Forms
    get_header();
    get_template_part('_parts/hero-bgcover');
?>
<div class="separator page-icon">

	<?php $logoimage = get_field('page_icon');

        if( !empty($logoimage) ): ?>

        <img class="animated rubberBand" src="<?php echo $logoimage['url']; ?>" />

	<?php endif; ?>

	<?php get_template_part('_parts/theme-parts/hero-usps'); ?>

</div>

<div class="container flexbox800" role="main">

	<div class="container flexbox800" role="main">

		<article class="grid grid6_12 box box--no-pad box-lightoffwhite">

			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

				<?php if(is_user_logged_in()) { ?>

					<div class="grid grid12_12 box box-fadedsandyyellow">

						<?php the_field("logged_in_content"); ?>

					</div>

					<div class="grid grid12_12 box box-lightoffwhite box--registration">

						<h3>Your Profile</h3>
						<br />

						<?php echo do_shortcode("[RM_Front_Submissions]"); ?>

					</div>

				<?php } else { ?>

					<div class="grid grid12_12 box box-fadedsandyyellow">

						<?php the_content(); ?>

					</div>

				<?php } ?>

			<?php endwhile; ?>

		</article>

		<div class="grid grid6_12 box box--registration  independent-image independent-image-1">

			<?php if(is_user_logged_in()) { ?>

			<?php
			global $user_login, $current_user;

			if (is_user_logged_in()) {
			get_currentuserinfo();
			$user_info = get_userdata($current_user->ID);

			if (in_array('Employee', $user_info->roles)) { ?>

                <div class="grid grid12_12 form-item">

                    <h2 class="form-title box">Pre-placement Health Questionnaire <span>Click to expand</span> <i class="fa fa-caret-right"></i></h2>    

                    <div class="form-content">

                        <h2>Pre-placement Health Questionnaire</h2>

                        <p>The purpose of the questionnaire is to assist your Employer to meet its statutory duty to maintain a safe and working environment and to provide you with the advice for necessary & reasonable adjustments to enable you to carry out your job. </p>

                        <p>If you answer ‘yes’ to any question, you may be asked to attend for an appointment either by telephone or face to face with an occupational health advisor.  </p>

                        <p>If you will be exposed to substances at work that could potentially cause ill health. Your employer, or your work, requires specific fitness criteria, you will be enrolled in the appropriate health surveillance or fitness assessment programme and will be given further specific health questionnaires.  </p>

                        <?php echo do_shortcode("[RM_Form id='5']"); ?>

                    </div>

                </div>

                <div class="form-item grid grid12_12">

                    <h2 class="form-title box">Night Worker Questionnaire <span>Click to expand</span><i class="fa fa-caret-right"></i></h2>    

                    <div class="form-content">

                        <h2>Night Worker Questionnaire</h2>

                        <p>The Working Time Directive 1998 provides the opportunity for employees who are classed as Night Workers, to undergo a health assessment.</p> 

                        <p>Please note: There is no obligation for you to participate. Should you decline this opportunity please completed Sections 1, 2 and 3 and submit.  </p>

                        <p>Should you wish a health assessment please complete Sections 1, 2 and 4 and submit. </p>

                        <p>From your completed form the OHA will determine if you are considered to be fit to undertake night work.  </p>

                        <p>As part of this process the OHA may wish to discuss your responses with you further and an appointment will be made for you to see him/her. </p>

                        <?php echo do_shortcode("[RM_Form id='6']"); ?>

                    </div>

                </div>

			<?php } else { ?>

			<p>Your user profile is not permitted to access the employee questionnaires.</p>

			<?php } } ?>

			<?php } else { ?>

				<div class="grid grid12_12 box box--registration">

					<article>
					<?php the_field("secondary_content"); ?>

					<?php echo do_shortcode("[RM_Form id='7']"); ?>
					</article>
				</div>

			<?php } ?>

		</div>

	</div>

</div>


<div class="container flexbox800">

	<div class="grid grid12_12 flexbox800">

		<div class="grid grid6_12 box box-logodeepblue">

			<?php get_template_part('_parts/theme-parts/why-choose-us'); ?>

		</div>

		<div class="grid grid6_12 box box-sandyyellow">

			<?php get_template_part('_parts/free-quotation-advice'); ?>

		</div>

	</div>

</div>

<?php get_template_part('_parts/separator'); ?>

<div class="container flexbox800">

	<div class="grid grid6_12 box box-logodeepblue get-in-touch">

		<?php get_template_part('_parts/cta-bottom'); ?>

	</div>

	<div class="grid grid6_12 box box-logodeepblue map">

	<?php get_template_part('_parts/map'); ?>

	</div>

</div><!-- /.main-->

<?php get_template_part('_parts/separator'); ?>
	
<?php get_footer(); ?>
