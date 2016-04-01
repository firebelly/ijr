<?php

namespace Firebelly\Utils;

/**
 * Get Page Blocks
 */
function get_page_blocks($post) {
  $output = '';
  $page_blocks = get_post_meta($post->ID, '_cmb2_page_blocks', true);
  if ($page_blocks) {
    foreach ($page_blocks as $page_block) {
      if (empty($page_block['hide_block'])) {
        $block_title = $block_body = '';
        if (!empty($page_block['title']))
          $block_title = $page_block['title'];
        if (!empty($page_block['body'])) {
          $block_body = apply_filters('the_content', $page_block['body']);
          $output .= '<section class="content-block"><div class="content">';
          if ($block_title) {
            $output .= '<h1 class="title">' . $block_title . '</h1>';
          }
          $output .= '<div class="user-content">' . $block_body . '</div>';
          $output .= '</div></section>';
        }
      }
    }
  }
  return $output;
}

/**
 * Take array of links and a buffer 
 * (number of links on each side of current page to show in list) 
 * return the list appropriate modified
 * ('' if only 1 page)
 */
function filter_pagination($links,$current,$buffer) {
  $n_display = $buffer * 2 + 1;
    $n_links = count($links);
    $display = array('');
    if($n_links == 1) { return ''; }
    if($n_links <= $n_display) { return $links; }
    if( ($current-1)-$buffer < 0 ) {
      return array_slice( $links, 0, $n_display );
    }
    if( ($current-1)+$buffer > ($n_links-1) ) {
      return array_slice( $links, ($n_links)-$n_display, $n_display );
    }
    return array_slice( $links, ($current-1)-$buffer, $n_display );
}



/**
 * Bump up # search results
 */
function search_queries( $query ) {
  if ( !is_admin() && is_search() ) {
    $query->set( 'posts_per_page', 40 );
  }
  return $query;
}
add_filter( 'pre_get_posts', __NAMESPACE__ . '\\search_queries' );

/**
 * Remove pages from search
 */
function remove_pages_from_search() {
    global $wp_post_types;
    $wp_post_types['page']->exclude_from_search = true;
}
add_action('init', __NAMESPACE__ . '\\remove_pages_from_search');

/**
 * Custom li'l excerpt function
 */
function get_excerpt( $post, $length=15, $force_content=false ) {
  $excerpt = trim($post->post_excerpt);
  if (!$excerpt || $force_content) {
    $excerpt = $post->post_content;
    $excerpt = strip_shortcodes( $excerpt );
    $excerpt = apply_filters( 'the_content', $excerpt );
    $excerpt = str_replace( ']]>', ']]&gt;', $excerpt );
    $excerpt_length = apply_filters( 'excerpt_length', $length );
    $excerpt = wp_trim_words( $excerpt, $excerpt_length );
  }
  return $excerpt;
}

/**
 * Send a string to javascript console (for debugging)
 */
function console( $string ) {
  echo "<script>console.log('".$string."');</script>";
}


/**
 * Get li's of post tags
 */
function get_tags( $post ) {
  $output = '';
  $tags=get_the_tags($post->ID);
  if ( has_tag(null,$post) ) {
    $tags=get_the_tags($post->ID);
   
    $tag_list = array();
    foreach ($tags as $tag) {
      $tag_link = get_tag_link( $tag->term_id );
      $tag_name = $tag->name;
      $taglist[] = '<a href="'.$tag_link.'">'.$tag_name.'</a>';
    }
    $output .= '<ul class="tags"><li>';
    $output .= implode(", </li><li>",$taglist);
    $output .= '</li></ul>';
    return $output;
  } else {
    return false;
  }
  
}

/**
 * Get top ancestor for post
 */
function get_top_ancestor($post){
  if (!$post) return;
  $ancestors = $post->ancestors;
  if ($ancestors) {
    return end($ancestors);
  } else {
    return $post->ID;
  }
}

/**
 * Get first term for post
 */
function get_first_term($post, $taxonomy='category') {
  $return = false;
  if ($terms = get_the_terms($post->ID, $taxonomy))
    $return = array_pop($terms);
  return $return;
}

/**
 * Get page content from slug
 */
function get_page_content($slug) {
  $return = false;
  if ($page = get_page_by_path($slug))
    $return = apply_filters('the_content', $page->post_content);
  return $return;
}

/**
 * Get category for post
 */
function get_category($post) {
  if ($category = get_the_category($post)) {
    return $category[0];
  } else return false;
}

/**
 * Get num_pages for category given slug + per_page
 */
function get_total_pages($category, $per_page) {
  $cat_info = get_category_by_slug($category);
  $num_pages = ceil($cat_info->count / $per_page);
  return $num_pages;
}

