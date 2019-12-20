<?php
  if (!defined('WPINC')) { die; }

  // Display Social Icons
  function ex_social() {
    $output = '';
    if (have_rows('social_networks', 'options')) {
      $output .= '<nav class="nav-social"><ul>';
        while (have_rows('social_networks', 'options')): the_row();
          $icon = get_sub_field('icon');
            $output .= '<li><a href="' . get_sub_field('url') . '" title="' . get_sub_field('description') . '" target="_blank">';
              $output .= '<img src="' . $icon['sizes']['small'] . '" alt="' . get_sub_field('description') . '" />';
              $output .= '<span>' . $icon['title'] . '</span>';
            $output .= '</a></li>';
        endwhile;
      $output .= '</ul></nav>';
    }
    return $output;
  }
