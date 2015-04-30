<?php

class PhpTagsWikiInit {

	public static function initializeRuntime() {
		global $wgCacheEpoch;

		\PhpTags\Hooks::addJsonFile( __DIR__ . '/PhpTagsWiki.json' );
		\PhpTags\Hooks::addCallbackConstantValues( 'PhpTagsWikiInit::initializeConstants', $wgCacheEpoch );

		return true;
	}

	public static function initializeConstants() {
		// Add all defined namespace constants, which either
		// start with 'NS_' or have '_NS_' in their names
		$phpConstants = get_defined_constants( true );
		$nsConstants = array();
		foreach ( $phpConstants['user'] as $key => $value ) {
			if ( !is_int( $value ) ) {
				continue;
			}
			$pos = strpos( $key, 'NS_' );
			if ( $pos === false || ( $pos > 0 && $key[$pos - 1] !== '_' ) ) {
				continue;
			}
			$nsConstants[$key] = $value;
		}
		return $nsConstants;
	}

}
