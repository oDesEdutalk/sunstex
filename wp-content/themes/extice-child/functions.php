<?php
/**
 * Theme functions and definitions.
 */

function extice_child_enqueue_history_timeline_assets() {
	$is_gioi_thieu = is_page( 'gioi-thieu' ) || ( get_the_ID() === 147 ) || ( isset( $_GET['elementor-preview'] ) && (int) $_GET['elementor-preview'] === 147 );
	if ( ! $is_gioi_thieu ) {
		return;
	}

	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();
	$css_path  = $theme_dir . '/assets/css/history-timeline.css';
	$js_path   = $theme_dir . '/assets/js/history-timeline.js';

	wp_enqueue_style(
		'extice-child-history-timeline',
		$theme_uri . '/assets/css/history-timeline.css',
		array(),
		file_exists( $css_path ) ? filemtime( $css_path ) : wp_get_theme()->get( 'Version' )
	);

	wp_enqueue_script(
		'extice-child-history-timeline',
		$theme_uri . '/assets/js/history-timeline.js',
		array(),
		file_exists( $js_path ) ? filemtime( $js_path ) : wp_get_theme()->get( 'Version' ),
		true
	);
}
add_action( 'wp_enqueue_scripts', 'extice_child_enqueue_history_timeline_assets' );