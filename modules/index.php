<?php
if (!defined('WPINC')) { die; }

  // Module Content Wrapper
  function ex_wrap($pos, $id = null, $name = null, $accent = null) {
    $output = '';
    if($pos == 'start') {
      if($name) { $namePrint = ' data-section-name="' . $name . '"'; }
      if($accent) { $accentPrint = ' data-section-color="' . $accent . '"'; }
      $output .= '<section id="' . $id . '" class="module module-' . $id . '"' . $namePrint . $accentPrint . '>';
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
