<?php
if (!defined('WPINC')) { die; }
/*
===========================
  [[[ Custom Post Types ]]]
===========================
*/

// Clear Rewrite Rules for CPT's
function ex_theme_terlet() {
  flush_rewrite_rules();
}
add_action('after_switch_theme', 'ex_theme_terlet');

// CPT: Performances
function cpt_performances() {
	$labels = array(
		'name'                  => _x( 'Performances', 'Post Type General Name', 'exonym' ),
		'singular_name'         => _x( 'Performance', 'Post Type Singular Name', 'exonym' ),
		'menu_name'             => __( 'Performances', 'exonym' ),
		'name_admin_bar'        => __( 'Performance', 'exonym' ),
		'archives'              => __( 'Performance Archives', 'exonym' ),
		'attributes'            => __( 'Performance Attributes', 'exonym' ),
		'parent_item_colon'     => __( 'Parent Performance:', 'exonym' ),
		'all_items'             => __( 'All Performances', 'exonym' ),
		'add_new_item'          => __( 'Add New Performance', 'exonym' ),
		'add_new'               => __( 'Add New', 'exonym' ),
		'new_item'              => __( 'New Performance', 'exonym' ),
		'edit_item'             => __( 'Edit Performance', 'exonym' ),
		'update_item'           => __( 'Update Performance', 'exonym' ),
		'view_item'             => __( 'View Performance', 'exonym' ),
		'view_items'            => __( 'View Performances', 'exonym' ),
		'search_items'          => __( 'Search Performance', 'exonym' ),
		'not_found'             => __( 'Not found', 'exonym' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'exonym' ),
		'featured_image'        => __( 'Poster', 'exonym' ),
		'set_featured_image'    => __( 'Set poster', 'exonym' ),
		'remove_featured_image' => __( 'Remove poster', 'exonym' ),
		'use_featured_image'    => __( 'Use as poster', 'exonym' ),
		'insert_into_item'      => __( 'Insert into Performance', 'exonym' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Performance', 'exonym' ),
		'items_list'            => __( 'Performances list', 'exonym' ),
		'items_list_navigation' => __( 'Performances list navigation', 'exonym' ),
		'filter_items_list'     => __( 'Filter Performances list', 'exonym' ),
	);
	$args = array(
		'label'                 => __( 'Performance', 'exonym' ),
		'labels'                => $labels,
		'supports'              => array( 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-tickets-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'performances',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
	);
	register_post_type( 'performances', $args );
}
add_action( 'init', 'cpt_performances', 0 );
