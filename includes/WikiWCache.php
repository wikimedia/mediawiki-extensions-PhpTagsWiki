<?php
namespace PhpTagsObjects;

/**
 * The WikiWCache class manages the cache of page rendering.
 *
 * @author pastakhov
 */
class WikiWCache extends \PhpTags\GenericObject {

	public static function checkArguments( $object, $method, $arguments, $expects = false ) {
		switch ( $method ) {
			case 'updatecacheexpiry':
				$method = 'updateCacheExpiry';
				$expects = array(
					\PhpTags\Hooks::TYPE_NUMBER,
					\PhpTags\Hooks::EXPECTS_EXACTLY_PARAMETERS => 1,
				);
				break;
			case 'disablecache':
				$method = 'disableCache';
				$expects = array(
					\PhpTags\Hooks::EXPECTS_EXACTLY_PARAMETERS => 0,
				);
				break;
		}
		return parent::checkArguments( $object, $method, $arguments, $expects );
	}

	public static function s_updateCacheExpiry( $seconds ) {
		return \PhpTags\Runtime::getParser()->getOutput()->updateCacheExpiry( $seconds );
	}

	public static function s_disableCache() {
		\PhpTags\Runtime::disableParserCache();
	}

	public static function c_CACHE_EXPIRY() {
		return \PhpTags\Runtime::getParser()->getOutput()->getCacheExpiry();
	}

	public static function c_CACHE_TIME_STRING() {
		return \PhpTags\Runtime::getParser()->getOutput()->getCacheTime();
	}

	public static function c_CACHE_TIME() {
		return \PhpTags\Hooks::getObjectWithValue(
				'DateTime',
				new \DateTime( self::c_CACHE_TIME_STRING() )
			);
	}

}

