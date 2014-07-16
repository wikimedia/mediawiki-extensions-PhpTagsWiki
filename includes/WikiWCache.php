<?php
namespace PhpTagsObjects;

/**
 * Description of WikiWCache
 *
 * @author pastakhov
 */
class WikiWCache extends \PhpTags\GenericObject {

	public static function checkArguments( $object, $method, $arguments, $expects = false ) {
		switch ( $method ) {
			case 'updateCacheExpiry':
				$expects = array(
					\PhpTags\Hooks::TYPE_NUMBER,
					\PhpTags\Hooks::EXPECTS_EXACTLY_PARAMETERS => 1,
				);
				break;
			case 'disableCache':
				$expects = array(
					\PhpTags\Hooks::EXPECTS_EXACTLY_PARAMETERS => 0,
				);
				break;
		}
		return parent::checkArguments( $object, $method, $arguments, $expects );
	}

	/**
	 * Get Parser from $transit variable
	 * @return \Parser
	 */
	private static function getParser() {
		return \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER];
	}

	public static function s_updateCacheExpiry( $seconds ) {
		return self::getParser()->getOutput()->updateCacheExpiry( $seconds );
	}

	public static function s_disableCache() {
		global $wgOut;
		self::getParser()->disableCache();
		$wgOut->enableClientCache( false );
	}

	public static function c_CACHEEXPIRY() {
		return self::getParser()->getOutput()->getCacheExpiry();
	}

	public static function c_CACHETIMESTRING() {
		return self::getParser()->getOutput()->getCacheTime();
	}

	public static function c_CACHETIME() {
		return \PhpTags\Hooks::getObjectWithValue(
				'DateTime',
				new \DateTime( self::c_CACHETIMESTRING() )
			);
	}

}

