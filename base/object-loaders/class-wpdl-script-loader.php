<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Script_Loader' ) ) {
	class WPDL_Script_Loader implements WPDL_Module, WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		public function init_module() {
			$this->action( 'init', 'register_objects' );
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Script ) {
					$object->register();
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Script ) {
					$object->unregister();
				}
			}
		}

		/**
		 * @return WPDL_Script[]
		 */
		public function get_objects(): array {
			return array_merge(
				$this->get_global_scripts(),
				is_admin() ? $this->get_admin_scripts() : $this->get_front_scripts(),
			);
		}

		private function get_global_scripts(): array {
			return apply_filters( 'wpdl_script_objects', wpdl()->get_loader()->get_objects( 'script' ) );
		}

		private function get_admin_scripts(): array {
			return apply_filters( 'wpdl_script_objects/admin', wpdl()->get_loader()->get_objects( 'script/admin' ) );
		}

		private function get_front_scripts(): array {
			return apply_filters( 'wpdl_script_objects/front', wpdl()->get_loader()->get_objects( 'script/front' ) );
		}
	}
}
