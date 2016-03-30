<?php get_template_part('templates/archive', 'header'); ?>


<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
	<div class="post-list">
		<?php if ($post->post_type=='post') : ?>
			<?php include(locate_template('templates/post-time.php')); ?>
		<?php endif ?>
	    <?php include(locate_template('templates/post-list-article.php')); ?>
	</div>
<?php endwhile; ?>

<?php the_posts_navigation(); ?>
