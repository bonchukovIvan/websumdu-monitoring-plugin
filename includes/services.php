<?php

if( !defined('ABSPATH') )
{
    exit; // Exit if accessed directly
}

function wbsmd_plg_get_response_service() {
    $news_allias = get_option( 'wbsmd_plg_slug_news' );
    $events_allias = get_option( 'wbsmd_plg_slug_events' );
   
    $news = wbsmd_plg_get_posts_by_slug( $news_allias );
    $events = wbsmd_plg_get_posts_by_slug( $events_allias );

    $data = [];
    $data['setup_info'] = ['news_allias' => $news_allias, 'events_allias' => $events_allias];
    $data['news'] = $news;
    $data['events'] = $events;

    $response = [];
    $response['success'] = true;
    $response['data'] = $data;

    return $response;
}

function wbsmd_plg_get_posts_by_slug($cat_slug) {
    $args = array(
        'date_query' => array(
            array(
                'after'     => date('Y-m-d', strtotime('-6 months')),
                'before'    => date('Y-m-d', strtotime('today')),
                'inclusive' => true,
            ),
        ),
        'category_name' => $cat_slug
    );
    $query = new WP_Query( $args );

    if ( empty( $query->posts ) ) {
        $args = array(
            'date_query' => array(
                array(
                    'after'     => date('Y-m-d', strtotime('-6 months')),
                    'before'    => date('Y-m-d', strtotime('today')),
                    'inclusive' => true,
                ),
            ),
            'post_type' => $cat_slug
        );
        $query = new WP_Query( $args );
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