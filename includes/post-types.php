<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* Register doc post type
*/
function docu_setup_post_types() {

	$docu_labels = array(
		'name' 				=> _x( 'Docs', 'doc post type general name', 'docu' ),
		'singular_name' 	=> _x( 'Doc', 'doc post type singular name', 'docu' ),
		'add_new' 			=> __( 'Add New', 'docu' ),
		'add_new_item' 		=> __( 'Add New Doc', 'docu' ),
		'edit_item' 		=> __( 'Edit Doc', 'docu' ),
		'new_item' 			=> __( 'New Doc', 'docu' ),
		'all_items' 		=> __( 'All Docs', 'docu' ),
		'view_item' 		=> __( 'View Doc', 'docu' ),
		'search_items' 		=> __( 'Search Docs', 'docu' ),
		'not_found' 		=> __( 'No Docs found', 'docu' ),
		'not_found_in_trash'=> __( 'No Docs found in Trash', 'docu' ),
		'parent_item_colon' => '',
		'menu_name' 		=> __( 'Docs', 'docu' )
	);

	$docu_args = array(
		'labels' 			=> apply_filters( 'docu_doc_post_type_labels', $docu_labels ),
        'public'                => true,
        'menu_position'         => 5,
        'rewrite'               => array('slug' => 'doc'),
        'supports'              => array('title','editor', 'thumbnail', 'excerpt'),
        'public'                => true,
        'show_ui'               => true,
        'publicly_queryable'    => true,
        'exclude_from_search'   => false,
        'menu_icon' => 'dashicons-format-aside'
	);

	register_post_type( 'doc', apply_filters( 'docu_doc_post_type_args', $docu_args ) );	

}

add_action( 'init', 'docu_setup_post_types', 1 );

function docu_get_default_labels() {

	$defaults = array(
	   'singular' => __( 'Doc', 'docu' ),
	   'plural'   => __( 'Docs', 'docu')
	);

	return apply_filters( 'docu_default_docs_name', $defaults );
	
}

function docu_get_label_singular( $lowercase = false ) {
	$defaults = docu_get_default_labels();
	return ($lowercase) ? strtolower( $defaults['singular'] ) : $defaults['singular'];
}

function docu_get_label_plural( $lowercase = false ) {
	$defaults = docu_get_default_labels();
	return ( $lowercase ) ? strtolower( $defaults['plural'] ) : $defaults['plural'];
}

function docu_change_default_title( $title ) {

     if ( !is_admin() ) {
     	$label = docu_get_label_singular();
        $title = sprintf( __( 'Enter %s name here', 'docu' ), $label );
     	return $title;
     }
     
     $screen = get_current_screen();

     if ( 'doc' == $screen->post_type ) {
     	$label = docu_get_label_singular();
        $title = sprintf( __( 'Enter %s name here', 'docu' ), $label );
     }

     return $title;
}

add_filter( 'enter_title_here', 'docu_change_default_title' );

/**
* Register doc_category taxonomy
*/
function docu_setup_taxonomies() {

	$category_labels = array(
		'name' 				=> sprintf( _x( '%s Categories', 'taxonomy general name', 'docu' ), docu_get_label_singular() ),
		'singular_name' 	=> _x( 'Category', 'taxonomy singular name', 'docu' ),
		'search_items' 		=> __( 'Search Categories', 'docu'  ),
		'all_items' 		=> __( 'All Categories', 'docu'  ),
		'parent_item' 		=> __( 'Parent Category', 'docu'  ),
		'parent_item_colon' => __( 'Parent Category:', 'docu'  ),
		'edit_item' 		=> __( 'Edit Category', 'docu'  ),
		'update_item' 		=> __( 'Update Category', 'docu'  ),
		'add_new_item' 		=> sprintf( __( 'Add New %s Category', 'docu'  ), docu_get_label_singular() ),
		'new_item_name' 	=> __( 'New Category Name', 'docu'  ),
		'menu_name' 		=> __( 'Categories', 'docu'  ),
	);

	$category_args = array(
		'hierarchical' 	=> true,
		'labels' 		=> apply_filters('docu_doc_category_labels', $category_labels),
		'show_ui' 		=> true,
		'query_var' 	=> 'doc_category',
		'rewrite' 		=> array('slug' => 'docs' . '/category', 'with_front' => false, 'hierarchical' => true ),
		'show_admin_column' => true 
	);

	register_taxonomy( 'doc_category', array('doc'), apply_filters('docu_doc_category_args', $category_args ) );
	register_taxonomy_for_object_type( 'doc_category', 'doc' );

}

add_action( 'init', 'docu_setup_taxonomies', 0 );


/**
* Adds current-class to docu-nav-list li in single doc
*/
function docu_cat_active( $output, $args ) {

  if( is_single() ){

    global $post;
    $post_type = get_post_type( $post->ID );

    if( $post_type == 'doc' ) {

    	$terms = get_the_terms( $post->ID, 'doc_category' );

    	if( $terms ) {

		    foreach( $terms as $term ) {

		    	 if ( preg_match( '#cat-item-' . $term ->term_id . '#', $output ) ) {

		    	 	$output = str_replace('cat-item-'.$term->term_id, 'cat-item-'.$term->term_id . ' current-cat', $output);

		    	 }

		    }

    	} else {

    		$output = '';

    	}

    }

  }

  return $output;

}

add_filter( 'wp_list_categories', 'docu_cat_active', 10, 2 );