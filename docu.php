<?php
/*
 * Plugin Name: Docu
 * Version: 1.1
 * Plugin URI: http://wp.dinamiko.com/demos/docu
 * Description: A simple Documentation Plugin
 * Author: Emili Castells
 * Author URI: http://www.dinamiko.com
 * Requires at least: 3.9
 * Tested up to: 4.1
 *
 * Text Domain: docu
 * Domain Path: /languages/
 */

if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'Docu' ) ) {

	final class Docu {

		private static $instance;

		public static function instance() {

			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Docu ) ) {

				self::$instance = new Docu;

				self::$instance->setup_constants();

				add_action( 'plugins_loaded', array( self::$instance, 'docu_load_textdomain' ) );
				
				self::$instance->includes();

			}

			return self::$instance;

		}

		public function docu_load_textdomain() {

			load_plugin_textdomain( 'docu', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 

		}

		private function setup_constants() {

			if ( ! defined( 'DOCU_VERSION' ) ) { define( 'DOCU_VERSION', '1.1' ); }
			if ( ! defined( 'DOCU_PLUGIN_DIR' ) ) { define( 'DOCU_PLUGIN_DIR', plugin_dir_path( __FILE__ ) ); }
			if ( ! defined( 'DOCU_PLUGIN_URL' ) ) { define( 'DOCUPLUGIN_URL', plugin_dir_url( __FILE__ ) ); }
			if ( ! defined( 'DOCU_PLUGIN_FILE' ) ) { define( 'DOCU_PLUGIN_FILE', __FILE__ ); }			

		}

		private function includes() {

			require_once DOCU_PLUGIN_DIR . 'includes/post-types.php';
			require_once DOCU_PLUGIN_DIR . 'includes/load-js-css.php';
			require_once DOCU_PLUGIN_DIR . 'includes/docu-functions.php';			
			require_once DOCU_PLUGIN_DIR . 'includes/class-gamajo-template-loader.php';
			require_once DOCU_PLUGIN_DIR . 'includes/class-docu-template-loader.php';
			require_once DOCU_PLUGIN_DIR . 'includes/shortcodes.php';
			require_once DOCU_PLUGIN_DIR . 'includes/sortable/sortable.php';		
			require_once DOCU_PLUGIN_DIR . 'includes/widgets.php';
			require_once DOCU_PLUGIN_DIR . 'includes/install.php';

		}

		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'docu' ), DOCU_VERSION );
		}

		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'docu' ), DOCU_VERSION );
		}

	}

}

function Docu() {

	return Docu::instance();

}

Docu();