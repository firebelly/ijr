<?php
/**
 * Template Name: Homepage
 */
?>

<?php 
// Main page data
// echo $post->post_title;
// echo apply_filters('the_content', $post->post_content);
?>

<!-- main carousel -->
<section>
  <div class="slider home-slider">
    <?php 
    // Carousels
    echo do_shortcode('[carousel]');
    ?>
  </div>
</section>

<!-- news list -->
<section>
  <div class="slider">
    <?php 
    // news posts
    $news_posts = get_posts(
      array(
        'numberposts' => 5,
        'category_name' => 'news',
      )
    );
    if ($news_posts):
      foreach ($news_posts as $post) {
        include(locate_template('templates/post-slider.php'));
      }
    endif;
    ?>
  </div>
  <a href="/blog/">View All News</a>
</section>

<!-- radar list -->
<section>
  <div class="slider">
    <?php 
    // radar posts
    $radar_posts = get_posts(
      array(
        'numberposts' => 5,
        'category_name' => 'radar',
      )
    );
    if ($radar_posts):
      foreach ($radar_posts as $post) {
        include(locate_template('templates/post-slider.php'));
      }
    endif;
    ?>
  </div>
  <a href="/blog/">View All</a>
</section>