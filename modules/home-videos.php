<?php
  $section = 'Videos';
  $member = gov_member($section);
  $video = $member['short_video'];
  $image = $member['short_video_image']['sizes']['large'];
  echo ex_wrap('start', 'videos', 'sinema', $section, $member['color']);
    echo govHomeSection('Recent Videos', 'Pull Shows, Albums, and Videos -- Sort by recently modified -- Show 7 Most Recent with -- CTA: "Show Me More Videos!"');
    echo govHomeVideo($video, $image);
  echo ex_wrap('end');
