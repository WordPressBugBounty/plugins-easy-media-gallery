<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class emg_sc_widget extends WP_Widget {

    // Create Widget
    function __construct() {
		
		$widget_ops = array(
			'classname'   => 'widget_emg_sc_widget',
			'description' => __( 'Use this widget to display your media as a widget.', 'easy-media-gallery' ),
		);
        $control_ops = array( 'width' => 295 );

		parent::__construct( 'emg-widget', __( 'Easy Media Gallery', 'easy-media-gallery' ), $widget_ops, $control_ops );
		
    }

    // Widget Content
    function widget( $args, $instance ) { 

		if ( isset( $instance['emg_shortcode'] ) ) {
		
			$emgshortcode = $instance['emg_shortcode'];
			
			if ( ! empty( $args['before_widget'] ) ) {
				echo wp_kses_post( $args['before_widget'] );
			}
			
			echo do_shortcode( $emgshortcode );
			
			if ( ! empty( $args['after_widget'] ) ) {
				echo wp_kses_post( $args['after_widget'] );
			}

		}

     }

    // Update and save the widget
	function update( $new_instance, $old_instance ) {
		
		$instance = $old_instance;

		$instance['emg_shortcode'] = sanitize_text_field( $new_instance['emg_shortcode'] );

		return $instance;
	}

    // If widget content needs a form
    function form( $instance ) {
		$instance      = wp_parse_args( (array) $instance, array( 'emg_shortcode' => '' ) );
		$emg_shortcode = ! empty( $instance['emg_shortcode'] ) ? $instance['emg_shortcode'] : '';
		
		echo '<p><label for="' . esc_attr( $this->get_field_id( 'emg_shortcode' ) ) . '">' . esc_html__( 'Make sure to generate the shortcode from post or page first, after that copy the shortcode and paste to the following field.', 'easy-media-gallery' ) . '</label>
			<textarea rows="5" class="widefat" id="' . esc_attr( $this->get_field_id( 'emg_shortcode' ) ) . '" name="' . esc_attr( $this->get_field_name( 'emg_shortcode' ) ) . '">' . esc_textarea( $emg_shortcode ) . '</textarea>
		</p>';
    }
}

function emg_widget_init() {
	register_widget( 'emg_sc_widget' );
}

add_action( 'widgets_init', 'emg_widget_init' );