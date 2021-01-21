<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPDL_Theme_Layout' ) ) {
	class WPDL_Theme_Layout extends WPDL_Base_Layout {
		public function __construct() {
			parent::__construct();
			$this->action( 'after_setup_theme', 'init_module' )
			     ->action( 'after_switch_theme', 'activation' )
			     ->action( 'switch_theme', 'deactivation' );
		}

		/**
		 * Initialize current module.
		 *
		 * @callback
		 * @action      after_setup_theme
		 */
		public function init_module() {
			$this->load_textdomain();
			$this->load_submodules();
		}

		public function get_layout(): string {
			return 'theme';
		}

		/**
		 * Load textdomain.
		 */
		private function load_textdomain() {
			load_theme_textdomain( 'wpdl', get_template_directory() . '/langugages' );
		}
	}
}
