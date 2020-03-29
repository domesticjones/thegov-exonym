<?php
  $bgVideo = get_field('landing_video');
  $bgImage = get_field('landing_video_image');
  echo ex_wrap('start', 'landing', 'high-there');
    if($bgVideo) {
      echo '<video id="landing-video" poster="' . $bgImage['sizes']['large'] . '" muted autoplay playsinline loop>';
        echo '<source src="' . $bgVideo['url'] . '" type="' . $bgVideo['mime_type'] . '">';
      echo '</video>';
    }
  echo ex_wrap('end');
