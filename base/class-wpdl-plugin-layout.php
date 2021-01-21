<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WPDL_Plugin_Layout' ) ) {
	class WPDL_Plugin_Layout extends WPDL_Base_Layout{
		public function __construct() {
			parent::__construct();
			$this->action( 'plugins_loaded', 'init_module' );
			register_activation_hook( $this->get_main_file(), Closure::fromCallable( [ $this, 'activation' ] ) );
			register_deactivation_hook( $this->get_main_file(), Closure::fromCallable( [ $this, 'deactivation' ] ) );
		}

		public function init_module() {
			if (
				( defined( 'WPDL_WOOCOMMERCE_REQUIRED' ) && WPDL_WOOCOMMERCE_REQUIRED ) &&
				! defined( 'WP_UNINSTALL_PLUGIN' ) && ! class_exists( 'WooCommerce', false )
			) {
				$this->admin_notice_no_woocommerce();
				return;
			}
			$this->load_textdomain();
			$this->load_submodules();
		}

		public function get_layout(): string {
			return 'plugin';
		}

		/**
		 * Display admin notice when WooCommerce is unavailable.
		 */
		private function admin_notice_no_woocommerce() {
			$this->action( 'admin_notices', function () {
				echo '<div class="notice notice-error"><p>';
				printf(
				/* translators: Woocommerce plugis URL. It is strctly fixed. */
					__(
						'[%s] The plugin requires Woocommrece. Install and activate <a href="%s">WooCommerce plugin</a>.',
						'wpdl'
					),
					$this->get_layout_name(),
					esc_url( 'https://wordpress.org/plugins/woocommerce/' )
				);
				echo '</p></div>';
			} );
		}

		/**
		 * Load textdomain.
		 */
		private function load_textdomain() {
			load_plugin_textdomain( 'wpdl', false, wp_basename( dirname( $this->get_main_file() ) ) . '/languages' );
		}
	}
}
