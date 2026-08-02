<?php

if (!defined('ABSPATH')) {
    exit;
}

class Extice_Widget_Product_Status extends WC_Widget {

    /**
     * Constructor.
     */
    public function __construct() {
        $this->widget_cssclass = 'woocommerce extice_widget_status widget_layered_nav';
        $this->widget_id       = 'extice_woocommerce_status';
        $this->widget_name     = esc_html__('Extice Product Status', 'extice');
        $this->settings        = array(
            'title' => array(
                'type'  => 'text',
                'std'   => esc_html__('Product Status', 'extice'),
                'label' => esc_html__('Title', 'extice'),
            )
        );
        parent::__construct();
    }


    /**
     * Output widget.
     *
     * @param array $args Arguments.
     * @param array $instance Instance.
     * @see WP_Widget
     *
     */
    public function widget($args, $instance) {
        if (!is_shop() && !is_product_taxonomy()) {
            return;
        }

        $this->widget_start($args, $instance);
        ?>
        <ul>
            <li class="<?php echo isset($_GET['stock_status']) && $_GET['stock_status'] == 'instock' ? 'chosen' : ''; ?>">
                <a href="<?php echo esc_url(add_query_arg('stock_status', 'instock')); ?>"><?php echo esc_html__('In Stock', 'extice'); ?></a>
            </li>
            <li class="<?php echo isset($_GET['on_sale']) && $_GET['on_sale'] == 'onsale' ? 'yes' : ''; ?>">
                <a href="<?php echo esc_url(add_query_arg('on_sale', 'yes')); ?>"><?php echo esc_html__('On Sale', 'extice'); ?></a>
            </li>
        </ul>
        <?php
        $this->widget_end($args);
    }

}

add_action('pre_get_posts', 'extice_filter_products_query');
function extice_filter_products_query($query) {
    if (!is_admin() && $query->is_main_query() && (is_shop() || is_product_taxonomy())) {
        if (isset($_GET['stock_status']) && $_GET['stock_status'] == 'instock') {
            $query->set('meta_query', array(
                array(
                    'key'   => '_stock_status',
                    'value' => 'instock',
                )
            ));
        }
        if (isset($_GET['on_sale']) && $_GET['on_sale'] == 'yes') {
            $query->set('post__in', array_merge(array(0), wc_get_product_ids_on_sale()));
        }
    }
}