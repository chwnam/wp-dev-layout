<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPDL_Init' ) ) {
	final class WPDL_Init {
		private static ?WPDL_Layout_Interface $instance = null;

		public static function init( string $layout ) {
			if ( is_null( self::$instance ) ) {
				if ( 'plugin' === $layout ) {
					self::$instance = new WPDL_Plugin_Layout();
				} elseif ( 'theme' === $layout ) {
					self::$instance = new WPDL_Theme_Layout();
				} elseif ( has_filter( "wpdl_init_layout_{$layout}" ) ) {
					self::$instance = apply_filters( "wpdl_init_layout_{$layout}", null );
				}
				if ( ! self::$instance ) {
					wp_die( esc_html( sprintf( '[%s] layout \'%s\' is not supported.', WPDL_SLUG, $layout ) ) );
				}
			}
		}

		public static function get_instance(): WPDL_Layout_Interface {
			if ( self::$instance ) {
				return self::$instance;
			} else {
				wp_die( esc_html( sprintf( '[%s] is not initialized.', WPDL_SLUG ) ) );
			}
		}
	}
}
