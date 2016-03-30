<?php 
$thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium')[0];
$duo_url = \Firebelly\Media\get_duo_url($thumb_url, '', [
    'color1' => '2f2d28',
    'color2' => 'dddcd6',
  ]);
$link = get_post_meta( $post->ID, '_cmb2_link', true );
?>

<a href="<?= $link ?>" target="_blank"><img src="<?= $duo_url ?>"></a>

