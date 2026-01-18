<?php
/**
 * Renderer class file for showing promo blocks content.
 *
 * @package WPCM\Frontend
 */

namespace WPCM\Frontend;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use WPCM\Cache\CacheManager;

/**
 * Renderer class
 */
class Renderer {

	public function render(): string {

		$promos = CacheManager::get();

		if ( empty( $promos ) ) {
			return '<p>No promo block found.</p>';
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