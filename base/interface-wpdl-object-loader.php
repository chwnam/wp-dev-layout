<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! interface_exists( 'WPDL_Object_Loader' ) ) :

	interface WPDL_Object_Loader extends WPDL_Module {
		public function register_objects(): void;

		public function unregister_objects(): void;

		public function get_objects(): array;
	}

endif;

