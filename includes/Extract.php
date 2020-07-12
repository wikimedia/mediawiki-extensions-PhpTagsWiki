<?php
namespace PhpTagsWiki;

use ConfigException;
use Exception;
use MediaWiki\MediaWikiServices;
use MWDebug;
use MWException;
use ParserOptions;
use Revision;
use TextExtracts\ExtractFormatter;
use Title;
use WikiPage;
use WikitextContent;

class Extract {

	/**
	 * @param Title $title
	 */
	public static function saveExtract( $title ) {
		$pageId = $title->getArticleID();
		if ( $pageId <= 0 ) {
			return;
		}

		$extractedText = self::getExtract( $title );

		$timestamp = wfTimestampNow();
		$db = wfGetDB( DB_MASTER );
		$index = [
			'ptw_page_id' => $pageId,
		];
		$set = [
			'ptw_timestamp' => $timestamp,
			'ptw_extract_plain' => $extractedText ?: null,
		];
		try {
			$db->upsert( 'phptagswiki_info', [ $index + $set ], [ 'ptw_page_id' ], $set, __METHOD__ );
		} catch ( Exception $ex ) {
			MWDebug::warning( $ex->getMessage() );
		}
	}

	/**
	 * @param Title $title
	 * @return string
	 */
	private static function getExtract( $title ) {
		global $wgParser;
		try {
			$page = WikiPage::factory( $title );
			$publicContent = $page->getContent( Revision::FOR_PUBLIC );
			if ( $publicContent instanceof WikitextContent ) {
				$options = ParserOptions::newCanonical( 'canonical' );
				$freshParser = $wgParser->getFreshParser();
				$wikitext = $freshParser->getSection( $publicContent->getText(), 0 );
				$parserOutput = $freshParser->parse( $wikitext, $title, $options );
				$text = $parserOutput->getText();
				$wrapperClass = $parserOutput->getWrapperDivClass();
				$str = "<div class=\"$wrapperClass\">";
				if ( strncmp( $text, $str, strlen( $str ) ) === 0 ) {
					$text = substr( $text, strlen( $str ) );
					$text = substr( $text, 0, -strlen( '</div>' ) );
				}

				$config = MediaWikiServices::getInstance()->getMainConfig();
				try {
					$extractsRemoveClasses = $config->get( 'ExtractsRemoveClasses' );
				} catch ( ConfigException $exception ) {
					MWDebug::warning( $exception->getMessage() );
					$extractsRemoveClasses = '';
				}
				$fmt = new ExtractFormatter( $text, true );
				$fmt->remove( $extractsRemoveClasses );
				$extractedText = trim( $fmt->getText() );
				return $extractedText;
			}
		} catch ( MWException $exception ) {
			MWDebug::warning( $exception->getText() );
		}
		return '';
	}

}
