<?php 
$photo = get_the_post_thumbnail($post->ID, 'medium');
$subtitle = get_post_meta( $post->ID, '_cmb2_subtitle', true );
$body = apply_filters('the_content', $post->post_content);
?>
<article data-url="<?= get_permalink($post) ?>" id="<?= $post->post_name ?>">
  <button class="person-activate person-toggle x-button -plus"><div class="x"></div></button>
  <div class="person-data person-activate person-toggle" id="<?= $post->post_name ?>">
    <div class="thumb-wrap">
      <div class="thumb"><?= $photo ?></div>
    <div class="person-info">
      <div class="person-title">
        <h3 class="person-activate person-toggle">
          <?= $post->post_title ?>
          <?= !empty($subtitle) ? '<span class="sub-title">'.$subtitle.'</span>' : ''; ?>
        </h3>
      </div>
      <div class="bio">
        <div class="info-content user-content">
          <?= $body ?>
        </div>
      </div>
    </div>
  </div>
</article>
