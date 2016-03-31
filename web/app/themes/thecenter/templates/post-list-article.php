<?php
use Firebelly\Utils; 
$category = Utils\get_category( $post );
$tags = Utils\get_tags( $post ); 
$excerpt = Utils\get_excerpt($post, 30);
$type = get_post_type_object(get_post_type($post))->labels->singular_name;
?>
<article class="post-list-article">
	<?php if ($category) : ?>
		<a class="category" href="<?= get_term_link($category); ?>"><?= $category->name; ?></a>
	<?php else : ?>
		<a class="category" href="<?= get_the_permalink($post); ?>"><?= $type ?></a>
	<?php endif; ?>
	<?php 
	$time_class='time-small';
	include(locate_template('templates/post-time.php')); 
	?>
    <h1 class="title"><a href="<?= get_the_permalink($post); ?>"><?php echo $post->post_title; ?></a></h1>
    <div class="excerpt user-content">
      	<p><a href="<?= get_the_permalink($post) ?>" class="read-more"><?= $excerpt ?></a></p>
    </div>
    <?= $tags ? $tags : '' ?>
</article>
