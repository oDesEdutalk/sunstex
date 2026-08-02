(function ($) {
    "use strict";
    $(window).on('elementor/frontend/init', () => {
        const addHandler = ($element) => {
            let hasStyle3 = $element.hasClass('elementor-service-style-3');
            if (hasStyle3) {
                let $itemChild = $element.find('.grid-item');
                $itemChild.first().addClass('active');
                $itemChild.on('mouseenter', function () {
                    $itemChild.removeClass('active');
                    $(this).addClass('active');
                });
            }
            elementorFrontend.elementsHandler.addHandler(exticeSwiperBase, {
                $element,
            });
        };
        elementorFrontend.hooks.addAction('frontend/element_ready/extice-services.default', addHandler);
    });
})(jQuery);