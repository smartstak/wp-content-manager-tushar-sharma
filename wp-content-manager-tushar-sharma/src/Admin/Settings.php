<?php
/**
 * Plugin's Register Settings class file.
 *
 * @package WPCM\Admin
 */

namespace WPCM\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use WPCM\Cache\CacheManager;

/**
 * Settings class
 */
class Settings {
	const OPTION = 'wpcm_settings';

	/**
	 * Constructor method
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'menu' ) );
		add_action( 'admin_init', array( $this, 'register' ) );

		add_action( 'update_option_' . self::OPTION, array( $this, 'on_options_updated'), 10, 2 );
		add_action( 'add_option_' . self::OPTION, array( $this, 'on_options_updated'), 10, 2 );
	}

	/**
	 * Adds menu page.
	 *
	 * @return void
	 */
	public function menu(): void {
		add_options_page(
			__( 'Dynamic Content', 'wp-content-manager-tushar-sharma' ),
			__( 'Dynamic Content', 'wp-content-manager-tushar-sharma' ),
			'manage_options',
			'wpcm-settings',
			array( $this, 'render' )
		);
	}

	/**
	 * Register settings
	 *
	 * @return void
	 */
	public function register(): void {
		register_setting(
			'wpcm_settings_group',
			self::OPTION,
			array(
				'sanitize_callback' => array( $this, 'sanitize' ),
				'default'           => $this->default_settings(),
			)
		);
	}

	/**
	 * Default settings
	 *
	 * @return array
	*/
	public function default_settings(): array {
		return array(
			'enabled'     => 0,
			'max_items'   => 9,
			'cache_ttl'   => 10,
			'enable_ajax' => 0,
		);
	}

	/**
	 * Sanitize settings values
	 *
	 * @param array $input Input values.
	 *
	 * @return array
	*/
	public function sanitize( array $input ): array {

		$output = $this->default_settings();

		$output['enabled']     = isset( $input['enabled'] ) && 1 === (int) $input['enabled'] ? 1 : 0;
		$output['max_items']   = isset( $input['max_items'] ) ? absint( $input['max_items'] ) : $output['max_items'];
		$output['cache_ttl']   = isset( $input['cache_ttl'] ) ? absint( $input['cache_ttl'] ) : $output['cache_ttl'];
		$output['enable_ajax'] = isset( $input['enable_ajax'] ) && 1 === (int) $input['enable_ajax'] ? 1 : 0;

		return $output;
	}

	/**
	 * Method for Rendering options
	 *
	 * @return void
	 */
	public function render(): void {
		if( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$options = wp_parse_args(
			get_option( self::OPTION, array() ),
			$this->default_settings()
		);
		?>
		<div class="wrap">
			<h2><?php esc_html_e( 'Dynamic Content Settings', 'wp-content-manager-tushar-sharma' );?></h2>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'wpcm_settings_group' );
				?>
				<table class="form-table" role="presentation">
					<tr>
						<th scope="row">
							<?php esc_html_e( 'Enable Promo Blocks', 'wp-content-manager-tushar-sharma' ); ?>
						</th>
						<td>
							<label for="<?php echo esc_attr( self::OPTION ); ?>-enabled">
								<input type="checkbox" id="<?php echo esc_attr( self::OPTION ); ?>-enabled" name="<?php echo esc_attr( self::OPTION ); ?>[enabled]" value="1"
								<?php checked( $options['enabled'] ?? '', 1 ); ?>>
								<?php esc_html_e( 'Enable promo blocks feature', 'wp-content-manager-tushar-sharma' ); ?>
							</label>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<?php esc_html_e( 'Maximum Promo Blocks', 'wp-content-manager-tushar-sharma' ); ?>
						</th>
						<td>
							<input type="number"
								min="1"
								class="small-text"
								name="<?php echo esc_attr( self::OPTION ); ?>[max_items]"
								value="<?php echo esc_attr( $options['max_items'] ); ?>">
							<p class="description">
								<?php esc_html_e( 'Maximun number of promo blocks to display.', 'wp-content-manager-tushar-sharma' );?>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<?php esc_html_e( 'Cache TTL (minutes)', 'wp-content-manager-tushar-sharma' ); ?>
						</th>
						<td>
							<input type="number"
								min="1"
								class="small-text"
								name="<?php echo esc_attr( self::OPTION ); ?>[cache_ttl]"
								value="<?php echo esc_attr( $options['cache_ttl'] ); ?>">
							<p class="description">
								<?php esc_html_e( 'Cache lifetime for promo blocks in minutes.', 'wp-content-manager-tushar-sharma' );?>
							</p>
						</td>
					</tr>

					<tr>
						<th scope="row">
							<?php esc_html_e( 'Enable Ajax Loading', 'wp-content-manager-tushar-sharma' ); ?>
						</th>
						<td>
							<label for="<?php echo esc_attr( self::OPTION ); ?>-enable_ajax">
								<input type="checkbox" id="<?php echo esc_attr( self::OPTION ); ?>-enable_ajax" name="<?php echo esc_attr( self::OPTION ); ?>[enable_ajax]" value="1"
								<?php checked( $options['enable_ajax'] ?? '', 1 ); ?>>
								<?php esc_html_e( 'Load promo blocks asynchronously after page load.', 'wp-content-manager-tushar-sharma' ); ?>
							</label>
						</td>
					</tr>
				</table>
				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}

	/**
	 * Clear promo blocks cache when options updated
	 * 
	 * @param mixed $old_value Old value. 
	 * @param mixed $value value.
	 *
	 * @return void
	 */
	public function on_options_updated( $old_value, $value ): void {
		if( $old_value === $value ) {
			return;
		}

		CacheManager::flush();
	}
}
