<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/* ----------------------------------------------
	Admin
---------------------------------------------- */

add_action( 'admin_enqueue_scripts', 'sortable_admin_enqueue_styles', 10, 1 );

function sortable_admin_enqueue_styles ( $hook = '' ) {

	if ( isset($_GET['post_type']) && $_GET['post_type'] == 'doc' ) {

		wp_register_style( 'sortable-css', plugins_url( 'docu/includes/sortable/css/sortable.css' ), array(), '1.0' );
		wp_enqueue_style( 'sortable-css' );

	}

}

global $pagenow;

if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'doc' ) {

	switch ( $pagenow ) {

		case 'edit-tags.php':
			add_action( 'init', 'sortable_load_scripts_categories' );     
			add_filter( 'get_terms_orderby', 'docu_order_categories', 10, 2 );
			break;

		case 'edit.php':
			add_action( 'init', 'sortable_load_scripts_posts' );
			add_filter( 'pre_get_posts', 'docu_order_docs' );
			break;

	}

}

function sortable_load_scripts_categories() {

	if ( isset($_GET['post_type']) && $_GET['post_type'] == 'doc' ) {

		wp_enqueue_script('jquery-ui-sortable');

		wp_register_script( 'sortable-categories', plugins_url( 'docu/includes/sortable/js/sortable-categories.js' ), array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'sortable-categories' );

	}

}

function sortable_load_scripts_posts() {

	if ( isset($_GET['post_type']) && $_GET['post_type'] == 'doc' ) {

		wp_enqueue_script('jquery-ui-sortable');

		wp_register_script( 'sortable-posts', plugins_url( 'docu/includes/sortable/js/sortable-posts.js' ), array( 'jquery' ), '1.0' );
		wp_enqueue_script( 'sortable-posts' );

	}

}

function docu_order_categories( $orderby, $args ) {
    $orderby = "t.term_group";
    return $orderby;
}

function docu_order_docs( $query ) {
    $query->set('orderby', 'menu_order');
    $query->set('order', 'ASC');
    return $query;
}

function docu_ajax_order_categories() {

	if ( ! isset( $_POST['action'] ) ) { return; } 

	global $wpdb;

    $categories = $_POST['tag'];
    $counter = 1;
    
    foreach ($categories as $cat_id) {
        
        $wpdb->update( 
            $wpdb->terms, 
            array( 'term_group' => $counter ), 
            array( 'term_id' => $cat_id ) 
        );

        $counter++;

    }

    die();	

}

add_action( 'wp_ajax_order_categories', 'docu_ajax_order_categories' );

function docu_ajax_order_docs() {

	if ( ! isset( $_POST['action'] ) ) { return; } 

	global $wpdb;

	$posts = $_POST['post'];
	$counter = 1;
		    
	foreach ( $posts as $post_id ) {
		        
		$wpdb->update( 
		    $wpdb->posts, 
		    array( 'menu_order' => $counter ), 
		    array( 'ID' => $post_id ) 
		);

		$counter++;

	}

	die();			

}

add_action( 'wp_ajax_order_docs', 'docu_ajax_order_docs' );


/* ----------------------------------------------
	Frontend
---------------------------------------------- */
/*
add_action( 'wp_enqueue_scripts', 'docu_enqueue_styles', 15 );
add_action( 'wp_enqueue_scripts', 'docu_enqueue_scripts', 10 );

function docu_enqueue_styles () {}

function docu_enqueue_scripts () {}
*/


