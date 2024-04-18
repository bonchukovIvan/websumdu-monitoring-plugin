<?php

if( !defined('ABSPATH') )
{
    exit; // Exit if accessed directly
}

include_once WEBSUMDU_MONITORING_PATH . 'includes/controllers.php';

add_action( 'rest_api_init', 'wbsmd_plg_register_monitoring_routes' );

/**
 * This function register monitoring endpoint.
 */
function wbsmd_plg_register_monitoring_routes() {

    register_rest_route( 'websumdu/v1', '/monitoring', array(
        'callback' => 'wbsmd_plg_get_controllers_monitoring',
        'methods'  => WP_REST_Server::READABLE,
        'permission_callback' => '__return_true'
    ) );

}
