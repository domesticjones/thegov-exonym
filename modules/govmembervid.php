<?php
  echo '<video id="member-video" poster="' . $memberImg['sizes']['large'] . '" muted autoplay playsinline loop>';
    echo '<source src="' . $memberVid['url'] . '" type="' . $memberVid['mime_type'] . '">';
  echo '</video>';
