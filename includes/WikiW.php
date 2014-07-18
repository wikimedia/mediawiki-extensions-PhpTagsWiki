<?php
namespace PhpTagsObjects;

/**
 * Description of WikiW
 *
 * @author pastakhov
 */
class WikiW extends \PhpTags\GenericObject {

	public static function c_CONTENT_LANGUAGE() {
		return $GLOBALS['wgLanguageCode'];
	}

	public static function c_CURRENT_VERSION() {
		static $value = false;
		if ( $value === false ) {
			$value = \SpecialVersion::getVersion();
		}
		return $value;
	}

	public static function c_SCRIPT_PATH() {
		return $GLOBALS['wgScriptPath'];
	}

	public static function c_SERVER() {
		return $GLOBALS['wgServer'];
	}

	public static function c_SERVER_NAME() {
		global $wgServer;
		$serverParts = \wfParseUrl( $wgServer );
		return $serverParts && isset( $serverParts['host'] ) ? $serverParts['host'] : $wgServer;
	}

	public static function c_SITE_NAME() {
		return $GLOBALS['wgSitename'];
	}

	public static function c_STYLE_PATH() {
		return $GLOBALS['wgStylePath'];
	}

}

