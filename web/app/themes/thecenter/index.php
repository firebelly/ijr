<?php get_template_part('templates/page', 'header'); ?>

<?php get_search_form(); ?>
<label for="sort">Sort:</label>
<select id="sort">
	<option data-href="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>" selected>All Posts</option>
	<?php 
	$tags = get_tags();
	foreach ($tags as $tag) {
	  $tag_link = get_tag_link( $tag->term_id );
	  $tag_name = $tag->name;
	  echo'<option data-href="'.$tag_link.'">'.$tag_name.'</option>';
	}
	?>
</select>

<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
  <?php get_search_form(); ?>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
    <?php include(locate_template('templates/post-list.php')); ?>
<?php endwhile; ?>

<?php the_posts_navigation(); ?>
