<?php

if( !defined('ABSPATH') )
{
    exit; // Exit if accessed directly
}

include_once WEBSUMDU_MONITORING_PATH . 'includes/services.php';

function wbsmd_plg_get_controllers_monitoring() {

    $response = wbsmd_plg_get_response_service();

    return rest_ensure_response( $response );

}