<?php
    global $post;
    $associates_page = get_page_by_path('associates');
    $associates_url = $associates_page ? get_permalink($associates_page->ID) : site_url('/associates/');
?>

<h3>Opportunities</h3>

<a href="<?php echo esc_url(get_post_type_archive_link('vacancies')); ?>">All Vacancies &raquo;</a>
<a href="<?php echo esc_url($associates_url); ?>">Associates &raquo;</a>

<?php if (is_singular('vacancies')) { ?>

    <h3>Other Vacancies</h3>

    <?php
    $vacancy_args = array(
        'post_type'      => 'vacancies',
        'post_status'    => 'publish',
        'posts_per_page' => 4,
        'post__not_in'   => array($post->ID),
    );
    $other_vacancies = new WP_Query($vacancy_args);

    if ($other_vacancies->have_posts()) :
        echo '<ul>';
        while ($other_vacancies->have_posts()) : $other_vacancies->the_post();
    ?>
        <li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> &raquo;</a></li>
    <?php
        endwhile;
        echo '</ul>';
    endif;

    wp_reset_postdata();
    ?>

<?php } ?>
