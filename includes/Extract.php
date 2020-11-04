<?php
namespace PhpTagsWiki;

use ConfigException;
use Exception;
use MediaWiki\MediaWikiServices;
use MWDebug;
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
	public static function saveExtract( Title $title ) {
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
	private static function getExtract( Title $title ) {
		global $wgParser;
		try {
			$page = WikiPage::factory( $title );
			$publicContent = $page->getContent( Revision::FOR_PUBLIC );
			if ( $publicContent instanceof WikitextContent ) {
				$options = ParserOptions::newCanonical( 'canonical' );
				$freshParser = $wgParser->getFreshParser();
				$config = MediaWikiServices::getInstance()->getMainConfig();
				$extractAnything = $config->get( 'PhpTagsWikiExtractAnything' );
				try {
					$extractsRemoveClasses = $config->get( 'ExtractsRemoveClasses' );
				} catch ( ConfigException $exception ) {
					MWDebug::warning( $exception->getMessage() );
					$extractsRemoveClasses = '';
				}
				$sectionId = 0;
				$extractedText = '';
				do {
					$wikitext = $freshParser->getSection( $publicContent->getText(), $sectionId, '<#NoSections#>' );
					if ( $sectionId !== 0 && $wikitext === '<#NoSections#>' ) {
						break;
					}
					if ( $wikitext ) {
						if ( $sectionId > 0 ) {
							// remove headers
							$wikitext = preg_replace( '/^(=+).*\1\s*$/m', '', $wikitext );
						}
						$parserOutput = $freshParser->parse( $wikitext, $title, $options );
						$text = $parserOutput->getText( [ 'unwrap' => true ] );
						if ( $text ) {
							$fmt = new ExtractFormatter( $text, true );
							$fmt->remove( $extractsRemoveClasses );
							$extractedText = trim( $fmt->getText() );
						}
					}
					$sectionId++;
				} while( !$extractedText && $extractAnything );
				// Remove new line chars and double spaces
				return $extractedText ? preg_replace( '/\s+/', ' ', $extractedText ) : '';
			}
		} catch ( Exception $exception ) {
			MWDebug::warning( $exception->getMessage() );
		}
		return '';
	}
}
