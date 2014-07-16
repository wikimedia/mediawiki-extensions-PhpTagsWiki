<?php

class PhpTagsWikiInit {

	public static function initializeRuntime() {
		\PhpTags\Hooks::setObjects(
				array(
					'W' => 'WikiW',
					'WCache' => 'WikiWCache',
					'WPage' => 'WikiWPage',
					'WStats' => 'WikiWStats',
					'WTitle' => 'WikiWTitle',
				)
			);

		return true;
	}

}
