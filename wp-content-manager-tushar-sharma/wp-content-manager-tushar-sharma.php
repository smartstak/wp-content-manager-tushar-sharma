<?php
/**
 * Plugin Name: WP Content Manager by Tushar Sharma
 * Description: Manage Promo Blocks content effieciently.
 * Author: Tushar Sharma
 * Author URI: https://profiles.wordpress.org/richeal/
 * Version: 1.0.0
 * Licence: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Tested up to: 6.9
 * Text Domain: wp-content-manager-tushar-sharma
 * Domain Path: /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Include Plugin bootstrap file.
require_once plugin_dir_path( __FILE__ ) . '/autoload.php';

use WPCM\Plugin;

add_action(
	'plugins_loaded',
	static function () {
		Plugin::init();
	}
);
