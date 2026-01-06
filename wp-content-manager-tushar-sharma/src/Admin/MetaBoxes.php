<?php
/**
 * Metabox class for Promo Block custom post type.
 *
 * @package WPCM\Admin
 */

namespace WPCM\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

use WP_Post;

/**
 * Promo Block metaboxes registration class.
 */
class MetaBoxes {

	/**
	 * Constructor method.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register' ) );
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'save_post_promo_block', array( '\WPCM\Cache\CacheManager', 'flush' ) );
	}

	/**
	 * Metaboxes registraction method.
	 *
	 * @return void
	 */
	public function register(): void {
		add_meta_box(
			'promo-block-meta',
			__( 'Promo Settings', 'wp-content-manager-tushar-sharma' ),
			array( $this, 'render' ),
			'promo_block'
		);
	}

	/**
	 * Callback method of add_meta_box.
	 *
	 * @param WP_Post $post post object.
	 *
	 * @return void
	 */
	public function render( WP_Post $post ): void {
		wp_nonce_field( 'promo_meta_nonce', 'promo_meta_nonce_field' );

		$cta_text         = get_post_meta( $post->ID, 'wpcm_cta_text', true );
		$cta_url          = get_post_meta( $post->ID, 'wpcm_cta_url', true );
		$display_priority = get_post_meta( $post->ID, 'wpcm_display_priority', true );
		$expiry_date      = get_post_meta( $post->ID, 'wpcm_expiry_date', true );
		?>
		<div class="promo-block-fields">
			<p class="promo-block-fields__paragraph">
				<label for="wpcm_cta_text"><?php esc_html_e( 'CTA Text', 'wp-content-manager-tushar-sharma' ); ?></label>
				<input type="text" name="wpcm_cta_text" id="wpcm_cta_text" class="widefat" value="<?php echo esc_attr( $cta_text ); ?>">
			</p>
			<p class="promo-block-fields__paragraph">
				<label for="wpcm_cta_url"><?php esc_html_e( 'CTA URL', 'wp-content-manager-tushar-sharma' ); ?></label>
				<input type="url" name="wpcm_cta_url" id="wpcm_cta_url" class="widefat" value="<?php echo esc_url( $cta_url ); ?>">
			</p>
			<p class="promo-block-fields__paragraph">
				<label for="wpcm_display_priority"><?php esc_html_e( 'Display Priority', 'wp-content-manager-tushar-sharma' ); ?></label>
				<input type="number" name="wpcm_display_priority" id="wpcm_display_priority" class="widefat" value="<?php echo esc_attr( $display_priority ); ?>">
			</p>
			<p class="promo-block-fields__paragraph">
				<label for="wpcm_expiry_date"><?php esc_html_e( 'Expiry Date', 'wp-content-manager-tushar-sharma' ); ?></label>
				<input type="date" name="wpcm_expiry_date" id="wpcm_expiry_date" class="widefat" value="<?php echo esc_attr( $expiry_date ); ?>">
			</p>
		</div>
		<?php
	}

	/**
	 * Save method
	 *
	 * @param int $post_id Post ID.
	 *
	 * @return void
	 */
	public function save( int $post_id ): void {

		if (
			! isset( $_POST['promo_meta_nonce_field'] ) ||
			! wp_verify_nonce(
				sanitize_text_field( wp_unslash( $_POST['promo_meta_nonce_field'] ) ),
				'promo_meta_nonce'
			)
		) {
			return;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		if ( isset( $_POST['wpcm_cta_text'] ) ) {
			update_post_meta(
				$post_id,
				'wpcm_cta_text',
				sanitize_text_field( wp_unslash( $_POST['wpcm_cta_text'] ) ?? '' )
			);
		}

		if ( isset( $_POST['wpcm_cta_url'] ) ) {
			update_post_meta(
				$post_id,
				'wpcm_cta_url',
				esc_url_raw( wp_unslash( $_POST['wpcm_cta_url'] ) ?? '' )
			);
		}

		if ( isset( $_POST['wpcm_display_priority'] ) ) {
			$priority = absint( wp_unslash( $_POST['wpcm_display_priority'] ) );
			update_post_meta( $post_id, 'wpcm_display_priority', $priority );
		}

		if ( isset( $_POST['wpcm_expiry_date'] ) ) {
			$date = wp_unslash( $_POST['wpcm_expiry_date'] );
			$dt   = date_create_from_format( 'Y-m-d', $date );
			update_post_meta(
				$post_id,
				'wpcm_expiry_date',
				$dt->format( 'Y-m-d' ) ?? ''
			);
		}
	}
}
