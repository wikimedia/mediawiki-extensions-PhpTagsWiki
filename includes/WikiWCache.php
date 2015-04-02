<?php
namespace PhpTagsObjects;

/**
 * The WikiWCache class manages the cache of page rendering.
 *
 * @author pastakhov
 */
class WikiWCache extends \PhpTags\GenericObject {

	/**
	 * Set a flag in this page indicating that the content is dynamic and shouldn't be cached.
	 */
	public static function s_disableCache() {
		\PhpTags\Runtime::disableParserCache();
	}

	/**
	 * Gets the number of seconds after which cache of this page should expire.
	 * @return int
	 */
	public static function q_cacheExpiry() {
		return \PhpTags\Runtime::$parser->getOutput()->getCacheExpiry();
	}

	/**
	 * Sets the number of seconds after which cache of this page should expire.
	 * @param int $value
	 */
	public static function d_cacheExpiry( $value ) {
		\PhpTags\Runtime::$parser->getOutput()->updateCacheExpiry( $value );
	}

	/**
	 * Gets time when this page was generated.
	 * @return string
	 */
	public static function c_CACHE_TIME_STRING() {
		return \PhpTags\Runtime::$parser->getOutput()->getCacheTime();
	}

	/**
	 * Gets time when this page was generated.
	 * @return \PhpTags\GenericObject
	 */
	public static function c_CACHE_TIME() {
		return \PhpTags\Hooks::getObjectWithValue(
				'DateTime',
				new \DateTime( self::c_CACHE_TIME_STRING() )
			);
	}

}
