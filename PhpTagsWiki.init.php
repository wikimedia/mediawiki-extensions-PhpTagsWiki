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
		// Add all defined namespace constants (that starts with 'NS_')
		//@todo cache it
		$phpConsts = get_defined_constants( true );
		$ns_keys = array_filter( array_keys( $phpConsts['user'] ), function( $key ){ return substr( $key, 0, 3 ) === "NS_"; } );
		$ns_consts = array_intersect_key( $phpConsts['user'], array_flip($ns_keys) );
		array_walk( $ns_consts, function(&$value){ $value = (int)$value; } ); // save NS_SQL_PASSWORD or NS_MY_CREDIT_CARD :)
		\PhpTags\Hooks::setConstantValues( $ns_consts );
		return true;
	}

}
