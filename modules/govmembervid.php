<?php
  echo '
    <video id="member-video" muted autoplay playsinline loop>
      <source src="' . $memberVid['url'] . '" type="' . $memberVid['mime_type'] . '">
    </video>
  ';
