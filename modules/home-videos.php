<?php
  $section = 'Videos';
  $member = gov_member($section);
  $video = $member['short_video'];
  $image = $member['short_video_image']['sizes']['large'];
  $fancyWords4vids = ['Motion Pictures', 'Ocular Titillation', 'Fantasies &amp;&nbsp;Realities', 'Smelly People', 'It\'s&nbsp;free for&nbsp;friends'];

  echo ex_wrap('start', 'videos', 'sinema', $section, $member['color']);

      $vidsSinema = gov_videoFetch('sinema');
      $vidsMusic  = gov_videoFetch('music');
      $vidsLive   = gov_videoFetch('live');

      // Recently Added Videos
      $vidsRecent = array_merge($vidsSinema, $vidsMusic, $vidsLive);
      $vidsRecentSort = array_column($vidsRecent, 'added');
      array_multisort($vidsRecentSort, SORT_DESC, $vidsRecent);
      $vidsContent = '<nav class="home-vids-list">';
        $vri = 1;
        foreach($vidsRecent as $vr) {
          if($vri <= 7) {
            $vidsContent .= '<a class="video-single" href="' . get_post_type_archive_link('video') . '?watch=' . $vr['id'] . '">';
          		$vidsContent .= '<img src="https://img.youtube.com/vi/' . $vr['id'] . '/hqdefault.jpg" alt="Video Preview Thumbnail for ' . $vr['name'] . '" />';
              $vidsContent .= '<h2>' . $vr['name'] . '</h2>';
              $vidsContent .= '<p class="release">' . substr($vr['release'], 0, 4) . '</p>';
            $vidsContent .= '</a>';
            $vri++;
          }
        }
        $vidsContent .= '<span class="video-single"><a class="home-cta" href="' . get_post_type_archive_link('video') . '">All Videos</a></span>';
      $vidsContent .= '</nav>';

    $heading = '<span><i>' . $fancyWords4vids[array_rand($fancyWords4vids)] . '</i></span><strong>Watch Stuff</strong>';
    $content = $vidsContent;

    echo govHomeSection($heading, $content);
    echo govHomeVideo($video, $image);
  echo ex_wrap('end');
