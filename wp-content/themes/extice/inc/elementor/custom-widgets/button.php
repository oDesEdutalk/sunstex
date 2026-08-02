<?php
// Button
use Elementor\Controls_Manager;

add_action('elementor/element/button/section_button/after_section_end', function ($element, $args) {
    /** @var \Elementor\Element_Base $element */
    $element->update_control(
        'button_type',
        [
            'label'        => esc_html__('Type', 'extice'),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'default',
            'options'      => [
                'default'   => esc_html__('Default', 'extice'),
                'outline' => esc_html__('OutLine', 'extice'),
                'info'    => esc_html__('Info', 'extice'),
                'success' => esc_html__('Success', 'extice'),
                'warning' => esc_html__('Warning', 'extice'),
                'danger'  => esc_html__('Danger', 'extice'),
                'type-link'  => esc_html__('Link', 'extice'),
            ],
            'prefix_class' => 'elementor-button-',
        ]
    );
}, 10, 2);

add_action('elementor/element/button/section_style/after_section_end', function ($element, $args) {

    $element->update_control(
        'button_text_color',
        [
            'global'    => [
                'default' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                '{{WRAPPER}}.elementor-button-type-link .elementor-button:after' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button svg' => 'fill: {{VALUE}};',
            ],
        ]
    );

    $element->update_control(
        'hover_color',
        [
            'global'    => [
                'default' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                '{{WRAPPER}}.elementor-button-type-link .elementor-button:before' => 'background-color: {{VALUE}};',
                '{{WRAPPER}} .elementor-button:hover svg' => 'fill: {{VALUE}};',
            ],
        ]
    );

    $element->update_control(
        'background_color',
        [
            'global'    => [
                'default' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}}; background-image: none;',
            ],
        ]
    );

    $element->update_control(
        'button_background_hover_color',
        [
            'global'    => [
                'default' => '',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}}; background-image: none;',
            ],
        ]
    );

}, 10, 2);

add_action('elementor/element/button/section_button/before_section_end', function ($element, $args) {
    $element->add_control(
        'icon_size',
        [
            'label' => esc_html__( 'Icon Size', 'extice' ),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'max' => 50,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button' => '--size-icon: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );

    $element->add_control(
        'button_icon_rotate',
        [
            'label' => esc_html__('Rotate Icon', 'extice'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'prefix_class' => 'button-icon-rotate-',
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
}, 10, 2);