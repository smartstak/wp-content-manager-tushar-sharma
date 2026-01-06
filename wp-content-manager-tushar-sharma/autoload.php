<?php
/**
 * WP Content Manager Tushar Sharma - Autoloder bootstrap file.
 *
 * @package WPCM
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

// Composer autoloader path.
$composer_autoload = __DIR__ . '/vendor/autoload.php';

if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
} else {
	add_action(
		'admin_notices',
		function () {
			?>
		<div class="notice notice-error">
			<p><?php esc_html_e( 'WP Content Manager by Tushar Sharma: Composer autoload file is missing. Please run "composer install" in the plugin directory.', 'wp-content-manager-tushar-sharma' ); ?></p>
		</div>
			<?php
		}
	);
}

if ( ! defined( 'WPCM_TS_VERSION' ) ) {
	define( 'WPCM_TS_VERSION', '0.1.77' );
}

if ( ! defined( 'WPCM_TS_PATH' ) ) {
	define( 'WPCM_TS_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WPCM_TS_URL' ) ) {
	define( 'WPCM_TS_URL', plugin_dir_url( __FILE__ ) );
}
