<?php
namespace PhpTagsObjects;

/**
 * Description of WikiWCategory
 *
 * @author pastakhov
 */
class WikiWCategory extends \PhpTags\GenericObject {

	public function __construct( $name, $value = null ) {
		if ( false === $value instanceof \Category ) {
			$value = null;
		}
		parent::__construct( $name, $value );
	}

		public function m___construct( $name = null ) {
		$category = null;
		if ( $name instanceof \PhpTags\GenericObject ) {
			$value = $name->getValue();
			if ( $value instanceof \Category ) {
				$category = $value;
			} elseif ( $value instanceof \Title && $value->inNamespace( NS_CATEGORY ) ) {
				$category = \Category::newFromTitle( $value );
			}
		} elseif ( true === is_string( $name ) ) {
			$category = \Category::newFromName( $name );
		}

		if ( $category instanceof \Category ) {
			$this->value = $category;
			return true;
		}
		$this->value = null;
		return false;
	}

	public function p_memberCount() {
		return $this->value->getPageCount();
	}

	public function p_pageCount() {
		$category = $this->value;
		$count = $category->getPageCount();
		$count -= $category->getSubcatCount();
		$count -= $category->getFileCount();
		return $count;
	}

	public function p_fileCount() {
		return $this->value->getFileCount();
	}

	public function p_subcatCount() {
		return $this->value->getSubcatCount();
	}

	public function p_name() {
		return $this->value->getName();
	}

	public function p_id() {
		return $this->value->getID();
	}

	public function p_title() {
		return \PhpTags\Hooks::getObjectWithValue( 'WTitle', $this->value->getTitle() );
	}

}
