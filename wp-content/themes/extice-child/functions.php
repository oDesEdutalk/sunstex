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

/**
 * Shortcode [sunstex_project_nav]
 * Displays the published projects in the sidebar navigation matching service-style-5.
 */
function sunstex_project_nav_shortcode() {
	$current_id = get_the_ID();
	$projects = get_posts( array(
		'post_type'      => 'extice_project',
		'post_status'    => 'publish',
		'numberposts'    => -1,
		'orderby'        => 'menu_order date',
		'order'          => 'ASC',
	) );

	if ( empty( $projects ) ) {
		return '';
	}

	ob_start();
	?>
	<div class="elementor-service-style-5 elementor-widget elementor-widget-extice-services">
		<div class="elementor-widget-container">
			<div class="elementor-service-wrapper">
				<div class="d-grid">
					<?php foreach ( $projects as $proj ) :
						$is_current = ( $proj->ID === $current_id );
						$item_class = $is_current ? 'current_post service-content post-' . $proj->ID : 'service-content post-' . $proj->ID;
					?>
						<div class="grid-item service-item service-style-5">
							<div class="<?php echo esc_attr( $item_class ); ?>">
								<h6 class="service-title">
									<a href="<?php echo esc_url( get_permalink( $proj->ID ) ); ?>">
										<span><?php echo esc_html( $proj->post_title ); ?></span>
										<i class="extice-icon-angle-right"></i>
									</a>
								</h6>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'sunstex_project_nav', 'sunstex_project_nav_shortcode' );

/**
 * Add Elementor classes to single project posts
 */
add_filter( 'body_class', function( $classes ) {
	if ( is_singular( 'extice_project' ) ) {
		$classes[] = 'elementor-page';
	}
	return $classes;
} );

/**
 * Ensure the breadcrumb banner heading title always displays "Dự Án/ Khách Hàng Tiêu Biểu" on project pages
 */
add_filter( 'elementor/widget/render_content', function( $widget_content, $widget ) {
	if ( 'extice-woocommerce-breadcrumb' === $widget->get_name() ) {
		$is_project = is_singular( 'extice_project' )
			|| is_post_type_archive( 'extice_project' )
			|| is_tax( 'project_cat' )
			|| ( isset( $_GET['elementor-preview'] ) && get_post_type( (int) $_GET['elementor-preview'] ) === 'extice_project' );

		if ( $is_project ) {
			$widget_content = preg_replace(
				'/<h1 class="extice-woocommerce-title"[^>]*>.*?<\/h1>/su',
				'<h1 class="extice-woocommerce-title">Dự Án/ Khách Hàng Tiêu Biểu</h1>',
				$widget_content
			);
		}
	}
	return $widget_content;
}, 20, 2 );

/**
 * Enqueue widget CSS for single projects
 */
function extice_child_enqueue_project_assets() {
	$theme_dir   = get_stylesheet_directory();
	$theme_uri   = get_stylesheet_directory_uri();
	$style_css   = $theme_dir . '/style.css';

	// Cache bust child theme style.css for all frontend pages
	wp_dequeue_style( 'extice-child-style' );
	wp_deregister_style( 'extice-child-style' );
	wp_enqueue_style(
		'extice-child-style',
		$theme_uri . '/style.css',
		array( 'extice-style' ),
		file_exists( $style_css ) ? filemtime( $style_css ) : time()
	);

	if ( is_singular( 'extice_project' ) ) {
		$upload_dir  = wp_upload_dir();

		// 1. Heading Widget CSS
		$heading_css_path = WP_PLUGIN_DIR . '/elementor/assets/css/widget-heading.min.css';
		if ( file_exists( $heading_css_path ) ) {
			wp_enqueue_style(
				'elementor-widget-heading',
				plugins_url( 'elementor/assets/css/widget-heading.min.css' ),
				array( 'elementor-frontend' ),
				'4.2.1'
			);
		}

		// 2. Icon Box Widget CSS
		$icon_box_path = $upload_dir['basedir'] . '/elementor/css/custom-widget-icon-box.min.css';
		if ( file_exists( $icon_box_path ) ) {
			wp_enqueue_style(
				'elementor-custom-widget-icon-box',
				$upload_dir['baseurl'] . '/elementor/css/custom-widget-icon-box.min.css',
				array( 'elementor-frontend' ),
				filemtime( $icon_box_path )
			);
		}

		// 3. Image Gallery Widget CSS
		$gallery_path = $upload_dir['basedir'] . '/elementor/css/custom-widget-image-gallery.min.css';
		if ( file_exists( $gallery_path ) ) {
			wp_enqueue_style(
				'elementor-custom-widget-image-gallery',
				$upload_dir['baseurl'] . '/elementor/css/custom-widget-image-gallery.min.css',
				array( 'elementor-frontend' ),
				filemtime( $gallery_path )
			);
		}

		// 4. Nested Accordion CSS
		$nested_acc_path = WP_PLUGIN_DIR . '/elementor/assets/css/widget-nested-accordion.min.css';
		if ( file_exists( $nested_acc_path ) ) {
			wp_enqueue_style(
				'widget-nested-accordion',
				plugins_url( 'elementor/assets/css/widget-nested-accordion.min.css' ),
				array( 'elementor-frontend' ),
				'4.2.1'
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'extice_child_enqueue_project_assets', 1001 );

/**
 * Contact Form 7 Lead Resilience
 * Ensures customer submissions saved to Flamingo are treated as successful,
 * preventing customers from seeing error alerts if email sending experiences issues.
 */
add_filter( 'wpcf7_submission_result', function( $result, $submission ) {
	if ( isset( $result['status'] ) && $result['status'] === 'mail_failed' ) {
		$contact_form = $submission->get_contact_form();
		$result['status'] = 'mail_sent';
		$result['message'] = $contact_form ? $contact_form->message( 'mail_sent_ok' ) : 'Cảm ơn bạn! Yêu cầu của bạn đã được gửi thành công.';
	}
	return $result;
}, 10, 2 );

add_filter( 'wpcf7_feedback_response', function( $response, $result ) {
	if ( isset( $response['status'] ) && $response['status'] === 'mail_failed' ) {
		$response['status'] = 'mail_sent';
		$contact_form = wpcf7_get_current_contact_form();
		if ( $contact_form ) {
			$response['message'] = $contact_form->message( 'mail_sent_ok' );
		}
	}
	return $response;
}, 20, 2 );