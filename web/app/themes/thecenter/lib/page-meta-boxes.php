<?php
/**
 * Extra fields for Pages
 */

namespace Firebelly\PostTypes\Pages;

 // Custom CMB2 fields for post type
 function metaboxes( array $meta_boxes ) {
   $prefix = '_cmb2_'; // Start with underscore to hide from custom fields list

   $meta_boxes['page_subtitle'] = array(
     'id'            => 'page_subtitle',
     'title'         => __( 'Subtitle', 'cmb2' ),
     'object_types'  => array( 'page', ), // Post type
     'context'       => 'normal',
     'priority'      => 'core',
     'show_names'    => true, // Show field names on the left
     'pages' => '',
     'fields'        => array(
    
       // General page fields
       array(
         'name' => 'Subtitle',
         'id'   => $prefix . 'subtitle',
         'type' => 'text',
       ),
       // array(
       //   'name' => 'Secondary Content',
       //   'desc' => 'Used on several pages for secondary content areas',
       //   'id'   => $prefix . 'secondary_content',
       //   'type' => 'wysiwyg',
       // ),
     ),
   );

  $meta_boxes['page_recess'] = array(
    'id'            => 'page_recess',
    'title'         => __( 'Additional Options', 'cmb2' ),
    'object_types'  => array( 'page', ), // Post type
    'context'       => 'side',
    'priority'      => 'default',
    'show_names'    => false,
    'fields'        => array(
      array(
          'name'     => 'yes',
          'id'       => $prefix . 'recess',
          'type'     => 'checkbox',
          'desc'     => 'Recess primary content block',
      ),
    ),
  );

/**
   * Repeating blocks
   */
  $cmb_group = new_cmb2_box( array(
      'id'           => $prefix . 'metabox',
      'title'        => __( 'Extra Blocks', 'cmb2' ),
      'priority'      => 'low',
      'object_types' => array( 'page', ),
    ) 
  );

  $group_field_id = $cmb_group->add_field( array(
      'id'          => $prefix . 'page_blocks',
      'type'        => 'group',
      'description' => __( "Note: <br>You must be in Text mode to add or reorder the Extra Blocks.  <br>If there is only one block and you would like remove it from the page, just erase the Block Title and Body fields.", 'cmb' ),
      'options'     => array(
          'group_title'   => __( 'Block {#}', 'cmb' ),
          'add_button'    => __( 'Add Another Block', 'cmb' ),
          'remove_button' => __( 'Remove Block', 'cmb' ),
          'sortable'      => true, // beta
      ),
  ) );

  $cmb_group->add_group_field( $group_field_id, array(
      'name' => 'Block Title',
      'id'   => 'title',
      'type' => 'text',
  ) );

  $cmb_group->add_group_field( $group_field_id, array(
      'name' => 'Body',
      'id'   => 'body',
      'type' => 'wysiwyg',
  ) );

  $cmb_group->add_group_field( $group_field_id, array(
      'name' => 'Hide Block',
      // 'desc' => 'Check this to hide Page Block from the front end',
      'id'   => 'hide_block',
      'type' => 'checkbox',
  ) );




   return $meta_boxes;
 }
 add_filter( 'cmb2_meta_boxes', __NAMESPACE__ . '\metaboxes' );

