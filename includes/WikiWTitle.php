<?php
namespace PhpTagsObjects;

use Category;
use MWNamespace;
use PageImages;
use PhpTags\GenericObject;
use PhpTags\HookException as PhpTagsHookException;
use PhpTags\Hooks as PhpTagsHooks;
use PhpTags\Renderer;
use PhpTags\Runtime as PhpTagsRuntime;
use Title;

/**
 * Description of WikiWTitle
 *
 * @author pastakhov
 */
class WikiWTitle extends GenericObject {

	/**
	 * Returns Parser Title object
	 * @return Title
	 */
	private static function getParserTitle() {
		return Renderer::getParser()->getTitle();
	}

	public function __toString() {
		return $this->toString();
	}

	public function toString() {
		return $this->p_fullName();
	}

	public function m___construct( $name, $namespace = NS_MAIN, $fragment = '' ) {
		$title = null;
		if ( $name instanceof GenericObject ) {
			$value = $name->getValue();
			if ( $value instanceof Title ) {
				$title = $value;
			} elseif ( $value instanceof Category ) {
				$title = $value->getTitle();
			}
		} elseif ( is_string( $name ) && is_numeric( $namespace) ) {
			$title = Title::newFromText( $name, $namespace );
		} elseif ( is_numeric( $name ) && $name > 0 ) {
			$title = Title::newFromID( $name );
		}

		if ( $title instanceof Title ) {
			if ( $fragment ) {
				$title = Title::makeTitleSafe( $title->getNamespace(), $title->getDBkey(), $fragment );
			}
			$this->value = $title;
			return true;
		}
		$this->value = null;
		return false;
	}

	public function m_fullUrl( $query = [] ) {
		$title = $this->value;
		if ( $title instanceof Title ) {
			return $title->getInternalURL( $query );
		}
	}

	public static function c_NS_TEXT( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getNsText();
	}

	public static function c_NS_NUMBER( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getNamespace();
	}

	public static function c_NAME( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getText();
	}

	/**
	 * Alias of Magic word {{FULLPAGENAME}}
	 * @param type $title
	 * @return type
	 */
	public static function c_FULL_NAME( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getPrefixedText();
	}

	public static function c_BASE_NAME( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getBaseText();
	}

	public static function c_SUBPAGE_NAME( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getSubpageText();
	}

	public static function c_ROOT_NAME( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getRootText();
	}

	public static function c_SUBJECT_NS_TEXT( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getSubjectNsText();
	}

	public static function c_SUBJECT_NS_NUMBER( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		$namespace = $title->getNamespace();
		return MWNamespace::getSubject( $namespace );
	}

	public static function c_TALK_NS_TEXT( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getTalkNsText();
	}

	public static function c_TALK_NS_NUMBER( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		$namespace = $title->getNamespace();
		return MWNamespace::getTalk( $namespace );
	}

	public static function c_IS_CONTENT_PAGE( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->isContentPage();
	}

	public static function c_IS_MOVABLE( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->isMovable();
	}

	public static function c_IS_MAIN_PAGE( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->isMainPage();
	}

	public static function c_ID( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getArticleID();
	}

	public static function c_DB_KEY( $title = null ) {
		if ( false === $title instanceof Title ) {
			$title = self::getParserTitle();
		}
		return $title->getDBkey();
	}

	public function p_nsText() {
		return self::c_NS_TEXT( $this->value );
	}

	public function p_nsNumber() {
		return self::c_NS_NUMBER( $this->value );
	}

	public function p_name() {
		return self::c_NAME( $this->value );
	}

	public function p_fullName() {
		return self::c_FULL_NAME( $this->value );
	}

	public function p_baseName() {
		return self::c_BASE_NAME( $this->value );
	}

	public function p_subpageName() {
		return self::c_SUBPAGE_NAME( $this->value );
	}

	public function p_rootName() {
		return self::c_ROOT_NAME( $this->value );
	}

	public function p_subjectNsText() {
		return self::c_SUBJECT_NS_TEXT( $this->value );
	}

	public function p_subjectNsNumber() {
		return self::c_SUBJECT_NS_NUMBER( $this->value );
	}

	public function p_talkNsText() {
		return self::c_TALK_NS_TEXT( $this->value );
	}

	public function p_talkNsNumber() {
		return self::c_TALK_NS_NUMBER( $this->value );
	}

	public function p_isContentPage() {
		return self::c_IS_CONTENT_PAGE( $this->value );
	}

	public function p_isMovable() {
		return self::c_IS_MOVABLE( $this->value );
	}

	public function p_isMainPage() {
		return self::c_IS_MAIN_PAGE( $this->value );
	}

	public function p_ID() {
		return self::c_ID( $this->value );
	}

	public function p_DBKey() {
		return self::c_DB_KEY( $this->value );
	}

	public function p_pageImage() {
		$title = $this->value;
		if ( $title instanceof Title ) {
			if ( !class_exists( 'PageImages' ) ) {
				PhpTagsRuntime::pushException( new PhpTagsHookException( 'The PageImages extension is not installed' ) );
				return null;
			}
			$file = PageImages::getPageImage( $title );
			if ( !$file ) {
				return null;
			}
			return $file->getTitle()->getFullText();
		}
	}

	public function m_getPageImage() {
		$file = $this->p_pageImage();
		if ( !$file ) {
			return $file;
		}
		return PhpTagsHooks::getObjectWithValue(
			'WidgetImage',
			$file
		);
	}

}
