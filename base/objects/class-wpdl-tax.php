<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Tax' ) ) {
	class WPDL_Tax implements WPDL_Object {
		public string $taxonomy;

		/** @var array|string */
		public $object_type;

		public array $args;

		public function __construct( string $taxonomy, $object_type, array $args = [] ) {
			$this->taxonomy    = $taxonomy;
			$this->object_type = (array) $object_type;
			$this->args        = $args;
		}

		public function register() {
			register_taxonomy(
				$this->taxonomy,
				$this->object_type,
				$this->args
			);
		}

		public function unregister() {
			unregister_taxonomy( $this->taxonomy );
		}
	}
}
