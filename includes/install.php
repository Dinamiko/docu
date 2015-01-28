<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function docu_install() {

	docu_setup_post_types();
	docu_setup_taxonomies();
	flush_rewrite_rules();
	
}

register_activation_hook( DOCU_PLUGIN_FILE, 'docu_install' );