<?php
/**
 * Promo Block Custom Post Type class.
 *
 * @package WPCM\Admin
 */

namespace WPCM\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register Promo Block custom post type.
 */
class CustomPostType {

	/**
	 * Constructor method
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register' ) );
	}

	/**
	 * Callback method for Promo Block custom post type registration.
	 *
	 * @return void
	 */
	public function register(): void {
		register_post_type(
			'promo_block',
			array(
				'labels'    => array(
					'name'          => __( 'Promo Blocks', 'wp-content-manager-tushar-sharma' ),
					'singular_name' => __( 'Promo Block', 'wp-content-manager-tushar-sharma' ),
					'add_new_item'  => __( 'Add New Promo Block', 'wp-content-manager-tushar-sharma' ),
					'edit_item'     => __( 'Edit Promo Block', 'wp-content-manager-tushar-sharma' ),
					'new_item'      => __( 'New Promo Block', 'wp-content-manager-tushar-sharma' ),
				),
				'public'    => false,
				'show_ui'   => true,
				'menu_icon' => 'dashicons-megaphone',
				'supports'  => array( 'title', 'editor', 'thumbnail' ),
			)
		);
	}
}
