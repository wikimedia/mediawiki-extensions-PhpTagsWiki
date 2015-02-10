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
			$pageid = \PhpTags\Runtime::$parser->getTitle()->getArticleID();
		}
		return $pageid;
	}

	public static function c_TITLE() {
		return \PhpTags\Hooks::getObjectWithValue(
				'WTitle',
				\PhpTags\Runtime::$parser->getTitle()
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
		return \PhpTags\Runtime::$parser->getCustomDefaultSort();
	}

	/**
	 * Sets default category sort key
	 * @param string $value
	 */
	public static function d_defaultSortKey( $value ) {
		\PhpTags\Runtime::$parser->setDefaultSort( $value );
	}

	public static function s_AddCategory( $category, $sortkey = '' ) {
		if ( is_array( $category ) ) {
			$return = true;
			foreach ( $category as $c ) {
				$return = self::s_AddCategory( $c ) && $return;
			}
			return $return;
		}

		if ( is_string( $category ) ) {
			$titleCategory = \Title::makeTitleSafe( NS_CATEGORY, $category );
		} else {
			$wcat = \PhpTags\Hooks::createObject( array($category), 'WCategory' );
			if ( $wcat && $wcat->value instanceof \Category ) {
				$titleCategory = $wcat->value->getTitle();
			} else {
				$titleCategory = false;
				$category = '';
			}
		}
		if ( $titleCategory ) {
			$parser = \PhpTags\Runtime::$parser;
			$parser->getOutput()->addCategory( $titleCategory->getDBkey(), $sortkey === '' ? $parser->getDefaultSort() : $sortkey );
			return true;
		} else {
			\PhpTags\Runtime::pushException( new \PhpTags\HookException( \PhpTags\HookException::EXCEPTION_NOTICE, \PhpTags\Hooks::$objectName . "::addCategory() \"$category\" is not a valid title!" ) );
			return false;
		}
	}

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_ID() {
		return self::c_ID();
	}

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_TITLE() {
		return self::c_TITLE();
	}

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_DEFAULT_SORT_KEY() {
		return self::q_defaultSortKey();
	}

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function d_DEFAULT_SORT_KEY( $value ) {
		self::d_defaultSortKey( $value );
	}

}
