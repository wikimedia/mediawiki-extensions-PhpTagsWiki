<?php
namespace PhpTagsWiki;

use ConfigException;
use Exception;
use MediaWiki\MediaWikiServices;
use MWDebug;
use ParserOptions;
use TextExtracts\ExtractFormatter;
use Title;
use Wikimedia\Rdbms\DBQueryError;
use WikiPage;
use WikitextContent;

class Extractor {

	/**
	 * Update extracted text in the database for title
	 * @param Title $title
	 */
	public static function update( Title $title ) {
		$pageId = $title->getArticleID();
		if ( $pageId <= 0 ) {
			return;
		}

		$extractedText = self::extract( $title );

		$timestamp = wfTimestampNow();
		$db = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_PRIMARY );
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
	 * Extracts text from title
	 * @param Title $title
	 * @return string
	 */
	private static function extract( Title $title ) {
		try {
			if ( method_exists( MediaWikiServices::class, 'getWikiPageFactory' ) ) {
				// MW 1.36+
				$page = MediaWikiServices::getInstance()->getWikiPageFactory()->newFromTitle( $title );
			} else {
				$page = WikiPage::factory( $title );
			}
			$publicContent = $page->getContent( RevisionRecord::FOR_PUBLIC );
			if ( $publicContent instanceof WikitextContent ) {
				$options = ParserOptions::newFromAnon();
				$freshParser = MediaWikiServices::getInstance()->getParserFactory()->getInstance();
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

	/**
	 * Select extracted text from the database
	 * @param int $pageId
	 * @return string|null
	 */
	public static function get( int $pageId ): ?string {
		$db = MediaWikiServices::getInstance()->getDBLoadBalancer()->getConnection( DB_REPLICA );
		try {
			$return = $db->selectField(
				'phptagswiki_info',
				'ptw_extract_plain',
				[ 'ptw_page_id' => $pageId ],
				__METHOD__
			);
		} catch ( DBQueryError $exception ) {
			MWDebug::warning( $exception->getMessage() );
			$return = null;
		}
		return $return ?: '';
	}
}
