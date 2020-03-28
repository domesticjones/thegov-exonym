<?php
  $dateNow = current_time('Y-m-d');
  $timeNow = strtotime($dateNow);
  $section = 'Shows';
  $member = gov_member($section);
  $video = $member['short_video'];
  $fancyWords4shows = ['Next Shindig', 'Live Appearance', 'Musical Summoning'];

  $showContent = [];
  $showStart = 1;
  $shows = get_posts(array(
    'posts_per_page' => 4,
    'post_type'      => 'performance',
    'meta_query'     => array(
      array(
        'key'         => 'date_start',
        'compare'     => '>=',
        'value'       => $dateNow,
        'type'        => 'DATETIME'
      )
    ),
  ));

  echo ex_wrap('start', 'shows', 'performances', $section, $member['color']);

    foreach(array_reverse($shows) as $s) {
      $id = $s->ID;
      $showFirst = ($showStart === 1) ? ' first' : '';
      $showStartDb = get_field('date', $id)['start'];
      $showStart = new DateTime($showStartDb);
      $showStartNice = $showStart->format('Y-m-d');
      $showOut = perfDistance($showStartNice, $dateNow);
      $showLocation = get_field('location', $id);
      $showAddress = '<address><strong>' . performanceLocation($showLocation)->name . '</strong>' . performanceLocation($showLocation, 'city') . '</address>';
      $showImage = get_the_post_thumbnail($id, 'small');
      $showDetails = '<div class="home-show-content"><p>' . $showOut . '</p><h2>' . get_the_title($id) . '</h2>' . $showAddress . '</div>';
      $show = '<a href="' . get_the_permalink($id) . '" class="home-show' . $showFirst . '">' . $showImage . $showDetails . '</a>';
      array_push($showContent, $show);
      $showStart++;
    }

    echo govHomeSection($fancyWords4shows[array_rand($fancyWords4shows)], implode(' ', $showContent));
    echo govHomeVideo($video);
  echo ex_wrap('end');
