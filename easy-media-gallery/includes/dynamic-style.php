<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*-------------------------------------------------------------------------------*/
/*   Dynamic CSS @since 1.2.9.5
/*-------------------------------------------------------------------------------*/
function emg_dynamic_css_generator() {

	// Get Plugin settings
	$frmcol           = easy_get_option( 'easymedia_frm_col' );
	$shdcol           = easy_get_option( 'easymedia_shdw_col' );
	$mrgnbox          = floatval( easy_get_option( 'easymedia_margin_box' ) );
	$imgborder        = floatval( easy_get_option( 'easymedia_frm_border' ) );
	$curstyle         = strtolower( easy_get_option( 'easymedia_cur_style' ) );
	$imgbbrdrradius   = easy_get_option( 'easymedia_brdr_rds' );
	$disenbor         = easy_get_option( 'easymedia_disen_bor' );
	$disenshadow      = easy_get_option( 'easymedia_disen_sdw' );
	$marginhlf        = $mrgnbox / 2;
	$pattover         = easy_get_option( 'easymedia_style_pattern' );
	$ttlcol           = easy_get_option( 'easymedia_ttl_col' );
	$thumbhov         = ucfirst( easy_get_option( 'easymedia_hover_style' ) ) . '.png';
	$thumbhov         = plugins_url( 'css/images/' . $thumbhov, dirname( __FILE__ ) );
	$thumbhovcol      = easymedia_hex2rgb( easy_get_option( 'easymedia_thumb_col' ) );
	$thumbhovcolopcty = floatval( easy_get_option( 'easymedia_hover_opcty' ) ) / 100;
	$thumbiconcol     = easy_get_option( 'easymedia_icon_col' );
	$disenico         = easy_get_option( 'easymedia_disen_ticon' );
	$borderrgba       = easymedia_hex2rgb( easy_get_option( 'easymedia_frm_col' ) );
	$borderrgbaopcty  = floatval( easy_get_option( 'easymedia_thumb_border_opcty' ) ) / 100;

	$css = '';

	// IMAGES
	$css .= '.view {margin-bottom:' . $mrgnbox . 'px; margin-right:' . $marginhlf . 'px; margin-left:' . $marginhlf . 'px;}';
	$css .= '.da-thumbs article.da-animate p{color:' . $ttlcol . ' !important;}';

	if ( easy_get_option( 'easymedia_disen_icocol' ) == '1' ) {
		$css .= 'span.link_post, span.zoom, span.zooma {background-color:' . $thumbiconcol . ';}';
	}

	if ( easy_get_option( 'easymedia_disen_hovstyle' ) == '1' ) {
		$css .= '.da-thumbs article.da-animate {cursor: ' . $curstyle . ';}';
	} else {
		$css .= '.da-thumbs img {cursor: ' . $curstyle . ';}';
	}

	if ( $imgbbrdrradius != '' ) {
		$css .= '.view,.view img,.da-thumbs,.da-thumbs article.da-animate {border-radius:' . intval( $imgbbrdrradius ) . 'px;}';
	}

	if ( $disenbor == 1 ) {
		$css .= '.view {border: ' . $imgborder . 'px solid rgba(' . $borderrgba . ',' . $borderrgbaopcty . ');}';
	}

	if ( $disenico != 1 ) {
		$css .= '.forspan {display: none !important;}';
	}

	if ( $disenshadow == 1 ) {
		$css .= '.view {-webkit-box-shadow: 1px 1px 3px ' . $shdcol . '; -moz-box-shadow: 1px 1px 3px ' . $shdcol . '; box-shadow: 1px 1px 3px ' . $shdcol . ';}';
	} else {
		$css .= '.view { box-shadow: none !important; -moz-box-shadow: none !important; -webkit-box-shadow: none !important;}';
	}

	// MEDIA BOX Patterns
	if ( $pattover != '' && $pattover != 'no_pattern' ) {
		$css .= '#mbOverlay {background: url(' . esc_url( EASYMEDG_PLUGIN_URL . 'css/images/patterns/' . $pattover ) . '); background-repeat: repeat;}';
	}

	// Thumbnails Title Background color @since 1.2.61
	$css .= '.da-thumbs article.da-animate p { background: rgba(' . easymedia_hex2rgb( easy_get_option( 'easymedia_ttl_back_col' ) ) . ',0.5) !important;}';

	// User Agent check for older browsers
	$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';
	if ( ! empty( $user_agent ) && preg_match( '/MSIE (.*?);/', $user_agent, $matches ) ) {
		if ( count( $matches ) > 1 && $disenbor == 1 ) {
			$version = explode( '.', $matches[1] );
			if ( floatval( $version[0] ) <= 8 ) {
				$css .= '.view {border: 1px solid ' . $shdcol . ';}';
				$css .= '.iehand {border: ' . $imgborder . 'px solid ' . $frmcol . ';}';
				$css .= '.da-thumbs article{position: absolute; background-image:url(' . esc_url( $thumbhov ) . '); background-repeat:repeat; width: 100%; height: 100%;}';
			} else {
				if ( $disenbor == 1 ) {
					$css .= '.view {border: ' . $imgborder . 'px solid rgba(' . $borderrgba . ',' . $borderrgbaopcty . ');}';
				}
				$css .= '.da-thumbs article{position: absolute; background: rgba(' . $thumbhovcol . ',' . $thumbhovcolopcty . '); background-repeat:repeat; width: 100%; height: 100%;}';
			}
		} elseif ( count( $matches ) > 1 && $disenbor != '1' ) {
			$css .= '.da-thumbs article{position: absolute; background-image:url(' . esc_url( $thumbhov ) . '); background-repeat:repeat; width: 100%; height: 100%;}';
		} else {
			$css .= '.da-thumbs article{position: absolute; background: rgba(' . $thumbhovcol . ',' . $thumbhovcolopcty . '); background-repeat:repeat; width: 100%; height: 100%;}';
		}
	}

	// Magnify Icon
	if ( easy_get_option( 'easymedia_mag_icon' ) != '' && $disenico == 1 ) {
		$css .= 'span.zoom{ background-image:url(' . esc_url( EASYMEDG_PLUGIN_URL . 'css/images/magnify/' . easy_get_option( 'easymedia_mag_icon' ) . '.png' ) . '); background-repeat:no-repeat; background-position:center; }';
	}

	return emg_css_compress( $css );
}