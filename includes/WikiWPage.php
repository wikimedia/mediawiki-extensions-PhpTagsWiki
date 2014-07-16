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

	public static function c_ID() {
		$parser = \PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER];
		$pageid = $parser->getTitle()->getArticleID();
		return $pageid;
	}

	public static function c_TITLE() {
		return \PhpTags\Hooks::getObjectWithValue(
				'WTitle',
				\PhpTags\Runtime::$transit[PHPTAGS_TRANSIT_PARSER]->getTitle()
			);
	}

	public function getTitle() {
		if ( true === isset( $this->value['title'] ) ) {
			return $this->value['title'];
		}

	}

}

