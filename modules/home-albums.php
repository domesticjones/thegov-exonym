<?php
  $section = 'Albums';
  $member = gov_member($section);
  $video = $member['short_video'];
  $image = $member['short_video_image']['sizes']['large'];
  echo ex_wrap('start', 'listen', 'music', $section, $member['color']);
    echo govHomeSection('Released Music', 'Big Photo for Albums -- Links for GOV on Streaming Platforms (Artist Links) -- CTA: Check Out Albums &amp; Streaming');
    echo govHomeVideo($video, $image);
  echo ex_wrap('end');
