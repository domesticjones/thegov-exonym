<?php
if (!defined('WPINC')) { die; }

  // Module Content Wrapper
  function ex_wrap($pos, $name = null) {
    $output = '';
    if($pos == 'start') {
      $output .= '<section id="' . $name . '" class="module module-' . $name . '">';
    } elseif($pos == 'end') {
      $output .= '</section>';
    }
    return $output;
  }

  // Find Member based on Assignment
  function gov_member($assign) {
    $members = get_field('members', 'options');
    $i = 0;
    foreach($members as $dude) {
      $dudeWhat = $dude['assign'];
      if($dudeWhat == $assign) {
        break;
      }
      $i++;
    }
    $dudeScent = $members[$i];
    return $dudeScent;
  }
