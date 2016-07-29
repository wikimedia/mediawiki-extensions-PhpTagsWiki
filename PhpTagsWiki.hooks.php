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
	 * Check on version compatibility
	 * @return boolean
	 */
	public static function onParserFirstCallInit() {
		$extRegistry = ExtensionRegistry::getInstance();
		$phpTagsLoaded = $extRegistry->isLoaded( 'PhpTags' );
		//if ( !$extRegistry->isLoaded( 'PhpTags' ) ) { use PHPTAGS_VERSION for backward compatibility
		if ( !($phpTagsLoaded || defined( 'PHPTAGS_VERSION' )) ) {
			throw new MWException( "\n\nYou need to have the PhpTags extension installed in order to use the PhpTags Wiki extension." );
		}
		if ( $phpTagsLoaded ) {
			$neededVersion = '5.8.0';
			$phpTagsVersion = $extRegistry->getAllThings()['PhpTags']['version'];
			if ( version_compare( $phpTagsVersion, $neededVersion, '<' ) ) {
				throw new MWException( "\n\nThis version of the PhpTags Wiki extension requires the PhpTags extension $neededVersion or above.\n You have $phpTagsVersion. Please update it." );
			}
		}
		if ( !$phpTagsLoaded || PHPTAGS_HOOK_RELEASE != 8 ) {
			throw new MWException( "\n\nThis version of the PhpTags Wiki extension is outdated and not compatible with current version of the PhpTags extension.\n Please update it." );
		}
		return true;
	}

	/**
	 *
	 * @return boolean
	 */
	public static function onPhpTagsRuntimeFirstInit() {
		global $wgCacheEpoch;

		$version = ExtensionRegistry::getInstance()->getAllThings()['PhpTags Wiki']['version'];
		\PhpTags\Hooks::addJsonFile( __DIR__ . '/PhpTagsWiki.json', $version );
		\PhpTags\Hooks::addCallbackConstantValues( 'PhpTagsWikiHooks::initializeConstants', $version . $wgCacheEpoch );
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
