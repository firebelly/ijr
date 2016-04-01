<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'header'); ?>
  <?php get_template_part('templates/content', 'page'); ?>
<?php endwhile; ?>

<section class="staff content-block">
  <div class="content">
      <h1 class="title">Staff</h1>    
      <?= \Firebelly\PostTypes\Person\get_people(); ?>
    </div>
</section>

<section class="partners content-block">
  <div class="content">
      <h1 class="title">Partners</h1>    
      <?= \Firebelly\PostTypes\Partners\get_partners(); ?>
  </div>
</section>