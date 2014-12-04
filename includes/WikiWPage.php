<?php
namespace PhpTagsObjects;

/**
 * Description of WikiWPage
 *
 * @author pastakhov
 */
class WikiWPage extends \PhpTags\GenericObject {

	public function m___construct( $name = null ) {
		$this->value['name'] = $name;
	}

	public static function checkArguments( $object, $method, $arguments, $expects = false ) {
		switch ( $method ) {
			case '__construct':
				$expects = array(
					\PhpTags\Hooks::TYPE_MIXED,
					\PhpTags\Hooks::EXPECTS_MAXIMUM_PARAMETERS => 1,
				);
				break;
			case 'addcategory':
				$method = 'addCategory';
				$expects = array(
					\PhpTags\Hooks::TYPE_MIXED,
					\PhpTags\Hooks::EXPECTS_EXACTLY_PARAMETERS => 1,
				);
				break;
			}
		return parent::checkArguments( $object, $method, $arguments, $expects );
	}

	public static function q_ID() {
		$parser = \PhpTags\Runtime::getParser();
		$pageid = $parser->getTitle()->getArticleID();
		return $pageid;
	}

	public static function q_TITLE() {
		return \PhpTags\Hooks::getObjectWithValue(
				'WTitle',
				\PhpTags\Runtime::getParser()->getTitle()
			);
	}

	public function getTitle() {
		if ( true === isset( $this->value['title'] ) ) {
			return $this->value['title'];
		}

	}

	public static function q_DEFAULT_SORT_KEY() {
		$parser = \PhpTags\Runtime::getParser();
		return $parser->getCustomDefaultSort();
	}

	public static function d_DEFAULT_SORT_KEY( $value ) {
		$parser = \PhpTags\Runtime::getParser();
		return $parser->setDefaultSort( (string)$value );
	}

	public static function s_AddCategory( $category ) {
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
			$parser = \PhpTags\Runtime::getParser();
			$parser->getOutput()->addCategory( $titleCategory->getDBkey(), $parser->getDefaultSort() );
			return true;
		} else {
			\PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_EXCEPTION][] = new \PhpTags\HookException( \PhpTags\HookException::EXCEPTION_NOTICE, \PhpTags\Hooks::$objectName . "::addCategory() \"$category\" is not a valid title!" );
			return false;
		}
	}

}
