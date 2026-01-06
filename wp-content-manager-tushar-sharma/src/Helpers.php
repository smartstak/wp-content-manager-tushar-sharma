<?php
/**
 * Helper class file.
 *
 * @package WPCM
 */

namespace WPCM;

use WPCM\Cache\CacheManager;
use WP_Query;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Helper methods
 */
class Helpers {

	/**
	 * Fetch promo blocks with caching.
	 *
	 * @return array
	 */
	public static function get_promos(): array {
		$settings = get_option( 'wpcm_settings', array() );

		if ( empty( $settings['enabled'] ) ) {
			return array();
		}

		$cached = CacheManager::get();
		if ( false !== $cached ) {
			return $cached;
		}

		$limit = absint( $settings['max_items'] ?? 3 );
		$ttl   = absint( $settings['cache_ttl'] ?? 10 ) * MINUTE_IN_SECONDS;

		$today = date( 'Y-m-d' );

		$promo_query = new WP_Query(
			array(
				'post_type'      => 'promo_block',
				'post_status'    => 'publish',
				'posts_per_page' => $limit,
				'meta_query'     => array(
					array(
						'key'     => 'wpcm_expiry_date',
						'value'   => $today,
						'compare' => '>=',
						'type'    => 'DATE',
					),
				),
				'orderby'        => 'meta_value_num',
				'meta_key'       => 'wpcm_display_priority',
				'order'          => 'ASC',
			)
		);

		$data = array();

		while ( $promo_query->have_posts() ) {
			$promo_query->the_post();
			$post_id = get_the_ID();

			$data[] = array(
				'id'      => $post_id,
				'title'   => get_the_title( $post_id ),
				'content' => apply_filters( 'the_content', get_the_content() ),
				'image'   => get_the_post_thumbnail_url( $post_id, 'medium' ),
				'cta'     => array(
					'text' => get_post_meta( $post_id, 'wpcm_cta_text', true ),
					'url'  => get_post_meta( $post_id, 'wpcm_cta_url', true ),
				),
			);
		}

		wp_reset_postdata();
		CacheManager::set( $data, $ttl );

		return $data;
	}
}
