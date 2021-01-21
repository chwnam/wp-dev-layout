<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Style_Loader' ) ) {
	class WPDL_Style_Loader implements WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		public function init_module() {
			$this->action( 'init', 'register_objects' );
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Style ) {
					$object->register();
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Style ) {
					$object->unregister();
				}
			}
		}

		/**
		 * @return WPDL_Style[]
		 */
		public function get_objects(): array {
			return array_merge(
				$this->get_global_styles(),
				is_admin() ? $this->get_admin_styles() : $this->get_front_styles(),
			);
		}

		private function get_global_styles(): array {
			return apply_filters( 'wpdl_style_objects', wpdl()->get_loader()->get_objects( 'style' ) );
		}

		private function get_admin_styles(): array {
			return apply_filters( 'wpdl_style_objects/admin', wpdl()->get_loader()->get_objects( 'style/admin' ) );
		}

		private function get_front_styles(): array {
			return apply_filters( 'wpdl_style_objects/front', wpdl()->get_loader()->get_objects( 'style/front' ) );
		}
	}
}
