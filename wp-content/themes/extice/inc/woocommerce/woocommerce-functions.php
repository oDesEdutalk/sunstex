<?php
/**
 * Checks if the current page is a product archive
 *
 * @return boolean
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function extice_is_product_archive() {
    if (is_shop() || is_product_taxonomy() || is_product_category() || is_product_tag()) {
        return true;
    } else {
        return false;
    }
}

/**
 * @param $product WC_Product
 */
function extice_product_get_image($product) {
    return $product->get_image();
}

/**
 * @param $product WC_Product
 */
function extice_product_get_price_html($product) {
    return $product->get_price_html();
}

/**
 * Retrieves the previous product.
 *
 * @param bool $in_same_term Optional. Whether post should be in a same taxonomy term. Default false.
 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
 * @param string $taxonomy Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
 * @return WC_Product|false Product object if successful. False if no valid product is found.
 * @since 2.4.3
 *
 */
function extice_get_previous_product($in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat') {
    $product = new Extice_WooCommerce_Adjacent_Products($in_same_term, $excluded_terms, $taxonomy, true);
    return $product->get_product();
}

/**
 * Retrieves the next product.
 *
 * @param bool $in_same_term Optional. Whether post should be in a same taxonomy term. Default false.
 * @param array|string $excluded_terms Optional. Comma-separated list of excluded term IDs. Default empty.
 * @param string $taxonomy Optional. Taxonomy, if $in_same_term is true. Default 'product_cat'.
 * @return WC_Product|false Product object if successful. False if no valid product is found.
 * @since 2.4.3
 *
 */
function extice_get_next_product($in_same_term = false, $excluded_terms = '', $taxonomy = 'product_cat') {
    $product = new Extice_WooCommerce_Adjacent_Products($in_same_term, $excluded_terms, $taxonomy);
    return $product->get_product();
}

function woocommerce_template_loop_rating() {

    global $product;
    if (!wc_review_ratings_enabled()) {
        return;
    }
    ?>
    <div class="count-review">
        <?php
        if ($rating_html = wc_get_rating_html($product->get_average_rating())) {
            echo apply_filters('extice_woocommerce_rating_html', $rating_html);
        } else {
            echo '<div class="star-rating"></div>';
        }
        ?>
    </div>
    <?php
}

if (!function_exists('extice_get_review_counting')) {
    function extice_get_review_counting() {

        global $post;
        $output = array();

        for ($i = 1; $i <= 5; $i++) {
            $args       = array(
                'post_id'    => ($post->ID),
                'meta_query' => array(
                    array(
                        'key'   => 'rating',
                        'value' => $i
                    )
                ),
                'count'      => true
            );
            $output[$i] = get_comments($args);
        }

        return $output;
    }
}