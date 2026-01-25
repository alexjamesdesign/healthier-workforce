<?php
// Template Name: Assoicates Form New
get_header();
get_template_part('_parts/hero-bgcover');
?>
<div class="separator page-icon">

    <?php $logoimage = get_field('page_icon');

    if (!empty($logoimage)): ?>

        <img class="animated rubberBand" src="<?php echo $logoimage['url']; ?>" />

    <?php endif; ?>

    <?php get_template_part('_parts/theme-parts/hero-usps'); ?>

</div>

<div class="container flexbox800" role="main">

    <div class="container flexbox800" role="main">

        <article class="grid grid6_12 box box--no-pad box-lightoffwhite">

            <?php if (have_posts())
                while (have_posts()):
                    the_post(); ?>

                    <?php if (is_user_logged_in()) { ?>

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

        <div class="grid grid6_12 independent-image independent-image-1">

            <?php if (is_user_logged_in()) { ?>

                <div class="grid grid12_12 box box--registration">

                    <h2>Join our successful team by completing the information below</h2>

                    <div class="role-selector prominent-role-selector">
                        <h3>What is your role?</h3>
                        <p>First, please select the role you are applying for so we can show you the relevant questions.</p>
                        <select id="roleSelect">
                            <option value="">Select your role</option>
                            <option value="template-form">Template Form</option>
                            <option value="oha">OHA</option>
                            <option value="ohn">OHN</option>
                            <option value="oht">OHT</option>
                            <option value="ohp">OHP</option>
                            <option value="oh-physio-therapist">OH Physio Therapist</option>
                            <option value="therapist-cbt">Therapist (CBT)</option>
                        </select>
                        <p>Elements of this form can only be completed using a laptop, if you are on a mobile device, please
                            visit this page whilst on a laptop.</p>
                    </div>

                    <div class="role-forms">
                        <div class="role-form" data-role="template-form" style="display:none;">
                            <?php echo do_shortcode('[ninja_form id=5]'); ?>
                        </div>
                        <div class="role-form" data-role="oha" style="display:none;">
                            <?php echo do_shortcode('[ninja_form id=6]'); ?>
                        </div>
                        <div class="role-form" data-role="ohn" style="display:none;">
                            <!-- Example: <?php // echo do_shortcode( '[ninja_form id=7]' ); ?> -->
                        </div>
                        <div class="role-form" data-role="oht" style="display:none;">
                            <!-- Example: <?php // echo do_shortcode( '[ninja_form id=8]' ); ?> -->
                        </div>
                        <div class="role-form" data-role="ohp" style="display:none;">
                            <!-- Example: <?php // echo do_shortcode( '[ninja_form id=9]' ); ?> -->
                        </div>
                        <div class="role-form" data-role="oh-physio-therapist" style="display:none;">
                            <!-- Example: <?php // echo do_shortcode( '[ninja_form id=10]' ); ?> -->
                        </div>
                        <div class="role-form" data-role="therapist-cbt" style="display:none;">
                            <!-- Example: <?php // echo do_shortcode( '[ninja_form id=11]' ); ?> -->
                        </div>
                    </div>

                    <style>
                        .prominent-role-selector {
                            margin: 2em 0 2em 0;
                            padding: 1.5em;
                            background: #f9f9e7;
                            border: 2px solid #ffe066;
                            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
                            font-size: 1.1em;
                        }

                        .prominent-role-selector select {
                            font-size: 1.0em;
                            font-weight: 600;
                            padding: 0.5em 1em;
                            border-radius: 5px;
                            border: 1.5px solid #ffe066;
                            background: #fffbe6;
                            margin-top: 0.75em;
                        }

                        .role-forms {
                            margin-top: 2em;
                        }
                    </style>

                </div>

            <?php } else { ?>

                <div class="grid grid12_12 box box--registration">

                    <?php the_field("secondary_content"); ?>

                    <?php echo do_shortcode("[RM_Form id='1']"); ?>

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