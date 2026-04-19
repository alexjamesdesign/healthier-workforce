<?php
$post_id       = get_the_ID();

if ( ! $post_id ) {
	return;
}

$parent_id     = wp_get_post_parent_id( $post_id );
$parent_slug   = $parent_id ? get_post_field( 'post_name', $parent_id ) : '';
$current_title = get_the_title( $post_id );

if ( $parent_slug === 'areas-we-cover' ) {
	echo esc_html( ucwords( strtolower( $current_title ) ) );
} else {
	echo do_shortcode( '[loc case="title"]' );
}