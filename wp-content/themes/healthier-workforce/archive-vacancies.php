<?php
    get_header();
    get_template_part('_parts/hero-bgcover');

    $associates_page = get_page_by_path('associates');
    $associates_url = $associates_page ? get_permalink($associates_page->ID) : site_url('/associates/');
    $associates_image = get_field('vacancies_associates_image', 'option');
?>

<div class="container flexbox800" role="main">

    <div class="grid grid8_12 box box-lightoffwhite resource-centre vacancies-list">

        <article class="post post-associates">
            <?php if (!empty($associates_image)) : ?>
                <div class="resource-centre-image">
                    <?php if (is_array($associates_image) && !empty($associates_image['ID'])) : ?>
                        <?php echo wp_get_attachment_image($associates_image['ID'], 'thumbnail'); ?>
                    <?php elseif (is_array($associates_image) && !empty($associates_image['url'])) : ?>
                        <img src="<?php echo esc_url($associates_image['url']); ?>" alt="<?php echo esc_attr(!empty($associates_image['alt']) ? $associates_image['alt'] : 'Associates'); ?>" />
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <p class="title"><a href="<?php echo esc_url($associates_url); ?>">Associates</a></p>

            <div class="post-info">
                <span>Ongoing opportunity</span>
            </div>

            <a class="btn btn-logomidblue vacancy-card-button" href="<?php echo esc_url($associates_url); ?>">View Associates</a>
        </article>

		<?php if ( have_posts() ) : while (have_posts()) : the_post(); ?>

            <article class="post" id="post-<?php the_ID(); ?>">
                <div class="resource-centre-image">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail('thumbnail'); } ?>
                </div>

                <p class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></p>

                <?php
                    $vacancy_card_description = get_field('vacancy_card_description');
                    if (!empty($vacancy_card_description)) :
                ?>
                    <p class="vacancy-card-description"><?php echo nl2br(esc_html($vacancy_card_description)); ?></p>
                <?php elseif (has_excerpt()) : ?>
                    <p class="vacancy-card-description"><?php echo esc_html(get_the_excerpt()); ?></p>
                <?php endif; ?>

                <div class="post-info vacancy-post-info">
                    <span><?php echo get_the_date(); ?></span>
                </div>

                <a class="btn btn-logomidblue vacancy-card-button" href="<?php the_permalink(); ?>">View Role</a>

            </article>

        <?php endwhile; ?>

            <div class="navigation">
                <div class="prev-posts"><?php previous_posts_link(); ?></div>
                <div class="next-posts"><?php next_posts_link(); ?></div>
            </div>

        <?php else : ?>

            <article class="post">
                <h1>No current vacancies</h1>
                <p>There are currently no live vacancies. Please check back soon.</p>
            </article>

        <?php endif; ?>
    </div>

    <aside class="grid grid4_12 news-aside">
        <?php get_sidebar('vacancies'); ?>
    </aside>

</div>
	
<?php get_footer(); ?>
