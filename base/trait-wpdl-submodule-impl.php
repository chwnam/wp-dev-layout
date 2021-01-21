<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! trait_exists( 'WPDL_Submodule_Impl' ) ) {
	trait WPDL_Submodule_Impl {
		/** @var WPDL_Module[] */
		private array $modules = [];

		/**
		 * @param string $name
		 *
		 * @return WPDL_Module|object|null
		 */
		public function __get( string $name ) {
			$module = $this->modules[ $name ] ?? null;

			if ( is_callable( $module ) ) {
				$module = $this->modules[ $name ] = $module();
				if ( $module instanceof WPDL_Module ) {
					$module->init_module();
				}
			}

			return $module;
		}

		public function __set( string $name, $value ) {
			throw new BadMethodCallException(
				sprintf(
					__( '%s does not allow submodule from outside.', 'wpdl' ),
					wpdl()->get_layout_name()
				)
			);
		}

		public function __isset( string $name ): bool {
			return isset( $this->modules[ $name ] );
		}

		public function __unset( string $name ): void {
			throw new BadMethodCallException(
				sprintf(
					__( '%s does not allow submodule removal.', 'wpdl' ),
					wpdl()->get_layout_name()
				)
			);
		}

		public function init_submodules( array $submodules ): void {
			$this->modules = $submodules;

			foreach ( $this->modules as $module ) {
				if ( $module instanceof WPDL_Module ) {
					$module->init_module();
				}
			}
		}
	}
}
