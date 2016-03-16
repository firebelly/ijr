<?php while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?> role="article">
    <header>
      <?php $category = get_the_category()[0];?>
      <a href="<?= get_term_link($category); ?>"><?= $category->name; ?></a>
      <h1 class="entry-title"><?php the_title(); ?></h1>
      <?php get_template_part('templates/entry-meta'); ?>
    </header>
    <div class="entry-content user-content">
      <?php the_content(); ?>
    </div>
    <footer>
      <?php previous_post_link( '%link', 'Previous' ); ?>
      <?php next_post_link( '%link', 'Next' ); ?>
      <?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
    </footer>
  </article>
<?php endwhile; ?>
