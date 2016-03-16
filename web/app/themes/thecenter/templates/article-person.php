<?php 
$photo = get_the_post_thumbnail($post->ID, 'medium');
$subtitle = get_post_meta( $post->ID, '_cmb2_subtitle', true );
$body = apply_filters('the_content', $post->post_content);
?>
<article data-url="<?= get_permalink($post) ?>" id="<?= $post->post_name ?>">
  <?= $photo ?>
  <hgroup>
    <h1><?= $post->post_title ?></h1>
    <?= !empty($subtitle) ? '<h2>'.$subtitle.'</h2>' : ''; ?>
  </hgroup>
  <div class="bio user-content">
    <?= $body ?>
  </div>
</article>
