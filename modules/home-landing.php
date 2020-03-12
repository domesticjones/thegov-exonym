<?php
  $bgVideo = get_field('landing_video');
  echo ex_wrap('start', 'landing', 'high-there');
    if($bgVideo) {
      echo '
      <video id="landing-video" muted autoplay playsinline loop>
        <source src="' . $bgVideo['url'] . '" type="' . $bgVideo['mime_type'] . '">
      </video>
      ';
    }
  echo ex_wrap('end');
