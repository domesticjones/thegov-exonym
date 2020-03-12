<?php
  $section = 'Shows';
  $member = gov_member($section);
  $video = $member['short_video'];
  echo ex_wrap('start', 'shows', 'performances', $section);
    echo '<div class="home-section-content">';
      echo 'asdf';
    echo '</div>';
    if($video) {
      echo '<aside class="home-bgvideo-wrap">';
        echo '<video class="home-bgvideo" autoplay muted playsinline loop>';
          echo '<source type="' . $video['mime_type'] . '" data-realvideo="' . $video['url'] . '">';
        echo '</video>';
      echo '</aside>';
    }
  echo ex_wrap('end');
