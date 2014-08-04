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

}

