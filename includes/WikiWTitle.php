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
		return (string)  self::c_FULLNAME( $this->name );
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

	public static function c_NSTEXT( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getNsText();
	}

	public static function c_NSNUMBER( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getNamespace();
	}

	public static function c_NAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getText();
	}

	public static function c_FULLNAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getPrefixedText();
	}

	public static function c_BASENAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getBaseText();
	}

	public static function c_SUBPAGENAME( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getSubpageText();
	}

	public static function c_SUBJECTNSTEXT( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getSubjectNsText();
	}

	public static function c_TALKNSTEXT( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->getTalkNsText();
	}

	public static function c_ISCONTENTPAGE( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->isContentPage();
	}

	public static function c_ISMOVABLE( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->isMovable();
	}

	public static function c_ISMAINPAGE( $objectName, $title = null ) {
		if ( false === $title instanceof \Title ) {
			$title = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle();
		}
		return $title->isMainPage();
	}

	public function p_nsText() {
		return self::c_NSTEXT( $this->name, $this->value );
	}

	public function p_nsNumber() {
		return self::c_NSNUMBER( $this->name, $this->value );
	}

	public function p_name() {
		return self::c_NAME( $this->name, $this->value );
	}

	public function p_fullName() {
		return self::c_FULLNAME( $this->name, $this->value );
	}

	public function p_baseName() {
		return self::c_BASENAME( $this->name, $this->value );
	}

	public function p_subpageName() {
		return self::c_SUBPAGENAME( $this->name, $this->value );
	}

	public function p_subjectNsText() {
		return self::c_SUBJECTNSTEXT( $this->name, $this->value );
	}

	public function p_talkNsText() {
		return self::c_TALKNSTEXT( $this->name, $this->value );
	}

	public function p_isContentPage() {
		return self::c_ISCONTENTPAGE( $this->name, $this->value );
	}

	public function p_isMovable() {
		return self::c_ISMOVABLE( $this->name, $this->value );
	}

	public function p_isMainPage() {
		return self::c_ISMAINPAGE( $this->name, $this->value );
	}

}
