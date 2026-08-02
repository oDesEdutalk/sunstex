<?php
// Counter
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;

add_action( 'elementor/element/counter/section_number/before_section_end', function ( $element, $args ) {
    $element->add_control(
        'counter_prefix_color',
        [
            'label'     => esc_html__('Prefix Color', 'extice'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-counter-number-prefix' => 'color: {{VALUE}};',
            ],
        ]
    );
    $element->add_control(
        'counter_suffix_color',
        [
            'label'     => esc_html__('Suffix Color', 'extice'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-counter-number-suffix' => 'color: {{VALUE}};',
            ],
        ]
    );

    $element->add_control(
        'color_gradient',
        [
            'label'        => esc_html__('Color Gradient', 'extice'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'effect-gradient-',
        ]
    );

    $element->add_group_control(
        Group_Control_Background::get_type(),
        [
            'name'           => 'select_gradient',
            'label'          => esc_html__('Color', 'extice'),
            'types'          => ['gradient'],
            'selector'       => '{{WRAPPER}} .elementor-counter-number,{{WRAPPER}} .elementor-counter-number-prefix,{{WRAPPER}} .elementor-counter-number-suffix',
            'condition' => [
                'color_gradient!' => '',
            ],
        ]
    );

}, 10, 2 );

add_action( 'elementor/element/counter/section_counter_style/before_section_end', function ($element, $args ) {
    $element->update_responsive_control(
        'number_position',
        [
            'label'        => __('Number Position', 'extice'),
            'type'         => Controls_Manager::CHOOSE,
            'options'      => [
                'left' => [
                    'title' => esc_html__( 'Start', 'extice' ),
                    'icon' => "eicon-h-align-left",
                ],
                'center' => [
                    'title' => esc_html__( 'Center', 'extice' ),
                    'icon' => 'eicon-h-align-center',
                ],
                'right' => [
                    'title' => esc_html__( 'End', 'extice' ),
                    'icon' => "eicon-h-align-right",
                ],
            ],
            'default'      => 'center',
            'prefix_class' => 'elementor-position-',
            'selectors'    => [
                '{{WRAPPER}} .elementor-counter-number-wrapper' => 'justify-content: {{VALUE}}',
            ],
        ]
    );

    $element->add_control(
        'show_divider',
        [
            'label'        => esc_html__('Divider', 'extice'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'show-divider-',
        ]
    );

    $element->add_control(
        'divider_color',
        [
            'label'     => esc_html__('Divider Color', 'extice'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}}.show-divider-yes .elementor-counter' => '--bg-normal: {{VALUE}};',
            ],
            'condition' => [
                'show_divider' => 'yes',
            ]
        ]
    );

    $element->add_control(
        'divider_color_hover',
        [
            'label'     => esc_html__('Divider Color Hover', 'extice'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}}.show-divider-yes:hover .elementor-counter' => '--bg-hover: {{VALUE}};',
            ],
            'condition' => [
                'show_divider' => 'yes',
            ]
        ]
    );

    $element->add_responsive_control(
        'divider_position',
        [
            'label' => esc_html__('Divider Spacing', 'extice'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 0,
                    'max' => 100,
                ],
            ],
            'condition' => [
                'show_divider' => 'yes',
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-counter-title' => 'padding-bottom: {{SIZE}}{{UNIT}};',
            ],
        ]
    );

}, 10, 2 );