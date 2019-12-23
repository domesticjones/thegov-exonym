<header class="nav-responsive">
  <nav>
    <ul>
      <?php
        $navMenu = wp_get_nav_menu_items('primary-menu');
        foreach($navMenu as $nav) {
          $navMeta = get_post_meta($nav->ID);
          $nameShort = $navMeta['short_name'][0];
          $nameLong = $nav->title;
          echo '<li>';
          $icon = (int)$navMeta['icon'][0];
            echo wp_get_attachment_image($icon);
            echo '<a href=""><span>' . $nameLong . '</span><i>' . $nameShort . '</i></a>';
          echo '</li>';
        }
      ?>
    </ul>
  </nav>
</header>
