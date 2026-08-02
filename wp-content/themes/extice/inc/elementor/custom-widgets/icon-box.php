<?php
// Icon Box
use Elementor\Controls_Manager;
add_action( 'elementor/element/icon-box/section_style_box/after_section_end', function ( $element, $args ) {
    $element->update_control(
        'title_bottom_space',
        [
            'label' => esc_html__( 'Content Spacing', 'extice' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'em', 'rem', 'custom' ],
            'range' => [
                'px' => [
                    'max' => 100,
                ],
                'em' => [
                    'min' => 0,
                    'max' => 10,
                ],
                'rem' => [
                    'min' => 0,
                    'max' => 10,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}}' => '--content_space: {{SIZE}}{{UNIT}};',
            ],
        ]
    );
}, 10, 2 );

add_action( 'elementor/element/icon-box/section_style_box/before_section_end', function ( $element, $args ) {
    $element->add_control(
        'show_divider',
        [
            'label' => esc_html__('Divider', 'extice'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'prefix_class' => 'show-divider-',
        ]
    );
}, 10, 2 );
