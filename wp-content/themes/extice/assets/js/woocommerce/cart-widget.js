jQuery(document).ready(function ($) {
    'use strict';

    $(document).on('change', '.woocommerce.widget_shopping_cart input.qty', function () {
        var $input    = $(this),
            value     = parseInt($input.val(), 10),
            $holder   = $input.closest('li'),
            itemHash  = $holder.find('.remove_from_cart_button').data('cart_item_key');

        if (!itemHash || isNaN(value) || value < 1) return;

        $holder.block({ message: null, overlayCSS: { opacity: 0.6 } });

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: extice_cart_widget_qty_ajax.ajax_url,
            data: {
                action:   'extice_change_widget_cart_qty',
                hash:     itemHash,
                quantity: value
            },
            success: function (response) {

                var $mini   = $holder.closest('.widget_shopping_cart_content'),
                    $subTot = $mini.find('.woocommerce-mini-cart__total .woocommerce-Price-amount.amount');
                if (response.data.subtotal_html && $subTot.length) {
                    $subTot.replaceWith(response.data.subtotal_html);
                }

                if (response.data.product_quantity) {
                    $holder.find('.cart-item').html(response.data.product_quantity);
                }
                // Refresh header icon
                $(document.body).trigger('wc_fragment_refresh');
            },
            complete: function () {
                $holder.unblock();
            }
        });
    });
});
