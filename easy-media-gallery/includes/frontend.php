<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*
|--------------------------------------------------------------------------
| CONTROL, REGISTER & ENQUEUE FRONT END SCRIPTS / STYLES
|--------------------------------------------------------------------------
*/
function easymedia_frontend_stylesheet() {
	wp_enqueue_style( 'easymedia_styles', EASYMEDG_PLUGIN_URL . 'css/frontend.css', array(), EASYMEDIA_VERSION );
	wp_enqueue_style( 'easymedia_lightbox_style', EASYMEDG_PLUGIN_URL . 'css/styles/mediabox/Light.css', array(), EASYMEDIA_VERSION );
}
add_action( 'wp_enqueue_scripts', 'easymedia_frontend_stylesheet' );


function easymedia_frontend_script() {	
	
	( easy_get_option( 'easymedia_disen_autopl' ) == '1' ) ? $audautoplay = 'true' : $audautoplay = 'false';
	( easy_get_option( 'easymedia_disen_audio_loop' ) == '1' ) ? $audioloop = 'true' : $audioloop = 'false';
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplaya = '&autoplay=1' : $autoplaya = '';
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplayb = '?autoplay=1' : $autoplayb = '';
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplayc = '1' : $autoplayc = '0';	
	( easy_get_option( 'easymedia_disen_autoplv' ) == '1' ) ? $autoplayd = 'true' : $autoplayd = 'false';		
	( easy_get_option( 'easymedia_disen_rclick' ) == '1' ) ? $disenrclck = 'true' : $disenrclck = 'false';	
			
	$eparams = array(
		'nblaswf'       => plugins_url( '/swf/NonverBlaster.swf', __FILE__ ),
		'audiovol'      => easy_get_option( 'easymedia_audio_vol' ),
		'audioautoplay' => $audautoplay,
		'audioloop'     => $audioloop,
		'vidautopa'     => $autoplaya,
		'vidautopb'     => $autoplayb,  
		'vidautopc'     => $autoplayc, 
		'vidautopd'     => $autoplayd,	
		'drclick'       => $disenrclck,
		'ajaxcid'       => easy_get_option( 'easymedia_ajax_con_id' ),					
		'ajaxpth'       => admin_url( 'admin-ajax.php' ),
		'ajaxnonce'     => wp_create_nonce( 'medialoader' ),
		'ovrlayop'      => floatval( easy_get_option( 'easymedia_overlay_opcty' ) ) / 100,   
	);

	wp_localize_script( 'easymedia-core', 'EasyLite', $eparams );

	// Enqueue HTML5 shim only on legacy WordPress (< 6.9) where conditional comments are supported
	global $wp_version;
	if ( version_compare( $wp_version, '6.9', '<' ) ) {
		wp_enqueue_script( 'easymedia-html5-shiv', plugins_url( 'js/func/html5.js', __FILE__ ), array(), EASYMEDIA_VERSION );
		wp_script_add_data( 'easymedia-html5-shiv', 'conditional', 'lt IE 9' );
	}

	// Attach inline script to ensure da-thumbs rel attribute
	$inline_rel_script = 'jQuery(document).ready(function($) { var add = "easymedia"; jQuery(\'.da-thumbs a[rel!="easymedia"]\').attr(\'rel\', function (i, old) { return old ? old + \' \' + add : add; }); });';
	wp_add_inline_script( 'easymedia-core', $inline_rel_script );
}
add_action( 'wp_enqueue_scripts', 'easymedia_frontend_script' );