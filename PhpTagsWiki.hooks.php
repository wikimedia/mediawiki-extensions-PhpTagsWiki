<?php


/**
 * PhpTags Wiki MediaWiki Hooks.
 *
 * @file PhpTagsWiki.hooks.php
 * @ingroup PhpTags
 * @author Pavel Astakhov <pastakhov@yandex.ru>
 * @licence GNU General Public Licence 2.0 or later
 */
class PhpTagsWikiHooks {

	/**
	 *
	 * @return boolean
	 */
	public static function onParserFirstCallInit() {
		if ( !defined( 'PHPTAGS_VERSION' ) ) {
			throw new MWException( "\n\nYou need to have the PhpTags extension installed in order to use the PhpTags Functions extension." );
		}
		$needVersion = '5.1.0';
		if ( version_compare( PHPTAGS_VERSION, $needVersion, '<' ) ) {
			throw new MWException( "\n\nThis version of the PhpTags Functions extension requires the PhpTags extension $needVersion or above.\n You have " . PHPTAGS_VERSION . ". Please update it." );
		}
		if ( PHPTAGS_HOOK_RELEASE != 8 ) {
			throw new MWException( "\n\nThis version of the PhpTags Functions extension is outdated and not compatible with current version of the PhpTags extension.\n Please update it." );
		}
		return true;
	}

	/**
	 *
	 * @return boolean
	 */
	public static function onPhpTagsRuntimeFirstInit() {
		global $wgCacheEpoch;

		\PhpTags\Hooks::addJsonFile( __DIR__ . '/PhpTagsWiki.json', PHPTAGS_WIKI_VERSION );
		\PhpTags\Hooks::addCallbackConstantValues( 'PhpTagsWikiHooks::initializeConstants', PHPTAGS_WIKI_VERSION . $wgCacheEpoch );

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

	/**
	 *
	 * @param array $files
	 * @return boolean
	 */
	public static function onUnitTestsList( &$files ) {
		$testDir = __DIR__ . '/tests/phpunit';
		$files = array_merge( $files, glob( "$testDir/*Test.php" ) );
		return true;
	}

}
