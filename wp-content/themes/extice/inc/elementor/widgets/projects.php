<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;


/**
 * Class Extice_Elementor_Project
 */
class Extice_Elementor_Project extends Extice_Base_Widgets_Swiper {

    public function get_name() {
        return 'extice-projects';
    }

    public function get_title() {
        return esc_html__('Extice Project', 'extice');
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
        return ['extice-elementor-projects', 'extice-elementor-swiper'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Project', 'extice'),
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
            'includes_ids',
            [
                'label'       => esc_html__('Includes', 'extice'),
                'type' => 'extice_query',
                'autocomplete' => [
                    'object' => 'extice_project',
                ],
                'label_block' => true,
                'multiple'    => true,
            ]
        );

        $this->add_control(
            'excludes_ids',
            [
                'label'       => esc_html__('Excludes', 'extice'),
                'type' => 'extice_query',
                'autocomplete' => [
                    'object' => 'extice_project',
                ],
                'label_block' => true,
                'multiple'    => true,
            ]
        );
        $this->add_control(
            'project_style',
            [
                'label'        => esc_html__('Style', 'extice'),
                'type'         => \Elementor\Controls_Manager::SELECT,
                'options'      => [
                    'project-style-1' => esc_html__('Style 1', 'extice'),
                    'project-style-2' => esc_html__('Style 2', 'extice'),
                    'project-style-3' => esc_html__('Style 3', 'extice'),
                ],
                'render_type'  => 'template',
                'default'      => 'project-style-1',
                'prefix_class' => 'elementor-'
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

        $this->add_responsive_control(
            'column',
            [
                'label'      => esc_html__('Columns', 'extice'),
                'type'       => \Elementor\Controls_Manager::SELECT,
                'default'    => 3,
                'options'    => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5],
                'selectors'  => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'condition'  => ['enable_carousel!' => 'yes'],

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
                ],
                'condition'  => ['enable_carousel!' => 'yes']
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label'     => esc_html__('Enable Carousel', 'extice'),
                'type'      => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_pagination',
            [
                'label'     => esc_html__('Pagination', 'extice'),
                'condition' => ['enable_carousel!' => 'yes']
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
            'pagination_align',
            [
                'label'     => esc_html__('Alignment', 'extice'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'extice'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} ul.page-numbers' => 'justify-content: {{VALUE}};',
                ],
                'condition' => [
                    'pagination_type!' => '',
                ],
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
            'content_width',
            [
                'label' => esc_html__('Width', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .project-content' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_min_height',
            [
                'label' => esc_html__('Min Height', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'size_units' => ['px', 'custom'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .project-content' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .project-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'content_title',
            [
                'label' => esc_html__( 'Title', 'extice' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_title_color',
            [
                'label' => esc_html__( 'Color', 'extice' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .project-title a' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_control(
            'content_title_color_hover',
            [
                'label' => esc_html__( 'Color Hover', 'extice' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .project-title a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_title_typography',
                'selector' => '{{WRAPPER}} .project-title',
            ]
        );


        $this->add_control(
            'content_location',
            [
                'label' => esc_html__( 'Location', 'extice' ),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );


        $this->add_control(
            'content_location_color',
            [
                'label' => esc_html__( 'Color', 'extice' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .project-location a' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'content_location_color_hover',
            [
                'label' => esc_html__( 'Color Hover', 'extice' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .project-location a:hover' => 'color: {{VALUE}};',
                ],

            ]
        );
        $this->add_control(
            'content_location_border_color',
            [
                'label' => esc_html__( 'Color border', 'extice' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .project-location' => 'border-color: {{VALUE}};',
                ],

            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_location_typography',
                'selector' => '{{WRAPPER}} .project-location a',
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
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .project-post-thumbnail' => 'padding-top: {{SIZE}}{{UNIT}}',
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
                    '{{WRAPPER}} .project-post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        $this->add_control_carousel([
            'relation' => 'and',
            'terms'    => [
                [
                    'name'     => 'enable_carousel',
                    'operator' => '==',
                    'value'    => 'yes',
                ],
            ],
        ], 'conditions');

    }

    public static function get_query_args($settings) {
        $query_args = [
            'post_type'           => 'extice_project',
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post__in'            => $settings['includes_ids'],
            'post__not_in'        => $settings['excludes_ids'],
            'post_status'         => 'publish',
        ];

        $query_args['posts_per_page'] = $settings['posts_per_page'];


        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        return $query_args;
    }

    public function query_posts() {
        $query_args = $this->get_query_args($this->get_settings());
        return new WP_Query($query_args);
    }


    protected function render() {
        $settings = $this->get_settings_for_display();
        $this->add_render_attribute('wrapper', 'class', 'elementor-project-wrapper');
        $this->get_data_elementor_columns();

        $allowed_styles = [
            'project-style-1',
            'project-style-2',
            'project-style-3',
        ];

        $style = $settings['project_style'] ?? 'project-style-1';

        if ( ! in_array( $style, $allowed_styles, true ) ) {
            $style = 'project-style-1';
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
                        <?php get_template_part('template-parts/project/item',$style); ?>
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

        $has_numbers = in_array($parent_settings['pagination_type'], ['numbers', 'numbers_and_prev_next']);

        $links = [];

        if ($has_numbers) {
            $links = paginate_links([
                'type'               => 'list',
                'current'            => $this->get_current_page(),
                'total'              => $page_limit,
                'prev_text'          => '<i class="extice-icon-chevron-left"></i>' . esc_html__('Prev', 'extice') ,
                'next_text'          => esc_html__('Next', 'extice') . '<i class="extice-icon-chevron-right"></i>',
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

    public function get_current_page() {
        if ('' === $this->get_settings('pagination_type')) {
            return 1;
        }

        return max(1, get_query_var('paged'), get_query_var('page'));
    }

}

$widgets_manager->register(new Extice_Elementor_Project());