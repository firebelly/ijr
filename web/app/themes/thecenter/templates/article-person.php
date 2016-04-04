<?php 

$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), array(372,246))[0];
$duo_url = \Firebelly\Media\get_duo_url($thumb_url, '', [
    'color1' => '2f2d28',
    'color2' => 'dddcd6',
  ]);
$photo_duo = '<img src="'.$duo_url.'" class="wp-post-image">';

$photo_color = get_the_post_thumbnail($post->ID, array(372,246));
$name = $post->post_title;
$title = get_post_meta( $post->ID, '_cmb2_title', true );
$show_title =  get_post_meta( $post->ID, '_cmb2_show_title', true )=='on';
$body = apply_filters('the_content', $post->post_content);
$person_num = isset($i) ? "data-person-num=\"{$i}\"" : '';
?>
<div data-url="<?= get_permalink($post) ?>" id="<?= $post->post_name ?>" class="person" <?= $person_num ?>>
  <?= $photo_duo ?>
  <div class="read-bio open-person">
    <a class="open-person">Read Bio</a>
  </div>
  <hgroup class="titles">
    <h1><?= $name ?></h1>
    <?= !empty($title) && $show_title ? '<h2>'.$title.'</h2>' : ''; ?>
  </hgroup>  
  <div class="mask close-people"></div>
  <div class="modal">
    <div class="viewport">
      <svg class="icon-x close-people" role="img"><use xlink:href="#icon-x"></use></svg>
      <svg class="icon-arrow-right next-person" role="img"><use xlink:href="#icon-arrow-right"></use></svg>
      <div class="content-wrapper">
        <svg class="icon-x close-people" role="img"><use xlink:href="#icon-x"></use></svg>
        <hgroup class="modal-titles">
          <h1><?= $name ?></h1>
          <?= !empty($title) ? '<h2>'.$title.'</h2>' : ''; ?>
        </hgroup>  
        <div class="bio user-content">
          <?= $body ?>
        </div>
        <svg class="icon-arrow-left prev-person" role="img"><use xlink:href="#icon-arrow-left"></use></svg>
        <svg class="icon-arrow-right next-person" role="img"><use xlink:href="#icon-arrow-right"></use></svg>
        
      </div>
    </div>
      <?= $photo_duo ?>
  </div>
</article>
