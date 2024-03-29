<?php
namespace PhpTagsObjects;

use Category;
use PhpTags\GenericObject;
use PhpTags\HookException;
use PhpTags\Hooks;
use PhpTags\Renderer;
use Title;

/**
 * Description of WikiWPage
 *
 * @author pastakhov
 */
class WikiWPage extends GenericObject {

	/**
	 * Get the article ID for current page
	 * @return int
	 */
	public static function c_ID() {
		static $pageid = false;
		if ( $pageid === false ) {
			$pageid = Renderer::getParser()->getTitle()->getArticleID();
		}
		return $pageid;
	}

	public static function c_TITLE() {
		return Hooks::getObjectWithValue(
				'WTitle',
				Renderer::getParser()->getTitle()
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
		$parserOutput = Renderer::getParser()->getOutput();
		if ( method_exists( $parserOutput, 'getPageProperty' ) ) {
			// MW 1.38+
			return $parserOutput->getPageProperty( 'defaultsort' ) ?? false;
		}
		return $parserOutput->getProperty( 'defaultsort' );
	}

	/**
	 * Sets default category sort key
	 * @param string $value
	 */
	public static function d_defaultSortKey( $value ) {
		$parserOutput = Renderer::getParser()->getOutput();
		if ( method_exists( $parserOutput, 'setPageProperty' ) ) {
			// MW 1.38+
			return $parserOutput->setPageProperty( 'defaultsort', $value );
		}
		return $parserOutput->setProperty( 'defaultsort', $value );
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
			$titleCategory = Title::makeTitleSafe( NS_CATEGORY, $category );
		} else {
			$wcat = Hooks::createObject( [ $category ], 'WCategory' );
			if ( $wcat->value instanceof Category ) {
				$titleCategory = $wcat->value->getTitle();
			} else {
				$titleCategory = false;
				$category = '';
			}
		}
		if ( $titleCategory ) {
			$parserOutput = Renderer::getParser()->getOutput();
			if ( method_exists( $parserOutput, 'getPageProperty' ) ) {
				// MW 1.38+
				$defaultSort = $parserOutput->getPageProperty( 'defaultsort' ) ?? '';
			} else {
				$defaultSort = $parserOutput->getProperty( 'defaultsort' ) ?: '';
			}
			$parserOutput->addCategory( $titleCategory->getDBkey(), $sortkey === '' ? $defaultSort : $sortkey );
			return true;
		} else {
			throw new HookException( "'$category' is not a valid title!" );
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
