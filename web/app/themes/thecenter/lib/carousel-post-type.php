<?php
/**
 * Carousel post type
 */

namespace Firebelly\PostTypes\Carousel;

// Custom image size for post type?
add_image_size( 'carousel-preview-thumb', 200, null, null );
add_image_size( 'carousel-thumb', 500, null, null );

// Register Custom Post Type
function post_type() {

  $labels = array(
    'name'                => 'Carousels',
    'singular_name'       => 'Carousel',
    'menu_name'           => 'Carousels',
    'parent_item_colon'   => '',
    'all_items'           => 'All Carousels',
    'view_item'           => 'View Carousel',
    'add_new_item'        => 'Add New Carousel',
    'add_new'             => 'Add New',
    'edit_item'           => 'Edit Carousel',
    'update_item'         => 'Update Carousel',
    'search_items'        => 'Search Carousels',
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
    'label'               => 'carousel',
    'description'         => 'Carousels',
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
    'exclude_from_search' => false,
    'publicly_queryable'  => true,
    'rewrite'             => $rewrite,
    'capability_type'     => 'page',
  );
  register_post_type( 'carousel', $args );

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
    '_cmb2_order_num' => 'Order #'
  );
  return $columns;
}
add_filter('manage_carousel_posts_columns', __NAMESPACE__ . '\edit_columns');

function custom_columns($column){
  global $post;
  if ( $post->post_type == 'carousel' ) {
    $custom = get_post_custom();
    if ( $column == 'featured_image' )
      echo the_post_thumbnail( 'carousel-preview-thumb' );
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

  $meta_boxes['carousel_metabox'] = array(
    'id'            => 'carousel_metabox',
    'title'         => __( 'Extra Fields', 'cmb2' ),
    'object_types'  => array( 'carousel', ), // Post type
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
    	array(
	    'name'    => 'Order #',
    	    'desc'    => '1 is the first carousel, 2 is second and so forth',
	    'default' => '1',
	    'id'      => $prefix . 'order_num',
	    'type'    => 'text_small'
  		), 
    ),
  );

  return $meta_boxes;
}
add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

// Get Carousel
function get_carousels() {
  $output = '';

  $args = array(
    'numberposts' => -1,
    'post_type' => 'carousel',
    'orderby' => 'meta_value_num',
    'meta_key' => '_cmb2_order_num',
    'order'     => 'ASC',
    );

  $carousel_posts = get_posts($args);
  if (!$carousel_posts) return false;

  foreach ($carousel_posts as $post):
    $thumb = get_the_post_thumbnail($post->ID, 'carousel-thumb');
    $link_text = get_post_meta( $post->ID, '_cmb2_link_text', true );
    $links_to = get_permalink(get_post_meta( $post->ID, '_cmb2_links_to', true ));

    $output .= <<<HTML
     	<div class="slide-item">
       		<div class="slider-content">
	     		{$thumb}
	   			<h2>{$post->post_title}</h2>
	   			<a href="{$links_to}">{$link_text}</a>
		    </div>
		</div>
HTML;
  endforeach;
 
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