<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Option_Loader' ) ) {
	class WPDL_Option_Loader implements WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		private array $fields = [];

		public function init_module() {
			$this->action( 'init', 'register_objects' );
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $idx => $object ) {
				if ( $object instanceof WPDL_Option ) {
					$object->register();
					$alias = is_int( $idx ) ? $object->get_option_name() : $idx;

					$this->fields[ $alias ] = [ $object->get_option_group(), $object->get_option_name() ];
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $object ) {
				if ( $object instanceof WPDL_Option ) {
					$object->unregister();
				}
			}
		}

		/**
		 * Get option objects.
		 *
		 * @return WPDL_Option[]
		 */
		public function get_objects(): array {
			return apply_filters( 'wpdl_option_objects', wpdl()->get_loader()->get_objects( 'option' ) );
		}

		/**
		 * Get WPDL_Option instance by alias
		 *
		 * @param string $alias
		 *
		 * @return ?WPDL_Option
		 */
		public function __get( string $alias ): ?WPDL_Option {
			if ( isset( $this->fields[ $alias ] ) ) {
				return WPDL_OPtion::factory( ...$this->fields[ $alias ] );
			}

			return null;
		}
	}
}
