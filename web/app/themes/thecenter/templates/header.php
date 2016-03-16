<header class="site-header" role="banner">
  <div class="container">
    <a class="brand" href="<?= esc_url(home_url('/')); ?>">
      <h1><?php bloginfo('name'); ?></h1>
      <svg role="image" class="icon icon-ijr"><use xlink:href="#icon-ijr"></use></svg>
    </a>
  
    <nav class="site-nav" role="navigation">
      <h2>Menu</h2>
      <?php
      if (has_nav_menu('primary_navigation')) :
        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
      endif;
      ?>
    </nav>
  </div>
</header>