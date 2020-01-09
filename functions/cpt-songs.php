<?php

// CPT: Songs
function cpt_songs() {

	$labels = array(
		'name'                  => _x( 'Songs', 'Post Type General Name', 'exonym' ),
		'singular_name'         => _x( 'Song', 'Post Type Singular Name', 'exonym' ),
		'menu_name'             => __( 'Songs', 'exonym' ),
		'name_admin_bar'        => __( 'Song', 'exonym' ),
		'archives'              => __( 'Song Archives', 'exonym' ),
		'attributes'            => __( 'Song Attributes', 'exonym' ),
		'parent_item_colon'     => __( 'Parent Song:', 'exonym' ),
		'all_items'             => __( 'All Songs', 'exonym' ),
		'add_new_item'          => __( 'Add New Song', 'exonym' ),
		'add_new'               => __( 'Add New', 'exonym' ),
		'new_item'              => __( 'New Song', 'exonym' ),
		'edit_item'             => __( 'Edit Song', 'exonym' ),
		'update_item'           => __( 'Update Song', 'exonym' ),
		'view_item'             => __( 'View Song', 'exonym' ),
		'view_items'            => __( 'View Songs', 'exonym' ),
		'search_items'          => __( 'Search Song', 'exonym' ),
		'not_found'             => __( 'Not found', 'exonym' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'exonym' ),
		'featured_image'        => __( 'Featured Image', 'exonym' ),
		'set_featured_image'    => __( 'Set featured image', 'exonym' ),
		'remove_featured_image' => __( 'Remove featured image', 'exonym' ),
		'use_featured_image'    => __( 'Use as featured image', 'exonym' ),
		'insert_into_item'      => __( 'Insert into Song', 'exonym' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Song', 'exonym' ),
		'items_list'            => __( 'Songs list', 'exonym' ),
		'items_list_navigation' => __( 'Songs list navigation', 'exonym' ),
		'filter_items_list'     => __( 'Filter Songs list', 'exonym' ),
	);
	$args = array(
		'label'                 => __( 'Song', 'exonym' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-playlist-audio',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => true,
		'rewrite'               => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'song', $args );

}
add_action( 'init', 'cpt_songs', 0 );
