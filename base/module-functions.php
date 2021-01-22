<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'wpdl_init' ) ) :
	function wpdl_init( string $layout ) {
		WPDL_Init::init( $layout );
	}
endif;


if ( ! function_exists( 'wpdl' ) ) :
	function wpdl(): WPDL_Layout_Interface {
		return WPDL_Init::get_instance();
	}
endif;


if ( ! function_exists( 'wpdl_parse_callback' ) ) {
	/**
	 * Parse callback handler.
	 *
	 * 1. Callable - use as-is.
	 * 2. String and not callable, including '@' - parse.
	 *
	 * @sample "foo@bar"       // [wpdl()->foo, 'bar']
	 * @sample "admin.foo@bar" // [wpdl()->admin->foo, 'bar']
	 *
	 * @param string|callable $maybe_callback
	 *
	 * @return callable|false
	 */
	function wpdl_parse_callback( $maybe_callback ) {
		static $cache = [];

		if ( is_callable( $maybe_callback ) ) {
			return $maybe_callback;
		} elseif ( is_string( $maybe_callback ) && false !== strpos( $maybe_callback, '@' ) ) {
			[ $module_part, $method ] = explode( '@', $maybe_callback, 2 );

			if ( isset( $cache[ $module_part ] ) ) {
				if ( $cache[ $module_part ] && method_exists( $cache[ $module_part ], $method ) ) {
					$callback = [ $cache[ $module_part ], $method ];
				} else {
					$callback = false;
				}
			} else {
				$module = wpdl();
				foreach ( explode( '.', $module_part ) as $crumb ) {
					if ( isset( $module->{$crumb} ) ) {
						$module = $module->{$crumb};
					} else {
						$module = false;
						break;
					}
				}
				$cache[ $module_part ] = $module;

				if ( $module && method_exists( $module, $method ) ) {
					$callback = [ $module, $method ];
				} else {
					$callback = false;
				}
			}

			return $callback;
		}

		return false;
	}
}


if ( ! function_exists( 'wpdl_submodule' ) ) {
	function wpdl_submodule( string $module_name ): ?WPDL_Module {
		if ( empty( $module_name ) ) {
			return null;
		}

		return new class( $module_name ) implements WPDL_Module {
			use WPDL_Submodule_Impl;

			private string $module_name;

			public function __construct( $module_name ) {
				$this->module_name = $module_name;
			}

			public function init_module() {
				$this->init_submodules( wpdl()->get_loader()->get_modules( $this->module_name ) );
			}
		};
	}
}


if ( ! function_exists( 'wpdl_url_helper' ) ) {
	/**
	 * Provide non-minified CSS, JS file.
	 *
	 * @param string $url
	 *
	 * @return string
	 */
	function wpdl_url_helper( string $url ): string {
		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$url = preg_replace( '/\.min\.(js|css)$/', '.$1', $url );
		}
		return $url;
	}
}
