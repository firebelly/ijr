<?php
use Firebelly\Utils;
$category = Utils\get_category( $post );
$tags = Utils\get_tag_list( $post ); 
?>
<article class="article slider-content">
	<div class="article-meta">
	    <time datetime="<?php echo date('c', strtotime($post->post_date)); ?>"><?php echo date('F d', strtotime($post->post_date)); ?></time>
	    <?php if ($category): ?>
	    	<div class="article-category">
	    		<a href="<?= get_term_link($category); ?>"><?= $category->name; ?></a>
	    	</div>
	    <?php endif; ?>
   </div>
  	<div class="article-content">
	    <header class="article-header">
	      	<h1 class="article-title"><a href="<?= get_the_permalink($post); ?>"><?php echo $post->post_title; ?></a></h1>
	    </header>
	    <div class="article-excerpt user-content">
	      	<p><a href="<?= get_the_permalink($post) ?>" class="read-more"><?php echo Utils\get_excerpt($post); ?></a></p>
	    </div>
	    <?php if($tags) : ?>
	    	<ul class="article-tags">
	    		<?= $tags ?>
	    	</ul>
	    <?php endif ?>
  	</div>
</article>