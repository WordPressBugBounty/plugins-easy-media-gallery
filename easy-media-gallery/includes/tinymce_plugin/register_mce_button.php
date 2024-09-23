<?php

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Please do not load this file directly!' );
}

/* Gutenberg Compatibility */
add_filter( 'mce_external_plugins', 'emg_tinymce_mceplugin' );
add_action( 'current_screen', 'emg_gutenberg_shortcode_manager' );

function emg_gutenberg_shortcode_manager()
{

    if ( function_exists( 'get_current_screen' ) ) {

        global $current_screen;

        if ( method_exists( $current_screen, 'is_block_editor' ) && $current_screen->is_block_editor() ) {

            add_filter( 'mce_buttons', 'emg_register_mcebuttons', 0 );
            add_action( 'enqueue_block_editor_assets', 'emg_block_editor_mcebtn_styles' );

        }

    }

}

function emg_register_mcebuttons( $buttons )
{

    array_push( $buttons, 'emgicons' );

    return $buttons;

}

//include the tinymce javascript plugin
function emg_tinymce_mceplugin( $plugin_array )
{

    $plugin_array['emgicons'] = EASYMEDG_PLUGIN_URL.'includes/tinymce_plugin/emg_editor_plugin.js';

    return $plugin_array;

}

/**
 * Enqueue block editor style
 */
function emg_block_editor_mcebtn_styles()
{

    wp_enqueue_style( 'icon-editor-styles', EASYMEDG_PLUGIN_URL.'includes/tinymce_plugin/emg_mcebutton_style.css', false, '1.0', 'all' );

}