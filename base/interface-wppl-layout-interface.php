<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! interface_exists( 'WPDL_Layout_Interface' ) ) {
	interface WPDL_Layout_Interface {
		public function get_main_file(): string;

		public function get_version(): string;

		public function get_slug(): string;

		public function get_layout(): string;

		public function get_default_priority(): int;

		public function get_layout_name(): string;

		public function get_scheme_file(): string;

		public function get_loader(): WPDL_Scheme_Loader;

		public function get( string $name, $default = null );

		public function set( string $name, $value );
	}
}
