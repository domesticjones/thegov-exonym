<?php
  function gov_color() {
    $memberColor = gov_member('Shows')['color'];
    include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);
  get_header();
    echo '<article id="performance-archive" class="page-content">';

    $dateNow = date('Y-m-d H:i:s');
    $fancyWords4shows = ['Performances', 'Shindigs', 'Discharges', 'Doings', 'Demonstrations', 'Feats', 'Triumphs', 'Executions', 'Conquests'];

    $upcomingPerfs = get_posts(array(
      'post_type'       => 'performance',
      'posts_per_page'  => 999,
      'meta_query'      => array(
        'relation'      => 'OR',
        array(
          'key'         => 'date_start',
          'compare'     => '>=',
          'value'       => $dateNow,
          'type'        => 'DATETIME',
        ),
        array(
          'key'         => 'date_end',
          'compare'     => '>=',
          'value'       => $dateNow,
          'type'        => 'DATETIME',
        ),
      ),
    ));

    $allPerfs = get_posts(array(
      'post_type'       => 'performance',
      'posts_per_page'  => -1,
    ));

    $pastPerfs = get_posts(array(
      'post_type'       => 'performance',
      'posts_per_page'  => 999,
      'meta_query'      => array(
        'relation'      => 'OR',
        array(
          'key'         => 'date_start',
          'compare'     => '<',
          'value'       => $dateNow,
          'type'        => 'DATETIME',
        ),
        array(
          'key'         => 'date_end',
          'compare'     => '<',
          'value'       => $dateNow,
          'type'        => 'DATETIME',
        ),
      ),
    ));
    if($upcomingPerfs) {
      echo ex_wrap('start', 'perf-upcoming');
        echo '<h1>Upcoming ' . $fancyWords4shows[array_rand($fancyWords4shows)] . '<span class="accent"><i>feat.</i>' . ex_brand() . '</span></h1>';
        echo '<nav class="upcoming-wrap">';
        foreach(array_reverse($upcomingPerfs) as $perf) {
          $link       = get_permalink($perf->ID);
          $date       = get_field('date', $perf->ID);
          $dateFormat = DateTime::createFromFormat('Y-m-d H:i:s', $date['start']);
          $title      = get_the_title($perf->ID);
          $poster     = get_the_post_thumbnail($perf->ID, 'small');
          $posterUrl  = get_the_post_thumbnail_url($perf->ID, 'medium');
          $location   = get_field('location', $perf->ID);
  				$admit      = get_field('admittance', $perf->ID);
          $admitAdv		= $admit['cost']['advance'];
          $admitDoors	= $admit['cost']['doors'];
          $acts       = get_field('acts', $perf->ID);
          $desc       = get_field('description', $perf->ID);
          echo '<a href="' . $link . '" title="Learn more about ' . $title . '">';
            echo '<div class="upcoming-poster"><div class="upcoming-bg" style="background-image: url(' . $posterUrl . ');"></div>' . $poster . '</div>';
            echo '<div class="upcoming-data">';
            echo '<h2>' . $title . '</h2>';
              if($acts) {
                $actList = [];
                foreach($acts as $a) { array_push($actList, $a['name']); }
                echo '<h3><small>with </small>' . implode(', ', $actList) . '</h3>';
              }
              echo '<address><strong>' . performanceLocation($location)->name . '</strong> &bull; ' . performanceLocation($location, 'city') . '</address>';
              echo '<time datetime="' . $dateFormat->format('Y-m-d H:i:s') . '">' . $dateFormat->format('g:ia - l, F jS, Y') . '</time>';
              echo'<ul>';
                if($admit['private']) {
                  echo '<li class="private">This is a Private Event for Private People.</li>';
                } else {
                  if(!empty($admit['ages'])) { echo '<li class="ages">Ages: <strong>' . $admit['ages'] . '</strong></li>'; }
                  if($admitAdv || $admitDoors) {
                    if($admitAdv === (string) '0') { $admitAdv = 'Free'; }
                    if($admitDoors === (string) '0') { $admitDoors = 'Free'; }
                    echo '<li class="cost">Cost: <strong>' . ($admitAdv ? $admitAdv . '/adv &bull; ' .$admitDoors . '/door' : $admitDoors) . '</strong></li>';
                  }
                }
                echo '<li class="button">More Information</li>';
              echo '</ul>';
            echo '</div>';
          echo '</a>';
        }
        echo '</nav>';
      echo ex_wrap('end');
    }
    $otherActs = [];
    if($allPerfs) {
      foreach($allPerfs as $perf) {
        $acts = get_field('acts', $perf->ID);
        if($acts) {
          foreach($acts as $act) {
            array_push($otherActs, $act['name']);
          }
        }
      }
    }
    $actsList = array_unique($otherActs);
    sort($actsList);
    if($actsList) {
      echo ex_wrap('start', 'perf-otheracts');
        echo '<h2 class="accent">' . ex_brand() . '<span> has performed with the following acts:</span></h2>';
        echo '<ul>';
          foreach($actsList as $act) {
            echo '<li>' . $act . '</li>';
          }
        echo '</ul>';
      echo ex_wrap('end');
    }
    if($pastPerfs) {
      echo ex_wrap('start', 'perf-past');
        echo '<h1 class="accent"><span>Past ' . $fancyWords4shows[array_rand($fancyWords4shows)] . '</span></h1>';
        echo '<nav class="past-wrap">';
        foreach($pastPerfs as $perf) {
          $link       = get_permalink($perf->ID);
          $title      = get_the_title($perf->ID);
          $poster     = get_the_post_thumbnail($perf->ID, 'thumbnail-medium');
          $location   = get_field('location', $perf->ID);
          $locName    = performanceLocation($location)->name . '<br />' . performanceLocation($location, 'city');
          echo '<a href="' . $link . '">' . $poster . '<h3>' . $title . '</h3><address>' . $locName . '</address></a>';
        }
      echo ex_wrap('end');
    }
    echo '</article>';
    echo '<aside class="page-sidebar">';
      $memberVid = gov_member('Shows')['long_video'];
      include('modules/govmembervid.php');
    echo '</aside>';
  get_footer();
?>
