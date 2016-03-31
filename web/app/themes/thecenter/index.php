<?php get_template_part('templates/archive', 'header'); ?>


<?php if (!have_posts()) : ?>
  <div class="alert alert-warning">
    <?php _e('Sorry, no results were found.', 'sage'); ?>
  </div>
<?php endif; ?>

<?php while (have_posts()) : the_post(); ?>
	<div class="post-list">
		<?php if ($post->post_type=='post') : ?>
			<?php 
			$time_class='time-big';
			include(locate_template('templates/post-time.php')); 
			?>
		<?php endif ?>
	    <?php include(locate_template('templates/post-list-article.php')); ?>
	</div>
<?php endwhile; ?>
<!-- <div class="pagination">
	<?php 
	$args = [
		'prev_text' => '<svg class="prev-page icon-arrow-left" role="img"><use xlink:href="#icon-arrow-left"></use></svg>',
		'next_text' => '<svg class="next-page icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>'
	];
	the_posts_navigation($args); 
	?>
</div> -->
