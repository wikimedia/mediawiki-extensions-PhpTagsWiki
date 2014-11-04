<?php
namespace PhpTags;

class PhpTagsWiki_Test extends \PHPUnit_Framework_TestCase {

	public function testRun_NS_FILE_constant() {
		$this->assertEquals(
				Runtime::runSource('echo NS_FILE;'),
				array(NS_FILE)
				);
	}

	public function testRun_NS_CATEGORY_constant() {
		$this->assertEquals(
				Runtime::runSource('echo NS_CATEGORY;'),
				array(NS_CATEGORY)
				);
	}

}
