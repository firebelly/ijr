<?php
	$recess = get_post_meta($post->ID, '_cmb2_recess', true)=='on';
	$subtitle = get_post_meta( $post->ID, '_cmb2_subtitle', true );
?>

<section class="content-block <?= $recess ? 'recess' : '' ?>">
	<div class="content">
		<?= !empty($subtitle) ? '<h1 class="title">'.$subtitle.'</h1>' : ''; ?>
		<div class="user-content">
			<?php the_content(); ?>
		</div>
	</div>
</section>

<?= Firebelly\Utils\get_page_blocks($post); ?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
