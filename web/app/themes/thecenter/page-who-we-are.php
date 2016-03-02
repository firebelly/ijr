<?php while (have_posts()) : the_post(); ?>

<div class="page-header">
	<?php the_post_thumbnail( 'large' ); ?>
  <h1>for Community-based Children &amp; Family Mental Health</h1>
</div>
<section class="page-content">
	<h2>Who We Are</h2>
  	<?php the_content(); ?>
</section>

<?php endwhile; ?>

<section id="staff">
  <h2>Staff</h2>    
  <?= \Firebelly\PostTypes\Person\get_people(); ?>
</section>

<section id="partners">
  <h2>Staff</h2>    
  <?= \Firebelly\PostTypes\Partners\get_partners(); ?>
</section>