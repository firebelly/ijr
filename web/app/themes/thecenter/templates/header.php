

<header class="site-header" role="banner">
  <div class="brand sticky">
    <a href="<?= esc_url(home_url('/')); ?>">
      <h1>the <span class="-center">Center</span></h1>
    </a>
  </div>
</header>

<div class="nav-toggle outside sticky">
  <h2 class="menu">Menu</h2>
  <svg role="image" class="icon icon-burger nav-icon"><use xlink:href="#icon-burger"></use></svg>
</div>
<div class="nav-mask"></div>
<!-- <div class="nav-backup-bg"></div> -->
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