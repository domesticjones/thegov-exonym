<?php
  $section = 'Merch';
  $member = gov_member($section);
  $video = $member['short_video'];
  echo ex_wrap('start', 'merch', 'stuff', $section, $member['color']);
    echo govHomeSection('Stuff to Buy', 'We\'re making some stuff for you -- Coming soon -- Add poll for what merch you want, add free DL for HugPunC');
    echo govHomeVideo($video);
  echo ex_wrap('end');
