<?php
	$recess = get_post_meta($post->ID, '_cmb2_recess', true);
?>

<section class="page_block <?= $recess=='on' ? 'recess' : '' ?>">
	<?php
	$subtitle = get_post_meta( $post->ID, '_cmb2_subtitle', true );
	echo !empty($subtitle) ? '<h1>'.$subtitle.'</h1>' : '';
	?>
	<div class="user-content">
		<?php the_content(); ?>
	</div>
</section>
<?= Firebelly\Utils\get_page_blocks($post); ?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
