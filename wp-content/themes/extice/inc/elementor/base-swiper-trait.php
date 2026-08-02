<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

trait Extice_Swiper_Functions_Trait
{
    protected function add_control_carousel($condition_value = [], $condition_key = 'condition')
    {
        $this->start_controls_section(
            'section_carousel_options',
            [
                'label' => esc_html__('Carousel Options', 'extice'),
                'type' => Controls_Manager::SECTION,
                $condition_key => $condition_value
            ]
        );

        $slides_to_show = range(1, 10);
        $slides_to_show = array_combine($slides_to_show, $slides_to_show);

        $this->add_responsive_control(
            'slides_to_show',
            [
                'label' => esc_html__('Slides to Show', 'extice'),
                'type' => Controls_Manager::TEXT,
                'frontend_available' => true,
                'default' => 3,
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .swiper:not(.swiper-initialized) .swiper-slide' => 'width: calc((100% - {{spaceBetween.SIZE}}{{spaceBetween.UNIT}}*({{VALUE}} - 1)) / {{VALUE}}); margin-right:{{spaceBetween.SIZE}}{{spaceBetween.UNIT}}',
                ],
                'condition' => [
                    'direction' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'slides_to_scroll',
            [
                'label' => esc_html__('Slides to Scroll', 'extice'),
                'type' => Controls_Manager::SELECT,
                'description' => esc_html__('Set how many slides are scrolled per swipe.', 'extice'),
                'options' => [
                        '' => esc_html__('Default', 'extice'),
                    ] + $slides_to_show,
                'frontend_available' => true,
                'condition' => [
                    'slides_to_show!' => '1',
                    'direction' => ''
                ],
            ]
        );

        $this->add_responsive_control(
            'spaceBetween',
            [
                'label' => esc_html__('Space Between', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'default' => [
                    'size' => 30
                ],
                'size_units' => ['px'],
                'render_type' => 'template',
                'selectors' => [
                    '{{WRAPPER}} .products' => '--gutter-width: {{SIZE}}{{UNIT}};',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'swiper_overflow',
            [
                'label' => esc_html__('Overflow', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none' => esc_html__('None', 'extice'),
                    'left' => esc_html__('Overflow to the left', 'extice'),
                    'right' => esc_html__('Overflow to the right', 'extice'),
                    'both' => esc_html__('Visible both', 'extice'),
                ],
                'frontend_available' => true,
                'prefix_class' => 'overflow-to-',
            ]
        );

        $this->add_control(
            'navigation',
            [
                'label' => esc_html__('Navigation', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'both' => esc_html__('Arrows and Dots', 'extice'),
                    'arrows' => esc_html__('Arrows', 'extice'),
                    'dots' => esc_html__('Dots', 'extice'),
                    'none' => esc_html__('None', 'extice'),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'navigation_type',
            [
                'label' => esc_html__('Dots Type', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'bullets',
                'options' => [
                    'bullets' => esc_html__('Bullets', 'extice'),
                    'fraction' => esc_html__('Fraction', 'extice'),
                ],
                'conditions' => [
                    'relation' => 'or',
                    'terms' => [
                        [
                            'name' => 'navigation',
                            'operator' => '==',
                            'value' => 'both',
                        ],
                        [
                            'name' => 'navigation',
                            'operator' => '==',
                            'value' => 'dots',
                        ],
                    ],
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'enable_scrollbar',
            [
                'label' => esc_html__('Scrollbar', 'extice'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'no',
                'frontend_available' => true,
            ]
        );


        $this->add_control(
            'allowTouchMove',
            [
                'label' => esc_html__('Allow Touch Move', 'extice'),
                'type' => Controls_Manager::SWITCHER,
                'default' => 'yes',
                'frontend_available' => true,
            ]
        );


        $this->add_responsive_control(
            'with_scrollbar',
            [
                'label' => esc_html__('With Scrollbar', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['%', 'custom'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 100
                ],
                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-scrollbar' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'spacing_scrollbar',
            [
                'label' => esc_html__('Spacing scrollbar', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => '',
                ],

                'condition' => [
                    'enable_scrollbar' => 'yes',
                ],
                'frontend_available' => true,
                'selectors' => [
                    '{{WRAPPER}} .swiper-scrollbar' => 'margin-top: {{SIZE}}{{UNIT}};',
                ]
            ]
        );


        $this->add_control(
            'lazyload',
            [
                'label' => esc_html__('Lazyload', 'extice'),
                'type' => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'mousewheel',
            [
                'label' => esc_html__('Mousewheel control', 'extice'),
                'type' => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoheight',
            [
                'label' => esc_html__('Auto Height', 'extice'),
                'type' => Controls_Manager::SWITCHER,
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => esc_html__('Autoplay', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'extice'),
                    'no' => esc_html__('No', 'extice'),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pause_on_hover',
            [
                'label' => esc_html__('Pause on Hover', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'extice'),
                    'no' => esc_html__('No', 'extice'),
                ],
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'pause_on_interaction',
            [
                'label' => esc_html__('Pause on Interaction', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'extice'),
                    'no' => esc_html__('No', 'extice'),
                ],
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'autoplay_speed',
            [
                'label' => esc_html__('Autoplay Speed', 'extice'),
                'type' => Controls_Manager::NUMBER,
                'default' => 5000,
                'condition' => [
                    'autoplay' => 'yes',
                ],
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        // Loop requires a re-render so no 'render_type = none'
        $this->add_control(
            'infinite',
            [
                'label' => esc_html__('Infinite Loop', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'yes',
                'options' => [
                    'yes' => esc_html__('Yes', 'extice'),
                    'no' => esc_html__('No', 'extice'),
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'effect',
            [
                'label' => esc_html__('Effect', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'slide',
                'options' => [
                    'slide' => esc_html__('Slide', 'extice'),
                    'fade' => esc_html__('Fade', 'extice'),
                ],
                'condition' => [
                    'slides_to_show' => '1',
                ],
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'speed',
            [
                'label' => esc_html__('Animation Speed', 'extice'),
                'type' => Controls_Manager::NUMBER,
                'default' => 500,
                'render_type' => 'none',
                'frontend_available' => true,
            ]
        );

        $this->add_control(
            'direction',
            [
                'label' => esc_html__('Direction', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'frontend_available' => true,
                'options' => [
                    '' => esc_html__('Horizontal', 'extice'),
                    'vertical' => esc_html__('Vertical', 'extice'),
                ],
            ]
        );

        $this->add_control(
            'rtl',
            [
                'label' => esc_html__('Direction Right/Left', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'ltr',
                'condition' => [
                    'direction' => ''
                ],
                'options' => [
                    'ltr' => esc_html__('Left', 'extice'),
                    'rtl' => esc_html__('Right', 'extice'),
                ],
            ]
        );

        $this->end_controls_section();

        $this->register_controls_navigation();
        $this->register_controls_dots();
    }

    protected function register_controls_dots()
    {
        $this->start_controls_section(
            'carousel_dots',
            [
                'label' => esc_html__('Carousel Dots', 'extice'),
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'enable_carousel',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'navigation',
                            'operator' => '!==',
                            'value' => 'none',
                        ],
                        [
                            'name' => 'navigation',
                            'operator' => '!==',
                            'value' => 'arrows',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'dots_position',
            [
                'label' => esc_html__('Position', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'outside',
                'options' => [
                    'outside' => esc_html__('Outside', 'extice'),
                    'inside' => esc_html__('Inside', 'extice'),
                ],
                'prefix_class' => 'elementor-pagination-position-',
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_alignment',
            [
                'label' => esc_html__('Alignment', 'extice'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'extice'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'text-align: {{VALUE}};'
                ],
                'condition' => [
                    'direction' => ''
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_size',
            [
                'label' => esc_html__('Size', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets' => '--size-dot: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-pagination-fraction' => '--size-dot: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => ['dots', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'dots_gap',
            [
                'label' => esc_html__('Gap', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 5,
                        'max' => 20,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullets' => '--swiper-pagination-bullet-horizontal-gap: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => ['dots', 'both'],
                    'navigation_type' => ['bullets'],
                ],
            ]
        );

        $this->start_controls_tabs('tabs_carousel_dots_style');

        $this->start_controls_tab(
            'tab_carousel_dots_normal',
            [
                'label' => esc_html__('Normal', 'extice'),
            ]
        );

        $this->add_control(
            'carousel_dots_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-fraction' => '--color-dot: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity',
            [
                'label' => esc_html__('Opacity', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_hover',
            [
                'label' => esc_html__('Hover', 'extice'),
            ]
        );

        $this->add_control(
            'carousel_dots_color_hover',
            [
                'label' => esc_html__('Color Hover', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .swiper-pagination-bullet:focus' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_hover',
            [
                'label' => esc_html__('Opacity', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet:hover' => 'opacity: {{SIZE}};',
                    '{{WRAPPER}} .swiper-pagination-bullet:focus' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_carousel_dots_activate',
            [
                'label' => esc_html__('Activate', 'extice'),
            ]
        );

        $this->add_control(
            'carousel_dots_color_activate',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'carousel_dots_opacity_activate',
            [
                'label' => esc_html__('Opacity', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-bullet' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'dots_vertical_value',
            [
                'label' => esc_html__('Spacing vertical', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination' => 'bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper~.swiper-pagination.swiper-pagination-horizontal' => 'bottom: {{SIZE}}{{UNIT}};',
                ]
            ]
        );

        $this->add_responsive_control(
            'dots_horizontal_value',
            [
                'label' => esc_html__('Spacing horizontal', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => '',
                ],
                'selectors' => [
                    '{{WRAPPER}} .swiper-pagination-vertical' => 'right: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .swiper-pagination-horizontal' => 'left: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->end_controls_section();
    }

    protected function register_controls_navigation()
    {
        $this->start_controls_section(
            'section_style_navigation',
            [
                'label' => esc_html__('Carousel Navigation', 'extice'),
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'enable_carousel',
                            'operator' => '==',
                            'value' => 'yes',
                        ],
                        [
                            'name' => 'navigation',
                            'operator' => '!==',
                            'value' => 'none',
                        ],
                        [
                            'name' => 'navigation',
                            'operator' => '!==',
                            'value' => 'dots',
                        ],
                    ],
                ],
            ]
        );

        $this->add_control(
            'heading_style_arrows',
            [
                'label' => esc_html__('Arrows', 'extice'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_size',
            [
                'label' => esc_html__('Size', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 60,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev i, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_width',
            [
                'label' => esc_html__('Width', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_height',
            [
                'label' => esc_html__('Height', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 200,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(

            Group_Control_Border::get_type(),
            [
                'name' => 'arrows_border',
                'selector' => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next',
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'arrows_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('arrows_tabs');

        $this->start_controls_tab('arrows_normal',
            [
                'label' => esc_html__('Normal', 'extice'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrows_box_shadow',
                'selector' => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next',
            ]
        );

        $this->add_control(
            'arrows_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev svg, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_background_color',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab('arrows_hover',
            [
                'label' => esc_html__('Hover', 'extice'),
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'arrows_box_shadow_hover',
                'selector' => '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover',
            ]
        );

        $this->add_control(
            'arrows_color_hover',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover svg, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover svg' => 'fill: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_background_color_hover',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev:hover, {{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );
        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'arrows_next_heading',
            [
                'label' => esc_html__('Next button', 'extice'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_next_vertical',
            [
                'label' => esc_html__('Next Vertical', 'extice'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'extice'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'extice'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-next-vertical-',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_next_vertical_value',
            [
                'type' => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'top: unset; bottom: unset; {{arrows_next_vertical.value}}: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                    'arrows_next_vertical' => ['top', 'bottom'],
                ],
            ]
        );

        $this->add_control(
            'arrows_next_horizontal',
            [
                'label' => esc_html__('Next Horizontal', 'extice'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-next-horizontal-',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );
        $this->add_responsive_control(
            'next_horizontal_value',
            [
                'type' => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => -45,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-next' => 'left: unset; right: unset;{{arrows_next_horizontal.value}}: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                    'arrows_next_horizontal' => ['left', 'right'],
                ],

            ]
        );

        $this->add_control(
            'arrows_prev_heading',
            [
                'label' => esc_html__('Prev button', 'extice'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_control(
            'arrows_prev_vertical',
            [
                'label' => esc_html__('Prev Vertical', 'extice'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'render_type' => 'ui',
                'options' => [
                    'top' => [
                        'title' => esc_html__('Top', 'extice'),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'bottom' => [
                        'title' => esc_html__('Bottom', 'extice'),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-prev-vertical-',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );

        $this->add_responsive_control(
            'arrows_prev_vertical_value',
            [
                'type' => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev' => 'top: unset; bottom: unset; {{arrows_prev_vertical.value}}: {{SIZE}}{{UNIT}};',
                ],

                'condition' => [
                    'navigation' => ['arrows', 'both'],
                    'arrows_prev_vertical' => ['top', 'bottom'],
                ],
            ]
        );

        $this->add_control(
            'arrows_prev_horizontal',
            [
                'label' => esc_html__('Prev Horizontal', 'extice'),
                'type' => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options' => [
                    'left' => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon' => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'elementor-swiper-button-prev-horizontal-',
                'condition' => [
                    'navigation' => ['arrows', 'both'],
                ],
            ]
        );
        $this->add_responsive_control(
            'arrows_prev_horizontal_value',
            [
                'type' => Controls_Manager::SLIDER,
                'show_label' => false,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => -1000,
                        'max' => 1000,
                        'step' => 1,
                    ],
                    '%' => [
                        'min' => -100,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-swiper-button.elementor-swiper-button-prev' => 'left: unset; right: unset; {{arrows_prev_horizontal.value}}: {{SIZE}}{{UNIT}};',
                ],

                'condition' => [
                    'navigation' => ['arrows', 'both'],
                    'arrows_prev_horizontal' => ['left', 'right'],
                ],
            ]
        );

        $this->end_controls_section();
    }


    public function render_swiper_pagination_navigation()
    {
        $settings = $this->get_settings_for_display();
        $enable_carousel = $settings['enable_carousel'] === 'yes';
        $show_dots = (in_array($settings['navigation'], ['dots', 'both']));
        $show_arrows = (in_array($settings['navigation'], ['arrows', 'both']));
        if ($settings['enable_scrollbar'] === 'yes') {
            ?>
            <div class="swiper-scrollbar"></div>
            <?php
        }
        if ($show_dots && $enable_carousel) : ?>
            <div class="swiper-pagination"></div>
        <?php endif; ?>
        <?php if ($show_arrows && $enable_carousel) {
        ?>
        <div class="elementor-swiper-button elementor-swiper-button-prev">
            <i class="extice-icon-arrow-left" aria-hidden="true"></i>
            <span class="elementor-screen-only"><?php echo esc_html__('Previous', 'extice'); ?></span>
        </div>
        <div class="elementor-swiper-button elementor-swiper-button-next">
            <i class="extice-icon-arrow-right" aria-hidden="true"></i>
            <span class="elementor-screen-only"><?php echo esc_html__('Next', 'extice'); ?></span>
        </div>
    <?php };
    }

    protected function get_data_elementor_columns()
    {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('row', 'class', 'd-grid');
        $this->add_render_attribute('item', 'class', 'grid-item');
        $enable_carousel = $settings['enable_carousel'] === 'yes';
        $class = $settings['slides_to_show'] == 'auto' ? 'swiper-autowidth' : '';
        if ($enable_carousel) {
            $this->add_render_attribute([
                'item' => [
                    'class' => 'swiper-slide',
                ],
                'wrapper' => [
                    'class' => 'extice-swiper swiper ' . $class,
                    'dir' => $settings['rtl'] ?: 'ltr',
                ],
                'row' => [
                    'class' => 'swiper-wrapper',
                ],
            ]);
            $this->remove_render_attribute('row', 'class', 'd-grid');
        }
    }
}