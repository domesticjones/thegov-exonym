<?php
    $id = get_the_id();
    wp_safe_redirect(get_post_type_archive_link('video') . '?viewing=' . get_post_field('post_name', $id));
?>