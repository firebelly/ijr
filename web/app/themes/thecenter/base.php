<?php

use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>

<!doctype html>
<!--[if IE 8]> <html class="ie8 lt-ie9 lt-ie10" lang="en"> <![endif]-->
<!--[if IE 9 ]> <html class="ie9 lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="" <?php language_attributes(); ?>> <!--<![endif]-->
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>
      <?php
        do_action('get_header');
        get_template_part('templates/header');
      ?>
    <div class="nav-push-wrap">
      <a href="<?= esc_url(home_url('/')); ?>" class="icon-ijr-wrap">
        <svg role="image" class="icon icon-ijr"><use xlink:href="#icon-ijr"></use></svg>
      </a>
      <!--[if lt IE 9]>
        <div class="alert alert-warning">
          <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
        </div>
      <![endif]-->
      <div class="site-wrap" role="document">
        <div class="content">
          <main class="site-main" role="main">
            <?php include Wrapper\template_path(); ?>
          </main><!-- /.main -->
          <?php if (Setup\display_sidebar()) : ?>
            <aside class="sidebar">
              <?php include Wrapper\sidebar_path(); ?>
            </aside><!-- /.sidebar -->
          <?php endif; ?>
        </div><!-- /.content -->
      </div><!-- /.site-wrap -->
      <?php
        do_action('get_footer');
        get_template_part('templates/footer');
        wp_footer();
      ?>
    </div>
  </body>
</html>
