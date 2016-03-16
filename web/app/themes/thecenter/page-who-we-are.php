<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>

<section id="staff">
  <h1>Staff</h1>    
  <?= \Firebelly\PostTypes\Person\get_people(); ?>
</section>

<section id="partners">
  <h1>Partners</h1>    
  <?= \Firebelly\PostTypes\Partners\get_partners(); ?>
</section>