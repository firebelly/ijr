<header class="site-header" role="banner">
  <hgroup class="brand">
    <a href="<?= esc_url(home_url('/')); ?>">
      <h1>the <span class="-center">Center</span></h1>
    </a>
  </hgroup>
  <a href="<?= esc_url(home_url('/')); ?>"><svg role="image" class="icon icon-ijr"><use xlink:href="#icon-ijr"></use></svg></a>
  <div class="nav-toggle outside">
    <h2 class="menu">Menu</h2>
    <svg role="image" class="icon icon-burger nav-icon"><use xlink:href="#icon-burger"></use></svg>
  </div>
  <nav class="site-nav" role="navigation">
    <?php
    if (has_nav_menu('primary_navigation')) :
      $args = [
        'theme_location' => 'primary_navigation', 
        'menu_class' => 'nav',
        'link_before' => '<span class="gradient-highlight">',
        'link_after' => '</span>',
      ];
      wp_nav_menu($args);
    endif;
    ?>
    <div class="nav-toggle inside">
      <h2 class="menu">Menu</h2>
      <svg role="image" class="icon icon-x nav-icon"><use xlink:href="#icon-x"></use></svg>
    </div>
  </nav>
</header>

