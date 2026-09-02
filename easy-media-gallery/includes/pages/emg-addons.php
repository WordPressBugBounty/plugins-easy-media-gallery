<?php

if ( ! defined( 'ABSPATH' ) ) exit;


function emg_lite_get_addons_feed() {
	if ( false === ( $cache = get_transient( 'emglite_addons_feed' ) ) ) {
		
	$addlist = get_option( "emg_active_addons_lite" );	
		
	if ( is_array( $addlist ) ) {
		
		$lst = $addlist;
		
		} else {
			
			$lst = array();
			
			}
		
	$url = array(
				'c' => 'addons',
				'p' => 'emglite',
				'addons' => $lst,
				);	
		
		$feed = wp_remote_get( 'https://content.ghozylab.com/feed.php?'.http_build_query( $url ).'', array( 'sslverify' => false, 'timeout' => 10 ) );
		
		if ( ! is_wp_error( $feed ) && 200 === wp_remote_retrieve_response_code( $feed ) ) {
			$body = wp_remote_retrieve_body( $feed );
			if ( ! empty( $body ) ) {
				$cache = $body;
				set_transient( 'emglite_addons_feed', $cache, 60 );
			} else {
				$cache = '<div class="error"><p>' . esc_html__( 'There was an error retrieving the list from the server. Please try again later.', 'easy-media-gallery' ) . '</p></div>';
			}
		} else {
			$cache = '<div class="error"><p>' . esc_html__( 'There was an error retrieving the list from the server. Please try again later.', 'easy-media-gallery' ) . '</p></div>';
		}
	}
	return (string) $cache;
}
