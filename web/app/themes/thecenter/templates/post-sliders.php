<?php
use Firebelly\Utils; 
?>

<div class="slider post-slider">
	<div class="bg-dots"></div>
	  	<?php
  	//time fg divs
  	$i = 0;
  	foreach ($posts as $post):
    	?>
    	<div class="slide-fg" data-slick-index="<?= $i ?>">
			<?php 
			$time_class='time-big';
			include(locate_template('templates/post-time.php')); 
			?>
		</div>
		<?php
    	$i++;
  	endforeach;
  	//article bg divs
  	foreach ($posts as $post): ?>
	    <div class="slide-item slide-bg">
	    	<?php include(locate_template('templates/post-list-article.php')) ?>
		</div>
	<?php endforeach;?>
</div>

 