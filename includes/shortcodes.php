<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/**
* [docu]
* This shortcode is used to display the contents of Docu index page 
*/
function docu_shortcode( $atts, $content = null ) {
	
	global $docu_atts;

	$docu_atts = shortcode_atts( array(

		'search' => 'false',
		'columns' => '1',
		'list_docs' => 'false',
		'content' => $content

	), $atts );

	$template = new DOCU_Template_Loader;

	ob_start();

	$template->get_template_part( 'docu-index' );

	return ob_get_clean();

}

add_shortcode( 'docu', 'docu_shortcode' );