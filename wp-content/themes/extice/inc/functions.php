<?php
/**
 * Extice functions.
 *
 * @package extice
 */
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
if (!function_exists('extice_is_bcn_nav_activated')) {
    function extice_is_bcn_nav_activated() {
        return function_exists('bcn_display') ? true : false;
    }
}

if (!function_exists('extice_is_cmb2_activated')) {
    function extice_is_cmb2_activated() {
        return defined('CMB2_LOADED') ? true : false;
    }
}

if (!function_exists('extice_is_revslider_activated')) {
    function extice_is_revslider_activated() {
        return class_exists('RevSliderBase');
    }
}

if (!function_exists('extice_is_wpml_activated')) {
    function extice_is_wpml_activated() {
        return class_exists('SitePress') ? true : false;
    }
}

if (!function_exists('extice_is_woocommerce_activated')) {
    /**
     * Query WooCommerce activation
     */
    function extice_is_woocommerce_activated() {
        return class_exists('WooCommerce') ? true : false;
    }
}

if (!function_exists('extice_is_dokan_activated')) {
    /**
     * Query WooCommerce activation
     */
    function extice_is_dokan_activated() {
        return class_exists('WeDevs_Dokan') ? true : false;
    }
}


if (!function_exists('extice_is_mas_woocommerce_brands_activated')) {
    /**
     * Query WooCommerce activation
     */
    function extice_is_mas_woocommerce_brands_activated() {
        return class_exists( 'Mas_WC_Brands' ) ? true : false;
    }
}


if (!function_exists('extice_is_elementor_activated')) {
    function extice_is_elementor_activated() {
        return defined('ELEMENTOR_VERSION') ? true : false;
    }
}

if (!function_exists('extice_is_elementor_pro_activated')) {
    function extice_is_elementor_pro_activated() {
        return defined('ELEMENTOR_PRO_VERSION') ? true : false;
    }
}

if (!function_exists('extice_is_redux_activated')) {
    function extice_is_redux_activated() {
        return class_exists('Redux') ? true : false;
    }
}

if (!function_exists('extice_is_contactform_activated')) {
    function extice_is_contactform_activated() {
        return class_exists('WPCF7');
    }
}

if (!function_exists('extice_is_mailchimp_activated')) {
    function extice_is_mailchimp_activated() {
        return defined('MC4WP_VERSION') ? true : false;
    }
}


/**
 * Call a shortcode function by tag name.
 *
 * @param string $tag The shortcode whose function to call.
 * @param array $atts The attributes to pass to the shortcode function. Optional.
 * @param array $content The shortcode's content. Default is null (none).
 *
 * @return string|bool False on failure, the result of the shortcode on success.
 * @since  1.4.6
 *
 */
function extice_do_shortcode($tag, array $atts = array(), $content = null) {
    global $shortcode_tags;

    if (!isset($shortcode_tags[$tag])) {
        return false;
    }

    return call_user_func($shortcode_tags[$tag], $atts, $content, $tag);
}

function extice_function_to_call($type, $args)
{
    $function_name = "register_" . $type;
    if (function_exists($function_name)) {
        call_user_func($function_name, ...$args);
    }
}

/*
 * get theme option redux
 * @param string $option_name
 * @param mix $default
 * @return mix
 *
 * */

if (!function_exists('extice_get_theme_option')) {
    function extice_get_theme_option($option_name, $default = false) {

        if ($option = get_option('extice_options_' . $option_name)) {
            $default = $option;
        }

        return  $default;
    }
}


if (!function_exists('extice_get_post_meta')) {
    function extice_get_post_meta($post_id, $meta_name, $default = false) {
        $value = get_post_meta($post_id, $meta_name, true);
        if (!$value) {
            return $default;
        }

        return $value;
    }
}

/**
 * @param $value
 *
 * @return string
 */
function extice_sanitize_editor($value) {
    return force_balance_tags(apply_filters('the_content', $value));
}

function extice_sanitize_button_switch($value) {
    if ($value) {
        return true;
    } else {
        return false;
    }
}

function extice_parse_text_editor( $content ) {

    $content = shortcode_unautop( $content );
    $content = do_shortcode( $content );
    $content = wptexturize( $content );

    if ( $GLOBALS['wp_embed'] instanceof \WP_Embed ) {
        $content = $GLOBALS['wp_embed']->autoembed( $content );
    }

    return $content;
}

function extice_add_meta($type, $callback, $priority = 10, $accepted_args = 1)
{
    $action_name = "add_meta_" . $type;
    if (has_action($action_name)) {
        add_action($action_name, $callback, $priority, $accepted_args);
    }
}

function extice_add_meta_fn($type, $args)
{
    $function_name = "add_meta_" . $type;
    if (function_exists($function_name)) {
        call_user_func($function_name, ...$args);
    }
}

if (!function_exists('extice_get_page_by_title')) {
    function extice_get_page_by_title($title,$output = OBJECT, $post_type = 'page') {
        $query = new WP_Query(
            [
                'post_type' => $post_type,
                'title'     => $title,
                'post_status' => 'publish',
                'posts_per_page' => 1,
            ]
        );

        if ( $query->have_posts() ) {
            $query->the_post();
            $page = get_post(get_the_ID(),$output);
        } else {
            $page = null;
        }

        wp_reset_postdata();

        return $page;

    }
}

if (!function_exists('extice_sanitize_image')) {
    function extice_sanitize_image($file, $setting) {

        $mimes = array(
            'jpg|jpeg|jpe' => 'image/jpeg',
            'gif'          => 'image/gif',
            'png'          => 'image/png',
            'bmp'          => 'image/bmp',
            'tif|tiff'     => 'image/tiff',
            'ico'          => 'image/x-icon'
        );

        //check file type from file name
        $file_ext = wp_check_filetype($file, $mimes);

        //if file has a valid mime type return it, otherwise return default
        return ($file_ext['ext'] ? $file : $setting->default);
    }
}

if ( ! function_exists( 'extice_write_to_file' ) ) {
    function extice_write_to_file( $file_path, $content ) {
        if ( ! function_exists( 'WP_Filesystem' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        global $wp_filesystem;
        if ( ! WP_Filesystem() ) {
            return false;
        }
        return $wp_filesystem->put_contents( $file_path, $content, FS_CHMOD_FILE );
    }
}

if ( ! function_exists( 'extice_read_from_file' ) ) {
    function extice_read_from_file( $file ) {
        if ( ! function_exists( 'WP_Filesystem' ) ) {
            require_once( ABSPATH . 'wp-admin/includes/file.php' );
        }
        global $wp_filesystem;
        if ( ! WP_Filesystem() ) {
            return false;
        }
        return $wp_filesystem->get_contents( $file );
    }
}