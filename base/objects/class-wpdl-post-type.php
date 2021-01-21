<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPDL_Post_Type' ) ) {
	class WPDL_Post_Type implements WPDL_Object {
		public string $post_type;

		public array $args;

		public function __construct( string $post_type, array $args = [] ) {
			$this->post_type = $post_type;
			$this->args      = $args;
		}

		public function register() {
			if ( ! post_type_exists( $this->post_type ) ) {
				register_post_type( $this->post_type, $this->args );
			}
		}

		public function unregister() {
			if ( post_type_exists( $this->post_type ) ) {
				unregister_post_type( $this->post_type );
			}
		}
	}
}
