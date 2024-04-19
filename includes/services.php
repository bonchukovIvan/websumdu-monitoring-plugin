<?php

if( !defined('ABSPATH') )
{
    exit; // Exit if accessed directly
}

function wbsmd_plg_get_response_service() {
    $news_allias = get_option( 'wbsmd_plg_slug_news' );
    $events_allias = get_option( 'wbsmd_plg_slug_events' );
    $eng_news_allias = get_option( 'wbsmd_plg_slug_news_eng' );
    $eng_events_allias = get_option( 'wbsmd_plg_slug_events_eng' );
   
    $news = wbsmd_plg_get_posts_by_slug( $news_allias );
    $events = wbsmd_plg_get_posts_by_slug( $events_allias );
    $eng_news = wbsmd_plg_get_posts_by_slug( $eng_news_allias );
    $eng_events = wbsmd_plg_get_posts_by_slug( $eng_events_allias );

    $data = [];
    $data['setup_info'] = [
        'news_alias' => $news_allias, 
        'events_alias' => $events_allias,
        'eng_news_alias' => $eng_news_allias, 
        'eng_events_alias' => $eng_events_allias
    ];
    $data['news'] = $news;
    $data['events'] = $events;
    $data['eng_news'] = $eng_news;
    $data['eng_events'] = $eng_events;

    $response = [];
    $response['success'] = true;
    $data_wrap = [];
    array_push($data_wrap, $data);
    $response['data'] = $data_wrap;

    return $response;
}

function wbsmd_plg_get_posts_by_slug($cat_slug) {
    
    $date_query = array(
        array(
            'after'     => date('Y-m-d', strtotime('-6 months')),
            'before'    => date('Y-m-d', strtotime('today')),
            'inclusive' => true,
        )
    );

    $args = array(
        'date_query' => $date_query,
        'category_name' => $cat_slug
    );
    $query = new WP_Query( $args );

    if ( empty( $query->posts ) ) {
        $args = array(
            'date_query' => $date_query,
            'post_type' => $cat_slug
        );
        $query = new WP_Query( $args );
    }

    if ( empty( $query->posts ) )  {
        return [];
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