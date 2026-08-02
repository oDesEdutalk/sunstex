<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
/**
 * Class Extice_Elementor_Service
 */
class Extice_Elementor_Service extends Extice_Base_Widgets_Swiper
{

    public function get_name()
    {
        return 'extice-services';
    }

    public function get_title()
    {
        return esc_html__('Extice Service', 'extice');
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
    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return array('extice-addons');
    }

    public function get_script_depends()
    {
        return ['extice-elementor-services', 'extice-elementor-swiper'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Service', 'extice'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => esc_html__('Posts Per Page', 'extice'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $this->add_control(
            'service_style',
            [
                'label' => esc_html__('Style', 'extice'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'service-style-1' => esc_html__('Style 1', 'extice'),
                    'service-style-2' => esc_html__('Style 2', 'extice'),
                    'service-style-3' => esc_html__('Style 3', 'extice'),
                    'service-style-4' => esc_html__('Style 4', 'extice'),
                    'service-style-5' => esc_html__('Style 5', 'extice'),
                ],
                'render_type' => 'template',
                'default' => 'service-style-1',
                'prefix_class' => 'elementor-'
            ]
        );

        $this->add_control(
            'includes_ids',
            [
                'label' => esc_html__('Includes', 'extice'),
                'type' => 'extice_query',
                'autocomplete' => [
                    'object' => 'extice_services',
                ],
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $this->add_control(
            'excludes_ids',

            [
                'label' => esc_html__('Excludes', 'extice'),
                'type' => 'extice_query',
                'autocomplete' => [
                    'object' => 'extice_services',
                ],
                'label_block' => true,
                'multiple' => true,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label' => esc_html__('Order By', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date' => esc_html__('Date', 'extice'),
                    'post_title' => esc_html__('Title', 'extice'),
                    'menu_order' => esc_html__('Menu Order', 'extice'),
                    'rand' => esc_html__('Random', 'extice'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label' => esc_html__('Order', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc' => esc_html__('ASC', 'extice'),
                    'desc' => esc_html__('DESC', 'extice'),
                ],
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label' => esc_html__('Columns', 'extice'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-5',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-4',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-3',
                        ],
                        [
                            'name' => 'enable_carousel',
                            'operator' => '!==',
                            'value' => 'yes',
                        ],
                    ],
                ]
            ]
        );

        $this->add_responsive_control(
            'item_spacing',
            [
                'label' => esc_html__('Spacing', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 30
                ],
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-gap:{{SIZE}}{{UNIT}}',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-5',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-4',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-3',
                        ],
                        [
                            'name' => 'enable_carousel',
                            'operator' => '!==',
                            'value' => 'yes',
                        ],
                    ],
                ]
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable Carousel', 'extice'),
                'type' => Controls_Manager::SWITCHER,

                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-3',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-4',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-5',
                        ],
                    ],
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination',
            [
                'label' => esc_html__('Pagination', 'extice'),
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-5',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-4',
                        ],
                        [
                            'name' => 'service_style',
                            'operator' => '!==',
                            'value' => 'service-style-3',
                        ],
                        [
                            'name' => 'enable_carousel',
                            'operator' => '!==',
                            'value' => 'yes',
                        ],
                    ],
                ]
            ]

        );

        $this->add_control(
            'pagination_type',
            [
                'label' => esc_html__('Pagination', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => '',
                'options' => [
                    '' => esc_html__('None', 'extice'),
                    'numbers' => esc_html__('Yes', 'extice'),
                ],
            ]
        );

        $this->add_control(
            'pagination_page_limit',
            [
                'label' => esc_html__('Page Limit', 'extice'),
                'default' => '5',
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );

        $this->add_control(
            'pagination_align',
            [
                'label' => esc_html__('Alignment', 'extice'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'extice'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'center',
                'selectors' => [
                    '{{WRAPPER}} ul.page-numbers' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_type!' => '',
                ],
            ]
        );

        $this->end_controls_section();


        // Service Style
        $this->start_controls_section(
            'service_style_wrap',
            [
                'label' => esc_html__('Service Style', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'style_content',
            [
                'type'  => Controls_Manager::HEADING,
                'label' => esc_html__('Content', 'extice'),

            ]
        );

        $this->add_responsive_control(
            'gutter',
            [
                'label' => esc_html__('Gap content', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-gap:{{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'enable_carousel!' => 'yes',
                ]
            ]
        );

        $this->add_control(
            'content_bg',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .service-item' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .service-style-3 .service-content' => 'background: {{VALUE}};',
                    '{{WRAPPER}} .service-style-5 .service-title a' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .service-item' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .service-style-3 .service-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .service-style-5 .service-title a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Padding', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .service-style-3 .service-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .service-style-5 .service-title a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'style_title',
            [
                'type'  => Controls_Manager::HEADING,
                'label' => esc_html__('Title', 'extice'),
                'separator' => 'before',

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .service-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .service-title a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'label'      => esc_html__('Margin', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-style-4 .service-title,{{WRAPPER}} .service-style-1 .service-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .service-head' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'service_style!'      => [ 'service-style-3', 'service-style-5' ],
                ]
            ]
        );


        $this->add_control(
            'style_description',
            [
                'type'  => Controls_Manager::HEADING,
                'label' => esc_html__('Description', 'extice'),
                'separator' => 'before',

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'description_typography',
                'selector' => '{{WRAPPER}} .description p',
            ]
        );

        $this->add_control(
            'description_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .description p' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'description_spacing',
            [
                'label'      => esc_html__('Margin', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .service-style-2 .description p,{{WRAPPER}} .service-style-1 .description p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition'  => [
                    'service_style!'      => [ 'service-style-3', 'service-style-4', 'service-style-5' ],
                ]
            ]
        );


        $this->add_control(
            'style_icon',
            [
                'type'  => Controls_Manager::HEADING,
                'label' => esc_html__('Icon', 'extice'),
                'condition'  => ['service_style!' => 'service-style-5']
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label'      => esc_html__('Size', 'extice'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .icon-wrap' => 'width: {{SIZE}}{{UNIT}};height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'icon_bg',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .icon-wrap' => 'background: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        

        $this->add_control_carousel(['enable_carousel' => 'yes']);

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'elementor-service-wrapper');

        $this->get_data_elementor_columns();

        $this->add_render_attribute('item', 'class', 'service-item ' . esc_attr($settings['service_style']));
        $allowed_styles = [
            'service-style-1',
            'service-style-2',
            'service-style-3',
            'service-style-4',
            'service-style-5'
        ];

        $style = $settings['service_style'] ?? 'service-style-1';

        if ( ! in_array( $style, $allowed_styles, true ) ) {
            $style = 'service-style-1';
        }

        $query = $this->query_posts();

        if (!$query->found_posts) {
            return;
        }

        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <div <?php $this->print_render_attribute_string('row'); ?>>
                <?php
                while ($query->have_posts()) {
                    $query->the_post();
                    ?>
                    <div <?php $this->print_render_attribute_string('item'); ?>>
                        <?php get_template_part('template-parts/services/item', $style); ?>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
        <?php $this->render_swiper_pagination_navigation();
        if ($settings['pagination_type'] && !empty($settings['pagination_type'])) {
            $this->render_loop_footer();
        }
        wp_reset_postdata();

    }

    public static function get_query_args($settings)
    {
        $query_args = [
            'posts_per_page' => $settings['posts_per_page'],
            'post_type' => 'extice_services',
            'orderby' => $settings['orderby'],
            'order' => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post__in' => $settings['includes_ids'],
            'post__not_in' => $settings['excludes_ids'],
            'post_status' => 'publish',
        ];

        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        return $query_args;
    }

    public function query_posts()
    {
        $query_args = $this->get_query_args($this->get_settings());
        return new WP_Query($query_args);
    }

    protected function render_loop_footer()
    {

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

        $has_numbers = in_array($parent_settings['pagination_type'], ['numbers']);

        $links = [];

        if ($has_numbers) {
            $links = paginate_links([
                'type' => 'list',
                'current' => $this->get_current_page(),
                'total' => $page_limit,
                'prev_text' => '<i class="extice-icon-chevron-left"></i>',
                'next_text' => '<i class="extice-icon-chevron-right"></i>',
                'before_page_number' => '<span class="elementor-screen-only">' . esc_html__('Page', 'extice') . '</span>',
            ]);
        }

        ?>
        <nav class="pagination">
            <div class="nav-links">
                <?php printf('%s', $links); ?>
            </div>
        </nav>
        <?php
    }

    public function get_current_page()
    {
        if ('' === $this->get_settings('pagination_type')) {
            return 1;
        }

        return max(1, get_query_var('paged'), get_query_var('page'));
    }

}

$widgets_manager->register(new Extice_Elementor_Service());