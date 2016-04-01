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
<div class="pagination">
	<?php 
	$args = [
		'prev_text' => '<svg class="prev-page icon-arrow-right" role="img"><use xlink:href="#icon-arrow-right"></use></svg>',
		'next_text' => '<svg class="next-page icon-arrow-left" role="img"><use xlink:href="#icon-arrow-left"></use></svg>'
	];
	the_posts_navigation($args); 
	?>

	<div class="pagination-numbers">
		<?php 
		$big = 999999999; // need an unlikely integer
		$current = max( 1, get_query_var('paged') );
		$args = array(
			// 'base'               => '%_%',
			// 'format'             => '?paged=%#%',
			// 'total'              => 1,
			// 'current'            => 0,
			'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format' => '?paged=%#%',
			'current' => $current,
			'total' => $wp_query->max_num_pages,
			'show_all'           => true,
			// 'end_size'           => 0,
			// 'mid_size'           => 2,
			'prev_next'          => false,
			'type'               => 'array',
			'add_args'           => false,
			'add_fragment'       => '',
			'before_page_number' => '',
			'after_page_number'  => ''
		); 
		// echo paginate_links( $args );
		$links = paginate_links( $args );
		$buffer = 2;
		$filtered_links = Firebelly\Utils\filter_pagination($links,$current,$buffer);
		echo implode($filtered_links);
	

		?>
	</div>
</div>
