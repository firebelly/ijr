<?php
  $time_class = isset($time_class) ? $time_class : '';
?>

<time class="<?= $time_class ?>" datetime="<?php echo date('c', strtotime($post->post_date)); ?>">
  <div class="month"><?php echo date('F', strtotime($post->post_date)); ?></div>
  <div class="day"><?php echo date('d', strtotime($post->post_date)); ?></div>
</time>