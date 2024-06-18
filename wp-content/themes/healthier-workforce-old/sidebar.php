<h3>Categories</h3>

<?php // Get the taxonomy's terms
$terms = get_terms(
    array(
        'taxonomy'   => 'resource_centre_taxonomy',
        'hide_empty' => false,
    )
);

// Check if any term exists
if ( ! empty( $terms ) && is_array( $terms ) ) {
    // Run a loop and print them all
    foreach ( $terms as $term ) { ?>
        <a href="<?php echo esc_url( get_term_link( $term ) ) ?>">
            <?php echo $term->name,' &raquo;'; ?>
        </a><?php
    }
} ?>
<br />

<?php if (is_singular('post') || is_singular('resource_centre')) { ?>

<h3>You may be interested in</h3>

<?php 
			 
// get the custom post type's taxonomy terms
	
$custom_taxterms = wp_get_object_terms( $post->ID, 'resource_centre_taxonomy', array('fields' => 'ids') );
// arguments
$args = array(
'post_type' => 'resource_centre',
'post_status' => 'publish',
'posts_per_page' => 4, // you may edit this number
'orderby' => 'rand',
'tax_query' => array(
	array(
		'taxonomy' => 'resource_centre_taxonomy',
		'field' => 'id',
		'terms' => $custom_taxterms
	)
),
'post__not_in' => array ($post->ID),
);
$related_items = new WP_Query( $args );
// loop over query
if ($related_items->have_posts()) :
echo '<ul>';
while ( $related_items->have_posts() ) : $related_items->the_post();
?>
	<li><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?> &raquo;</a></li>
<?php
endwhile;
echo '</ul>';
endif;
// Reset Post Data
wp_reset_postdata();
?>

<?php } ?>