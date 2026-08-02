<?php
/**
 * =================================================
 * Hook extice_page
 * =================================================
 */
add_action('extice_page', 'extice_page_header', 10);
add_action('extice_page', 'extice_page_content', 20);

/**
 * =================================================
 * Hook extice_single_post_top
 * =================================================
 */
add_action('extice_single_post_top', 'extice_post_header', 5);
add_action('extice_single_post_top', 'extice_post_thumbnail', 10);

/**
 * =================================================
 * Hook extice_single_post
 * =================================================
 */
add_action('extice_single_post', 'extice_post_content', 30);

/**
 * =================================================
 * Hook extice_single_post_bottom
 * =================================================
 */
add_action('extice_single_post_bottom', 'extice_post_taxonomy', 5);
add_action('extice_single_post_bottom', 'extice_post_nav', 15);
add_action('extice_single_post_bottom', 'extice_single_author', 16);
add_action('extice_single_post_bottom', 'extice_display_comments', 20);

/**
 * =================================================
 * Hook extice_loop_post
 * =================================================
 */
add_action('extice_loop_post', 'extice_post_header', 15);
add_action('extice_loop_post', 'extice_post_content', 30);

/**
 * =================================================
 * Hook extice_footer
 * =================================================
 */
add_action('extice_footer', 'extice_footer_default', 20);

/**
 * =================================================
 * Hook extice_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'extice_template_account_dropdown', 1);
add_action('wp_footer', 'extice_mobile_nav', 1);
add_action('wp_footer', 'render_html_back_to_top', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */
add_action('wp_head', 'extice_pingback_header', 1);

/**
 * =================================================
 * Hook extice_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook extice_before_content
 * =================================================
 */

/**
 * =================================================
 * Hook extice_content_top
 * =================================================
 */

/**
 * =================================================
 * Hook extice_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook extice_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook extice_sidebar
 * =================================================
 */
add_action('extice_sidebar', 'extice_get_sidebar', 10);

/**
 * =================================================
 * Hook extice_loop_after
 * =================================================
 */
add_action('extice_loop_after', 'extice_paging_nav', 10);

/**
 * =================================================
 * Hook extice_page_after
 * =================================================
 */
add_action('extice_page_after', 'extice_display_comments', 10);
