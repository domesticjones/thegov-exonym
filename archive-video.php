<?php
  function gov_videoLoop($v) {
    $output = '';
    $output .= '<li id="' . $v['id'] . '" class="video-control">';
      $output .= '<img src="https://img.youtube.com/vi/' . $v['id'] . '/hqdefault.jpg" alt="Video Preview Thumbnail for ' . $v['name'] . '" />';
      $output .= '<h3>' . $v['name'] . '</h3>';
      $output .= '<p class="release">' . substr($v['release'], 0, 4) . '</p>';
      $output .= '<div class="video-desc">' . $v['desc'] . '</div>';
    $output .= '</li>';
    return $output;
  }

  function gov_color() {
    $memberColor = gov_member('Videos')['color'];
    include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);
  get_header();
  echo '<article id="performance-archive" class="page-content">';
    $vidsSinema = [];
    $vidsMusic  = [];
    $vidsLive   = [];

    // Sinema
    if(have_posts()): while(have_posts()): the_post();
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
        array_push($vidsSinema, array(
          'id'        => $videoId,
          'name'      => $name,
          'added'     => $added,
          'release'   => $release,
          'desc'      => $desc,
        ));
      }
    endwhile; endif;

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
        array_push($vidsMusic, array(
          'id'        => $videoId,
          'name'      => $name,
          'added'     => $added,
          'release'   => $added,
          'desc'      => $desc, // TODO: Put expandable lyrics section here
        ));
      }
    endwhile; endif;
    wp_reset_query();

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

    // Current Player
    echo ex_wrap('start', 'video-current');
      $videoDefault = get_field('fallback_video', 'options');
      echo '<div id="video-current-thumb"><img src="' . wp_get_attachment_image_url($videoDefault['ID'], 'medium') . '" class="default" /><span></span><button class="video-close accent"><span>Turn Off Video</span></button></div>';
      echo '<div class="video-current-data">';
        echo '<h1><span class="default">Watch Somethin\'</span><span class="active">Now Playing</span></h1>';
        echo '<div id="video-current-info"></div>';
      echo '</div>';
      echo '<nav id="video-tabs" class="accent">';
        echo '<p>Choose<span> a Genre:</span></p>';
        echo '<a href="#vids-recent" class="is-active">Recent</a>';
        echo '<a href="#vids-sinema">Sinema</a>';
        echo '<a href="#vids-music">Music Videos</a>';
        echo '<a href="#vids-live">Live</a>';
      echo '</nav>';
    echo ex_wrap('end');

    echo ex_wrap('start', 'video-lists');

      // Recently Added Videos
      $vidsRecent = array_merge($vidsSinema, $vidsMusic, $vidsLive);
      $vidsRecentSort = array_column($vidsRecent, 'added');
      array_multisort($vidsRecentSort, SORT_DESC, $vidsRecent);
      echo '<ul id="vids-recent" class="is-active">';
        $vri = 1;
        foreach($vidsRecent as $vr) { if($vri <= 12) { echo gov_videoLoop($vr); $vri++; } }
      echo '</ul>';

      // Sinema Videos
      $vidsSinemaSort = array_column($vidsSinema, 'release');
      array_multisort($vidsSinemaSort, SORT_DESC, $vidsSinema);
      echo '<ul id="vids-sinema">';
        foreach($vidsSinema as $vs) { echo gov_videoLoop($vs); }
      echo '</ul>';

      // Music Videos
      $vidsMusicSort = array_column($vidsMusic, 'release');
      array_multisort($vidsMusicSort, SORT_DESC, $vidsMusic);
      echo '<ul id="vids-music">';
        foreach($vidsMusic as $vm) { echo gov_videoLoop($vm); }
      echo '</ul>';

      // Live Videos
      $vidsLiveSort = array_column($vidsLive, 'release');
      array_multisort($vidsLiveSort, SORT_DESC, $vidsLive);
      echo '<ul id="vids-live">';
        foreach($vidsLive as $vl) { echo gov_videoLoop($vl); }
      echo '</ul>';

    echo ex_wrap('end');
  echo '</article>';

  echo '<aside class="page-sidebar">';
    $memberVid = gov_member('Videos')['long_video'];
    include('modules/govmembervid.php');
  echo '</aside>';

  echo '<aside id="video-player">';
    echo '<div class="noise"></div>';
    echo '<iframe id="video-daddy" src="about:blank" type="text/html" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
  echo '</aside>';

  get_footer();
?>
