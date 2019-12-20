<?php
if (!defined('WPINC')) { die; }

  // Module Content Wrapper
  function ex_wrap($position, $name = 'default', $classes = null, $print = true) {
    $output = '';
    $classesOuter = ['module'];
    if($classes) { array_push($classesOuter, $classes); }
    $classesInner = ['module-inner'];
    $classesInnerPrint = [];
    $style = '';
    if($position == 'start' || $position == 'start-modules') {
      if($position == 'start-modules') {
        $size = get_sub_field('module_size');
        $name = get_sub_field('module_id');
        $p = get_sub_field('module_padding');
        $pad = ['module-pad-t-' . $p['top'], 'module-pad-b-' . $p['bottom'], 'module-pad-l-' . $p['left'], 'module-pad-r-' . $p['right']];
        $height = $size['height']['number'];
        if($height > 0) { $style .= ' style="min-height: ' . $height . $size['height']['measure'] . ';"'; }
        $width = $size['width']['size'];
        $constrain = $size['width']['constrain'];
        $align = $size['width']['align'];
        if($width != 'full' && $constrain) {
          array_push($classesOuter, 'module-constrain', 'module-width-' . $width, 'module-align-' . $align);
        } else {
          array_push($classesInner, 'module-width-' . $width, 'module-align-' . $align);
        }
        $classesInnerPrint = array_merge($classesInner, $pad);
      }
      $id = str_replace(' ', '-', strtolower($name));
      array_push($classesOuter, 'module-' . $id, 'animate-on-enter');
      $output .= '<section id="' . $id . '" class="' . implode(' ', $classesOuter) . '"' . $style . '>';
      $output .= '<div class="' . implode(' ' , $classesInnerPrint) . '">';
    } elseif($position == 'end') {
      $output .= '</div>';
      $output .= '</section>';
    } elseif($position == 'start-body') {
      $output .= '<article id="' . get_post_type() . '-' . get_the_ID() . '" class="module-wrapper ' . implode(' ', get_post_class()) . '">';
    } elseif($position == 'end-body') {
      $output .= '</article>';
    }
    if($print) {
      echo $output;
    } else {
      return $output;
    }
  }

  function ex_content($id = false) {
    if(!$id) { $id = $post->ID; }
    if(have_rows('content_builder', $id)) {
      while(have_rows('content_builder', $id)) {
        the_row();
        ex_wrap('start-modules');
          echo '<p>asdf</p><blockquote><q>Quote Goes Here</q><cite>Person Name</cite></blockquote>';
        ex_wrap('end');
      }
    }
  }
