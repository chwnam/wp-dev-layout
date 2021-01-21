<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Ajax_Loader' ) ) {
	/**
	 * Class WPDL_Ajax_Loader
	 */
	class WPDL_Ajax_Loader implements WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		/**
		 * @uses WPDL_Ajax_Handler::register_all()
		 */
		public function init_module() {
			$this->action( 'init', 'register_objects' );
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $ajax ) {
				if ( $ajax instanceof WPDL_Ajax ) {
					$ajax->register();
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $ajax ) {
				if ( $ajax instanceof WPDL_Ajax ) {
					$ajax->unregister();
				}
			}
		}

		/**
		 * @return WPDL_Ajax[]
		 */
		public function get_objects(): array {
			return apply_filters( 'wpdl_ajax_objects', wpdl()->get_loader()->get_objects( 'ajax' ) );
		}
	}
}
