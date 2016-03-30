<?php
/**
 * Headline post type
 */

namespace Firebelly\PostTypes\Headline;

// Custom image size for post type?
add_image_size( 'headline-thumb', 1800, null, null );

// Register Custom Post Type
function post_type() {

  $labels = array(
    'name'                => 'Headlines',
    'singular_name'       => 'Headline',
    'menu_name'           => 'Headlines',
    'parent_item_colon'   => '',
    'all_items'           => 'All Headlines',
    'view_item'           => 'View Headline',
    'add_new_item'        => 'Add New Headline',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Headline',
    'update_item'         => 'Update Headline',
    'search_items'        => 'Search Headlines',
    'not_found'           => 'Not found',
    'not_found_in_trash'  => 'Not found in Trash',
  );
  $rewrite = array(
    'slug'                => '',
    'with_front'          => false,
    'pages'               => false,
    'feeds'               => false,
  );
  $args = array(
    'label'               => 'headline',
    'description'         => 'Headlines',
    'labels'              => $labels,
    'supports'            => array( 'title','thumbnail'), //took out editor
    'hierarchical'        => false,
    'public'              => true,
    'show_ui'             => true,
    'show_in_menu'        => true,
    'show_in_nav_menus'   => true,
    'show_in_admin_bar'   => true,
    'menu_position'       => 20,
    'menu_icon'           => 'dashicons-admin-post',
    'can_export'          => false,
    'has_archive'         => false,
    'exclude_from_search' => true,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
    'capability_type'     => 'page',
  );
  register_post_type( 'headline', $args );

}
add_action( 'init', __NAMESPACE__ . '\post_type', 0 );

// Custom admin columns for post type
function edit_columns($columns){
  $columns = array(
    'cb' => '<input type="checkbox" />',
    'title' => 'Title',
    'featured_image' => 'Image',
    '_cmb2_link_text' => 'Link Text',
    '_cmb2_links_to' => 'Links To',
  );
  return $columns;
}
add_filter('manage_headline_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'headline' ) {
    $custom = get_post_custom();
    if ( $column == 'featured_image' )
      echo the_post_thumbnail( 'thumbnail' );
    elseif ( $column == '_cmb2_links_to' ) {
      if ($pages = get_pages(array('include' => $custom[$column][0]))) {
        foreach($pages as $page) {
          $pages_on[] = $page->post_title;
        }
        echo implode(',', $pages_on);
      }
    }
    elseif ( $column == 'content' )
      echo the_content();
    elseif ( $column == '_cmb2_link_text' || $column == '_cmb2_order_num' )
      echo $custom[$column][0];
  }
}
add_action('manage_posts_custom_column',  __NAMESPACE__ . '\custom_columns');

// Custom CMB2 fields for post type
function metaboxes( array $meta_boxes ) {
  $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

  $meta_boxes['headline_metabox'] = array(
    'id'            => 'headline_metabox',
    'title'         => __( 'Extra Fields', 'cmb2' ),
    'object_types'  => array( 'headline', ), // Post type
    'context'       => 'normal',
    'priority'      => 'high',
    'show_names'    => true, // Show field names on the left
    'fields'        => array(
    	array(
    	    'name'    => 'Link text',
    	    'id'      => $prefix . 'link_text',
    	    'type'    => 'text',
  		'default' => 'Learn More'
    	),
    	array(
    	    'name'    => 'Links to',
    	    'id'      => $prefix . 'links_to',
    	    'type'    => 'select',
    	    'options' => cmb2_get_post_options( array( 'post_type' => 'page', 'numberposts' => -1, 'post_parent' => 0	 ) ),
    	),
    // 	array(
	   //  'name'    => 'Order #',
    // 	    'desc'    => '1 is the first headline, 2 is second and so forth',
	   //  'default' => '1',
	   //  'id'      => $prefix . 'order_num',
	   //  'type'    => 'text_small'
  		// ), 
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

// Get Headlines
function get_headlines() {
  $output = '';
  $output .= <<<HTML
    <section class="headline-banner">
      <div class="slider headline-slider">
        
HTML;

  $args = array(
    'numberposts' => -1,
    'post_type' => 'headline',
    // 'orderby' => 'meta_value_num',
    // 'meta_key' => '_cmb2_order_num',
    // 'order'     => 'ASC',
    );

  $headline_posts = get_posts($args);
  if (!$headline_posts) return false;

  //bg divs
  foreach ($headline_posts as $post):
    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'headline-thumb')[0];
    $duo_url = \Firebelly\Media\get_duo_url($thumb_url, '', [
        'color1' => '2f2d28',
        'color2' => 'dddcd6',
      ]);
    $output .= <<<HTML
    <div class="slide-item slide-bg" style="background-image: url('{$thumb_url}')">
      <div class="headline-duo" style="background-image: url('{$duo_url}')"> </div>
    </div>
HTML;
  endforeach;

  //add the goddamn dots :)
  $output .= '<div class="dots"></div>';

  $output .= '<div class="overflow-wrapper">';

  //article divs
  $i = 0;
  foreach ($headline_posts as $post):
    $link_text = get_post_meta( $post->ID, '_cmb2_link_text', true );
    $links_to = get_permalink(get_post_meta( $post->ID, '_cmb2_links_to', true ));
    $output .= <<<HTML
      <article class="slide-fg headline-article" data-slick-index="{$i}" data-links-to="{$links_to}">
        <h1 class="headline-title"><span class="gradient-highlight">{$post->post_title}</span></h1>
        <a class="learn-more">{$link_text}</a>
      </article>
HTML;
    $i++;
  endforeach;

  $output .= <<<HTML
        </div>
      </div>
</section>
HTML;
 
  return $output;
}

function cmb2_get_post_options( $query_args ) {

    $args = wp_parse_args( $query_args, array(
        'post_type'   => 'post',
        'numberposts' => 10,
        'post_parent' => 0,
    ) );

    $posts = get_posts( $args );

    $post_options = array();
    if ( $posts ) {
        foreach ( $posts as $post ) {
          $post_options[ $post->ID ] = $post->post_title;
        }
    }

    return $post_options;
}