<?php
/**
 * Gutenberg Block Wrapper class file.
 *
 * @package WPCM\Frontend
 */

namespace WPCM\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Gutenberg block wrapper
 */
class Block {

	/**
	 * Constructor method
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}


	/**
	 * Register block type
	 *
	 * @return void
	 */
	public function register(): void {

		// wp_register_script(
		// 	'wpcm-block-editor',
		// 	WPCM_TS_URL . 'assets/js/block-editor.js',
		// 	array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-block-editor' ),
		// 	WPCM_TS_VERSION,
		// 	true
		// );

		register_block_type(
			__DIR__ . '/block.json',
			array(
				'render_callback' => function () {
					//return do_shortcode( '[dynamic_promo]' );
					return '<div style="border:1px dashed #999;padding:10px">
					Promo Blocks Placeholder
				</div>';
				},
			)
		);

		//error_log( 'Block Class initiated' );
	}
}
