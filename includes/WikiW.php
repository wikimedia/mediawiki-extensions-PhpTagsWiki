<?php
namespace PhpTagsObjects;

/**
 * Description of WikiW
 *
 * @author pastakhov
 */
class WikiW extends \PhpTags\GenericObject {

	public static function c_CONTENTLANGUAGE() {
		return $GLOBALS['wgLanguageCode'];
	}

	public static function c_CURRENTVERSION() {
		static $value = false;
		if ( $value === false ) {
			$value = \SpecialVersion::getVersion();
		}
		return $value;
	}

	public static function c_SCRIPTPATH() {
		return $GLOBALS['wgScriptPath'];
	}

	public static function c_SERVER() {
		return $GLOBALS['wgServer'];
	}

	public static function c_SERVERNAME() {
		global $wgServer;
		$serverParts = \wfParseUrl( $wgServer );
		return $serverParts && isset( $serverParts['host'] ) ? $serverParts['host'] : $wgServer;
	}

	public static function c_SITENAME() {
		return $GLOBALS['wgSitename'];
	}

	public static function c_STYLEPATH() {
		return $GLOBALS['wgStylePath'];
	}

}

