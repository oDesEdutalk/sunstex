<?php
/**
 * Theme functions and definitions.
 */

/**
 * Enqueue SVN-Gotham font and typography stylesheet for all frontend pages
 */
function extice_child_enqueue_svn_gotham() {
	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();
	$css_path  = $theme_dir . '/assets/css/svn-gotham.css';

	wp_enqueue_style(
		'extice-child-svn-gotham',
		$theme_uri . '/assets/css/svn-gotham.css',
		array( 'extice-style' ),
		file_exists( $css_path ) ? filemtime( $css_path ) : wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'extice_child_enqueue_svn_gotham', 999 );

/**
 * Enqueue SVN-Gotham in Elementor editor and WordPress Admin
 */
function extice_child_enqueue_svn_gotham_admin() {
	$theme_dir = get_stylesheet_directory();
	$theme_uri = get_stylesheet_directory_uri();
	$css_path  = $theme_dir . '/assets/css/svn-gotham.css';

	wp_enqueue_style(
		'extice-child-svn-gotham-editor',
		$theme_uri . '/assets/css/svn-gotham.css',
		array(),
		file_exists( $css_path ) ? filemtime( $css_path ) : wp_get_theme()->get( 'Version' )
	);
}
add_action( 'elementor/editor/after_enqueue_scripts', 'extice_child_enqueue_svn_gotham_admin' );
add_action( 'admin_enqueue_scripts', 'extice_child_enqueue_svn_gotham_admin' );

/**
 * Register SVN-Gotham font family in Elementor font picker
 */
add_filter( 'elementor/fonts/groups', function( $groups ) {
	$groups['custom_fonts'] = esc_html__( 'Custom Fonts', 'extice' );
	return $groups;
} );

add_filter( 'elementor/fonts/additional_fonts', function( $fonts ) {
	$fonts['SVN-Gotham'] = 'custom_fonts';
	return $fonts;
} );

/**
 * Disable external Google Fonts to improve loading speed since SVN-Gotham is self-hosted
 */
add_filter( 'extice_google_font_families', '__return_empty_array' );
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

/**
 * Enqueue history timeline assets for About Us page
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
		array( 'extice-child-svn-gotham' ),
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
add_action( 'wp_enqueue_scripts', 'extice_child_enqueue_history_timeline_assets', 1000 );