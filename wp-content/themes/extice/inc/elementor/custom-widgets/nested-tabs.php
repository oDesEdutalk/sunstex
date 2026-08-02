<?php
// nested-tabs
use Elementor\Controls_Manager;

add_action('elementor/element/nested-tabs/section_title_style/before_section_end', function ($element, $args) {
    /** @var \Elementor\Element_Base $element */

    $element->add_control(
        'tabs_heading_background_color',
        [
            'label' => esc_html__( 'Background Active', 'extice' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} > .elementor-widget-container > .e-n-tabs > .e-n-tabs-heading > .e-n-tab-title[aria-selected="true"] .e-n-tab-title-text' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} > .elementor-widget-container > .e-n-tabs[data-touch-mode="true"] > .e-n-tabs-heading > .e-n-tab-title[aria-selected="false"]:hover .e-n-tab-title-text' => 'background-color: {{VALUE}};',
            ],
            'separator' => 'before'
        ]
    );

    $element->add_responsive_control(
        'tabs_heading_border_radius',
        [
            'label'      => esc_html__('Border Radius', 'extice'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', '%'],
            'selectors'  => [
                '{{WRAPPER}} .e-n-tab-title-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );
    $element->add_responsive_control(
        'tabs_heading_padding',
        [
            'label'      => esc_html__('Padding', 'extice'),
            'type'       => Controls_Manager::DIMENSIONS,
            'size_units' => ['px', 'em', '%'],
            'selectors'  => [
                '{{WRAPPER}} .e-n-tab-title-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
        ]
    );

}, 10, 2);

add_action('elementor/element/nested-tabs/section_tabs/before_section_end', function ($element, $args) {
    $element->add_control(
        'style_icon',
        [
            'label'        => esc_html__('Style Icon', 'extice'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'style-icon-'
        ]
    );
}, 10, 2);
