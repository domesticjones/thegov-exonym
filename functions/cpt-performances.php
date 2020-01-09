<?php

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
	register_post_type( 'performance', $args );
}
add_action( 'init', 'cpt_performances', 0 );

// CPT: Performances - Custom Naming
function cpt_performancesTitles($post_id) {
    global $wpdb;
    if(get_post_type($post_id) == 'performance') {
        $name = get_post_meta($post_id, 'event_name', true);
        $slug = '';
        $title = '';
        $dateRaw = get_post_meta($post_id, 'date_start', true);
        if($dateRaw) {
            $dateFormat = DateTime::createFromFormat('Y-m-d H:i:s', $dateRaw);
            $slug = $dateFormat->format('Y-m-d');
            $title = $dateFormat->format('Y.m.d');
        }
        if($name) {
            $title = $name;
        }
        $where = array('ID' => $post_id);
        $wpdb->update($wpdb->posts, array('post_title' => $title, 'post_name' => $slug), $where);
    }
}
add_action('save_post', 'cpt_performancesTitles');

// CPT: Performances - Order by Date
function cpt_performancesOrdering($query) {
	if(isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'performance') {
		$query->set('orderby', 'meta_value');
		$query->set('meta_key', 'date_start');
		$query->set('order', 'DESC');
	}


    if(!is_admin() && $query->is_main_query() && is_post_type_archive('performance')) {
      $query->set('posts_per_page', -1 );
    }
	return $query;
}
add_action('pre_get_posts', 'cpt_performancesOrdering');

// CPT: Performances - Columns
function cpt_performancesColumnsPage($columns) {
    $columns = array(
        'cb'        => '<input type="checkbox" />',
        'poster'    => 'Poster',
        'title'     => 'Performance',
        'location'  => 'Location',
        'acts'      => 'Other Acts',
    );
    return $columns;
}

function cpt_performancesColumnsData($column) {
    global $post;
    if ($column == 'poster') {
        echo '<a href="' . get_edit_post_link($post->ID) . '">';
            the_post_thumbnail('thumbnail');
        echo '</a>';
    } elseif ($column == 'location') {
        $place = get_field('location', $post->ID);
        if($place) {
            echo '<strong>' . performanceLocation($place)->name . '</strong><br />';
            echo performanceLocation($place, 'address') . '<br />';
            echo performanceLocation($place, 'city');
        } else {
            echo '<em>No location has been set for this performance.</em>';
        }
    } elseif ($column == 'acts') {
        $acts = get_field('acts', $post->ID);
        if($acts) {
            echo '<ul >';
                foreach($acts as $act) {
                    echo '<li>' . $act['name'] . '</li>';
                }
            echo '</ul>';
        } else {
            echo '<em>Just ' . ex_brand() . '!</em>';
        }
    }
}
add_action('manage_performance_posts_custom_column', 'cpt_performancesColumnsData');
add_filter('manage_performance_posts_columns', 'cpt_performancesColumnsPage');

// Display - Get the Location Data
function performanceLocation($place, $type = null) {
    $placeQueryUrl = 'https://maps.googleapis.com/maps/api/place/details/json?place_id=' . $place['place_id'] . '&key=' . get_field('maps_api', 'options');
    $placeQueryJson = file_get_contents($placeQueryUrl);
    $placeData = json_decode($placeQueryJson);
    $placeAddress = $placeData->result->address_components;

    if($placeData->status == 'OK') {
        $placeNumber = '';
        $placeStreet = '';
        $placeHood = '';
        $placeCity = '';
        $placeState = '';
        foreach($placeData->result->address_components as $address_component){
            if(in_array('street_number', $address_component->types)){
                $placeNumber = $address_component->long_name;
                continue;
            } elseif(in_array('route', $address_component->types)) {
                $placeStreet = $address_component->short_name;
                continue;
            } elseif(in_array('neighborhood', $address_component->types)) {
                $placeHood = '<span>' . $address_component->long_name . '<i> - </i></span>';
                continue;
            } elseif(in_array('locality', $address_component->types)) {
                $placeCity = $address_component->long_name;
                continue;
            } elseif(in_array('administrative_area_level_1', $address_component->types)) {
                $placeState = $address_component->short_name;
                continue;
            }
        }
        if($type == 'address') {
            return $placeNumber . ' ' . $placeStreet;
        } elseif($type == 'city') {
            return $placeHood . $placeCity . ', ' . $placeState;
        } else {
            return $placeData->result;
        }
    } else {
        return 'No location info.';
    }
}
