<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! interface_exists( 'WPDL_Module' ) ) {
	interface WPDL_Module {
		/**
		 * Define action, filter, shortcode, and other initialization code in here
		 * instead of __construct().
		 *
		 * Because __construct() is called while being instantiated,
		 * sometimes calling modules in __construct() can cause an infinite loop.
		 */
		public function init_module();
	}
}
