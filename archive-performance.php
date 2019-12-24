<?php
  function gov_color() {
    $memberColor = gov_member('Shows')['color'];
    include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);
  get_header();
    echo '<article id="performance-archive" class="page-content">';

    $dateNow = date('Y-m-d H:i:s');

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
      ex_wrap('start', 'perf-upcoming');
        foreach($upcomingPerfs as $perf) {
          $date       = get_field('date');
          $title = get_the_title($perf->ID);
          $poster = get_the_post_thumbnail($perf->ID, 'small');
          $location   = get_field('location');
        }
      ex_wrap('end');
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
      ex_wrap('start', 'perf-otheracts');
        echo '<h2>' . ex_brand() . ' has performed with the following acts:</h2>';
        echo '<ul>';
          foreach($actsList as $act) {
            echo '<li>' . $act . '</li>';
          }
        echo '</ul>';
      ex_wrap('end');
    }



    if($pastPerfs) {
      foreach($pastPerfs as $perf) {
        //echo get_the_title($perf->ID);
      }
    }




    echo '</article>';
    echo '<aside class="page-sidebar">';
      $memberVid = gov_member('Shows')['long_video'];
      include('modules/govmembervid.php');
    echo '</aside>';
  get_footer();
?>
