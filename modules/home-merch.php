<?php
  $section = 'Merch';
  $member = gov_member($section);
  $video = $member['short_video'];
  echo ex_wrap('start', 'merch', 'stuff', $section, $member['color']);
    echo '<div class="home-section-content">';
      echo 'asdf';
    echo '</div>';
    echo govHomeVideo($video);
  echo ex_wrap('end');
