<?php
namespace Posts_Grid_Builder;

/**
 * API controller class
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Controller class
 */
class Api {
	
	public $api_namespace = 'posts-grid-builder/v1';
	private $_endpoints = null;
	
	// Here initialize our namespace and resource name.
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	/**
	 * Returns all endpoints instances
	 */
	public function get_endpoints() {
		if ( ! $this->_endpoints ) {
			$this->_endpoints = array(
				new Endpoints\Posts(),
				new Endpoints\Post_Types(),
				new Endpoints\Terms(),
				new Endpoints\Taxonomies(),
			);
		}

		return $this->_endpoints;
	}

	/**
	 * Returns endpoints URLs
	 */
	public function get_endpoints_urls() {

		$result = array();
		$endpoints = $this->get_endpoints();

		foreach ( $endpoints as $endpoint ) {
			$key = str_replace( '-', '', ucwords( $endpoint->get_name(), '-' ) );
			$result[ $key ] = get_rest_url( null, $this->api_namespace . '/' . $endpoint->get_name() . '/' . $endpoint->get_query_params() , 'rest' );
		}

		return $result;

	}
	
	// Register our routes.
	public function register_routes() {
		
		$endpoints = $this->get_endpoints();

		foreach ( $endpoints as $endpoint ) {
			
			$args = array(
				'methods'             => 'GET',
				'callback'            => array( $endpoint, 'callback' ),
				'permission_callback' => '__return_true'
			);

			if ( ! empty( $endpoint->get_args() ) ) {
				$args['args'] = $endpoint->get_args();
			}

			$route = '/' . $endpoint->get_name() . '/' . $endpoint->get_query_params();

			register_rest_route( $this->api_namespace, $route, $args );

		}
	}

}
