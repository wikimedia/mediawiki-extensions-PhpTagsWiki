<?php
namespace PhpTagsObjects;

/**
 * Static accessor class for site_stats and related things
 *
 * @author pastakhov
 */
class WikiWStats extends \PhpTags\GenericObject {

	/* @todo
	 * pagesInCategory()
	 * pagesInNamespace()
	 * usersInGroup()
	 *
	 */

	public static function q_ACTIVE_USERS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::activeUsers();
		}
		return $value;
	}

	public static function q_ADMINS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::numberingroup( 'sysop' );
		}
		return $value;
	}

	public static function q_ARTICLES() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::articles();
		}
		return $value;
	}

	public static function q_EDITS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::edits();
		}
		return $value;
	}

	public static function q_FILES() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::images();
		}
		return $value;
	}

	public static function q_PAGES() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::pages();
		}
		return $value;
	}

	public static function q_USERS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::users();
		}
		return $value;
	}

	public static function q_VIEWS() {
		static $value = false;
		if ( $value === false ) {
			$value = $GLOBALS['wgDisableCounters'] ? (int)\SiteStats::views() : null;
		}
		return $value;
	}

	public static function q_JOBS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::jobs();
		}
		return $value;
	}

}
