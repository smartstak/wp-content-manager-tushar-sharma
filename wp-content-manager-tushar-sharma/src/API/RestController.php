<?php
/**
 * Rest Controller class file.
 *
 * @package WPCM\API
 */

namespace WPCM\API;

use WPCM\Helpers;
use WPCM\Frontend\Renderer;
use WP_REST_Server;
use WP_REST_Request;
use WP_REST_Response;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Rest endpoint class for promo blocks
 */
class RestController {

	/**
	 * Constructor method
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register' ) );
	}

	/**
	 * Callback method of rest_api_init hook
	 *
	 * @return void
	 */
	public function register(): void {
		register_rest_route(
			'dcm/v1',
			'/promos',
			array(
				'method'              => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_promos' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'rendered' => array(
						'type'    => 'boolean',
						'default' => false,
					),
				),
			)
		);
	}

	/**
	 * Get promo blocks
	 * 
	 * @param WP_REST_Request $request request variable.
	 *
	 * @return \WP_REST_Response
	 */
	public function get_promos( WP_REST_Request $request ): WP_REST_Response {

		if ( true === $request->get_param( 'rendered' ) ) {
			return rest_ensure_response(
				array(
					'html' => ( new Renderer() )->render(),
				)
			);
		}

		return rest_ensure_response( Helpers::get_promos() );
	}
}
