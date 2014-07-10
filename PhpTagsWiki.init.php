<?php

class PhpTagsWikiInit {

	public static function initializeRuntime() {
		\PhpTags\Hooks::setObjects(
				array(
					'W' => 'WikiW',
					'WStats' => 'WikiWStats',
				)
			);
		return true;
	}

}
