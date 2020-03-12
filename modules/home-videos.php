<?php
  $section = 'Videos';
  $member = gov_member($section);
  $video = $member['short_video'];
  echo ex_wrap('start', 'videos', 'sinema', $section, $member['color']);
    echo '<div class="home-section-content">';
      echo 'asdf';
    echo '</div>';
    echo govHomeVideo($video);
  echo ex_wrap('end');
