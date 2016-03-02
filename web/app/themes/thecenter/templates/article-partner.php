<?php 
$image = get_the_post_thumbnail($post->ID, 'medium');
$link = get_post_meta( $post->ID, '_cmb2_link', true );
?>

<a href="<?= $link ?>"><?= $image ?></a>

