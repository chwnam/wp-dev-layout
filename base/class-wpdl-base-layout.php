<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPDL_Base_Layout' ) ) {
	abstract class WPDL_Base_Layout implements WPDL_Layout_Interface, WPDL_Module {
		use WPDL_Hooks_Impl;
		use WPDL_Submodule_Impl;

		protected bool $module_loaded = false;

		protected WPDL_Scheme_Loader $loader;

		private array $storage = [];

		public function __construct() {
			$this->loader = new WPDL_Scheme_Loader();
			$this->loader->init( $this->get_scheme_file() );
		}

		public function get_main_file(): string {
			return WPDL_MAIN;
		}

		public function get_version(): string {
			return WPDL_VERSION;
		}

		public function get_slug(): string {
			return WPDL_SLUG;
		}

		public function get_default_priority(): int {
			return WPDL_PRIORITY;
		}

		public function get_layout_name(): string {
			return WPDL_NAME;
		}

		public function get_scheme_file(): string {
			return dirname( $this->get_main_file() ) . '/user/scheme.php';
		}

		public function get_loader(): WPDL_Scheme_Loader {
			return $this->loader;
		}

		public function get( string $name, $default = null ) {
			return $this->storage[ $name ] ?? $default;
		}

		public function set( string $name, $value ) {
			if ( is_null( $value ) ) {
				unset( $this->storage[ $name ] );
			} else {
				$this->storage[ $name ] = $value;
			}
		}

		public function activation() {
			// Modules should be loaded at first.
			$this->load_submodules();
			do_action( 'wpdl_activation' );
		}

		public function deactivation() {
			do_action( 'wpdl_deactivation' );
		}

		/**
		 * Load all submodules.
		 */
		protected function load_submodules() {
			if ( ! $this->module_loaded ) {
				$this->module_loaded = true;

				$this->init_submodules( $this->loader->get_modules( 'root' ) );

				// Trigger all submodule initialization.
				do_action( 'wpdl_modules_loaded' );
			}
		}
	}
}