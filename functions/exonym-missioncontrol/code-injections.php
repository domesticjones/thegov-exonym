<?php
  if (!defined('WPINC')) { die; }

  // Inject Header
  function ex_injectHeader() {
    the_field('inject_header', 'options');
  }
  add_action('wp_head', 'ex_injectHeader', 99);

  // Inject Footer
  function ex_injectFooter() {
    the_field('inject_footer', 'options');
  }
  add_action('wp_footer', 'ex_injectFooter', 99);
