<?php
  if (!defined('WPINC')) { die; }

  // Inside Contact Info Display
  function ex_ContactLoopInner($type, $link, $typeLink) {
    $output = '';
    $typeData = '';
    if ($type == 'email') {
      $typeData = get_sub_field('address');
    } elseif ($type == 'phone') {
      $typeData = get_sub_field('number');
    }
    $output .= '<li>';
      if ($link) { $output .= '<a href="' . $typeLink . $typeData . '" target="_blank">'; }
        if (get_sub_field('name')) { $output .= '<span class="name">' . get_sub_field('name') . '</span>'; }
        $output .= '<span class="data">' . $typeData . '</span>';
      if ($link) { $output .= '</a>'; }
    $output .= '</li>';
    return $output;
  }

  // Loop for displaying Contact Info
  function ex_ContactLoop($type = null, $link = true, $amount = 'all') {
    $output = '';
    $navWrapStart = '<nav class="nav-' . $type . '"><ul>';
    $navWrapEnd = '</ul></nav>';
    $typeName = '';
    $typeLink = '';
    if ($type == 'email') {
      $typeName = 'email_addresses';
      $typeLink = 'mailto:';
    } elseif ($type == 'phone') {
      $typeName = 'phone_numbers';
      $typeLink = 'tel:';
    }
    if ($type != null) {
      $output .= $navWrapStart;
      while (have_rows($typeName, 'options')): the_row();
      if ($amount == 'all') {
        $output .= ex_ContactLoopInner($type, $link, $typeLink);
      } elseif ($amount == 'global' && get_sub_field('global')) {
        $output .= ex_ContactLoopInner($type, $link, $typeLink);
      }
      endwhile;
      $output .= $navWrapEnd;
    }
    return $output;
  }

  // Contact Lists
  function ex_contact($type, $link = true, $amount = 'all') {
    if ($type == 'email') { if (have_rows('email_addresses', 'options')) { return ex_ContactLoop($type, $link, $amount); } }
    if ($type == 'phone') { if (have_rows('phone_numbers', 'options')) { return ex_ContactLoop($type, $link, $amount); } }
    if ($type == 'address') { return get_field('address', 'options'); }
  }
