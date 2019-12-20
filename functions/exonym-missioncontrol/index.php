<?php
  if (!defined('WPINC')) { die; }

  // Create Mission Control Options Page
  if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
      'page_title' 	=> 'Exonym Mission Control',
      'menu_title'	=> 'Mission Control',
      'menu_slug' 	=> 'ex-missioncontrol',
      'capability'	=> 'switch_themes',
      'redirect'		=> true,
      'icon_url'    => 'dashicons-editor-kitchensink',
      'position'    => 2
    ));
  }

  require_once('migration-management.php');
  require_once('code-injections.php');
