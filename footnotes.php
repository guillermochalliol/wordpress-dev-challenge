<?php

/**
 *
 * The plugin bootstrap file
 *
 * This file is responsible for starting the plugin using the main plugin class file.
 *
 * @since 0.0.1
 * @package footnotes
 *
 * @wordpress-plugin
 * Plugin Name:     Footnotes + Link checker
 * Description:     This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:         0.0.1
 * Author:          Guillermo Challiol
 * Author URI:      https://www.example.com
 * License:         GPL-2.0+
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     footnotes
 * Domain Path:     /lang
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Direct access not permitted.' );
}

if ( ! class_exists( 'footnotes' ) ) {

	/*
	 * main footnotes class
	 *
	 * @class footnotes
	 * @since 0.0.1
	 */
	class footnotes {

		/*
		 * footnotes plugin version
		 *
		 * @var string
		 */
		public $version = '4.7.5';

		/**
		 * The single instance of the class.
		 *
		 * @var footnotes
		 * @since 0.0.1
		 */
		protected static $instance = null;

		/**
		 * Main footnotes instance.
		 *
		 * @since 0.0.1
		 * @static
		 * @return footnotes - main instance.
		 */
		public static function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

		/**
		 * footnotes class constructor.
		 */
		public function __construct() {
			$this->load_plugin_textdomain();
			$this->define_constants();
			$this->includes();
			$this->define_actions();
		}

		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'footnotes', false, basename( dirname( __FILE__ ) ) . '/lang/' );
		}

		/**
		 * Include required core files
		 */
		public function includes() {
            // Example
			//require_once __DIR__ . '/includes/loader.php';

			// Load custom functions and hooks
			require_once __DIR__ . '/includes/includes.php';
		}

		/**
		 * Get the plugin path.
		 *
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}


		/**
		 * Define footnotes constants
		 */
		private function define_constants() {
			define( 'FOOTNOTES_PLUGIN_FILE', __FILE__ );
			define( 'FOOTNOTES_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			define( 'FOOTNOTES_VERSION', $this->version );
			define( 'FOOTNOTES_PATH', $this->plugin_path() );
			define( 'FOOTNOTES_ASSETS', plugin_dir_url( __FILE__ ) );
            define( 'FOOTNOTES_PP', 'footnotes');
        
		}

		/**
		 * Define footnotes actions
		 */
		public function define_actions() {
			//
		}		
	}

	$footnotes = new footnotes();
}





