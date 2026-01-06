<?php
/**
 * Bootstrap class file for core classes.
 *
 * @package WPCM
 */

namespace WPCM;

use WPCM\Admin\CustomPostType;
use WPCM\Admin\MetaBoxes;
use WPCM\Admin\Settings;
use WPCM\Frontend\Shortcode;
use WPCM\Frontend\Assets;
use WPCM\Frontend\Block;
use WPCM\API\RestController;
use WPCM\API\AjaxController;
use WP_CLI;
use WPCM\CLI\FlushPromosCacheCommand;


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main plugin bootstrap class.
 */
final class Plugin {

	/**
	 * Initialize plugin.
	 *
	 * @return void
	 */
	public static function init(): void {
		load_plugin_textdomain(
			'wp-content-manager-tushar-sharma',
			false,
			WPCM_TS_PATH . '/languages'
		);

		new CustomPostType();
		new Metaboxes();
		new Settings();

		new Assets();
		new Shortcode();
		new Block();

		new RestController();

		if( defined( 'WP_CLI' ) && WP_CLI ) {
			WP_CLI::add_command( 'wpcm flush-promos-cache', FlushPromosCacheCommand::class );
		}
	}
}
