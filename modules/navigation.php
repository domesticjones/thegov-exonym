<header class="nav-responsive">
  <nav>
    <ul>
      <?php
        $navMenu = wp_get_nav_menu_items('primary-menu');
        foreach($navMenu as $nav) {
          $navMeta    = get_post_meta($nav->ID);
          //var_dump($nav);
          $nameShort  = $navMeta['short_name'][0];
          $nameLong   = $nav->title;
          $link       = $nav->url;
          echo '<li>';
            echo '<a href="' . $link . '">';
            $icon = (int)$navMeta['icon'][0];
              echo wp_get_attachment_image($icon);
              echo '<p><span>' . $nameLong . '</span><i>' . $nameShort . '</i></p>';
            echo '</a>';
          echo '</li>';
        }
      ?>
    </ul>
  </nav>
</header>
