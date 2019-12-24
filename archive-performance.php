<?php
  function gov_color() {
    $memberColor = gov_member('Shows')['color'];
    include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);
  get_header();
    echo '<article id="performance-archive" class="page-content">';



    // Find todays date in Ymd format.
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

    if($upcomingPerfs) {
      foreach($upcomingPerfs as $perf) {
        the_title();
      }
    }




    echo '</article>';
    echo '<aside class="page-sidebar">';
      $memberVid = gov_member('Shows')['long_video'];
      include('modules/govmembervid.php');
    echo '</aside>';
  get_footer();
?>
