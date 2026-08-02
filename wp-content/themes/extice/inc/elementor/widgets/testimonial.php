<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;

class Extice_Elementor_Testimonials extends Extice_Base_Widgets_Swiper
{
    /**
     * Get widget name.
     *
     * Retrieve testimonial widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name()
    {
        return 'extice-testimonials';
    }

    /**
     * Get widget title.
     *
     * Retrieve testimonial widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title()
    {
        return esc_html__('Extice Testimonials', 'extice');
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
        return 'eicon-testimonial';
    }

    public function get_script_depends()
    {
        return ['extice-elementor-testimonial', 'extice-elementor-swiper'];
    }

    public function get_categories()
    {
        return array('extice-addons');
    }

    /**
     * Register testimonial widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_testimonial',
            [
                'label' => esc_html__('Testimonials', 'extice'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'testimonial_icon',
            [
                'label' => esc_html__('Icon', 'extice'),
                'type' => Controls_Manager::ICONS,
                'skin' => 'inline',
                'label_block' => false,
            ]
        );

        $repeater->add_control(
            'testimonial_rating',
            [
                'label' => esc_html__('Rating', 'extice'),
                'default' => 0,
                'type' => Controls_Manager::SELECT,
                'options' => [
                    0 => esc_html__('Hidden', 'extice'),
                    1 => esc_html__('Very poor', 'extice'),
                    2 => esc_html__('Not that bad', 'extice'),
                    3 => esc_html__('Average', 'extice'),
                    4 => esc_html__('Good', 'extice'),
                    5 => esc_html__('Perfect', 'extice'),
                ]
            ]
        );

        $repeater->add_control(
            'testimonial_title',
            [
                'label' => esc_html__('Title', 'extice'),
                'type' => Controls_Manager::TEXT,
                'default' => '',
            ]
        );

        $repeater->add_control(
            'testimonial_content',
            [
                'label' => esc_html__('Content', 'extice'),
                'type' => Controls_Manager::WYSIWYG,
                'default' => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'label_block' => true,
                'rows' => '10',
            ]
        );

        $repeater->add_control(
            'testimonial_name',
            [
                'label' => esc_html__('Name', 'extice'),
                'default' => 'John Doe',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_job',
            [
                'label' => esc_html__('Job', 'extice'),
                'default' => 'Design',
                'type' => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'testimonial_link',
            [
                'label' => esc_html__('Link to', 'extice'),
                'placeholder' => esc_html__('https://your-link.com', 'extice'),
                'type' => Controls_Manager::URL,
            ]
        );
        $repeater->add_control(
            'testimonial_image',
            [
                'label' => esc_html__('Choose Image', 'extice'),
                'type' => Controls_Manager::MEDIA,
                'show_label' => false,
            ]
        );

        $this->add_control(
            'testimonials',
            [
                'label' => esc_html__('Items', 'extice'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'title_field' => '{{{ testimonial_name }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name' => 'testimonial_image',
                'default' => 'full',
                'separator' => 'none',
            ]
        );


        $this->add_responsive_control(
            'column',
            [
                'label' => esc_html__('Columns', 'extice'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 1,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'conditions' => [
                    'relation' => 'and',
                    'terms' => [
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
            'gutter',
            [
                'label' => esc_html__('Gutter', 'extice'),
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

        $this->add_responsive_control(
            'testimonial_alignment',
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
                'label_block' => false,
                'render_type' => 'template',
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-item' => 'text-align: {{VALUE}};',
                ],
                'prefix_class' => 'alignment-',
            ]
        );

        $this->add_control(
            'testimonial_layout',
            [
                'label' => esc_html__('Layout', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('Layout 1', 'extice'),
                    '2' => esc_html__('Layout 2', 'extice'),
                    '3' => esc_html__('Layout 3', 'extice'),

                ],
                'frontend_available' => true,
                'render_type' => 'template',
                'prefix_class' => 'testimonial-layout-',
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable Carousel', 'extice'),
                'type' => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'view',
            [
                'label' => esc_html__('View', 'extice'),
                'type' => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );
        $this->end_controls_section();


        // WRAPPER STYLE
        $this->start_controls_section(
            'section_style_testimonial_wrapper',
            [
                'label' => esc_html__('Wrapper', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_responsive_control(
            'testimonial_width',
            [
                'label' => esc_html__('Width', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-item-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        $this->add_responsive_control(
            'padding_testimonial_wrapper',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .grid-item .wrap_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin_testimonial_wrapper',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .grid-item .wrap_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'color_testimonial_wrapper',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .grid-item .wrap_content,{{WRAPPER}} .grid-item .wrap_content:before,{{WRAPPER}} .grid-item .wrap_content:after' => 'background: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'wrapper_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .grid-item .wrap_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_gutter',
            [
                'label' => esc_html__('Gutter', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-content' => 'gap:{{SIZE}}{{UNIT}}',
                ],
                'condition' => ['testimonial_layout' => '2']
            ]
        );

        $this->end_controls_section();

        // Image style
        $this->start_controls_section(
            'section_style_testimonial_image',
            [
                'label' => esc_html__('Image', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_responsive_control(
            'image_width',
            [
                'label' => esc_html__('Width', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 330,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-image' => 'min-width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-testimonial-image img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_height',
            [
                'label' => esc_html__('Height', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'default' => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 450,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-image' => 'min-height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-testimonial-image img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'image_border_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-image img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .elementor-testimonial-image img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Icon style
        $this->start_controls_section(
            'section_style_testimonial_icon',
            [
                'label' => esc_html__('Icon', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .icon i,{{WRAPPER}} .icon svg' => 'color: {{VALUE}};fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_spacing',
            [
                'label' => esc_html__('Icon Spacing', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['testimonial_layout' => '3']
            ]
        );

        $this->add_responsive_control(
            'icon_position',
            [
                'label' => esc_html__('Icon Position', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon' => 'right: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['testimonial_layout' => '1']
            ]
        );

        $this->add_responsive_control(
            'icon_rotation',
            [
                'label' => esc_html__('Icon Rotation', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'deg' => [
                        'min' => 0,
                        'max' => 360,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .icon' => 'transform: rotate({{SIZE}}deg);',
                ],
            ]
        );

        $this->end_controls_section();


        // Content style
        $this->start_controls_section(
            'section_style_testimonial_content',
            [
                'label' => esc_html__('Content', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'text_indent',
            [
                'label' => esc_html__('Text indent', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .content' => 'text-indent: {{SIZE}}{{UNIT}};',
                ],
                'condition' => ['testimonial_layout' => '2']
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label' => esc_html__('Color Hover', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-item:hover .content' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'content_typography',
                'selector' => '{{WRAPPER}} .grid-item .content',
            ]
        );


        $this->add_responsive_control(
            'content_margin',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    '{{WRAPPER}} .content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'content_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .content',
                'separator' => 'before',
                'condition' => ['testimonial_layout!' => '3']
            ]
        );

        $this->end_controls_section();


        // Title.
        $this->start_controls_section(
            'section_style_testimonial_title',
            [
                'label' => esc_html__('Title', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition' => ['testimonial_title!' => '']

            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_text_color_hover',
            [
                'label' => esc_html__('Color Hover', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .testimonial-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .testimonial-title',
            ]
        );

        $this->add_responsive_control(
            'title_spacing',
            [
                'size_units' => ['px', 'em', '%'],
                'label' => esc_html__('Spacing', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .testimonial-title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Name.
        $this->start_controls_section(
            'section_style_testimonial_name',
            [
                'label' => esc_html__('Name', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_text_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .name, {{WRAPPER}} .name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'name_text_color_hover',
            [
                'label' => esc_html__('Color Hover', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-item:hover .name, .name a' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typography',
                'selector' => '{{WRAPPER}} .name',
            ]
        );

        $this->end_controls_section();

        // Job.
        $this->start_controls_section(
            'section_style_testimonial_job',
            [
                'label' => esc_html__('Job', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'job_text_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'job_text_color_hover',
            [
                'label' => esc_html__('Color Hover', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-testimonial-item:hover .job' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'job_typography',
                'selector' => '{{WRAPPER}} .job',
            ]
        );

        $this->end_controls_section();

        // Carousel options
        $this->add_control_carousel(['enable_carousel' => 'yes']);

    }

    /**
     * Render testimonial widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();

        if (!empty($settings['testimonials']) && is_array($settings['testimonials'])) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-testimonial-item-wrapper');
            $this->add_render_attribute('row', 'class', 'layout-' . esc_attr($settings['testimonial_layout']));
            // Carousel
            $this->get_data_elementor_columns();
            // Item
            $this->add_render_attribute('item', 'class', 'elementor-testimonial-item');
            $detail_image = '';
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); // WPCS: XSS ok. ?>>
                <div <?php $this->print_render_attribute_string('row'); // WPCS: XSS ok. ?>>
                    <?php foreach ($settings['testimonials'] as $key => $testimonial): ?>
                        <div <?php $this->print_render_attribute_string('item'); // WPCS: XSS ok. ?>>
                            <div class="testimonial-content elementor-repeater-item-<?php echo esc_attr($testimonial['_id']); ?>">
                                <?php if ($settings['testimonial_layout'] == '2') {
                                    $this->render_image($settings, $testimonial);
                                } ?>
                                <div class="testimonial-content-inner">
                                    <div class="wrap_content">
                                        <?php if (!empty($testimonial['testimonial_icon']['value'])) : ?>
                                            <div class="icon">
                                                <?php \Elementor\Icons_Manager::render_icon($testimonial['testimonial_icon'], ['aria-hidden' => 'true']); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($testimonial['testimonial_rating'] && $testimonial['testimonial_rating'] > 0 ) {
                                            echo '<div class="elementor-testimonial-rating">';
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $testimonial['testimonial_rating']) {
                                                    Icons_Manager::render_icon(["value" => "extice-icon-star", "library" => "extice-icon"], ['aria-hidden' => 'true']);
                                                }
                                            }
                                            echo '</div>';
                                        } ?>
                                        <?php if ($testimonial['testimonial_title']) { ?>
                                            <h6 class="testimonial-title"><?php echo esc_html($testimonial['testimonial_title']); ?></h6>
                                        <?php } ?>

                                        <?php if (!empty($testimonial['testimonial_content'])) { ?>
                                            <div class="content"><?php echo sprintf('%s', $testimonial['testimonial_content']); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class="details">
                                        <?php if ($settings['testimonial_layout'] !== '2') {
                                            $this->render_image($settings, $testimonial);
                                        } ?>
                                        <div class="details-info">
                                            <?php $testimonial_name_html = $testimonial['testimonial_name'];

                                            if (!empty($testimonial['testimonial_link']['url'])) {
                                                $testimonial_name_html = '<a href="' . esc_url($testimonial['testimonial_link']['url']) . '">' . esc_html($testimonial_name_html) . '</a>';
                                            }

                                            printf('<span class="name">%s</span>', $testimonial_name_html);
                                            ?>
                                            <?php if ($testimonial['testimonial_job']) { ?>
                                                <span class="job"><?php echo esc_html($testimonial['testimonial_job']); ?></span>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $this->render_swiper_pagination_navigation(); ?>

            <?php
        }
    }

    private function render_image($settings, $testimonial)
    {
        if (!empty($testimonial['testimonial_image']['url'])) :
            ?>
            <div class="elementor-testimonial-image">
                <?php
                $testimonial['testimonial_image_size'] = $settings['testimonial_image_size'];
                $testimonial['testimonial_image_custom_dimension'] = $settings['testimonial_image_custom_dimension'];
                echo Group_Control_Image_Size::get_attachment_image_html($testimonial, 'testimonial_image');
                ?>
            </div>
        <?php
        endif;
    }
}

$widgets_manager->register(new Extice_Elementor_Testimonials());