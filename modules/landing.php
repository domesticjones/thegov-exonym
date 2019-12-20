<?php
  $bgVideo = get_field('landing_video');
  echo ex_wrap('start', 'hello');
    if($bgVideo) {
      echo '
      <video id="vid" autoplay loop>
  <source src="' . $bgVideo['url'] . '" type="' . $bgVideo['mime_type'] . '">
</video>
      ';
    }
  echo ex_wrap('end');
