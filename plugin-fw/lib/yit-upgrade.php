<?php
/*
 * This file belongs to the YIT Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

if ( ! class_exists( 'PGA_Upgrade' ) ) {
	/**
	 * YIT Upgrade
	 *
	 * Notify and Update plugin
	 *
	 * @class       PGA_Upgrade
	 * @since       1.0
	 * @author Panevnyk Roman <panevnyk.roman@gmail.com>
	 * @see         WP_Updater Class
	 */
	class PGA_Upgrade {
		/**
		 * @var PGA_Upgrade The main instance
		 */
		protected static $_instance;

		/**
		 * Construct
		 *
		 * @author Panevnyk Roman <panevnyk.roman@gmail.com>
		 * @since  1.0
		 */
		public function __construct() {
			//Silence is golden...
		}

		/**
		 * Main plugin Instance
		 *
		 * @param $plugin_slug | string The plugin slug
		 * @param $plugin_init | string The plugin init file
		 *
		 * @return void
		 *
		 * @since  1.0
		 * @author Panevnyk Roman <panevnyk.roman@gmail.com>
		 */
		public function register( $plugin_slug, $plugin_init ) {
			if( ! function_exists( 'PG_Plugin_Upgrade' ) ){
				//Try to load PG_Plugin_Upgrade class
				yith_plugin_fw_load_update_and_licence_files();
			}

            try {
                PG_Plugin_Upgrade()->register( $plugin_slug, $plugin_init );
            } catch( Error $e ){
            }
		}

		/**
		 * Main plugin Instance
		 *
		 * @static
		 * @return object Main instance
		 *
		 * @since  1.0
		 * @author Panevnyk Roman <panevnyk.roman@gmail.com>
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}
	}
}

if ( ! function_exists( 'PGA_Upgrade' ) ) {
	/**
	 * Main instance of plugin
	 *
	 * @return PGA_Upgrade
	 * @since  1.0
	 * @author Panevnyk Roman <panevnyk.roman@gmail.com>
	 */
	function PGA_Upgrade() {
		return PGA_Upgrade::instance();
	}
}

/**
 * Instance a PGA_Upgrade object
 */
PGA_Upgrade();
