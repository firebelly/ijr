<?php 
use Roots\Sage\Titles; 
$thumb_url = $post ? wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'headline-thumb')[0] : '';
$duo_url = \Firebelly\Media\get_duo_url($post, [ 'size' => 'headline-thumb' ]);
$recess = $post ? get_post_meta($post->ID, '_cmb2_recess', true)=='on' : '';
?>

<div class="page-header" style="background-image: url('<?= $duo_url ? $duo_url : ''; ?>');">
  <div class="bg-dots"></div>
  <h1 class="headline-title"><span class="gradient-highlight"><?= Titles\title(); ?></span></h1>
</div>


