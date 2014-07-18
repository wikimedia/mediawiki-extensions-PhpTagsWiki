<?php
namespace PhpTagsObjects;

/**
 * Description of WikiWTitle
 *
 * @author pastakhov
 */
class WikiWTitle extends \PhpTags\GenericObject {

	public function __toString() {
		return $this->toString();
	}

	public function toString() {
		return (string)  self::c_FULL_NAME( $this->name );
	}

	public function m___construct( $name, $namespace = null ) {
		$title = null;
		if ( $name instanceof \PhpTags\GenericObject ) {
			$value = $name->getValue();
			if ( $value instanceof \Title ) {
				$title = $value;
			} elseif ( $value instanceof \Category ) {
				$title = $value->getTitle();
			}
		} elseif ( true === is_string( $name ) && true === is_numeric( $namespace) ) {
			$title = \Title::newFromText( $name, $namespace );
		}

		if ( $title instanceof \Title ) {
			$this->value = $title;
			return true;
		}
		$this->value = null;
		return false;
	}

	public static function c_NS_TEXT( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getNsText();
	}

	public static function c_NS_NUMBER( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getNamespace();
	}

	public static function c_NAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getText();
	}

	public static function c_FULL_NAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getPrefixedText();
	}

	public static function c_BASE_NAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getBaseText();
	}

	public static function c_SUBPAGE_NAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getSubpageText();
	}

	public static function c_SUBJECT_NS_TEXT( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getSubjectNsText();
	}

	public static function c_TALK_NS_TEXT( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->getTalkNsText();
	}

	public static function c_IS_CONTENT_PAGE( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->isContentPage();
	}

	public static function c_IS_MOVABLE( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->isMovable();
	}

	public static function c_IS_MAIN_PAGE( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::getParser()->getTitle();
		}
		return $title->isMainPage();
	}

	public function p_nsText() {
		return self::c_NS_TEXT( $this->name, $this->value );
	}

	public function p_nsNumber() {
		return self::c_NS_NUMBER( $this->name, $this->value );
	}

	public function p_name() {
		return self::c_NAME( $this->name, $this->value );
	}

	public function p_fullName() {
		return self::c_FULL_NAME( $this->name, $this->value );
	}

	public function p_baseName() {
		return self::c_BASE_NAME( $this->name, $this->value );
	}

	public function p_subpageName() {
		return self::c_SUBPAGE_NAME( $this->name, $this->value );
	}

	public function p_subjectNsText() {
		return self::c_SUBJECT_NS_TEXT( $this->name, $this->value );
	}

	public function p_talkNsText() {
		return self::c_TALK_NS_TEXT( $this->name, $this->value );
	}

	public function p_isContentPage() {
		return self::c_IS_CONTENT_PAGE( $this->name, $this->value );
	}

	public function p_isMovable() {
		return self::c_IS_MOVABLE( $this->name, $this->value );
	}

	public function p_isMainPage() {
		return self::c_IS_MAIN_PAGE( $this->name, $this->value );
	}

}
