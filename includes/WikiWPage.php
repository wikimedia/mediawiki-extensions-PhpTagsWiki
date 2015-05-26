<?php
namespace PhpTagsObjects;

/**
 * Description of WikiWPage
 *
 * @author pastakhov
 */
class WikiWPage extends \PhpTags\GenericObject {

	/**
	 * Get the article ID for current page
	 * @return int
	 */
	public static function c_ID() {
		static $pageid = false;
		if ( $pageid === false ) {
			$pageid = \PhpTags\Renderer::getParser()->getTitle()->getArticleID();
		}
		return $pageid;
	}

	public static function c_TITLE() {
		return \PhpTags\Hooks::getObjectWithValue(
				'WTitle',
				\PhpTags\Renderer::getParser()->getTitle()
			);
	}

	public function getTitle() {
		if ( true === isset( $this->value['title'] ) ) {
			return $this->value['title'];
		}
	}

	/**
	 * Gets default category sort key
	 * @return string
	 */
	public static function q_defaultSortKey() {
		return \PhpTags\Renderer::getParser()->getCustomDefaultSort();
	}

	/**
	 * Sets default category sort key
	 * @param string $value
	 */
	public static function d_defaultSortKey( $value ) {
		\PhpTags\Renderer::getParser()->setDefaultSort( $value );
	}

	public static function s_addCategory( $category, $sortkey = '' ) {
		if ( is_array( $category ) ) {
			$return = true;
			foreach ( $category as $c ) {
				$return = self::s_addCategory( $c ) && $return;
			}
			return $return;
		}

		if ( is_string( $category ) ) {
			$titleCategory = \Title::makeTitleSafe( NS_CATEGORY, $category );
		} else {
			$wcat = \PhpTags\Hooks::createObject( array($category), 'WCategory' );
			if ( $wcat->value instanceof \Category ) {
				$titleCategory = $wcat->value->getTitle();
			} else {
				$titleCategory = false;
				$category = '';
			}
		}
		if ( $titleCategory ) {
			$parser = \PhpTags\Renderer::getParser();
			$parser->getOutput()->addCategory( $titleCategory->getDBkey(), $sortkey === '' ? $parser->getDefaultSort() : $sortkey );
			return true;
		} else {
			throw new \PhpTags\HookException( "'$category' is not a valid title!" );
		}
	}

	/**
	 * @deprecated since version 1.6.0
	 */
	public static function q_DEFAULT_SORT_KEY() {
		return self::q_defaultSortKey();
	}

	/**
	 * @deprecated since version 1.6.0
	 */
	public static function d_DEFAULT_SORT_KEY( $value ) {
		self::d_defaultSortKey( $value );
	}

}
