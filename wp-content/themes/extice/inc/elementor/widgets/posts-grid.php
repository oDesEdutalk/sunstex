<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

/**
 * Class Extice_Elementor_Blog
 */
class Extice_Elementor_Post_Grid extends Extice_Base_Widgets_Swiper {

    public function get_name() {
        return 'extice-post-grid';
    }

    public function get_title() {
        return esc_html__('Posts Grid', 'extice');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array('extice-addons');
    }

    public function get_script_depends() {
        return ['extice-elementor-posts-grid', 'extice-elementor-swiper'];
    }

    public function on_export($element) {
        unset($element['settings']['categories']);
        unset($element['settings']['tag']);

        return $element;
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Query', 'extice'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => esc_html__('Posts Per Page', 'extice'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'extice'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order By', 'extice'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date'  => esc_html__('Date', 'extice'),
                    'post_title' => esc_html__('Title', 'extice'),
                    'menu_order' => esc_html__('Menu Order', 'extice'),
                    'rand'       => esc_html__('Random', 'extice'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'extice'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => esc_html__('ASC', 'extice'),
                    'desc' => esc_html__('DESC', 'extice'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'       => esc_html__('Categories', 'extice'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_post_categories(),
                'label_block' => true,
                'multiple'    => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label'     => esc_html__('Category Operator', 'extice'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'extice'),
                    'IN'     => esc_html__('IN', 'extice'),
                    'NOT IN' => esc_html__('NOT IN', 'extice'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'tags',
            [
                'label'       => esc_html__('Tags', 'extice'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_post_tags(),
                'label_block' => true,
                'multiple'    => true,
            ]
        );

        $this->add_control(
            'tag_operator',
            [
                'label'     => esc_html__('Tags Operator', 'extice'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'extice'),
                    'IN'     => esc_html__('IN', 'extice'),
                    'NOT IN' => esc_html__('NOT IN', 'extice'),
                ],
                'condition' => [
                    'tags!' => ''
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'extice'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'post_style',
            [
                'label'        => esc_html__('Style', 'extice'),
                'type'         => \Elementor\Controls_Manager::SELECT,
                'options'      => [
                    'post-grid' => esc_html__('Style Grid', 'extice'),
                    'post-list' => esc_html__('Style List', 'extice'),
                    'post-style-1' => esc_html__('Style 1', 'extice'),
                    'post-style-2' => esc_html__('Style 2', 'extice'),
                    'post-style-3' => esc_html__('Style 3', 'extice'),
                ],
                'default'      => 'post-grid',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'     => esc_html__('Columns', 'extice'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 3,
                'options'   => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'condition' => [
                    'enable_carousel!' => 'yes',
                    'post_style!'      => [ 'post-style-1', 'post-style-2' ],
                ]
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label'      => esc_html__('Spacing', 'extice'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default'    => [
                    'size' => 30
                ],
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .d-grid' => 'grid-gap:{{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-post-wrapper' => '--grid-gap:{{SIZE}}{{UNIT}}',
                ],
                'condition'  => [
                    'enable_carousel!' => 'yes',
                ]
            ]
        );
        $this->add_control(
            'enable_carousel',
            [
                'label'     => esc_html__('Enable Carousel', 'extice'),
                'type'      => Controls_Manager::SWITCHER,
                'condition'  => [
                    'post_style!'      => [ 'post-style-1', 'post-style-2' ],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination',
            [
                'label'     => esc_html__('Pagination', 'extice'),
                'condition' => [
                    'enable_carousel!' => 'yes',
                    'post_style!'      => [ 'post-style-1', 'post-style-2' ],
                ]
            ]

        );

        $this->add_control(
            'pagination_type',
            [
                'label'   => esc_html__('Pagination', 'extice'),
                'type'    => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    ''                      => esc_html__('None', 'extice'),
                    'numbers'               => esc_html__('Numbers', 'extice'),
                    'prev_next'             => esc_html__('Previous/Next', 'extice'),
                    'numbers_and_prev_next' => esc_html__('Numbers', 'extice') . ' + ' . esc_html__('Previous/Next', 'extice'),
                ],
            ]
        );

        $this->add_control(
            'pagination_page_limit',
            [
                'label'     => esc_html__('Page Limit', 'extice'),
                'default'   => '5',
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );

        $this->add_control(
            'pagination_numbers_shorten',
            [
                'label'     => esc_html__('Shorten', 'extice'),
                'type'      => Controls_Manager::SWITCHER,
                'default'   => '',
                'condition' => [
                    'pagination_type' => [
                        'numbers',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_prev_label',
            [
                'label'     => esc_html__('Previous Label', 'extice'),
                'default'   => esc_html__('&laquo; Previous', 'extice'),
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_next_label',
            [
                'label'     => esc_html__('Next Label', 'extice'),
                'default'   => esc_html__('Next &raquo;', 'extice'),
                'condition' => [
                    'pagination_type' => [
                        'prev_next',
                        'numbers_and_prev_next',
                    ],
                ],
            ]
        );

        $this->add_control(
            'pagination_align',
            [
                'label'     => esc_html__('Alignment', 'extice'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start'   => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'extice'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'  => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-pagination' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'item_style',
            [
                'label' => esc_html__('Item', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .blog-grid' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'condition' => [
                    'post_style' => 'post-grid',
                ]
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'item_border',
                'selector' => '{{WRAPPER}} .post-inner',
                'separator' => 'before',
            ]
        );


        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'item_shadow',
                'selector' => '{{WRAPPER}} .post-inner',
            ]
        );

        $this->add_control(
            'item_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'extice' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .post-inner' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_border_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_gap',
            [
                'label'      => esc_html__('Item Spacing', 'extice'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'default'    => [
                    'size' => 30
                ],
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .blog-list' => 'gap:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'post_style' => 'post-list',
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'content_style',
            [
                'label' => esc_html__('Content', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'height',
            [
                'label' => esc_html__( 'Height', 'extice' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem', 'vh', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-post-grid .post-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
                    '{{WRAPPER}} .elementor-post-list .post-thumbnail' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );


        $this->add_responsive_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .post-thumbnail' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'category_style',
            [
                'label' => esc_html__('Category', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'cat_typography',
                'selector' => '{{WRAPPER}} .categories-link a',
            ]
        );


        $this->start_controls_tabs( 'cat_color_tabs' );

        $this->start_controls_tab( 'cat_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'extice' ),
            ]
        );

        $this->add_control(
            'cat_color',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .categories-link a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'cat_bg_color',
            [
                'label' => esc_html__( 'Background Color', 'extice' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .categories-link a' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'cat_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'extice' ),
            ]
        );
        $this->add_control(
            'cat_color_hover',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .categories-link a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'cat_bg_hover',
            [
                'label' => esc_html__( 'Background Color', 'extice' ),
                'type' => Controls_Manager::COLOR,

                'selectors' => [
                    '{{WRAPPER}} .categories-link a:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_responsive_control(
            'cat_border_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .categories-link a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'cat_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .categories-link a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .grid-item .entry-title',
            ]
        );

        $this->start_controls_tabs( 'title_color_tabs' );

        $this->start_controls_tab( 'title_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'extice' ),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'title_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'extice' ),
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();


        $this->add_responsive_control(
            'title_margin',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .entry-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );



        $this->end_controls_section();

        $this->start_controls_section(
            'meta_style',
            [
                'label' => esc_html__('Meta', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'meta_typography',
                'selector' => '{{WRAPPER}} .grid-item .entry-meta',
            ]
        );


        $this->add_responsive_control(
            'meta_margin',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .entry-meta' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );


        $this->start_controls_tabs( 'meta_color_tabs' );

        $this->start_controls_tab( 'meta_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'extice' ),
            ]
        );
        $this->add_control(
            'meta_color',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-meta, {{WRAPPER}} .entry-meta a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'meta_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'extice' ),
            ]
        );
        $this->add_control(
            'meta_color_hover',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .entry-meta a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();



        $this->start_controls_section(
            'readmore_style',
            [
                'label' => esc_html__('Read More', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs( 'readmore_color_tabs' );

        $this->start_controls_tab( 'readmore_colors_normal',
            [
                'label' => esc_html__( 'Normal', 'extice' ),
            ]
        );
        $this->add_control(
            'readmore_color',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .more-link-wrap a.more-link' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .more-link-wrap a.more-link i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'readmore_colors_hover',
            [
                'label' => esc_html__( 'Hover', 'extice' ),
            ]
        );
        $this->add_control(
            'readmore_color_hover',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .more-link-wrap a.more-link:hover' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .more-link-wrap a.more-link:hover i' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->add_control_carousel(['enable_carousel' => 'yes']);
    }

    protected function get_post_tags() {
        $tags    = get_terms(array(
                'taxonomy'   => 'post_tag',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $results[$tag->slug] = $tag->name;
            }
        }
        return $results;
    }

    protected function get_post_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'category',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = $this->query_posts();

        if (!$query->found_posts) {
            return;
        }

        $this->add_render_attribute('wrapper', 'class', 'elementor-post-wrapper');

        $this->add_render_attribute('wrapper', 'class', 'elementor-' . esc_attr($settings['post_style']));
        $this->get_data_elementor_columns();

        ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <?php
                $style1 = $settings['post_style'] === 'post-style-1';
                $style2 = $settings['post_style'] === 'post-style-2';
                $style3 = $settings['post_style'] === 'post-style-3';
                ?>

                <?php if ($style1): ?>
                    <div class="blog-style-overlay">
                        <?php
                        $count = 0;
                        $content_html = '';
                        while ($query->have_posts()) :
                            $query->the_post();
                             if ($count < 1) {
                                get_template_part('template-parts/posts-grid/item-post-overlay');
                             } else {
                                 ob_start();
                                 get_template_part('template-parts/posts-grid/item-post-list-1');
                                 $content_html .= ob_get_clean();
                             }

                            $count++;
                        endwhile; ?>
                    </div>
                    <div class="blog-style-list">
                        <?php printf('%s', $content_html); ?>
                    </div>
                <?php elseif ($style2): ?>
                    <div class="blog-style-grid">
                        <?php
                        $count = 0;
                        $content_html = '';
                        while ($query->have_posts()) :
                            $query->the_post();
                            if ($count < 1) {
                                get_template_part('template-parts/posts-grid/item-post-grid');
                            } else {
                                ob_start();
                                get_template_part('template-parts/posts-grid/item-post-list-1');
                                $content_html .= ob_get_clean();
                            }

                            $count++;
                        endwhile; ?>
                    </div>
                    <div class="blog-column">
                        <?php printf('%s', $content_html); ?>
                    </div>
                <?php elseif ($style3): ?>
                    <div <?php $this->print_render_attribute_string('row'); ?>>
                        <?php
                        while ($query->have_posts()) :
                            $query->the_post();
                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <?php get_template_part('template-parts/posts-grid/item-post-grid');?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div <?php $this->print_render_attribute_string('row'); ?>>
                        <?php

                        $allowed_styles = [
                            'post-grid', 'post-list'
                        ];

                        $style = $settings['post_style'] ?? 'post-grid';

                        if ( ! in_array( $style, $allowed_styles, true ) ) {
                            $style = 'post-grid';
                        }

                        while ($query->have_posts()) :
                            $query->the_post();
                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <?php get_template_part('template-parts/posts-grid/item', $style);?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php if ($settings['pagination_type'] && !empty($settings['pagination_type'])): ?>
                <?php $this->render_loop_footer(); ?>
            <?php endif; ?>
        <?php $this->render_swiper_pagination_navigation(); ?>
        <?php

        wp_reset_postdata();

    }

    public function query_posts() {
        $query_args = $this->get_query_args($this->get_settings());
        return new WP_Query($query_args);
    }

    public static function get_query_args($settings) {
        $query_args = [
            'post_type'           => 'post',
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish', // Hide drafts/private posts for admins
        ];

        if (!empty($settings['categories'])) {
            $categories = array();
            foreach ($settings['categories'] as $category) {
                $cat = get_term_by('slug', $category, 'category');
                if (!is_wp_error($cat) && is_object($cat)) {
                    $categories[] = $cat->term_id;
                }
            }

            if ($settings['cat_operator'] == 'AND') {
                $query_args['category__and'] = $categories;
            } elseif ($settings['cat_operator'] == 'IN') {
                $query_args['category__in'] = $categories;
            } else {
                $query_args['category__not_in'] = $categories;
            }
        }

        if (!empty($settings['tags'])) {
            $tags = array();
            foreach ($settings['tags'] as $tag) {
                $tag = get_term_by('slug', $tag, 'post_tag');
                if (!is_wp_error($tag) && is_object($tag)) {
                    $tags[] = $tag->term_id;
                }
            }

            if ($settings['tag_operator'] == 'AND') {
                $query_args['tag__and'] = $tags;
            } elseif ($settings['tag_operator'] == 'IN') {
                $query_args['tag__in'] = $tags;
            } else {
                $query_args['tag__not_in'] = $tags;
            }
        }

        $query_args['posts_per_page'] = $settings['posts_per_page'];

        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        return $query_args;
    }

    protected function render_loop_footer() {

        $parent_settings = $this->get_settings();
        if ('' === $parent_settings['pagination_type']) {
            return;
        }

        $page_limit = $this->query_posts()->max_num_pages;
        if ('' !== $parent_settings['pagination_page_limit']) {
            $page_limit = min($parent_settings['pagination_page_limit'], $page_limit);
        }

        if (2 > $page_limit) {
            return;
        }

        $this->add_render_attribute('pagination', 'class', 'elementor-pagination');

        $has_numbers   = in_array($parent_settings['pagination_type'], ['numbers', 'numbers_and_prev_next']);
        $has_prev_next = in_array($parent_settings['pagination_type'], ['prev_next', 'numbers_and_prev_next']);

        $links = [];

        if ($has_numbers) {
            $links = paginate_links([
                'type'               => 'array',
                'current'            => $this->get_current_page(),
                'total'              => $page_limit,
                'prev_next'          => false,
                'show_all'           => 'yes' !== $parent_settings['pagination_numbers_shorten'],
                'before_page_number' => '<span class="elementor-screen-only">' . esc_html__('Page', 'extice') . '</span>',
            ]);
        }

        if ($has_prev_next) {
            $prev_next = $this->get_posts_nav_link($page_limit);
            array_unshift($links, $prev_next['prev']);
            $links[] = $prev_next['next'];
        }

        ?>
        <div class="pagination">
            <nav class="elementor-pagination" role="navigation"
                 aria-label="<?php esc_attr_e('Pagination', 'extice'); ?>">
                <?php echo implode(PHP_EOL, $links); ?>
            </nav>
        </div>
        <?php
    }

    public function get_current_page() {
        if ('' === $this->get_settings('pagination_type')) {
            return 1;
        }

        return max(1, get_query_var('paged'), get_query_var('page'));
    }

    public function get_posts_nav_link($page_limit = null) {
        if (!$page_limit) {
            $page_limit = $this->query_posts()->max_num_pages;
        }

        $return = [];

        $paged = $this->get_current_page();

        $link_template     = '<a class="page-numbers %s" href="%s">%s</a>';
        $disabled_template = '<span class="page-numbers %s">%s</span>';

        if ($paged > 1) {
            $next_page = intval($paged) - 1;
            if ($next_page < 1) {
                $next_page = 1;
            }

            $return['prev'] = sprintf($link_template, 'prev', get_pagenum_link($next_page), $this->get_settings('pagination_prev_label'));
        } else {
            $return['prev'] = sprintf($disabled_template, 'prev', $this->get_settings('pagination_prev_label'));
        }

        $next_page = intval($paged) + 1;

        if ($next_page <= $page_limit) {
            $return['next'] = sprintf($link_template, 'next', get_pagenum_link($next_page), $this->get_settings('pagination_next_label'));
        } else {
            $return['next'] = sprintf($disabled_template, 'next', $this->get_settings('pagination_next_label'));
        }
        return $return;
    }
}

$widgets_manager->register(new Extice_Elementor_Post_Grid());
