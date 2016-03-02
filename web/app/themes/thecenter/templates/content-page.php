<?php
$subtitle = get_post_meta( $post->ID, '_cmb2_subtitle', true );
echo !empty($subtitle) ? '<h2>'.$subtitle.'</h2>' : '';
?>
<?php the_content(); ?>
<?php wp_link_pages(['before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']); ?>
