<?php

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_enqueue_scripts', 'docu_enqueue_styles', 15 );
add_action( 'wp_enqueue_scripts', 'docu_enqueue_scripts', 10 );
add_action( 'admin_enqueue_scripts', 'docu_admin_enqueue_scripts', 10, 1 );
add_action( 'admin_enqueue_scripts', 'docu_admin_enqueue_styles', 10, 1 );

function docu_enqueue_styles () {

	//wp_enqueue_style( 'dashicons' );

	wp_register_style( 'docu-frontend', plugins_url( 'docu/assets/css/frontend.css' ), array(), '1.0' );
	wp_enqueue_style( 'docu-frontend' );

}

function docu_enqueue_scripts () {

	wp_enqueue_script('masonry');

	wp_register_script( 'docu-imagesloaded', plugins_url( 'docu/assets/js/imagesloaded.pkgd.min.js' ), array( 'jquery' ), '3.1' );
	wp_enqueue_script( 'docu-imagesloaded' );

	wp_register_script( 'docu-frontend', plugins_url( 'docu/assets/js/frontend.js' ), array( 'jquery' ), '1.0' );
	wp_enqueue_script( 'docu-frontend' );

}

function docu_admin_enqueue_styles ( $hook = '' ) {

	wp_register_style( 'docu-admin', plugins_url( 'docu/assets/css/admin.css' ), array(), '1.0' );
	wp_enqueue_style( 'docu-admin' );

}

function docu_admin_enqueue_scripts ( $hook = '' ) {

	wp_register_script( 'docu-admin', plugins_url( 'docu/assets/js/admin.js' ), array( 'jquery' ), '1.0' );
	wp_enqueue_script( 'docu-admin' );	
				
}