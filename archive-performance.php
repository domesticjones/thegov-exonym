<?php
  function gov_color() {
    $memberColor = gov_member('Shows')['color'];
    include('modules/govcolors.php');
  }
  add_action('wp_head', 'gov_color', 100);

  get_header();
    echo '<article id="performance-archive" class="page-content">';

    $dateNow = (int) current_time('YmdHis');
    $fancyWords4shows = ['Performances', 'Shindigs', 'Discharges', 'Doings', 'Demonstrations', 'Feats', 'Triumphs', 'Executions', 'Conquests'];
    $fancyWords4info = ['More Info', 'Tell Me More', 'Gimme Them Deets', 'Comprehensive Data', 'The Full Situation', 'More Fuckin Info'];

    $allPerfs = [];
    $allBands = [];

    if(have_posts()): while(have_posts()): the_post();
      $idPrint    = array('id' => get_the_id());
      $date       = get_field('date');
      $dateFormat = DateTime::createFromFormat('Y-m-d H:i:s', $date['start']);
      $dateSort   = array('dateSort' => (int) $dateFormat->format('YmdHis'));
      $link       = array('link' => get_the_permalink());
      $title      = array('title' => get_the_title());
      $poster     = array('posterImg' => get_the_post_thumbnail($id, 'small'));
      $posterUrl  = array('posterUrl' => get_the_post_thumbnail_url($id, 'medium'));
      $location   = array('location' => get_field('location'));
      $admit      = array('admit' => get_field('admittance'));
      $actsRows   = get_field('acts');
      $acts       = array('acts' => $actsRows);
      $perfOutput = array_merge(
        $idPrint,
        $dateSort,
        $link,
        $title,
        $poster,
        $posterUrl,
        $location,
        $admit,
        $acts
      );
      foreach($actsRows as $a) { array_push($allBands, $a['name']); }
      array_push($allPerfs, $perfOutput);
    endwhile; endif;

    $perfsUpcoming = $allPerfs;
    $pUi = 0;
    foreach($perfsUpcoming as $pu) { if($pu['dateSort'] <= $dateNow) { unset($perfsUpcoming[$pUi]); } $pUi++; }
    $perfsUpcomingClean = array_values($perfsUpcoming);

    if($perfsUpcomingClean) {
      echo ex_wrap('start', 'perf-upcoming');
        echo '<h1>Upcoming ' . $fancyWords4shows[array_rand($fancyWords4shows)] . '<span class="accent"><i>feat.</i>' . ex_brand() . '</span></h1>';
        echo '<nav class="upcoming-wrap">';
        foreach(array_reverse($perfsUpcomingClean) as $perf) {
          $date       = $perf['dateSort'];
          $dateFormat = DateTime::createFromFormat('YmdHis', $date);
  		  $admit      = $perf['admit'];
          $admitAdv	  = $admit['cost']['advance'];
          $admitDoors = $admit['cost']['doors'];
          echo '<a href="' . $perf['link'] . '" title="Learn more about ' . $perf['title'] . '">';
            echo '<div class="upcoming-poster"><div class="upcoming-bg" style="background-image: url(' . $perf['posterUrl'] . ');"></div>' . $perf['posterImg'] . '</div>';
            echo '<div class="upcoming-data">';
            echo '<h2>' . $perf['title'] . '</h2>';
              if($perf['acts']) {
                $actList = [];
                foreach($perf['acts'] as $a) { array_push($actList, $a['name']); }
                echo '<h3><small>with </small>' . implode(', ', $actList) . '</h3>';
              }
              echo '<address><strong>' . performanceLocation($perf['location'])->name . '</strong> &bull; ' . performanceLocation($perf['location'], 'city') . '</address>';
              echo '<time datetime="' . $dateFormat->format('Y-m-d H:i:s') . '">' . $dateFormat->format('g:ia - l, F jS, Y') . '</time>';
              echo'<ul>';
                if($admit['private']) {
                  echo '<li class="private">This is a Private Event for Private People.</li>';
                } else {
                  if(!empty($admit['ages'])) { echo '<li class="ages">Ages: <strong>' . $admit['ages'] . '</strong></li>'; }
                  if($admitAdv || $admitDoors) {
                    if($admitAdv === (string) '0') { $admitAdv = 'Free'; }
                    if($admitDoors === (string) '0') { $admitDoors = 'Free'; }
                    echo '<li class="cost">Cost: <strong>' . ($admitAdv ? $admitAdv . '/adv &bull; ' . $admitDoors . '/door' : $admitDoors) . '</strong></li>';
                  }
                }
                echo '<li class="button">' . $fancyWords4info[array_rand($fancyWords4info)] . '</li>';
              echo '</ul>';
            echo '</div>';
          echo '</a>';
        }
        echo '</nav>';
      echo ex_wrap('end');
    }

    sort($allBands);
    $allBandsUnique = array_unique($allBands, SORT_STRING);

    if($allBandsUnique) {
      echo ex_wrap('start', 'perf-otheracts');
        echo '<h2 class="accent">' . ex_brand() . '<span> has performed with the following acts:</span></h2>';
        echo '<ul>';
          foreach($allBandsUnique as $act) {
            echo '<li>' . $act . '</li>';
          }
        echo '</ul>';
      echo ex_wrap('end');
    }

    $perfsPast = $allPerfs;
    $pPi = 0;
    foreach($perfsPast as $pp) { if($pp['dateSort'] > $dateNow) { unset($perfsPast[$pPi]); } $pPi++; }
    $perfsPastClean = array_values($perfsPast);

    if($perfsPastClean) {
      echo ex_wrap('start', 'perf-past');
        echo '<h1 class="accent"><span>Past ' . $fancyWords4shows[array_rand($fancyWords4shows)] . '</span></h1>';
        echo '<nav class="past-wrap">';
        foreach($perfsPastClean as $perf) {
          $poster     = get_the_post_thumbnail($perf['id'], 'thumbnail-medium');
          $location   = $perf['location'];
          $locName    = performanceLocation($location)->name . '<br />' . performanceLocation($location, 'city');
          echo '<a href="' . $perf['link'] . '">' . $poster . '<h3>' . $perf['title'] . '</h3><address>' . $locName . '</address></a>';
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
