<?php
/**
 * Main entry point for the PhpTags Wiki extension.
 *
 * @link https://www.mediawiki.org/wiki/Extension:PhpTags_Wiki Documentation
 * @file PhpTagsFunctions.php
 * @defgroup PhpTags
 * @ingroup Extensions
 * @author Pavel Astakhov <pastakhov@yandex.ru>
 * @licence GNU General Public Licence 2.0 or later
 */

// Check to see if we are being called as an extension or directly
if ( !defined('MEDIAWIKI') ) {
	die( 'This file is an extension to MediaWiki and thus not a valid entry point.' );
}

if ( !defined( 'PHPTAGS_VERSION' ) ) {
	die( 'ERROR: The <a href="https://www.mediawiki.org/wiki/Extension:PhpTags">extension PhpTags</a> must be installed for the extension PhpTags Wiki to run!' );
}

$needVersion = '2.6.2';
if ( version_compare( PHPTAGS_VERSION, $needVersion, '<' ) ) {
	die(
		'<b>Error:</b> This version of extension PhpTags Wiki needs <a href="https://www.mediawiki.org/wiki/Extension:PhpTags">PhpTags</a> ' . $needVersion . ' or later.
		You are currently using version ' . PHPTAGS_VERSION . '.<br />'
	);
}

if ( PHPTAGS_HOOK_RELEASE != 4 ) {
	die (
			'<b>Error:</b> This version of extension PhpTags Wiki is not compatible to current version of extension PhpTags.'
	);
}

define( 'PHPTAGS_WIKI_VERSION' , '1.3.0' );

// Register this extension on Special:Version
$wgExtensionCredits['phptags'][] = array(
	'path'				=> __FILE__,
	'name'				=> 'PhpTags Wiki',
	'version'			=> PHPTAGS_WIKI_VERSION,
	'url'				=> 'https://www.mediawiki.org/wiki/Extension:PhpTags_Wiki',
	'author'			=> '[https://www.mediawiki.org/wiki/User:Pastakhov Pavel Astakhov]',
	'descriptionmsg'	=> 'phptagswiki-desc'
);

// Allow translations for this extension
$wgMessagesDirs['PhpTagsWiki'] =			__DIR__ . '/i18n';
$wgExtensionMessagesFiles['PhpTagsWiki'] =	__DIR__ . '/PhpTagsWiki.i18n.php';

// Specify the function that will initialize the parser function.
/**
 * @codeCoverageIgnore
 */
$wgHooks['PhpTagsRuntimeFirstInit'][] = 'PhpTagsWikiInit::initializeRuntime';

// Preparing classes for autoloading
$wgAutoloadClasses['PhpTagsWikiInit']	= __DIR__ . '/PhpTagsWiki.init.php';

$wgAutoloadClasses['PhpTagsObjects\\WikiW']				= __DIR__ . '/includes/WikiW.php';
$wgAutoloadClasses['PhpTagsObjects\\WikiWCache']		= __DIR__ . '/includes/WikiWCache.php';
$wgAutoloadClasses['PhpTagsObjects\\WikiWCategory']		= __DIR__ . '/includes/WikiWCategory.php';
$wgAutoloadClasses['PhpTagsObjects\\WikiWPage']			= __DIR__ . '/includes/WikiWPage.php';
$wgAutoloadClasses['PhpTagsObjects\\WikiWStats']		= __DIR__ . '/includes/WikiWStats.php';
$wgAutoloadClasses['PhpTagsObjects\\WikiWTitle']		= __DIR__ . '/includes/WikiWTitle.php';
$wgAutoloadClasses['PhpTagsObjects\\WikiWTitleArray']	= __DIR__ . '/includes/WikiWTitleArray.php';

/**
 * Add files to phpunit test
 * @codeCoverageIgnore
 */
$wgHooks['UnitTestsList'][] = function ( &$files ) {
	$testDir = __DIR__ . '/tests/phpunit';
	$files = array_merge( $files, glob( "$testDir/*Test.php" ) );
	return true;
};

$wgParserTestFiles[] = __DIR__ . '/tests/parser/PhpTagsWikiTests.txt';
