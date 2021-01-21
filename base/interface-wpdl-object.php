<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! interface_exists( 'WPDL_Object' ) ) {
	interface WPDL_Object {
		public function register();

		public function unregister();
	}
}
