<?php

if ( ! defined( 'ABSPATH' ) ) exit;

/*-----------------------------------------------------------------------------------
/*	Register Taxonomy
/*---------------------------------------------------------------------------------*/
function easmedia_register_emg_tax() {
	$labels = array(
		'name'               => _x( 'Easy Media Gallery', 'taxonomy general name', 'easy-media-gallery' ),
		'singular_name'      => _x( 'Easy Media Gallery', 'taxonomy singular name', 'easy-media-gallery' ),
		'add_new'            => _x( 'Add New Category', 'taxonomy context', 'easy-media-gallery' ),
		'add_new_item'       => __( 'Add New Category', 'easy-media-gallery' ),
		'edit_item'          => __( 'Edit Category', 'easy-media-gallery' ),
		'new_item'           => __( 'New Category', 'easy-media-gallery' ),
		'view_item'          => __( 'View Category', 'easy-media-gallery' ),
		'search_items'       => __( 'Search Category', 'easy-media-gallery' ),
		'not_found'          => __( 'No Category found', 'easy-media-gallery' ),
		'not_found_in_trash' => __( 'No Category found in Trash', 'easy-media-gallery' ),
		'menu_name'          => __( 'Categories', 'easy-media-gallery' ),
	);
	
	$pages = array( 'easymediagallery' );
				
	$args = array(
		'labels'            => $labels,
		'singular_label'    => __( 'Emediagallery', 'easy-media-gallery' ),
		'public'            => true,
		'show_ui'           => true,
		'query_var'         => true,
		'hierarchical'      => true,
		'show_tagcloud'     => false,
		'show_in_nav_menus' => false,
		'rewrite'           => array( 'slug' => 'easy-media', 'with_front' => false ),
	);
	register_taxonomy( 'emediagallery', $pages, $args );
}
add_action( 'init', 'easmedia_register_emg_tax', 11 );