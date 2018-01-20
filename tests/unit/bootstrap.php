<?php # -*- coding: utf-8 -*-

if ( ! defined( 'DOCU_PLUGIN_DIR' ) ) {
	define( 'DOCU_PLUGIN_DIR', rtrim( dirname( dirname( __DIR__ ) ), '/' ) );
}

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', DOCU_PLUGIN_DIR );
}

// Require Composer Auto-loader.
require_once DOCU_PLUGIN_DIR . '/vendor/autoload.php';
