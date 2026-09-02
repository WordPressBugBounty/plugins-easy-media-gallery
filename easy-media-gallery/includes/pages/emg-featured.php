<?php

if ( ! defined( 'ABSPATH' ) ) exit;

function emg_premium_plugins() {
	$feed = emg_get_feed();
	?>
	<div class="wrap" id="ghozy-featured">
		<?php
		if ( ! empty( $feed ) && is_string( $feed ) ) {
			emg_render_remote_feed( $feed );
		} else {
			echo '<div class="error"><p>' . esc_html__( 'There was an error retrieving the list from the server. Please try again later.', 'easy-media-gallery' ) . '</p></div>';
		}
		?>
	</div>
	<?php
}

function emg_get_feed() {
	if ( false === ( $cache = get_transient( 'easymediagallery_featured_feed' ) ) ) {
		$feed = wp_remote_get( 'https://content.ghozylab.com/feed.php?c=featuredplugins', array( 'sslverify' => false, 'timeout' => 10 ) );
		if ( ! is_wp_error( $feed ) && 200 === wp_remote_retrieve_response_code( $feed ) ) {
			$body = wp_remote_retrieve_body( $feed );
			if ( ! empty( $body ) ) {
				$cache = $body;
				set_transient( 'easymediagallery_featured_feed', $cache, 3600 );
			} else {
				$cache = '<div class="error"><p>' . esc_html__( 'There was an error retrieving the list from the server. Please try again later.', 'easy-media-gallery' ) . '</p></div>';
			}
		} else {
			$cache = '<div class="error"><p>' . esc_html__( 'There was an error retrieving the list from the server. Please try again later.', 'easy-media-gallery' ) . '</p></div>';
		}
	}
	return (string) $cache;
}