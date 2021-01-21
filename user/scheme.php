<?php
/**
 * User scheme
 *
 * @var WPDL_Scheme_Loader $loader
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/* ****************************************************************************
 * Module setup
 **************************************************************************** */

$loader->set_modules( 'root', function () {
	return [
		'admin'   => wpdl_submodule( 'admin' ),
		'object'  => wpdl_submodule( 'object' ),
		'setting' => wpdl_submodule( 'setting' ),
	];
} );


// root > admin
$loader->set_modules( 'admin', function () {
	return [];
} );


// root > object
$loader->set_modules( 'object', function () {
	return [
		'ajax'      => new WPDL_Ajax_Loader(),
		'block'     => new WPDL_Block_Loader(),
		'cpt'       => new WPDL_CPT_Loader(),
		'cron'      => new WPDL_Cron_Loader(),
		'meta'      => new WPDL_Meta_Loader(),
		'option'    => new WPDL_Option_Loader(),
		'script'    => new WPDL_Script_Loader(),
		'shortcode' => new WPDL_Shortcode_Loader(),
		'style'     => new WPDL_Style_Loader(),
		'tax'       => new WPDL_Tax_Loader(),
	];
} );


// root > setting
$loader->set_modules( 'setting', function () {
	return [];
} );


/* ****************************************************************************
 * Objects definitions
 **************************************************************************** */

$loader->set_objects( 'ajax', function () {
	return [
		// new WPDL_Ajax( 'action', 'callback', false ),
	];
} );


$loader->set_objects( 'block', function () {
	return [
		// new WPDL_Block( 'block_type', [ 'editor_script' => '' ] ),
	];
} );


$loader->set_objects( 'cpt', function () {
	return [
		// new WPDL_Post_Type( 'post_type', [ ... ] ),
	];
} );


$loader->set_objects( 'cron', function () {
	return [
		// new WPDL_Cron( 'hook', timestamp, recurrence  ),
	];
} );


$loader->set_objects( 'meta', function () {
	return [
		// 'key' => new WPDL_Meta( 'post', 'meta_key', [] ),
	];
} );


$loader->set_objects( 'option', function () {
	return [
		// new WPDL_Option( 'option_group', 'option_name', [] ),
	];
} );


/* script: both front and admin. */
$loader->set_objects( 'script', function () {
	return [
		// new WPDL_Script( 'handle', 'src', deps, ver ),
	];
} );


/* script: admin only. */
$loader->set_objects( 'script/admin', function () {
	return [
		// new WPDL_Script( 'handle', 'src', deps, ver ),
	];
} );


/* script: front only. */
$loader->set_objects( 'script/front', function () {
	return [
		// new WPDL_Script( 'handle', 'src', deps, ver ),
	];
} );


$loader->set_objects( 'shortcode', function () {
	return [
		// new WPDL_Shortcode( 'shortcode', 'callback' ),
	];
} );


/* style: both front and admin. */
$loader->set_objects( 'style', function () {
	return [
		// new WPDL_Style( 'handle', 'src', deps, ver ),
	];
} );


/* style: admin only. */
$loader->set_objects( 'style/admin', function () {
	return [
		// new WPDL_Style( 'handle', 'src', deps, ver ),
	];
} );


/* style: front only. */
$loader->set_objects( 'style/front', function () {
	return [
		// new WPDL_Style( 'handle', 'src', deps, ver ),
	];
} );


$loader->set_objects( 'tax', function () {
	return [
		// new WPDL_Tax( 'taxonomy', [ 'post_type' ], [ ... ] );
	];
} );
