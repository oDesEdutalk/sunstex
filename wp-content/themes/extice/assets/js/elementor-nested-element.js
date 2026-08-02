elementorCommon.elements.$window.on("elementor/nested-element-type-loaded", function () {
    class ExticeNestedCarousel extends elementor.modules.elements.types.NestedElementBase {
        getType() {
            return "extice-nested-slide";
        }
    }
    /**
     * And below you register the element within elementor elements manager
     */
    elementor.elementsManager.registerElementType(new ExticeNestedCarousel());
});
