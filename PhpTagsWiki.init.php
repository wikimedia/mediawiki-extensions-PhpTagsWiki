<?php

class PhpTagsWikiInit {

	public static function initializeRuntime() {
		\PhpTags\Hooks::setObjects(
				array(
					'W'				=> 'WikiW',
					'WCache'		=> 'WikiWCache',
					'WCategory'		=> 'WikiWCategory',
					'WPage'			=> 'WikiWPage',
					'WStats'		=> 'WikiWStats',
					'WTitle'		=> 'WikiWTitle',
					'WTitleArray'	=> 'WikiWTitleArray',
				)
			);

		return true;
	}

}
