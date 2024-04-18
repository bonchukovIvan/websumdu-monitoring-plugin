<?php

if( !defined('ABSPATH') )
{
    exit; // Exit if accessed directly
}

/**
 * Add the top level menu page.
 */
function wbsmd_plg_options_page() {
	add_menu_page(
		'WebSumdu Monitoring options',
		'WSM  Options',
		'manage_options',
		'wbsmd_plg',
		'wbsmd_plg_options_page_html',
	);
}

/**
 * register wbsmd_plg_settings_init to the admin_init action hook
 */
add_action('admin_init', 'wbsmd_plg_settings_init');

/**
 * Register our wbsmd_plg_options_page to the admin_menu action hook.
 */
add_action( 'admin_menu', 'wbsmd_plg_options_page' );

/**
 * custom option and settings
 */
function wbsmd_plg_settings_init() {
    /*
     * register custom options
     */ 
    register_setting( 'wbsmd_plg', 'wbsmd_plg_slug_news' );
    register_setting( 'wbsmd_plg', 'wbsmd_plg_slug_events' );
    /*
     * register custom setting options
     */ 
    add_settings_section( 
        'wbsmd_plg_setting_section',
        'Налаштування параметрів плагіну',
        'wbsmd_plg_setting_section_callback',
        'wbsmd_plg'
    );
    /*
     * add news setting field
     */ 
    add_settings_field(
        'wbsmd_plg_news_slug_field',
        'Аліас новин',
        'wbsmd_plg_setting_section_news_field_callback',
        'wbsmd_plg',
        'wbsmd_plg_setting_section',
        [
			'label_for' => 'wbsmd_plg_slug_news'
		]
    );
    /*
     * add news setting field
     */ 
    add_settings_field(
        'wbsmd_plg_events_slug_field',
        'Аліас подій',
        'wbsmd_plg_setting_section_events_field_callback',
        'wbsmd_plg',
        'wbsmd_plg_setting_section',
        [
			'label_for' => 'wbsmd_plg_slug_events'
		]
    );
}

function wbsmd_plg_setting_section_news_field_callback( $args ) { 
    ?>
    <input 
        type="text"
        id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="<?php echo esc_attr( $args['label_for'] );?>"
        value="<?php echo get_option( 'wbsmd_plg_slug_news' ); ?>"
    />
    <?php
}

function wbsmd_plg_setting_section_events_field_callback( $args ) { 
    ?>
    <input 
        type="text"
        id="<?php echo esc_attr( $args['label_for'] ); ?>"
        name="<?php echo esc_attr( $args['label_for'] );?>"
        value="<?php echo get_option( 'wbsmd_plg_slug_events' ); ?>"
    />
    <?php
}

function wbsmd_plg_setting_section_callback( $args ) {
    echo '<p>Будь-ласка, введіть alias(посилання) на категорії новин та анонсів</p>';
}

function wbsmd_plg_options_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
    // check if the user have submitted the settings
	// WordPress will add the "settings-updated" $_GET parameter to the url
    if ( isset( $_GET['settings-updated'] ) ) {
		// add settings saved message with the class of "updated"
		add_settings_error( 'wbsmd_plg_messages', 'wbsmd_plg_message', 'Налаштування успішно збережено :)', 'wbsmd_plg', 'updated' );
	}

    // show error/update messages
	settings_errors( 'wbsmd_plg_messages' );
    ?>
        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "wporg"
                settings_fields( 'wbsmd_plg' );
                // output setting sections and their fields
                // (sections are registered for "wporg", each field is registered to a specific section)
                do_settings_sections( 'wbsmd_plg' );
                // output save settings button
                submit_button( 'Зберегти налаштування' );
                ?>
            </form>
        </div> 
    <?php
}