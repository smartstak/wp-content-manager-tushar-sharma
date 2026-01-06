<?php
/**
 * File that handles cache mechanism for Promo blocks.
 *
 * @package WPCM\Cache
 */

namespace WPCM\Cache;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * CacheManager class
 */
class CacheManager {

	/**
	 * Generate cache key
	 */
	public static function get_key(): string {
		return 'wpcm_promos_cache';
	}

	/**
	 * Get cached promos
	 */
	public static function get() {
		return get_transient( self::get_key() );
	}

	/**
	 * Set cache.
	 */
	public static function set( $data, int $ttl ): void {
		set_transient( self::get_key(), $data, $ttl );
	}

	/**
	 * Flush transient of promo blocks
	 *
	 * @return void
	 */
	public static function flush(): void {
		delete_transient( self::get_key() );
	}
}
