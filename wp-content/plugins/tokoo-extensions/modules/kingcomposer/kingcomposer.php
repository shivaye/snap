<?php

/**
 * Module Name 			: King Composer Addons
 * Module Description 	: Provides additional King Composer Elements for the Tokoo theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'Tokoo_KCExtensions' ) ) {
	class Tokoo_KCExtensions {

		/**
		 * Constructor function.
		 * @access  public
		 * @since   1.0.0
		 * @return  void
		 */
		public function __construct() {
			add_action( 'init', array( $this, 'setup_constants' ),	10 );
			add_action( 'init', array( $this, 'map_kc_elements' ),	20 );
		}

		/**
		 * Setup plugin constants
		 *
		 * @access public
		 * @since  1.0.0
		 * @return void
		 */
		public function setup_constants() {

			// Plugin Folder Path
			if ( ! defined( 'TOKOO_KC_PLUGIN_EXTENSIONS_DIR' ) ) {
				define( 'TOKOO_KC_PLUGIN_EXTENSIONS_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL
			if ( ! defined( 'TOKOO_KC_PLUGIN_EXTENSIONS_URL' ) ) {
				define( 'TOKOO_KC_PLUGIN_EXTENSIONS_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File
			if ( ! defined( 'TOKOO_KC_PLUGIN_EXTENSIONS_FILE' ) ) {
				define( 'TOKOO_KC_PLUGIN_EXTENSIONS_FILE', __FILE__ );
			}
		}

		/**
		 * Map Config Dir
		 *
		 * @since  1.0.0
		 * @access public
		 */
		public function map_kc_elements() {
			require_once TOKOO_KC_PLUGIN_EXTENSIONS_DIR.'/maps.php';
		}
	}
}

if( class_exists( 'KingComposer' ) ) {
	// Finally initialize code
	new Tokoo_KCExtensions();
}

if( function_exists( 'kc_do_shortcode' ) && ! function_exists( 'tokoo_get_kc_content' ) ) {
	function tokoo_get_kc_content( $id ) {
		$raw_content = kc_raw_content( $id );
		return kc_do_shortcode( $raw_content );
	}
}
