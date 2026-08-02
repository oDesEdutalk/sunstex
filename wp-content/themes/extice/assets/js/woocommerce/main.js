(function ($) {
    'use strict';
    var $body = $('body');

    function tooltip() {
        $body.on('mouseenter', '.group-action.tooltip-left .opal-add-to-cart:not(.tooltipstered), .group-action.tooltip-left .woosw-btn:not(.tooltipstered), .group-action.group-action.tooltip-left .woosq-btn:not(.tooltipstered), .group-action.group-action.tooltip-left .woosc-btn:not(.tooltipstered)', function () {
            var $element = $(this);
            if (typeof $.fn.tooltipster !== 'undefined') {
                $element.tooltipster({
                    position: 'left',
                    functionBefore: function (instance, helper) {
                        instance.content(instance._$origin.text());
                    },
                    theme: 'opal-product-tooltipster',
                    delay: 0,
                    animation: 'grow'
                }).tooltipster('show');
            }
        });

        $body.on('mouseenter', '.group-action.tooltip-top .opal-add-to-cart:not(.tooltipstered),.group-action.tooltip-top .woosw-btn:not(.tooltipstered), .group-action.group-action.tooltip-top .woosq-btn:not(.tooltipstered), .group-action.group-action.tooltip-top .woosc-btn:not(.tooltipstered)', function () {
            var $element = $(this);
            if (typeof $.fn.tooltipster !== 'undefined') {
                $element.tooltipster({
                    position: 'top',
                    functionBefore: function (instance, helper) {
                        instance.content(instance._$origin.text());
                    },
                    theme: 'opal-product-tooltipster',
                    delay: 0,
                    animation: 'grow'
                }).tooltipster('show');
            }
        });
    }

    function ajax_wishlist_count() {

        $body.on('woosw_change_count', function (event, count) {
            var counter = $('.header-wishlist .count, .footer-wishlist .count');
            if (count == 0) {
                counter.addClass('hide');
            } else {
                counter.removeClass('hide');
            }
            counter.html(count.toString());
        });
    }

    function ajax_compare_count() {
        $body.on('woosc_change_count', function (event, count) {
            var counter = $('.woosc-menu a .count');
            counter.html(count.toString());
        });
    }


    $(document).ready(function () {
        tooltip();
    });

    ajax_wishlist_count();
    ajax_compare_count();
})(jQuery);
