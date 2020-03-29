<?php

// CPT: Videos
function cpt_videos() {

	$labels = array(
		'name'                  => _x( 'Videos', 'Post Type General Name', 'exonym' ),
		'singular_name'         => _x( 'Video', 'Post Type Singular Name', 'exonym' ),
		'menu_name'             => __( 'Videos', 'exonym' ),
		'name_admin_bar'        => __( 'Video', 'exonym' ),
		'archives'              => __( 'Video Archives', 'exonym' ),
		'attributes'            => __( 'Video Attributes', 'exonym' ),
		'parent_item_colon'     => __( 'Parent Video:', 'exonym' ),
		'all_items'             => __( 'All Videos', 'exonym' ),
		'add_new_item'          => __( 'Add New Item', 'exonym' ),
		'add_new'               => __( 'Add New', 'exonym' ),
		'new_item'              => __( 'New Video', 'exonym' ),
		'edit_item'             => __( 'Edit Video', 'exonym' ),
		'update_item'           => __( 'Update Video', 'exonym' ),
		'view_item'             => __( 'View Video', 'exonym' ),
		'view_items'            => __( 'View Videos', 'exonym' ),
		'search_items'          => __( 'Search Video', 'exonym' ),
		'not_found'             => __( 'Not found', 'exonym' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'exonym' ),
		'featured_image'        => __( 'Featured Image', 'exonym' ),
		'set_featured_image'    => __( 'Set featured image', 'exonym' ),
		'remove_featured_image' => __( 'Remove featured image', 'exonym' ),
		'use_featured_image'    => __( 'Use as featured image', 'exonym' ),
		'insert_into_item'      => __( 'Insert into Video', 'exonym' ),
		'uploaded_to_this_item' => __( 'Uploaded to this Video', 'exonym' ),
		'items_list'            => __( 'Videos list', 'exonym' ),
		'items_list_navigation' => __( 'Videos list navigation', 'exonym' ),
		'filter_items_list'     => __( 'Filter Videos list', 'exonym' ),
	);
	$args = array(
		'label'                 => __( 'Video', 'exonym' ),
		'labels'                => $labels,
		'supports'              => array( 'title' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 10,
		'menu_icon'             => 'dashicons-video-alt',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'sinema',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'video', $args );

}
add_action( 'init', 'cpt_videos', 0 );

// CTAX: Series
function ctax_series() {

	$labels = array(
		'name'                       => _x( 'Series', 'Taxonomy General Name', 'exonym' ),
		'singular_name'              => _x( 'Series', 'Taxonomy Singular Name', 'exonym' ),
		'menu_name'                  => __( 'Series', 'exonym' ),
		'all_items'                  => __( 'All Series', 'exonym' ),
		'parent_item'                => __( 'Parent Series', 'exonym' ),
		'parent_item_colon'          => __( 'Parent Series:', 'exonym' ),
		'new_item_name'              => __( 'New Series Name', 'exonym' ),
		'add_new_item'               => __( 'Add New Series', 'exonym' ),
		'edit_item'                  => __( 'Edit Series', 'exonym' ),
		'update_item'                => __( 'Update Series', 'exonym' ),
		'view_item'                  => __( 'View Series', 'exonym' ),
		'separate_items_with_commas' => __( 'Separate Series with commas', 'exonym' ),
		'add_or_remove_items'        => __( 'Add or remove Series', 'exonym' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'exonym' ),
		'popular_items'              => __( 'Popular Series', 'exonym' ),
		'search_items'               => __( 'Search Series', 'exonym' ),
		'not_found'                  => __( 'Not Found', 'exonym' ),
		'no_terms'                   => __( 'No Series', 'exonym' ),
		'items_list'                 => __( 'Series list', 'exonym' ),
		'items_list_navigation'      => __( 'Series list navigation', 'exonym' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => false,
	);
	register_taxonomy( 'series', array( 'video' ), $args );

}
add_action( 'init', 'ctax_series', 0 );

// CPT: Videos - Order by Date
function cpt_videosOrdering($query) {
	if(isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == 'video') {
		$query->set('orderby', 'meta_value');
		$query->set('meta_key', 'release_date');
		$query->set('order', 'DESC');
	}
	return $query;
}
add_action('pre_get_posts', 'cpt_videosOrdering');


// Retrieve Videos Functions
function gov_videoFetch($return) {
  $output = [];
  if($return === 'sinema') {
    // Sinema
    $sinemavidsArgs = array(
      'posts_per_page'    => -1,
      'post_type'         => 'video',
    );
    $sinemaVidsQuery = new WP_Query($sinemavidsArgs);
    if($sinemaVidsQuery->have_posts()): while($sinemaVidsQuery->have_posts()): $sinemaVidsQuery->the_post();
      $name           = get_the_title();
      $added          = get_the_date('Ymd');
      $releaseRaw     = get_field('release_date');
      $releaseMake    = DateTime::createFromFormat('F j, Y', $releaseRaw);
      $release        = $releaseMake->format('Ymd');
      $video          = parse_url(get_field('video', $post->ID, false)); parse_str($video['query'], $videoData);
      $videoId        = $videoData['v'];
      $series         = get_the_terms($post->ID, 'series');
      $title          = '<h2><span class="accent">' . $series[0]->name . ': </span>' . $name . '</h2>';
      $desc           = $title . '<p><em>Released on ' . $releaseRaw . '</em></p>' . get_field('description');
      if($videoId) {
        array_push($output, array(
          'id'        => $videoId,
          'name'      => $name,
          'added'     => $added,
          'release'   => $release,
          'desc'      => $desc,
        ));
      }
    endwhile; endif;
    wp_reset_query();
  } elseif($return === 'music') {
    // Music Videos
    $musicvidsArgs = array(
      'posts_per_page'    => -1,
      'post_type'         => 'song',
    );
    $musicVidsQuery = new WP_Query($musicvidsArgs);
    if($musicVidsQuery->have_posts()): while($musicVidsQuery->have_posts()): $musicVidsQuery->the_post();
      $name     = get_the_title($t);
      $added    = get_the_date('Ymd', $t);
      $release  = get_the_date('F j, Y', $t);
      $video    = parse_url(get_field('music_video', $t)); parse_str($video['query'], $videoData);
      $videoId  = $videoData['v'];
      $title    = '<h2><span class="accent">Music Video for:</span>' . $name . '</h2>';
      $desc     = $title . '<p><em>Released on ' . $release . '</em></p>';
      if($videoId) {
        array_push($output, array(
          'id'        => $videoId,
          'name'      => $name,
          'added'     => $added,
          'release'   => $added,
          'desc'      => $desc, // TODO: Put expandable lyrics section here
        ));
      }
    endwhile; endif;
    wp_reset_query();
  } elseif($return === 'live') {
    // Live Videos
    $livevidsArgs = array(
      'posts_per_page'    => -1,
      'post_type'         => 'performance',
    );
    $liveVidsQuery = new WP_Query($livevidsArgs);
    if($liveVidsQuery->have_posts()): while($liveVidsQuery->have_posts()): $liveVidsQuery->the_post();
      $videos = get_field('videos');
      if($videos) {
        $added        = get_the_date('Ymd');
        $releaseRaw   = get_field('date')['start'];
        $releaseMake  = DateTime::createFromFormat('Y-m-d H:i:s', $releaseRaw);
        $release      = $releaseMake->format('Ymd');
        $location     = get_field('location');
        $i = 0;
        foreach($videos as $v) {
          if($v['video']) {
            $name       = $v['info']['song'];
            $cameraDude = ($v['info']['videographer'] ? $v['info']['videographer'] : 'Unknown');
            $notes      = ($v['info']['notes'] ? ' &bull; ' . $v['info']['notes'] : null);
            $videoRaw   = get_post_meta($post->ID, 'videos_' . $i . '_video', false);
            $video      = parse_url($videoRaw[0]); parse_str($video['query'], $videoData);
            $videoId    = $videoData['v'];
            $title      = '<h2><span class="accent">Live on ' . $releaseMake->format('F j, Y') . ' </span>' . $name . '</h2>';
            $desc       = $title . '<p><em>Performed at ' . performanceLocation($location)->name . ' in ' . performanceLocation($location, 'city') . '</em></p><p>Shot by: ' . $cameraDude . $notes . '</p>';
            if($videoId) {
              array_push($vidsLive, array(
                'id'        => $videoId,
                'name'      => $name,
                'added'     => $added,
                'release'   => $release,
                'desc'      => $desc,
              ));
            }
          }
          $i++;
        }
      }
    endwhile; endif;
    wp_reset_query();
  }
  return $output;
}

// Video Display Loop
function gov_videoLoop($v) {
	$output = '';
	$output .= '<li id="' . $v['id'] . '" class="video-control">';
		$output .= '<img src="https://img.youtube.com/vi/' . $v['id'] . '/hqdefault.jpg" alt="Video Preview Thumbnail for ' . $v['name'] . '" />';
		$output .= '<h3>' . $v['name'] . '</h3>';
		$output .= '<p class="release">' . substr($v['release'], 0, 4) . '</p>';
		$output .= '<div class="video-desc">' . $v['desc'] . '</div>';
	$output .= '</li>';
	$output .= '<li class="video-mobile"><a href="https://www.youtube.com/watch?v=' . $v['id'] . '">';
		$output .= '<img src="https://img.youtube.com/vi/' . $v['id'] . '/hqdefault.jpg" alt="Video Preview Thumbnail for ' . $v['name'] . '" />';
		$output .= '<h3>' . $v['name'] . '</h3>';
		$output .= '<p class="release">' . substr($v['release'], 0, 4) . '</p>';
	$output .= '</a></li>';
	return $output;
}
