<?php
/**
 * Flush Promos Cache CLI Command class file.
 * 
 * @package WPCM\CLI
 */

namespace WPCM\CLI;

if( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if acessed directly
}

use WP_CLI;
use WPCM\Cache\CacheManager;

/**
 * FlushPromosCacheCommand class
 */
class FlushPromosCacheCommand {
    /**
     * Custom WP_CLI command to flush promos cache
     *
     * ## EXAMPLES
     *
     *  wp wpcm flush-promos-cache
     *
     * @when after_wp_load
     */
    public function __invoke( $args, $assoc_args ) {
        CacheManager::flush();
        WP_CLI::success( 'Promos Block cache flushed successfully.' );
    }
}
