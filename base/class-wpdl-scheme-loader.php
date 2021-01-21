<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPDL_Scheme_Loader' ) ) {
	class WPDL_Scheme_Loader {
		use WPDL_Hooks_Impl;

		private array $modules = [];

		private array $objects = [];

		public function set_modules( string $name, $modules ) {
			if ( is_null( $modules ) ) {
				unset( $this->modules[ $name ] );
			} else {
				$this->modules[ $name ] = $modules;
			}
		}

		public function set_objects( string $name, $objects ) {
			if ( is_null( $objects ) ) {
				unset( $this->objects[ $name ] );
			} else {
				$this->objects[ $name ] = $objects;
			}
		}

		public function get_modules( string $name ): ?array {
			if ( ! isset( $this->modules[ $name ] ) ) {
				return null;
			}

			if ( is_callable( $this->modules[ $name ] ) ) {
				$modules = $this->modules[$name]();
			} elseif ( is_array( $this->modules[ $name ] ) ) {
				$modules = &$this->modules[ $name ];
			} else {
				$modules = null;
			}

			return is_array( $modules ) ? $modules : null;
		}

		public function get_objects( string $name ): ?array {
			if ( ! isset( $this->objects[ $name ] ) ) {
				return null;
			}

			if ( is_callable( $this->objects[ $name ] ) ) {
				$objects = $this->objects[$name]();
			} elseif ( is_array( $this->objects[ $name ] ) ) {
				$objects = &$this->objects[ $name ];
			} else {
				$objects = null;
			}

			return is_array( $objects ) ? $objects : null;
		}

		public function init( string $scheme_file ) {
			if ( file_exists( $scheme_file ) && is_readable( $scheme_file ) ) {
				$loader = $this;
				/** @noinspection PhpIncludeInspection */
				include $scheme_file;
			}
		}
	}
}
