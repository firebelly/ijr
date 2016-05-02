<?php
/**
 * Template Name: Homepage
 */
?>

<?= \Firebelly\PostTypes\Headline\get_headlines(); ?>

<section class="news">
    <?php
    // news posts
    $posts = get_posts(
      array(
        'numberposts' => 5,
        'category_name' => 'news',
      )
    );
    if ($posts):
      include(locate_template('templates/post-sliders.php'));
    endif;
    ?>
  <a class="all" href="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>">View All</a>
</section>

<section class="radar">
    <?php
    // radar posts
    $posts = get_posts(
      array(
        'numberposts' => 5,
        'category_name' => 'radar',
      )
    );
    if ($posts):
      include(locate_template('templates/post-sliders.php'));
    endif;
    ?>
  <a class="all" href="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>">View All</a>
</section>