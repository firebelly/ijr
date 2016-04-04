  <div class="pagination-numbers">
    <?php 
    $big = 999999999; // need an unlikely integer
    $current = max( 1, get_query_var('paged') );
    $args = array(
      // 'base'               => '%_%',
      // 'format'             => '?paged=%#%',
      // 'total'              => 1,
      // 'current'            => 0,
      'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
      'format' => '?paged=%#%',
      'current' => $current,
      'total' => $wp_query->max_num_pages,
      'show_all'           => true,
      // 'end_size'           => 0,
      // 'mid_size'           => 2,
      'prev_next'          => false,
      'type'               => 'array',
      'add_args'           => false,
      'add_fragment'       => '',
      'before_page_number' => '',
      'after_page_number'  => ''
    ); 
    // echo paginate_links( $args );
    $links = paginate_links( $args );
    $buffer = 2;
    $filtered_links = Firebelly\Utils\filter_pagination($links,$current,$buffer);
    if ($filtered_links) {
      echo implode($filtered_links);
    }
  

    ?>
  </div>