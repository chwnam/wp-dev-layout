<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! class_exists( 'WPDL_Style' ) ) {
	/**
	 * Class WPDL_Style
	 *
	 * Object for style enqueueing.
	 */
	class WPDL_Style implements WPDL_Object {
		public string $handle;

		public string $src;

		public array $deps;

		/**
		 * @var bool|null|string
		 */
		public $ver;

		public string $media;

		public function __construct(
			string $handle,
			string $src,
			array $deps = [],
			$ver = false,
			string $media = 'all'
		) {
			$this->handle = $handle;
			$this->src    = $src;
			$this->deps   = $deps;
			$this->ver    = $ver;
			$this->media  = $media;
		}

		public function register() {
			if ( $this->handle && $this->src ) {
				wp_register_style( $this->handle, $this->src, $this->deps, $this->ver, $this->media );
			}
		}

		public function unregister() {
			if ( $this->handle && $this->src ) {
				wp_deregister_style( $this->handle );
			}
		}
	}
}
