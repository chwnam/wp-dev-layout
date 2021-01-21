<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Meta_Loader' ) ) {
	/**
	 * Class WPDL_Meta_Loader
	 */
	class WPDL_Meta_Loader implements WPDL_Object_Loader {
		use WPDL_Hooks_Impl;

		private array $fields = [];

		public function init_module() {
			$this->action( 'init', 'register_objects' );
		}

		public function register_objects(): void {
			foreach ( $this->get_objects() as $idx => $object ) {
				if ( $object instanceof WPDL_Meta ) {
					$object->register();
					$alias = is_int( $idx ) ? $object->get_key() : $idx;

					$this->fields[ $alias ] = [
						$object->get_object_type(),
						$object->get_key(),
						$object->object_subtype,
					];
				}
			}
		}

		public function unregister_objects(): void {
			foreach ( $this->get_objects() as $idx => $object ) {
				if ( $object instanceof WPDL_Meta ) {
					$object->unregister();
					$alias = is_int( $idx ) ? $object->get_key() : $idx;
					unset( $this->fields[ $alias ] );
				}
			}
		}

		/**
		 * Get meta objects.
		 *
		 * @return WPDL_Meta[]
		 */
		public function get_objects(): array {
			return apply_filters( 'wpdl_meta_objects', wpdl()->get_loader()->get_objects( 'meta' ) );
		}

		/**
		 * @param string $alias
		 *
		 * @return ?WPDL_Meta
		 */
		public function __get( string $alias ): ?WPDL_Meta {
			if ( isset ( $this->fields[ $alias ] ) ) {
				return WPDL_Meta::factory( ...$this->fields[ $alias ] );
			}

			return null;
		}
	}
}
