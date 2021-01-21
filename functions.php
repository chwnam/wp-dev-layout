<?php
/**
 * Plugin Name:       WP Development Layout
 * Plugin URI:
 * Version:           0.1.0
 * Description:       Boilerplate code for WordPress development.
 * Author:            Changwoo Nam
 * Author URI:        https://blog.changwoo.pe.kr/
 * Text Domain:       wpdl
 * Domain Path:       languages/
 * Network:           false
 * Requires at least:
 * Requires PHP:      7.4
 * License:           GPLv2 or later
 * License URI:
 */

require_once __DIR__ . '/vendor/autoload.php';

define( 'WPDL_MAIN', __FILE__ );
define( 'WPDL_VERSION', '0.1.0' );
define( 'WPDL_PRIORITY', '100' );
define( 'WPDL_NAME', 'WP Development Layout' );
define( 'WPDL_SLUG', 'wppl' );
// define( 'WPDL_WOOCOMMERCE_REQUIRED', true );

wpdl_init( 'plugin' );
// wpdl_init( 'theme' );
