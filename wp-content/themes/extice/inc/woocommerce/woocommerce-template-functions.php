<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (!function_exists('extice_before_content')) {
    /**
     * Before Content
     * Wraps all WooCommerce content in wrappers which match the theme markup
     *
     * @return  void
     * @since   1.0.0
     */
    function extice_before_content()
    {
        echo <<<HTML
<div id="primary" class="content-area">
    <main id="main" class="site-main">
HTML;

    }
}


if (!function_exists('extice_after_content')) {
    /**
     * After Content
     * Closes the wrapping divs
     *
     * @return  void
     * @since   1.0.0
     */
    function extice_after_content()
    {
        echo <<<HTML
	</main><!-- #main -->
</div><!-- #primary -->
HTML;

        do_action('extice_sidebar');
    }
}

if (!function_exists('extice_woo_cart_available')) {
    /**
     * Validates whether the Woo Cart instance is available in the request
     *
     * @return bool
     * @since 2.6.0
     */
    function extice_woo_cart_available()
    {
        $woo = WC();
        return $woo instanceof \WooCommerce && $woo->cart instanceof \WC_Cart;
    }
}

if (!function_exists('extice_cart_link_fragment')) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param array $fragments Fragments to refresh via AJAX.
     *
     * @return array            Fragments to refresh via AJAX
     */
    function extice_cart_link_fragment($fragments)
    {
        ob_start();
        extice_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        return $fragments;
    }
}

if (!function_exists('extice_cart_link')) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since  1.0.0
     */
    function extice_cart_link()
    {
        if (!extice_woo_cart_available()) {
            return;
        }
        ?>
        <a class="cart-contents" href="<?php echo esc_url(wc_get_cart_url()); ?>"
           title="<?php esc_attr_e('View your shopping cart', 'extice'); ?>">
            <span class="cart-content"><?php echo esc_html__('Cart', 'extice'); ?></span>
            <?php if (WC()->cart->get_cart_contents_count() != 0) { ?>
                <span class="count">(<?php echo wp_kses_data(sprintf('%d', WC()->cart->get_cart_contents_count())); ?>)</span>
            <?php } ?>
        </a>
        <?php
    }
}

if (!function_exists('extice_product_search')) {
    /**
     * Display Product Search
     *
     * @return void
     * @uses  extice_is_woocommerce_activated() check if WooCommerce is activated
     * @since  1.0.0
     */
    function extice_product_search()
    {
        if (extice_is_woocommerce_activated()) {
            static $index = 0;
            $index++;
            ?>
            <div class="site-search ajax-search">
                <div class="widget woocommerce widget_product_search">
                    <div class="ajax-search-result d-none"></div>
                    <form method="get" class="woocommerce-product-search"
                          action="<?php echo esc_url(home_url('/')); ?>">
                        <label class="screen-reader-text"
                               for="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>"><?php esc_html_e('Search for:', 'extice'); ?></label>
                        <input type="search"
                               id="woocommerce-product-search-field-<?php echo isset($index) ? absint($index) : 0; ?>"
                               class="search-field"
                               placeholder="<?php echo esc_attr__('Start your search here...', 'extice'); ?>"
                               autocomplete="off" value="<?php echo get_search_query(); ?>" name="s"/>
                        <button type="submit" value="<?php echo esc_attr_x('Search', 'submit button', 'extice'); ?>">
                            <span><?php echo esc_html_x('Search', 'submit button', 'extice'); ?></span>
                        </button>
                        <input type="hidden" name="post_type" value="product"/>
                    </form>
                </div>
            </div>
            <?php
        }
    }
}

if (!function_exists('extice_header_cart')) {
    /**
     * Display Header Cart
     *
     * @return void
     * @uses  extice_is_woocommerce_activated() check if WooCommerce is activated
     * @since  1.0.0
     */
    function extice_header_cart()
    {
        if (extice_is_woocommerce_activated()) {
            if (!extice_get_theme_option('show_header_cart', true)) {
                return;
            }
            ?>
            <div class="site-header-cart menu">
                <?php extice_cart_link(); ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('extice_header_cart_side')) {
    function extice_header_cart_side()
    {
        if (extice_is_woocommerce_activated()) {
            if (apply_filters('woocommerce_widget_cart_is_hidden', is_cart() || is_checkout())) {
                return;
            }
            ?>
            <div class="site-header-cart-side">
                <div class="cart-side-heading">
                    <span class="cart-side-title"><?php echo esc_html__('shopping cart', 'extice'); ?></span>
                    <a href="#" class="close-cart-side">
                        <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                             viewBox="0 0 23.691 22.723">
                            <g transform="translate(-126.154 -143.139)">
                                <line x2="23" y2="22" transform="translate(126.5 143.5)" fill="none"
                                      stroke="CurrentColor" stroke-width="1"></line>
                                <path d="M0,22,23,0" transform="translate(126.5 143.5)" fill="none"
                                      stroke="CurrentColor" stroke-width="1"></path>
                            </g>
                        </svg>
                    </a></div>
                <?php the_widget('WC_Widget_Cart', 'title='); ?>
            </div>
            <div class="cart-side-overlay"></div>
            <?php
        }
    }
}

if (!function_exists('extice_shop_messages')) {
    /**
     * ThemeBase shop messages
     *
     * @since   1.4.4
     * @uses    extice_do_shortcode
     */
    function extice_shop_messages()
    {
        if (!is_checkout()) {
            echo extice_do_shortcode('woocommerce_messages');
        }
    }
}

if (!function_exists('extice_woocommerce_pagination')) {
    /**
     * ThemeBase WooCommerce Pagination
     * WooCommerce disables the product pagination inside the woocommerce_product_subcategories() function
     * but since ThemeBase adds pagination before that function is excuted we need a separate function to
     * determine whether or not to display the pagination.
     *
     * @since 1.4.4
     */
    function extice_woocommerce_pagination()
    {
        if (woocommerce_products_will_display()) {
            woocommerce_pagination();
        }
    }
}


if (!function_exists('extice_single_product_pagination')) {
    /**
     * Single Product Pagination
     *
     * @since 2.3.0
     */
    function extice_single_product_pagination()
    {

        // Show only products in the same category?
        $in_same_term = apply_filters('extice_single_product_pagination_same_category', true);
        $excluded_terms = apply_filters('extice_single_product_pagination_excluded_terms', '');
        $taxonomy = apply_filters('extice_single_product_pagination_taxonomy', 'product_cat');

        $previous_product = extice_get_previous_product($in_same_term, $excluded_terms, $taxonomy);
        $next_product = extice_get_next_product($in_same_term, $excluded_terms, $taxonomy);

        if ((!$previous_product && !$next_product) || !is_product()) {
            return;
        }

        ?>
        <div class="extice-product-pagination-wrap">
            <nav class="extice-product-pagination" aria-label="<?php esc_attr_e('More products', 'extice'); ?>">
                <?php if ($previous_product) : ?>
                    <a href="<?php echo esc_url($previous_product->get_permalink()); ?>" rel="prev">
                        <span class="pagination-prev "><i
                                    class="extice-icon-arrow-left"></i><?php echo esc_html__('Prev', 'extice'); ?></span>
                        <div class="product-item">
                            <?php echo sprintf('%s', $previous_product->get_image()); ?>
                            <div class="extice-product-pagination-content">
                                <h4 class="extice-product-pagination__title"><?php echo sprintf('%s', $previous_product->get_name()); ?></h4>
                                <?php if ($price_html = $previous_product->get_price_html()) :
                                    printf('<span class="price">%s</span>', $price_html);
                                endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>

                <?php if ($next_product) : ?>
                    <a href="<?php echo esc_url($next_product->get_permalink()); ?>" rel="next">
                        <span class="pagination-next"><?php echo esc_html__('Next', 'extice'); ?><i
                                    class="extice-icon-arrow-right"></i></span>
                        <div class="product-item">
                            <?php echo sprintf('%s', $next_product->get_image()); ?>
                            <div class="extice-product-pagination-content">
                                <h4 class="extice-product-pagination__title"><?php echo sprintf('%s', $next_product->get_name()); ?></h4>
                                <?php if ($price_html = $next_product->get_price_html()) :
                                    printf('<span class="price">%s</span>', $price_html);
                                endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            </nav><!-- .extice-product-pagination -->
        </div>
        <?php

    }
}

if (!function_exists('extice_sticky_single_add_to_cart')) {
    /**
     * Sticky Add to Cart
     *
     * @since 2.3.0
     */
    function extice_sticky_single_add_to_cart()
    {
        global $product;

        if (!is_product()) {
            return;
        }

        $show = false;

        if ($product->is_purchasable() && $product->is_in_stock()) {
            $show = true;
        } else if ($product->is_type('external')) {
            $show = true;
        }

        if (!$show) {
            return;
        }

        $params = apply_filters(
            'extice_sticky_add_to_cart_params', array(
                'trigger_class' => 'entry-summary',
            )
        );

        wp_localize_script('extice-sticky-add-to-cart', 'extice_sticky_add_to_cart_params', $params);
        ?>

        <section class="extice-sticky-add-to-cart">
            <div class="col-fluid">
                <div class="extice-sticky-add-to-cart__content">
                    <?php echo woocommerce_get_product_thumbnail(); ?>
                    <div class="extice-sticky-add-to-cart__content-product-info">
						<span class="extice-sticky-add-to-cart__content-title"><?php esc_html_e('You\'re viewing:', 'extice'); ?>
							<strong><?php the_title(); ?></strong></span>
                        <span class="extice-sticky-add-to-cart__content-price"><?php echo sprintf('%s', $product->get_price_html()); ?></span>
                        <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                    </div>
                    <a href="<?php echo esc_url($product->add_to_cart_url()); ?>"
                       class="extice-sticky-add-to-cart__content-button button alt">
                        <?php echo esc_attr($product->add_to_cart_text()); ?>
                    </a>
                </div>
            </div>
        </section><!-- .extice-sticky-add-to-cart -->
        <?php
    }
}

if (!function_exists('extice_woocommerce_product_loop_action')) {
    function extice_woocommerce_product_loop_action()
    {
        ?>
        <div class="group-action">
            <div class="shop-action">
                <?php do_action('extice_woocommerce_product_loop_action'); ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('extice_single_product_summary_top')) {
    function extice_single_product_summary_top()
    {
        ?>
        <div class="product-labels single-product-labels">
            <?php woocommerce_show_product_loop_sale_flash(); ?>
        </div>
        <?php
    }
}

if (!function_exists('extice_product_label')) {
    function extice_product_label()
    {
        global $product;

        $output = array();

        if ($product->is_on_sale()) {

            $percentage = '';

            if ($product->get_type() == 'variable') {

                $available_variations = $product->get_variation_prices();
                $max_percentage = 0;

                foreach ($available_variations['regular_price'] as $key => $regular_price) {
                    $sale_price = $available_variations['sale_price'][$key];

                    if ($sale_price < $regular_price) {
                        $percentage = round((($regular_price - $sale_price) / $regular_price) * 100);

                        if ($percentage > $max_percentage) {
                            $max_percentage = $percentage;
                        }
                    }
                }

                $percentage = $max_percentage;
            } elseif (($product->get_type() == 'simple' || $product->get_type() == 'external')) {
                $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
            }

            if ($percentage) {
                $output[] = '<span class="product-label onsale">' . esc_html__('Sale ', 'extice') . $percentage . '%</span>';
            } else {
                $output[] = '<span class="product-label onsale">' . esc_html__('Sale', 'extice') . '</span>';
            }
        }

        if ($output) {
            echo implode('', $output);
        }
    }
}

add_filter('woocommerce_sale_flash', 'extice_product_label', 10);


if (!function_exists('extice_woocommerce_get_product_label_stock')) {
    function extice_woocommerce_get_product_label_stock()
    {
        /**
         * @var $product WC_Product
         */
        global $product;
        if (!$product->managing_stock()) { ?>
            <div class="inventory-stock">
                <?php
                if (!$product->is_in_stock()) {
                    echo '<span class="inventory_status out-of-stock">' . esc_html__('Out Of Stock', 'extice') . '</span>';
                } elseif ($product->is_on_backorder()) {
                    echo '<span class="inventory_status backorder">' . esc_html__('Available on backorder', 'extice') . '</span>';
                } else {
                    $stock_quantity = $product->get_stock_quantity();
                    echo '<span class="inventory_status in-stock">' . esc_html($stock_quantity . ' in stock') . '</span>';

                } ?>
            </div>
            <?php
        } else { ?>
            <div class="inventory-stock">
                <?php
                if (!$product->is_in_stock()) {
                    echo '<span class="inventory_status out-of-stock">' . esc_html__('Out Of Stock', 'extice') . '</span>';
                } elseif ($product->is_on_backorder(1) && $product->backorders_require_notification()) {
                    echo '<span class="inventory_status backorder">' . esc_html__('Available on backorder', 'extice') . '</span>';
                } else {
                    $stock_quantity = $product->get_stock_quantity();
                    echo '<span class="inventory_status in-stock">' . esc_html($stock_quantity . ' in stock') . '</span>';
                } ?>
            </div>
            <?php
        }
    }
}

if (!function_exists('extice_woocommerce_single_brand')) {
    function extice_woocommerce_single_brand()
    {
        $id = get_the_ID();

        $terms = get_the_terms($id, 'product_brand');

        if (is_wp_error($terms)) {
            return $terms;
        }

        if (empty($terms)) {
            return false;
        }

        $links = array();

        foreach ($terms as $term) {
            $link = get_term_link($term, 'product_brand');
            if (is_wp_error($link)) {
                return $link;
            }
            $links[] = '<a href="' . esc_url($link) . '" rel="tag">' . $term->name . '</a>';
        }
        echo '<div class="product-brand">' . esc_html__('Brand: ', 'extice') . join('', $links) . '</div>';
    }
}
if (!function_exists('extice_single_product_after_title')) {
    function extice_single_product_after_title()
    {
        ?>
        <div class="product_after_title">
            <?php
            extice_woocommerce_single_brand();
            woocommerce_template_single_rating();
            extice_woocommerce_get_product_label_stock();
            ?>
        </div>
        <?php
    }
}

if (!function_exists('extice_template_loop_product_thumbnail')) {
    function extice_template_loop_product_thumbnail($size = 'woocommerce_thumbnail')
    {
        global $product;
        if (!$product) {
            return '';
        }
        $gallery = $product->get_gallery_image_ids();
        $hover_skin = extice_get_theme_option('woocommerce_product_hover', 'none');

        if ($hover_skin == 'none' || count($gallery) <= 0) {
            echo '<div class="product-image image-main">' . woocommerce_get_product_thumbnail($size) . '</div>';

            return '';
        }
        $image_featured = '<div class="product-image image-main">' . woocommerce_get_product_thumbnail($size) . '</div>';
        $image_featured .= '<div class="product-image second-image">' . wp_get_attachment_image($gallery[0], $size) . '</div>';

        echo <<<HTML
<div class="product-img-wrap {$hover_skin}">
    <div class="inner">
        {$image_featured}
    </div>
</div>
HTML;
    }
}


if (!function_exists('extice_woocommerce_single_product_image_thumbnail_html')) {
    function extice_woocommerce_single_product_image_thumbnail_html($image, $attachment_id)
    {
        return wc_get_gallery_image_html($attachment_id, true);
    }
}

if (!function_exists('extice_woocommerce_single_product_image_thumbnail_html_sticky')) {
    function extice_woocommerce_single_product_image_thumbnail_html_sticky($image, $attachment_id)
    {
        return '<div class="swiper-slide">' . wc_get_gallery_image_html($attachment_id, true) . '</div>';
    }
}

if (!function_exists('woocommerce_template_loop_product_title')) {

    /**
     * Show the product title in the product loop.
     */
    function woocommerce_template_loop_product_title()
    {
        echo '<h3 class="woocommerce-loop-product__title"><a href="' . esc_url_raw(get_the_permalink()) . '">' . get_the_title() . '</a></h3>';
    }
}

if (!function_exists('extice_woocommerce_get_product_category')) {
    function extice_woocommerce_get_product_category()
    {
        global $product;
        echo wc_get_product_category_list($product->get_id(), ', ', '<div class="posted-in">', '</div>');
    }
}

if (!function_exists('extice_header_wishlist')) {
    function extice_header_wishlist()
    {
        if (function_exists('yith_wcwl_count_all_products')) {
            if (!extice_get_theme_option('show_header_wishlist', true)) {
                return;
            }
            ?>
            <div class="site-header-wishlist">
                <a class="header-wishlist"
                   href="<?php echo esc_url(get_permalink(get_option('yith_wcwl_wishlist_page_id'))); ?>">
                    <i class="extice-icon-favorite"></i>
                    <span class="count">(<?php echo esc_html(yith_wcwl_count_all_products()); ?>)</span>
                    <span class="wishlist-content"><?php echo esc_html__('Wishlist', 'extice'); ?></span>
                </a>
            </div>
            <?php
        } elseif (function_exists('woosw_init')) {
            if (!extice_get_theme_option('show_header_wishlist', true)) {
                return;
            }
            $key = WPCleverWoosw::get_key();
            $class = WPCleverWoosw::get_count($key) > 0 ? 'count' : 'count hide';
            ?>
            <div class="site-header-wishlist">
                <a class="header-wishlist" href="<?php echo esc_url(WPCleverWoosw::get_url($key, true)); ?>">
                    <i class="extice-icon-favorite"></i>
                    <span class="<?php echo esc_attr($class); ?>"><?php echo sprintf('%d', WPCleverWoosw::get_count($key)); ?></span>
                    <span class="wishlist-content"><?php echo esc_html__('Wishlist', 'extice'); ?></span>
                </a>
            </div>
            <?php
        }
    }
}

if (!function_exists('extice_product_time_sale')) {
    function extice_product_time_sale($disable_title = false)
    {
        /**
         * @var $product WC_Product
         */
        global $product;

        if (!$product->is_on_sale()) {
            return;
        }

        $time_sale = '';
        $show = '';
        $type = 'simple';

        if ($product->is_type('variable')) {
            $time_sale = [];
            $available_variations = $product->get_available_variations();
            foreach ($available_variations as $variation) {
                $variation_id = $variation['variation_id'];
                $time = intval(get_post_meta($variation_id, '_sale_price_dates_to', true)) + (get_option('gmt_offset') * HOUR_IN_SECONDS);
                if ($time) {
                    $time_sale[$variation_id] = intval(get_post_meta($variation_id, '_sale_price_dates_to', true)) + (get_option('gmt_offset') * HOUR_IN_SECONDS);
                }
            }
            $show = 'display:none;';
            $type = 'variable';
            $time_sale = json_encode($time_sale);
        } else {
            $time = intval(get_post_meta($product->get_id(), '_sale_price_dates_to', true)) + (get_option('gmt_offset') * HOUR_IN_SECONDS);
            if ($time) {
                $time_sale = $time;
            }
        }
        if (!empty($time_sale)) {
            wp_enqueue_script('extice-countdown-single');

            ?>
            <div class="time-sale" style="<?php echo esc_attr($show); ?>">
                <?php if (empty($disable_title)): ?>
                    <div class="title"><?php echo esc_html__('Hurry up! Flash sale ends in', 'extice'); ?></div>
                <?php endif; ?>
                <div class="extice-countdown <?php echo esc_attr($type); ?>" data-countdown="true"
                     data-date="<?php echo esc_attr($time_sale); ?>">
                    <div class="countdown-item">
                        <span class="countdown-digits countdown-days"></span>
                        <span class="countdown-label"><?php echo esc_html__('days', 'extice'); ?></span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-digits countdown-hours"></span>
                        <span class="countdown-label"><?php echo esc_html__('hrs', 'extice'); ?></span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-digits countdown-minutes"></span>
                        <span class="countdown-label"><?php echo esc_html__('mins', 'extice'); ?></span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-digits countdown-seconds"></span>
                        <span class="countdown-label"><?php echo esc_html__('secs', 'extice'); ?></span>
                    </div>
                </div>
            </div>
            <?php
        }
    }
}


if (!function_exists('extice_woocommerce_get_product_short_description')) {
    function extice_woocommerce_get_product_short_description()
    {
        global $post;
        $short_description = wp_trim_words(apply_filters('woocommerce_short_description', $post->post_excerpt), 20);
        if ($short_description) {
            ?>
            <p class="short-description">
                <?php echo sprintf('%s', $short_description); ?>
            </p>
            <?php
        }
    }
}
if (!function_exists('extice_woocommerce_group_action')) {
    function extice_woocommerce_group_action($position = 'left', $add_to_cart = false, $wislist = true, $compare = true, $quickview = true)
    {
        $class = 'tooltip-' . $position . ' ' . 'group-action'
        ?>
        <div class="<?php echo esc_attr($class); ?>">
            <div class="shop-action">
                <?php
                if ($wislist) {
                    extice_wishlist_button();
                }
                if ($compare) {
                    extice_compare_button();
                }
                if ($quickview) {
                    extice_quickview_button();
                }
                if ($add_to_cart) {
                    echo '<div class="opal-add-to-cart">';
                    woocommerce_template_loop_add_to_cart();
                    echo '</div>';
                }
                ?>
            </div>
        </div>
        <?php
    }
}

if (!function_exists('woocommerce_checkout_order_review_start')) {

    function woocommerce_checkout_order_review_start()
    {
        echo '<div class="checkout-review-order-table-wrapper">';
    }
}

if (!function_exists('woocommerce_checkout_order_review_end')) {

    function woocommerce_checkout_order_review_end()
    {
        echo '</div>';
    }
}

if (!function_exists('extice_output_product_data_accordion')) {
    function extice_output_product_data_accordion()
    {
        $product_tabs = apply_filters('woocommerce_product_tabs', array());
        if (!empty($product_tabs)) : ?>
            <div id="extice-accordion-container" class="woocommerce-tabs wc-tabs-wrapper product-accordions">
                <?php $_count = 0; ?>
                <?php foreach ($product_tabs as $key => $tab) : ?>
                    <div class="accordion-item">
                        <div class="accordion-head <?php echo esc_attr($key); ?>_tab js-btn-accordion"
                             id="tab-title-<?php echo esc_attr($key); ?>">
                            <div class="accordion-title">
                                <?php echo apply_filters('woocommerce_product_' . $key . '_tab_title', esc_html($tab['title']), $key); ?>
                            </div>
                        </div>
                        <div class="accordion-body js-card-body">
                            <?php call_user_func($tab['callback'], $key, $tab); ?>
                        </div>
                    </div>
                    <?php $_count++; ?>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }
}

if (!function_exists('extice_quickview_button')) {
    function extice_quickview_button()
    {
        if (function_exists('woosq_init')) {
            echo do_shortcode('[woosq]');
        }
    }
}

if (!function_exists('extice_compare_button')) {
    function extice_compare_button()
    {
        if (function_exists('woosc_init')) {
            echo do_shortcode('[woosc]');
        }
    }
}

if (!function_exists('extice_wishlist_button')) {
    function extice_wishlist_button()
    {
        if (function_exists('woosw_init')) {
            echo do_shortcode('[woosw]');
        }
    }
}

if (!function_exists('extice_button_shop_canvas')) {
    function extice_button_shop_canvas()
    {
        if (is_active_sidebar('sidebar-woocommerce-shop')) { ?>
            <a href="#" class="filter-toggle" aria-expanded="false">
                <span><?php esc_html_e('Filter', 'extice'); ?></span><i class="extice-icon-filter"></i>
            </a>
            <?php
        }
    }
}

if (!function_exists('extice_render_woocommerce_shop_canvas')) {
    function extice_render_woocommerce_shop_canvas()
    {
        if (is_active_sidebar('sidebar-woocommerce-shop') && extice_is_product_archive()) {
            ?>
            <div id="extice-canvas-filter" class="extice-canvas-filter">
                <div class="extice-canvas-header">
                    <span class="filter-close">
                        <svg class="close-icon" xmlns="http://www.w3.org/2000/svg" width="23.691" height="22.723"
                             viewBox="0 0 23.691 22.723">
                        <g transform="translate(-126.154 -143.139)">
                            <line x2="23" y2="22" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor"
                                  stroke-width="1"></line>
                            <path d="M0,22,23,0" transform="translate(126.5 143.5)" fill="none" stroke="CurrentColor"
                                  stroke-width="1"></path>
                        </g>
                    </svg>
                    </span>
                </div>

                <div class="extice-canvas-filter-wrap">
                    <?php if (extice_get_theme_option('woocommerce_archive_layout') == 'canvas' || extice_get_theme_option('woocommerce_archive_layout') == 'menu' || extice_get_theme_option('woocommerce_archive_layout') == 'fullwidth') {
                        dynamic_sidebar('sidebar-woocommerce-shop');
                    }
                    ?>
                </div>
            </div>
            <div class="extice-overlay-filter"></div>
            <?php
        }
    }
}

function extice_ajax_add_to_cart_add_fragments($fragments)
{
    $all_notices = WC()->session->get('wc_notices', array());
    $notice_types = apply_filters('woocommerce_notice_types', array('error', 'success', 'notice'));

    ob_start();
    foreach ($notice_types as $notice_type) {
        if (wc_notice_count($notice_type) > 0) {
            wc_get_template("notices/{$notice_type}.php", array(
                'notices' => array_filter($all_notices[$notice_type]),
            ));
        }
    }
    $fragments['notices_html'] = ob_get_clean();

    wc_clear_notices();

    return $fragments;
}

add_filter('woocommerce_add_to_cart_fragments', 'extice_ajax_add_to_cart_add_fragments');


if (!function_exists('extice_shop_page_link')) {
    function extice_shop_page_link($keep_query = false, $taxonomy = '')
    {
        // Base Link decided by current page
        if (is_post_type_archive('product') || is_page(wc_get_page_id('shop')) || is_shop()) {
            $link = get_permalink(wc_get_page_id('shop'));
        } elseif (is_product_category()) {
            $link = get_term_link(get_query_var('product_cat'), 'product_cat');
        } elseif (is_product_tag()) {
            $link = get_term_link(get_query_var('product_tag'), 'product_tag');
        } else {
            $queried_object = get_queried_object();
            $link = get_term_link($queried_object->slug, $queried_object->taxonomy);
        }

        if ($keep_query) {

            // Min/Max
            if (isset($_GET['min_price'])) {
                $link = add_query_arg('min_price', wc_clean($_GET['min_price']), $link);
            }

            if (isset($_GET['max_price'])) {
                $link = add_query_arg('max_price', wc_clean($_GET['max_price']), $link);
            }

            // Orderby
            if (isset($_GET['orderby'])) {
                $link = add_query_arg('orderby', wc_clean($_GET['orderby']), $link);
            }

            // Status
            if (isset($_GET['stock_status'])) {
                $link = add_query_arg('stock_status', wc_clean($_GET['stock_status']), $link);
            }

            if (isset($_GET['on_sale'])) {
                $link = add_query_arg('on_sale', wc_clean($_GET['on_sale']), $link);
            }

            if (isset($_GET['woocommerce_catalog_columns'])) {
                $link = add_query_arg('woocommerce_catalog_columns', wc_clean($_GET['woocommerce_catalog_columns']), $link);
            }

            $allowed_values = ['default', 'full'];
            if (isset($_GET['woocommerce_archive_width']) && in_array($_GET['woocommerce_archive_width'], $allowed_values, true)) {
                $link = add_query_arg('woocommerce_archive_width', wc_clean($_GET['woocommerce_archive_width']), $link);
            }

            if (isset($_GET['woocommerce_archive_layout'])) {
                $link = add_query_arg('woocommerce_archive_layout', wc_clean($_GET['woocommerce_archive_layout']), $link);
            }

            if (isset($_GET['wocommerce_block_style'])) {
                $link = add_query_arg('wocommerce_block_style', wc_clean($_GET['wocommerce_block_style']), $link);
            }

            /**
             * Search Arg.
             * To support quote characters, first they are decoded from &quot; entities, then URL encoded.
             */
            if (get_search_query()) {
                $link = add_query_arg('s', rawurlencode(wp_specialchars_decode(get_search_query())), $link);
            }

            // Post Type Arg
            if (isset($_GET['post_type'])) {
                $link = add_query_arg('post_type', wc_clean($_GET['post_type']), $link);
            }

            // Min Rating Arg
            if (isset($_GET['min_rating'])) {
                $link = add_query_arg('min_rating', wc_clean($_GET['min_rating']), $link);
            }

            // All current filters
            if ($_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes()) {
                foreach ($_chosen_attributes as $name => $data) {
                    if ($name === $taxonomy) {
                        continue;
                    }
                    $filter_name = sanitize_title(str_replace('pa_', '', $name));
                    if (!empty($data['terms'])) {
                        $link = add_query_arg('filter_' . $filter_name, implode(',', $data['terms']), $link);
                    }
                    if ('or' == $data['query_type']) {
                        $link = add_query_arg('query_type_' . $filter_name, 'or', $link);
                    }
                }
            }
        }

        if (is_string($link)) {
            return $link;
        } else {
            return '';
        }
    }
}


if (isset($_GET['per_page'])) {
    add_filter('loop_shop_per_page', 'extice_loop_shop_per_page', 20);
}

function extice_loop_shop_per_page($cols)
{

    $cols = isset($_GET['per_page']) ? $_GET['per_page'] : $cols;

    return $cols;
}

if (!function_exists('extice_active_filters')) {
    function extice_active_filters()
    {
        global $wp;
        $url = home_url(add_query_arg(array(), $wp->request));
        $link_remove_all = strtok($url, '?');
        echo '<div class="extice-active-filters">';
        the_widget('WC_Widget_Layered_Nav_Filters');

        $on_sale = isset($_GET['on_sale']) ? wc_clean(wp_unslash($_GET['on_sale'])) : 0;
        $stock_status = isset($_GET['stock_status']) ? wc_clean(wp_unslash($_GET['stock_status'])) : 0;
        $base_link = extice_shop_page_link(true);
        if ($on_sale || $stock_status) {
            echo '<div class="widget woocommerce widget_layered_nav_filters"><ul>';
            if ($on_sale) {
                $link = remove_query_arg('on_sale', $base_link);
                echo '<li class="chosen"><a rel="nofollow" aria-label="' . esc_attr__('Remove filter', 'extice') . '" href="' . esc_url($link) . '">' . esc_html__('On Sale', 'extice') . '</a></li>';
            }

            if ($stock_status) {
                $link = remove_query_arg('stock_status', $base_link);
                echo '<li class="chosen"><a rel="nofollow" aria-label="' . esc_attr__('Remove filter', 'extice') . '" href="' . esc_url($link) . '">' . esc_html__('In Stock', 'extice') . '</a></li>';
            }
            echo '</ul></div>';
        }


        echo '<a class="clear-all" href="' . esc_url($link_remove_all) . '">' . esc_html__('Clear All', 'extice') . '</a></div>';
    }
}

if (!function_exists('extice_single_product_no_tab')) {
    function extice_single_product_no_tab()
    {
        $product_tabs = apply_filters('woocommerce_product_tabs', array());
        if (!empty($product_tabs)) :
            ?>
            <div class="extice-product-no-tabs">
                <?php foreach ($product_tabs as $key => $product_tab) : ?>
                    <div id="tab-<?php echo esc_attr($key); ?>" class="section">
                        <?php printf('<h2>%s</h2>', $product_tab['title']) ?>
                        <div class="content">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }
}

if (!function_exists('extice_single_product_related_products')) {
    function extice_single_product_related_products()
    {
        if (is_singular('product')) {
            ?>
            <div class="extice-related-products">
                <div class="col-full">
                    <?php
                    woocommerce_upsell_display();
                    woocommerce_output_related_products();
                    ?>
                </div>
            </div>
            <?php
        }
    }
}

if (!function_exists('extice_single_product_no_tab')) {
    function extice_single_product_no_tab()
    {
        $product_tabs = apply_filters('woocommerce_product_tabs', array());
        if (!empty($product_tabs)) :
            ?>
            <div class="extice-product-no-tabs">
                <?php foreach ($product_tabs as $key => $product_tab) : ?>
                    <div id="tab-<?php echo esc_attr($key); ?>" class="section">
                        <?php printf('<h2>%s</h2>', $product_tab['title']) ?>
                        <div class="content">
                            <?php
                            if (isset($product_tab['callback'])) {
                                call_user_func($product_tab['callback'], $key, $product_tab);
                            }
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif;
    }
}

if (!function_exists('extice_single_product_loop_action')) {
    function extice_single_product_loop_action()
    {
        ?>
        <div class="single-product-group-action">
            <?php do_action('extice_woocommerce_single_product_loop_action'); ?>
            <div class="right">
                <?php
                extice_wishlist_button();
                extice_compare_button();
                ?>
            </div>
        </div>
        <?php
    }
}