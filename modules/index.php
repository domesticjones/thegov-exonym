<?php
if (!defined('WPINC')) { die; }

  // Module Content Wrapper
  function ex_wrap($pos, $name = null, $class = null) {
    $output = '';
    if($pos == 'start') {
      $output .= '<section id="' . $name . '" class="module module-' . $name . '">';
    } elseif($pos == 'end') {
      $output .= '</section>';
    }
    return $output;
  }
