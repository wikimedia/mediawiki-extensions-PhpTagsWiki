<?php
namespace PhpTagsObjects;

/**
 * Description of WikiWTitleArray
 *
 * @author pastakhov
 */
class WikiWTitleArray extends \PhpTags\GenericObject implements \Countable, \Iterator {

	public function count() {
		$value = $this->value;
		if ( true === $value instanceof \TitleArrayFromResult ) {
			return $value->count();
		}
		return false;
	}

	public function current() {
		$value = $this->value;
		if ( true === $value instanceof \TitleArrayFromResult ) {
			$title = $value->current();
			return \PhpTags\Hooks::getObjectWithValue( 'WTitle', $title );
		}
		return false;
	}

	public function key() {
		$value = $this->value;
		if ( true === $value instanceof \TitleArrayFromResult ) {
			return $value->key();
		}
		return false;
	}

	public function next() {
		$value = $this->value;
		if ( true === $value instanceof \TitleArrayFromResult ) {
			return $value->next();
		}
	}

	public function rewind() {
		$value = $this->value;
		if ( true === $value instanceof \TitleArrayFromResult ) {
			return $value->rewind();
		}
	}

	public function valid() {
		$value = $this->value;
		if ( true === $value instanceof \TitleArrayFromResult ) {
			return $value->valid();
		}
		return false;
	}

//	public function m___construct( $WPage = null ) {
//	}

}
