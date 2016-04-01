<?php 
$category = get_the_category()[0];
?>
<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?> role="article">
    <header class="page-header">
      <a href="<?= get_term_link($category); ?>" class="category"><?= $category->name; ?></a>
      <h1 class="entry-title headline-title"><span class="gradient-highlight"><?php the_title(); ?></span></h1>
    </header>
    <div class="post-content">
      <?php 
      $time_class='time-big';
      include(locate_template('templates/post-time.php')); 
      ?>
      <div class='arrows'>
        <?php previous_post_link( '%link', '<svg class="prev-post icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>' ); ?>
        <?php next_post_link( '%link', '<svg class="next-post icon-arrow-left" role="img"><use xlink:href="#icon-arrow-left"></use></svg>' ); ?>
      </div>
      <div class="entry-content user-content">
        <?php the_content(); ?>
      </div>
     
    </div>
  </article>
<?php endwhile; ?>
