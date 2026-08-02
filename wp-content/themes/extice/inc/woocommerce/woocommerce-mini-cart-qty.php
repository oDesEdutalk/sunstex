<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function extice_ajax_change_widget_cart_qty() {
    $cart_item_key = sanitize_text_field($_POST['hash']);
    $new_quantity = sanitize_text_field($_POST['quantity']);

    $cart_item_values = WC()->cart->get_cart_item($cart_item_key);
    $product_id = $cart_item_values['product_id'];
    $product = wc_get_product($product_id);

    $stock_quantity = $product->get_stock_quantity();
    if ($stock_quantity !== null && $new_quantity > $stock_quantity) {
        wp_send_json_error([
            'mess' => sprintf( __( 'You cannot add that amount to the cart - we have %1$s in stock and you already!.', 'extice' ), wc_format_stock_quantity_for_display( $stock_quantity, $product ))
        ]);
    }

    WC()->cart->set_quantity($cart_item_key, $new_quantity, true);

    wp_send_json_success([
        'subtotal_html' => WC()->cart->get_cart_subtotal(),
        'product_quantity' => $new_quantity
    ]);

    wp_die();
}

add_action('wp_ajax_extice_change_widget_cart_qty', 'extice_ajax_change_widget_cart_qty');
add_action('wp_ajax_nopriv_extice_change_widget_cart_qty', 'extice_ajax_change_widget_cart_qty');

add_action('wp_enqueue_scripts', function () {
    $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
    wp_register_script('extice-cart-widget', get_template_directory_uri() . '/assets/js/woocommerce/cart-widget' . $suffix . '.js', array('jquery'), EXTICE_VERSION, true);
    wp_localize_script('extice-cart-widget', 'extice_cart_widget_qty_ajax', ['ajax_url' => admin_url('admin-ajax.php')]);
    wp_enqueue_script('extice-cart-widget');
});