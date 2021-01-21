<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Block_Loader' ) ) {
	class WPDL_Block_Loader implements WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		/**
		 * @uses WPDL_Block_Handler::register_objects()
		 */
		public function init_module() {
			if ( function_exists( 'register_block_type' ) ) {
				$this->action( 'enqueue_block_editor_assets', 'register_objects' );
			}
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Block ) {
					$object->register();
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Block ) {
					$object->unregister();
				}
			}
		}

		/**
		 * @return WPDL_Block[]
		 */
		public function get_objects(): array {
			return apply_filters( 'wpdl_block_objects', wpdl()->get_loader()->get_objects( 'block' ) );
		}
	}
}
