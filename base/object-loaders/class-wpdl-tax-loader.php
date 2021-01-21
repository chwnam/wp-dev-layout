<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Tax_Loader' ) ) {
	class WPDL_Tax_Loader implements WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		public function init_module() {
			$this->action( 'init', 'register_objects' );
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Tax ) {
					$object->register();
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Tax ) {
					$object->unregister();
				}
			}
		}

		/**
		 * @return WPDL_Tax[]
		 */
		public function get_objects(): array {
			return apply_filters( 'wpdl_tax_objects', wpdl()->get_loader()->get_objects( 'tax' ) );
		}
	}
}