<?php
  $video    = parse_url(get_field('video', $post->ID, false)); parse_str($video['query'], $videoData);
  $videoId  = $videoData['v'];
  wp_safe_redirect(get_post_type_archive_link('video') . '#' . $videoId);
?>