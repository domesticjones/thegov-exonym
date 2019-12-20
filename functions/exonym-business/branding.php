<?php
  if (!defined('WPINC')) { die; }

  // Business Name
  function ex_brand($type = 'name') {
    $output = '';
    if ($type == 'name') {
      $output = get_field('business_name', 'options');
    } elseif ($type == 'legal') {
      $output = get_field('legal_name', 'options');
    }
    return $output;
  }

  // Logo
  function ex_logo($style = 'primary', $color = 'full_color', $size = 'large') {
    $logoTable = get_field('logo', 'options');
    $logoChosen = $logoTable[$style][$color];
    $logo = $logoChosen['sizes'][$size];
    return $logo;
  }
