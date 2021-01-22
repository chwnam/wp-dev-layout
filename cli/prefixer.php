#!/usr/bin/env php
<?php
/**
 * 'base' 디렉토리의 기본 접두를 교체합니다.
 *
 * 디렉토리 내에서 'wpdl', 혹은 'WPDL' 접두어는 string replace 처리됩니다.
 */

if ( 'cli' !== php_sapi_name() ) {
	exit;
}

define( 'ROOT_DIR', dirname( __DIR__ ) );


/**
 * @return string
 */
function prefix_input(): string {
	do {
		$prefix = readline( 'Enter a prefix: ' );
		$match  = preg_match( '/^[A-Za-z0-9_]+$/', $prefix );
		if ( ! $match ) {
			echo "Error! Invalid prefix. Prefix should contain lowercase a-z, 0-9, and underscore only.\n";
		}
		if ( false !== strpos( strtolower( $prefix ), 'wpdl' ) ) {
			echo "Error! string 'wpdl' is included. Choose another prefix.\n";
			$match = false;
		}
	} while ( ! $match );

	return trim( $prefix, '_' );
}


function confirm_input( string $prefix ): bool {
	do {
		printf(
            'Replace all prefix with \'%s\' for class name prefixes, \'%s\' for string prefixes, \'%s\' for define prefixes. Are you sure? [y, n] ',
            $prefix,
            strtolower( $prefix),
            strtoupper( $prefix )
        );
		$answer = trim( strtolower( readline() ) );
		if ( 'n' == $answer ) {
			return false;
		}
	} while ( $answer !== 'y' );

	return true;
}


function replace_prefix( string $prefix ) {
	$targets = [
		ROOT_DIR . '/base',
	];

	foreach ( $targets as $target ) {
		if ( is_dir( $target ) ) {
			$iterator = new RegexIterator(
				new RecursiveIteratorIterator( new RecursiveDirectoryIterator( $target ) ),
				'/\.php$/i',
				RecursiveRegexIterator::MATCH
			);
			foreach ( $iterator as $it ) {
				/** @var SplFileInfo $it */
				__replace_prefix( $it->getPathname(), $prefix );
			}
		} elseif ( is_file( $target ) ) {
			__replace_prefix( $target, $prefix );
		}
	}
}


function __replace_prefix( string $path, string $prefix ) {
	if ( file_exists( $path ) && is_file( $path ) && is_readable( $path ) && is_writeable( $path ) ) {
		$content = file_get_contents( $path );
		$lower   = strtolower( $prefix );
		$upper   = strtoupper( $prefix );

		// Replace constants.
		$search = [
			'WPDL_MAIN',
			'WPDL_VERSION',
			'WPDL_PRIORITY',
			'WPDL_NAME',
			'WPDL_SLUG',
			'WPDL_WOOCOMMERCE_REQUIRED',
		];

		$replace = [
			"{$upper}_MAIN",
			"{$upper}_VERSION",
			"{$upper}_PRIORITY",
			"{$upper}_NAME",
			"{$upper}_SLUG",
			"{$upper}_WOOCOMMERCE_REQUIRED",
		];

		$content = str_replace( $search, $replace, $content );
		$content = str_replace( [ 'wpdl', 'WPDL' ], [ $lower, $upper ], $content );

		file_put_contents( $path, $content );

		// File name fix.
		$sep      = DIRECTORY_SEPARATOR;
		$dirname  = dirname( $path );
		$basename = str_replace( 'wpdl', $lower, pathinfo( $path, PATHINFO_BASENAME ) );
		$renamed  = "{$dirname}{$sep}{$basename}";

		rename( $path, $renamed );

		echo $path . ' => ' . $renamed . PHP_EOL;
	}
}


/* Script begin */
$prefix = prefix_input();
if ( confirm_input( $prefix ) ) {
	replace_prefix( $prefix );
}
