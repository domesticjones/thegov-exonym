<?php
  $section = 'Contact';
  $member = gov_member($section);
  $video = $member['short_video'];
  echo ex_wrap('start', 'contact', 'touch', $section, $member['color']);
    echo govHomeSection('We\'re Just Happy to See You', 'Preview of Bio -- Sample of Photo Grid (8 photos) -- CTA: Read More, view press articles & photos');
    echo govHomeVideo($video);
  echo ex_wrap('end');
