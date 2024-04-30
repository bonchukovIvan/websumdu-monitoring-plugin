<?php

if( !defined('ABSPATH') )
{
    exit; // Exit if accessed directly
}

include_once WEBSUMDU_MONITORING_PATH . 'includes/services.php';

function wbsmd_plg_post_controllers_monitoring( $request) {
    try {

        $response = wbsmd_plg_post_response_service( $request );

        return rest_ensure_response( $response );
    }
    catch (Exception $e) {
        return json_encode([
            "success" => false,
            "message" => $e->getMessage()
        ]);
    }
}