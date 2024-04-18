<?php
 /*
 Plugin Name: WebSumdu Monitoring
 Description: Моніторинг акутальності новин та анонсів на сайті
 Version: 1.0.0
 Requires at least: 5.9
 Requires PHP: 5.6
 Author: WebSumdu
 Author URI: https://web.sumdu.edu.ua/
 License: GPL2
 License URI: https://www.gnu.org/licenses/gpl-2.0.html
 Text Domain: tinymce-advanced
 
 
 Websumdu Monitoring is free software: you can
 redistribute it and/or modifyit under the terms of the GNU General Public License
 as published bythe Free Software Foundation, either version 2 of the License, or
 any later version.
 
 Websumdu Monitoring is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.
 
 You should have received a copy of the GNU General Public License along
 with Websumdu Monitoring or WordPress. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 
 Copyright (c) 2007-2023 WebSumdu, Inc. All rights reserved.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WebSumduMonitoring' )) {
    class WebSumduMonitoring {

        public function __construct() {
            /**
             * Currently plugin version.
             */
            define( 'WEBSUMDU_MONITORING_VERSION', '1.0.0' );
            /**
             * Currently plugin path.
             */
            define('WEBSUMDU_MONITORING_PATH', plugin_dir_path(__FILE__));
            /**
             * Currently plugin url.
             */
            define('WEBSUMDU_MONITORING_URL', plugin_dir_url(__FILE__));
        }

        public function initialize() {
            include_once WEBSUMDU_MONITORING_PATH . 'includes/options-page.php';
            include_once WEBSUMDU_MONITORING_PATH . 'includes/monitoring.php';
        }
    }

    $websumdu_monitoring = new WebSumduMonitoring();
    $websumdu_monitoring->initialize();
}