<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Cron_Loader' ) ) {
	/**
	 * Class WPDL_Cron_Loader
	 */
	class WPDL_Cron_Loader implements WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		public function init_module() {
			/**
			 * @uses WPDL_Cron_Loader::activation_setup()
			 * @uses WPDL_Cron_Loader::deactivation_cleanup()
			 */
			$this
				->action( 'wpdl_activation', 'activation_setup' )
				->action( 'wpdl_deactivation', 'deactivation_cleanup' );
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Cron ) {
					$object->register();
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Cron ) {
					$object->unregister();
				}
			}
		}

		/**
		 * @return WPDL_Cron[]
		 */
		public function get_objects(): array {
			return apply_filters( 'wpdl_cron_objects', wpdl()->get_loader()->get_objects( 'cron' ) );
		}

		/**
		 * Activation callback.
		 */
		public function activation_setup() {
			$this->register_objects();
		}

		/**
		 * Deactivation callback.
		 */
		public function deactivation_cleanup() {
			$this->unregister_objects();
		}
	}
}
