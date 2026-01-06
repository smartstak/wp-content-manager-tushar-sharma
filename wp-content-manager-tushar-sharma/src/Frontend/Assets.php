<?php
/**
 * Enqueue frontend assests files.
 *
 * @package WPCM\Frontend
 */

namespace WPCM\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Frontend Assets class
 */
class Assets {

    /**
     * Constructor method
     */
    public function __construct() {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    /**
     * Enqueue frontend scripts and styles
     *
     * @return void
     */
    public function enqueue_scripts(): void {
        wp_register_style(
            'wpcm-frontend-style',
            WPCM_TS_URL . 'assets/css/promo-blocks.css',
            array(),
            WPCM_TS_VERSION
        );
    }
}
