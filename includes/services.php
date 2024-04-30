<?php

if( !defined('ABSPATH') )
{
    exit; // Exit if accessed directly
}

include_once ABSPATH . 'wp-admin/includes/plugin.php';
include_once ABSPATH . 'wp-admin/includes/taxonomy.php';

if ( function_exists('is_plugin_active') ) {
    define( 'WEBSUMDU_IS_WPML', is_plugin_active('sitepress-multilingual-cms/sitepress.php') );
}

function wbsmd_plg_post_response_service( $request ) {
    
    $slug_news = get_option( 'wbsmd_plg_slug_news' );
    $slug_events = get_option( 'wbsmd_plg_slug_events' );
    $eng_slug_news = get_option( 'wbsmd_plg_slug_news_eng' );
    $eng_slug_events = get_option( 'wbsmd_plg_slug_events_eng' );

    $data = [];

    $start_date = isset($request->get_params()['custom_date']) 
        ? date( 'Y-m-d', strtotime($request->get_params()['custom_date']) ) 
        : date( 'Y-m-d', strtotime('first day of january this year') );

    $data['setup_info'] = [
        'news_alias' => $slug_news, 
        'events_alias' => $slug_events,
        'eng_news_alias' => $eng_slug_news, 
        'eng_events_alias' => $eng_slug_events,
        'start_date' => $start_date
    ];

    if ( WEBSUMDU_IS_WPML ) {
        $langs = []; 
        foreach( icl_get_languages( 'skip_missing=0' ) as $lang ) {
            array_push( $langs, $lang['language_code'] );
        }
        global $sitepress;
        $current_lang = $sitepress->get_current_language();
        if ( $current_lang != 'uk' ) {
            $sitepress->switch_lang( 'uk' );
        }
    }

    wbsmd_plg_add_posts_to_data( $data, $slug_news, 'news', $start_date );
    wbsmd_plg_add_posts_to_data( $data, $slug_events, 'events', $start_date );

    if ( WEBSUMDU_IS_WPML ) {
        $sitepress->switch_lang( 'en' );
    }

    wbsmd_plg_add_posts_to_data( $data, $eng_slug_news, 'eng_news', $start_date );
    wbsmd_plg_add_posts_to_data( $data, $eng_slug_events, 'eng_events', $start_date );

    if ( WEBSUMDU_IS_WPML ) {
        $sitepress->switch_lang( $sitepress->get_current_language() );
    }

    $response = [];
    $response['success'] = true;

    $data_wrap = [];
    array_push($data_wrap, $data);
    
    $response['data'] = $data_wrap;

    return $response;
}

function wbsmd_plg_get_posts_by_slug($cat_slug, $start_date) {  
    if ( !$cat_slug )  {
        return ["error" => "category_not_set"];
    }

    if ( !category_exists( $cat_slug ) && !post_type_exists( $cat_slug )) {
        return ["error" => "category_not_found"];
    }
    
    $date_query = array(
        array(
            'after'     => $start_date,
            'before'    => date('Y-m-d', strtotime('today')),
            'inclusive' => true,
        )
    );

    $args = array(
        'date_query' => $date_query,
        'category_name' => $cat_slug,
    );
    $query = new WP_Query( $args );

    if ( empty( $query->posts ) ) {
        $args = array(
            'date_query' => $date_query,
            'post_type' => $cat_slug,
        );
        $query = new WP_Query( $args );
    }

    if ( empty( $query->posts ) )  {
        return ["error" => "posts_not_found"];
    }

    $posts = [];

    foreach($query->posts as $post) {
        $p = [];
        $p['id'] = $post->ID;
        $p['title'] = $post->post_title;
        $p['created'] = $post->post_date;
        array_push($posts, $p);
    }

    return $posts;
}

function wbsmd_plg_add_posts_to_data( &$data, $cat_slug,  $d_slug, $start_date ) {
    $posts = wbsmd_plg_get_posts_by_slug( $cat_slug, $start_date );
    $data[$d_slug] = $posts;
    return true;
}