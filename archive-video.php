<?php
  function gov_color() {
    $memberColor = gov_member('Videos')['color'];
    include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);
  get_header();
  echo '<article id="performance-archive" class="page-content">';

    // Current Player
    echo ex_wrap('start', 'video-current');
      $videoDefault = get_field('video_fallbacks', 'options')['nothing_playing'];
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

      $vidsSinema = gov_videoFetch('sinema');
      $vidsMusic  = gov_videoFetch('music');
      $vidsLive   = gov_videoFetch('live');

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
    $memberImg = gov_member('Videos')['long_video_image'];
    include('modules/govmembervid.php');
  echo '</aside>';

  echo '<aside id="video-player">';
    $static = get_field('video_fallbacks', 'options')['static'];
    echo '<div class="noise" style="background-image: url(' . wp_get_attachment_image_url($static['ID'], 'jumbo') . ')"></div>';
    echo '<iframe id="video-daddy" src="about:blank" type="text/html" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
  echo '</aside>';

  get_footer();
?>
