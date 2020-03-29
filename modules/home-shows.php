<?php
  $section = 'Shows';
  $member = gov_member($section);
  $video = $member['short_video'];
  $image = $member['short_video_image']['sizes']['large'];
  $fancyWords4show = ['Next Shindig', 'Live Appearance', 'Musical Summoning'];
  $fancyWords4past = ['Last Seen', 'Prior Whereabouts', 'Recently Witnessed'];

  $dateNow = current_time('Y-m-d H:i:s');

  $showsNext = get_posts(array(
    'posts_per_page' => 999,
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
  array_reverse($showsNext, true);
  $showsPast = get_posts(array(
    'posts_per_page' => 1,
    'post_type'      => 'performance',
    'meta_query'     => array(
      array(
        'key'         => 'date_start',
        'compare'     => '<',
        'value'       => $dateNow,
        'type'        => 'DATETIME'
      )
    ),
  ));
  echo ex_wrap('start', 'shows', 'performances', $section, $member['color']);
    $showId = ($showsNext) ? (int) end($showsNext)->ID : (int) $showsPast[0]->ID;

    $showStartDb = get_field('date', $showId)['start'];
    $showStart = new DateTime($showStartDb);
    $showStartNice = $showStart->format('Y-m-d H:i:s');

    $showOut = perfDistance($showStartNice, $dateNow);
    $showHeaderSmall = ($showsNext) ? $fancyWords4show[array_rand($fancyWords4show)] : $fancyWords4past[array_rand($fancyWords4past)];
    $showHeaderBig = ($showsNext) ? $showOut : $showStart->format('Y.m.d');

    $showImage = '<div class="home-show-image"><div class="home-show-bg" style="background-image: url(' . get_the_post_thumbnail_url($showId, 'small') . ')"></div>' . get_the_post_thumbnail($showId, 'small') . '</div>';
    $showLocation = get_field('location', $showId);
    $showDay = '<p class="home-show-day">' . $showStart->format('g:i a - l, F j, Y') . '</p>';
    $showName = ($showStart->format('Y.m.d') == get_the_title($showId)) ? '' : '<p class="home-show-name">' . get_the_title($showId) . '</p>';
    $showAddress = '<address><strong>at ' . performanceLocation($showLocation)->name . '</strong>' . performanceLocation($showLocation, 'city') . '</address>';
    $showActs = '';
    $showActsList = get_field('acts', $showId);
    if($showActsList) { $showActs = '<p class="home-show-acts">also playing '; foreach($showActsList as $a) { $showActs .= '&bull; ' . $a['name']; } $showActs .= '</p>'; }
    $showCta = '<button type="button" class="home-cta button">All Performances</button>';
    $showContent = '<div class="home-show-content">' . $showDay . $showName . $showActs . $showAddress . $showCta . '</div>';

    $heading = '<span><i>' . $showHeaderSmall . '</i></span><strong>' . $showHeaderBig . '</strong>';
    $content = '<a href="' . get_post_type_archive_link('performance') . '" class="home-show">' . $showImage . $showContent . '</a>';

    echo govHomeSection($heading, $content);
    echo govHomeVideo($video, $image);
  echo ex_wrap('end');
