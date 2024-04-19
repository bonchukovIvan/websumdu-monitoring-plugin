<?php

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
/* 
 * Delete all plugin options
 */
delete_option( 'wbsmd_plg_slug_news' );

delete_option( 'wbsmd_plg_slug_events' );

delete_option( 'wbsmd_plg_slug_news_eng' );

delete_option( 'wbsmd_plg_slug_events_eng' );