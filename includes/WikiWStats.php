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

	public static function c_ACTIVE_USERS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::activeUsers();
		}
		return $value;
	}

	public static function c_ADMINS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::numberingroup( 'sysop' );
		}
		return $value;
	}

	public static function c_ARTICLES() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::articles();
		}
		return $value;
	}

	public static function c_EDITS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::edits();
		}
		return $value;
	}

	public static function c_FILES() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::images();
		}
		return $value;
	}

	public static function c_PAGES() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::pages();
		}
		return $value;
	}

	public static function c_USERS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::users();
		}
		return $value;
	}

	public static function c_JOBS() {
		static $value = false;
		if ( $value === false ) {
			$value = (int)\SiteStats::jobs();
		}
		return $value;
	}

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_ACTIVE_USERS() { return self::c_ACTIVE_USERS(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_ADMINS() { return self::c_ADMINS(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_ARTICLES() { return self::c_ARTICLES(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_EDITS() { return self::c_EDITS(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_FILES() { return self::c_FILES(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_JOBS() { return self::c_JOBS(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_PAGES() { return self::c_PAGES(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_USERS() { return self::c_USERS(); }

	/**
	 * @deprecated since version 2.0.0
	 */
	public static function q_VIEWS() {
		static $value = false;
		if ( $value === false ) {
			$value = $GLOBALS['wgDisableCounters'] ? (int)\SiteStats::views() : null;
		}
		return $value;
	}

}
