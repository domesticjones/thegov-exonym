<?php
  if (!defined('WPINC')) { die; }

  // URL Redirects
  function ex_urlRedirects() {
    $currentPage = "//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $redirects = get_field('url_redirects', 'options');
    foreach($redirects as $url) {
      $newLink = $url['new_link'] ? $url['new_link'] : get_home_url();
      if($currentPage == $url['old_link'] || $currentPage == $url['old_link'] . '/') {
        wp_redirect($newLink, $url['status'], ex_brand('legal'));
        exit;
      }
    }
  }
  add_action('template_redirect', 'ex_urlRedirects');
