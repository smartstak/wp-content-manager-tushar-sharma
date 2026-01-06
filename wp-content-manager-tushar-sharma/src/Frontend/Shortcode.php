<?php
/**
 * Promo Blocks Shortcode class file.
 *
 * @package WPCM\Frontend
 */

namespace WPCM\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use WPCM\Helpers;
use WPCM\Frontend\Renderer;

/**
 * Promo Blocks Shortcode handler class.
 */
class Shortcode {

	/**
	 * Constructor method
	 */
	public function __construct() {
		add_shortcode( 'dynamic_promo', array( $this, 'render' ) );
	}

	/**
	 * Shortcode render method
	 *
	 * @return string
	 */
	public function render(): string {

		$promos = Helpers::get_promos();

		if ( empty( $promos ) ) {
			return '';
		}

		$options = wp_parse_args(
			get_option( 'wpcm_settings', [] ),
			[
				'enable_ajax' => 0,
			]
		);

		wp_enqueue_style('wpcm-frontend-style');

		// AJAX mode.
		if ( ! empty( $options['enable_ajax'] ) ) {

			wp_register_script(
				'wpcm-frontend-script',
				WPCM_TS_URL . 'assets/js/promo-blocks.js',
				array(),
				WPCM_TS_VERSION,
				true
			);

			wp_enqueue_script('wpcm-frontend-script');
			wp_localize_script(
				'wpcm-frontend-script',
				'wpcm_promo',
				array(
					'rest_url' => esc_url_raw( rest_url( 'dcm/v1/promos?rendered=1' ) ),
					'nonce'    => wp_create_nonce( 'wp_rest' ),
				)
			);

			return '
				<div class="wpcm-promo-wrapper" data-ajax="1">
					<div class="wpcm-loader">Loading promo blocks…</div>
				</div>
			';
		}
		
		ob_start();
		?>
		<div class="wpcm-promos">
			<?php foreach ( $promos as $promo ) : ?>
				<div class="wpcm-promos__promo">
					<?php if ( ! empty( $promo['image'] ) ) : ?>
						<img src="<?php echo esc_url( $promo['image'] ); ?>" class="wpcm-promos__image" loading="lazy">
					<?php endif; ?>

					<h3 class="wpcm-promos__title"><?php echo esc_html( $promo['title'] ); ?></h3>

					<div class="wpcm-promos__content">
						<?php echo wp_kses_post( $promo['content'] ); ?>
					</div>
					<?php if ( $promo['cta']['text'] && $promo['cta']['url'] ) : ?>
						<a href="<?php echo esc_url( $promo['cta']['url'] ); ?>" class="wpcm-promos__cta">
							<?php echo esc_html( $promo['cta']['text'] ); ?>
						</a>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php
		return ob_get_clean();
	}
}
