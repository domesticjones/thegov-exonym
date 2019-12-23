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
              $output .= '<img src="' . $icon['sizes']['small'] . '" alt="Icon for ' . get_sub_field('name') . '" />';
              $output .= '<p class="social-info"><strong>' . get_sub_field('name') . '</strong><span>' . get_sub_field('description') . '</span></p>';
            $output .= '</a></li>';
        endwhile;
      $output .= '</ul></nav>';
    }
    return $output;
  }
