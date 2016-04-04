<?php 
use Roots\Sage\Titles; 
?>

<header class="page-header">
  <h1 class="headline-title"><span class="gradient-highlight"><?= Titles\title(); ?></span></h1>
  <?php get_search_form(); ?>

  <div class="nav-forms">
    <div class="search-toggle-wrap">
    <a class="search-toggle">Search</a>
    <form class="sort">
      <label for="sort-select">Sort:</label>
      <div class="select-wrap">
        <select id="sort-select">
          <option value="<?= get_permalink( get_option( 'page_for_posts' ) ) ?>">All Posts</option>
          <?php 
          $tags = get_tags();
          foreach ($tags as $tag) {
            $tag_link = get_tag_link( $tag->term_id );
            $tag_name = $tag->name;
            $selected = is_tag( $tag->term_id ) ? ' selected' : '';
            echo'<option value="'.$tag_link.'"'.$selected.'>'.$tag_name.'</option>';
          }
          $cats = get_categories();
          foreach ($cats as $cat) {
            $cat_link = get_category_link( $cat->cat_ID );
            $cat_name = $cat->name;
            $selected = is_category( $cat->cat_ID ) ? ' selected' : '';
            echo'<option value="'.$cat_link.'"'.$selected.'>'.$cat_name.'</option>';
          }
          ?>
        </select>
        <div class="darr">&darr;</div>
      </div>
    </form>
  </div>
</header>
