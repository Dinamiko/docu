<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* If doc post type remove default next/prev links in single.php template
*/
function docu_remove_default_prevnext_links() {

  global $post;
  
  if( $post && $post->post_type == 'doc' && is_singular( 'doc' ) && is_main_query() ) {

    switch ( current_filter() ) {

      case 'previous_post_link':
        return ''; 
        break;
       
      case 'next_post_link':
        return ''; 
        break;

    }

  } 

}

/**
* Single doc content filter
*/
function single_doc_filter_content( $content ) {

  global $post;
  
  if( $post && $post->post_type == 'doc' && is_singular( 'doc' ) && is_main_query() ) {

    // remove default next/prev links of single.php template
    add_filter( 'next_post_link' , 'docu_remove_default_prevnext_links' );
    add_filter( 'previous_post_link' , 'docu_remove_default_prevnext_links' );

    ob_start();
    do_action( 'docu_after_doc_content' );
    $content .= ob_get_clean();

  }

  return $content;

}

add_filter('the_content', 'single_doc_filter_content');

/**
* load docu-prevnext-nav.php template
*/
function docu_prevnext_nav() {

  $template = new DOCU_Template_Loader;
  $template->get_template_part( 'docu-prevnext-nav' );

}

add_action( 'docu_after_doc_content', 'docu_prevnext_nav' );


/**
* Returns an array with prev/next ids, based on doc post id
* @param int $id post id
* @param string $taxonomy taxonomy slug
* @return array $link_ids $link_ids[0] = prev id | $link_ids[1] = next id 
*/
function docu_get_prevnext_links( $id, $taxonomy = 'doc_category' ) {

  global $post;
  $terms = get_the_terms( $id, $taxonomy );

  foreach ($terms as $term) {
    $term_id = $term->term_id;
    $term_slug = $term->slug;
  }

  $args = array(
    'post_type' => 'doc',
    'post_status' => 'publish',
    'tax_query' => array(
      array(
        'taxonomy' => 'doc_category',
        'field' => 'id',
        'terms' => array( $term_id )
      ),
    ),
    'orderby' => 'menu_order', 
    'order' => 'ASC'
  );
            
  $the_query = new WP_Query( $args );
  $ids = array();
            
  if ( $the_query->have_posts() ) {
            
    while ( $the_query->have_posts() ) {
      $the_query->the_post();
      $ids[] = $post->ID;     
    }
            
  } 

  wp_reset_postdata();

  $index = array_search( $post->ID, $ids );
  $link_ids = array();

  $previd = 0;
  $nextid = 0;

  if ( $index > 0 ) {
    $prev = $index - 1;
    $previd = $ids[ $prev ];
  }

  if ( $index < count( $ids ) - 1 ) {
    $next = $index + 1;
    $nextid = $ids[ $next ];
  }

  array_push($link_ids, $previd, $nextid );

  return $link_ids;

} 

/**
* output a list of all doc categories
* do_action('docu_after_term_description', $term);
*/
function custom_docu_after_term_description( $term ) {

  $term_id = $term->term_id;

  $args = array(
    'post_type' => 'doc',
    'post_status' => 'publish',
    'tax_query' => array(
      array(
        'taxonomy' => 'doc_category',
        'field'    => 'id',
        'terms'    => array( $term_id )
      )
    ),
    'orderby' => 'menu_order',
    'order' => 'asc'
  );

  $the_query = new WP_Query( $args );

  if ( $the_query->have_posts() ) { ?>

  <ul class="docu-nav-list">
      <?php while ( $the_query->have_posts() ) {
          $the_query->the_post(); ?>

      <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>

      <?php } ?>
  </ul>
  
  <?php } 

  wp_reset_postdata();

}

add_action( 'docu_after_term_description', 'custom_docu_after_term_description', 10, 1 );

/**
* Modifies the search query if get_query_var('post_type') is equal to doc
* <input type="hidden" name="post_type" value="doc" /> in docu-search-form.php template 
*/
function docu_search_filter( $query ) {

  if( $query->is_search ) {

    $search_post_type = get_query_var('docu_post_type');
    $s = $query->get('s');
    
    if( empty( $s ) ) { return false; }

    if( $search_post_type == 'doc' ) {

      if( ! isset( $_POST['docu_nonce_field'] ) || ! wp_verify_nonce( $_POST['docu_nonce_field'], 'docu_action' ) ) {

          print 'Sorry, your nonce did not verify.';
          exit;

      } else {

          $query->set('post_type', array( 'doc' ) ); 

      }

    } 

  }

  return $query;

}

add_filter('pre_get_posts','docu_search_filter');

/**
* Modifies the is_archive query to match the same order in the admin
*/
function docu_archive_filter( $query ) {

  if( $query->is_main_query() && $query->is_archive() && empty( $query->query_vars['suppress_filters'] ) ) {

    $doc_category = $query->get('doc_category');

    if( $doc_category) {

      $query->set( 'orderby', 'menu_order');
      $query->set( 'order', 'asc');

    }

  }

}

add_filter( 'pre_get_posts', 'docu_archive_filter' );

