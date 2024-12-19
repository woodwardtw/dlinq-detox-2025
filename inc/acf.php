<?php
/**
 * ACF specific functions
 *
 * @package WP-Bootstrap-Navwalker
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

//display gravity submitted data 

//change title for ACF flexible layout in collapsed mode

add_filter('acf/fields/flexible_content/layout_title/name=content', 'dlinq_acf_fields_flexible_content_layout_title', 10, 4);
function dlinq_acf_fields_flexible_content_layout_title( $title, $field, $layout, $i ) {

    if( get_sub_field('sub_topic_title') ) {
        $title .= ' - ' . get_sub_field('sub_topic_title');     
    }
	if( get_sub_field('title') ) {
        $title .= ' - ' . get_sub_field('title');     
    }
	 if( get_sub_field('accordion_title') ) {
        $title .= ' - ' . get_sub_field('accordion_title');     
    }

    return $title;
}


//activity custom post type

// Register Custom Post Type activity
// Post Type Key: activity

function create_activity_cpt() {

  $labels = array(
    'name' => __( 'Activities', 'Post Type General Name', 'textdomain' ),
    'singular_name' => __( 'Activity', 'Post Type Singular Name', 'textdomain' ),
    'menu_name' => __( 'Activity', 'textdomain' ),
    'name_admin_bar' => __( 'Activity', 'textdomain' ),
    'archives' => __( 'Activity Archives', 'textdomain' ),
    'attributes' => __( 'Activity Attributes', 'textdomain' ),
    'parent_item_colon' => __( 'Activity:', 'textdomain' ),
    'all_items' => __( 'All Activities', 'textdomain' ),
    'add_new_item' => __( 'Add New Activity', 'textdomain' ),
    'add_new' => __( 'Add New', 'textdomain' ),
    'new_item' => __( 'New Activity', 'textdomain' ),
    'edit_item' => __( 'Edit Activity', 'textdomain' ),
    'update_item' => __( 'Update Activity', 'textdomain' ),
    'view_item' => __( 'View Activity', 'textdomain' ),
    'view_items' => __( 'View Activities', 'textdomain' ),
    'search_items' => __( 'Search Activities', 'textdomain' ),
    'not_found' => __( 'Not found', 'textdomain' ),
    'not_found_in_trash' => __( 'Not found in Trash', 'textdomain' ),
    'featured_image' => __( 'Featured Image', 'textdomain' ),
    'set_featured_image' => __( 'Set featured image', 'textdomain' ),
    'remove_featured_image' => __( 'Remove featured image', 'textdomain' ),
    'use_featured_image' => __( 'Use as featured image', 'textdomain' ),
    'insert_into_item' => __( 'Insert into activity', 'textdomain' ),
    'uploaded_to_this_item' => __( 'Uploaded to this activity', 'textdomain' ),
    'items_list' => __( 'Activity list', 'textdomain' ),
    'items_list_navigation' => __( 'Activity list navigation', 'textdomain' ),
    'filter_items_list' => __( 'Filter Activity list', 'textdomain' ),
  );
  $args = array(
    'label' => __( 'activity', 'textdomain' ),
    'description' => __( '', 'textdomain' ),
    'labels' => $labels,
    'menu_icon' => '',
    'supports' => array('title', 'editor', 'revisions', 'author', 'trackbacks', 'custom-fields', 'thumbnail',),
    'taxonomies' => array('category', 'post_tag'),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'menu_position' => 5,
    'show_in_admin_bar' => true,
    'show_in_nav_menus' => true,
    'can_export' => true,
    'has_archive' => true,
    'hierarchical' => false,
    'exclude_from_search' => false,
    'show_in_rest' => true,
    'publicly_queryable' => true,
    'capability_type' => 'post',
    'menu_icon' => 'dashicons-universal-access-alt',
  );
  register_post_type( 'activity', $args );
  
  // flush rewrite rules because we changed the permalink structure
  global $wp_rewrite;
  $wp_rewrite->flush_rules();
}
add_action( 'init', 'create_activity_cpt', 0 );


	//save acf json
		add_filter('acf/settings/save_json', 'detox_json_save_point');
		 
		function detox_json_save_point( $path ) {
		    
		    // update path
		    $path = get_stylesheet_directory() . '/acf-json'; //replace w get_stylesheet_directory() for theme
		    
		    
		    // return
		    return $path;
		    
		}


		// load acf json
		add_filter('acf/settings/load_json', 'detox_json_load_point');

		function detox_json_load_point( $paths ) {
		    
		    // remove original path (optional)
		    unset($paths[0]);
		    
		    
		    // append path
		    $paths[] = get_stylesheet_directory()  . '/acf-json';//replace w get_stylesheet_directory() for theme
		    
		    
		    // return
		    return $paths;
		    
		}