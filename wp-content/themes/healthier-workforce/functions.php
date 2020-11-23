<?php
/**
 * Functions and definitions
 * @package adtrak_boilerplate
 */

require('_wp/custom-dash.php');
require("_wp/wp-head.php");

/* ========================================================================================================================
	
jQuery
	
======================================================================================================================== */

wp_enqueue_script('jquery');

/* ========================================================================================================================
	
Enqueue scripts and stylesheets
	
======================================================================================================================== */

function site_script_loader() {
	// Style sheets
    wp_enqueue_style( 'master', get_stylesheet_directory_uri() . '/_css/master.css' );
    wp_enqueue_style( 'fontawesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css' );
    // Scripts
    wp_enqueue_script( 'production', get_template_directory_uri() .'/_js/production.min.js','','', true  );

    /* ========================================================================================================================
        
    Add variables to WP_Localize so we can use them in ajax-form
        
    ======================================================================================================================== */

    $translation_array = array( 'templateUrl' => get_stylesheet_directory_uri() );
    wp_localize_script( 'production', 'object_name', $translation_array );
}

add_action( 'wp_enqueue_scripts', 'site_script_loader' );

/* ========================================================================================================================
	
Navigation
	
======================================================================================================================== */

function register_menus() {
  register_nav_menus(
    array(
      'main' => __( 'Main Nav' ),
      'topnav' => __( 'Top Nav' ),
      'locations' => __( 'Locations' )
    )
  );
}

add_action( 'init', 'register_menus' );

/* ========================================================================================================================
	
Enable Featured Image
	
======================================================================================================================== */

add_theme_support('post-thumbnails');

/* ========================================================================================================================
	
Allow SVG in media library
	
======================================================================================================================== */

function allow_svg( $mimes ){
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter( 'upload_mimes', 'allow_svg' );

/* ========================================================================================================================
	
Image handling
	
======================================================================================================================== */

function remove_width_attribute( $html ) {
   $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
   return $html;
}

function my_image_class_filter() {
	return 'w100' ;
}

function stop_thumbs($sizes){
      return array();
}

add_filter('get_image_tag_class', 'my_image_class_filter');
add_filter('post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter('image_send_to_editor', 'remove_width_attribute', 10 );

/* ========================================================================================================================
	
Remove P tags from images through WYSIWYG
	
======================================================================================================================== */

function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

add_filter('the_content', 'filter_ptags_on_images');

/* ========================================================================================================================
	
Remove YOAST Bar for non-admins
	
======================================================================================================================== */

function mytheme_admin_bar_render() {
    global $wp_admin_bar;
    if(!current_user_can( 'install_themes' ) ) {
        $wp_admin_bar->remove_menu('wpseo-menu');
        remove_meta_box('wpseo_meta', 'page', 'normal');
        remove_meta_box('wpseo_meta', 'post', 'normal');
        remove_meta_box('wpseo_meta', 'custom-post-type-slug', 'normal');
    }
}
// and we hook our function via
add_action( 'wp_before_admin_bar_render', 'mytheme_admin_bar_render' );

/* ========================================================================================================================
	
Hide frontend toolbar
	
======================================================================================================================== */

add_filter('show_admin_bar', '__return_false'); 

/* ========================================================================================================================
	
Custom image sizes
	
======================================================================================================================== */

add_action( 'after_setup_theme', 'custom_image_sizes' );
function custom_image_sizes() {
	/* Useful for buckets */
	add_image_size( 'square-350', 350, 350, true );
	/* Hero images */
	add_image_size( 'hero-2000', 2000, 650, true );
	add_image_size( 'hero-1200', 1200, 500, true );
	add_image_size( 'hero-600', 600, 600, true );
}

/* ========================================================================================================================
    
Hero Picturefill Function
    
======================================================================================================================== */

function heroPictureFill($sizes, $default) {
    $alt = get_field('h1');
    echo "<picture>
          <!--[if IE 9]><video style='display: none;'><![endif]-->";
    foreach($sizes as $size => $option) {
        $attachment = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), "hero-".$option['imageSize'] );
        $attachment = $attachment['0'];
        echo "<source srcset='$attachment' media='(".$option['mediaQuery'].")'>";
    }
    echo "<!--[if IE 9]></video><![endif]-->";
    echo "<img srcset='$default' alt='$alt'>";
    echo "</picture>";
}

/* ========================================================================================================================
    
Shortcodes

======================================================================================================================== */

function remote_surveillance( $attr ) {
    ob_start();
        get_template_part( '_parts/shortcode-remote-surveillance' );
    return ob_get_clean();
}
add_shortcode( 'remote_surveillance', 'remote_surveillance' );

/* ========================================================================================================================

Show ALT tag for images in Media Library (IM request)

======================================================================================================================== */

function wpse_media_extra_column( $cols ) {
$cols["alt"] = "ALT";
return $cols;
}
function wpse_media_extra_column_value( $column_name, $id ) {
    if( $column_name == 'alt' )
        echo get_post_meta( $id, '_wp_attachment_image_alt', true);
}
add_filter( 'manage_media_columns', 'wpse_media_extra_column' );
add_action( 'manage_media_custom_column', 'wpse_media_extra_column_value', 10, 2 );

/* ========================================================================================================================
	
Move Yoast lower down the page
	
======================================================================================================================== */

add_filter( 'wpseo_metabox_prio', function() { return 'low';});

/* ========================================================================================================================
	
Options pages
	
======================================================================================================================== */

if( function_exists('acf_add_options_page') ) {

	$optionspage = acf_add_options_page(array(
		'page_title' 	=> 'Site Specific',
		'menu_title' 	=> 'Site Specific',
		'menu_slug' 	=> 'site-specific',
		'position' 		=> 75,
		'capability' 	=> 'edit_themes',
		'icon_url' 		=> 'dashicons-hammer',
		'redirect' 		=> false
	));

	$optionspage = acf_add_options_page(array(
		'page_title' 	=> 'Marketing',
		'menu_title' 	=> 'Marketing',
		'menu_slug' 	=> 'marketing',
		'position' 		=> 75,
		'capability' 	=> 'edit_themes',
		'icon_url' 		=> 'dashicons-randomize',
		'redirect' 		=> false
	));

}

/* ========================================================================================================================
	
Address - Stacked
	
======================================================================================================================== */

function address_stacked() {

	// loop through the rows of data
	while ( have_rows('company_address', 'options') ) : the_row();

	// display a sub field value
	the_sub_field('address_line', 'options');

	echo "<br/>";

	endwhile;

	the_field('company_postcode', 'option');

}

/* ========================================================================================================================
	
Address - Inline
	
======================================================================================================================== */

function address_inline() {

	// loop through the rows of data
	while ( have_rows('company_address', 'options') ) : the_row();

	// display a sub field value
	the_sub_field('address_line', 'options');

	echo ",&nbsp;";

	endwhile;

	the_field('company_postcode', 'option');

}


/* ========================================================================================================================
	
Enable Widgets
	
======================================================================================================================== */

function arphabet_widgets_init() {

	register_sidebar( array(
		'name'          => 'News Sidebar',
		'id'            => 'news_sidebar',
		'before_widget' => '<div class="aside-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3>',
		'after_title'   => '</h3>',
	) );

}
add_action( 'widgets_init', 'arphabet_widgets_init' );

/* ========================================================================================================================

Case Studies CPT
	
======================================================================================================================== */

// Register Custom Post Type
function case_studies_post_type() {

	$labels = array(
		'name'                  => _x( 'Case Studies', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Case Study', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Case Studies', 'text_domain' ),
		'name_admin_bar'        => __( 'Case Studies', 'text_domain' ),
		'archives'              => __( 'Archives', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'All Case Studies', 'text_domain' ),
		'add_new_item'          => __( 'Add New Case Study', 'text_domain' ),
		'add_new'               => __( 'Add Case Study', 'text_domain' ),
		'new_item'              => __( 'New Item', 'text_domain' ),
		'edit_item'             => __( 'Edit Item', 'text_domain' ),
		'update_item'           => __( 'Update Item', 'text_domain' ),
		'view_item'             => __( 'View Item', 'text_domain' ),
		'search_items'          => __( 'Search Item', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into item', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$rewrite = array(
		'slug'                  => 'case-studies',
		'with_front'            => false,
		'pages'                 => true,
		'feeds'                 => true,
	);
	$args = array(
		'label'                 => __( 'Case Study', 'text_domain' ),
		'description'           => __( 'Case studies information page.', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', ),
		'hierarchical'          => true,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-universal-access-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,		
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'rewrite'               => $rewrite,
		'capability_type'       => 'page',
	);
	register_post_type( 'case_studies', $args );

}
add_action( 'init', 'case_studies_post_type', 0 );

/* ========================================================================================================================

Change excerpt length
	
======================================================================================================================== */

/**
 * Filter the except length to 20 characters.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function wpdocs_custom_excerpt_length( $length ) {
    return 20;
}
add_filter( 'excerpt_length', 'wpdocs_custom_excerpt_length', 999 );