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
    <?= \Firebelly\PostTypes\Headline\get_headlines(); ?>
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
        ?><div class="slide-item"><?php
        include(locate_template('templates/post-list.php'));
        ?></div><?php
      }
    endif;
    ?>
  </div>
  <a href="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>">View All News</a>
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
        ?><div class="slide-item"><?php
        include(locate_template('templates/post-list.php'));
        ?></div><?php
      }
    endif;
    ?>
  </div>
  <a href="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>">View All</a>
</section>