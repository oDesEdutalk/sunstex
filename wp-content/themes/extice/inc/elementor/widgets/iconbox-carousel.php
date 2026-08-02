<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Repeater;
use Elementor\Icons_Manager;

class Extice_Elementor_IconboxCarousel extends Extice_Base_Widgets_Swiper {
    /**
     * Get widget name.
     *
     * Retrieve iconbox widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'extice-iconbox-carousel';
    }

    /**
     * Get widget title.
     *
     * Retrieve iconbox widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Extice Iconbox Carousel', 'extice');
    }

    /**
     * Get widget icon.
     *
     * Retrieve iconbox widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-carousel';
    }

    public function get_script_depends() {
        return ['extice-elementor-iconbox-carousel', 'extice-elementor-swiper'];
    }

    public function get_categories() {
        return array('extice-addons');
    }

    /**
     * Register iconbox widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_iconbox',
            [
                'label' => esc_html__('Iconbox Carousel', 'extice'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'selected_icon',
            [
                'label'     => esc_html__('Icon', 'extice'),
                'type'      => Controls_Manager::ICONS,
                'fa4compatibility' => 'icon',
                'default'   => [
                    'value'   => 'fas fa-star',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $repeater->add_control(
            'iconbox_title',
            [
                'label'   => esc_html__('Title', 'extice'),
                'type'    => Controls_Manager::TEXT,
                'label_block' => true,
                'default'     => '',
            ]
        );

        $repeater->add_control(
            'iconbox_content',
            [
                'label'       => esc_html__('Content', 'extice'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.',
                'label_block' => true,
                'rows'        => '10',
            ]
        );

        $repeater->add_control(
            'iconbox_link',
            [
                'label'       => esc_html__('Link to', 'extice'),
                'type'        => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
                'placeholder' => esc_html__('https://your-link.com', 'extice'),
            ]
        );

        $repeater->add_control(
            'bgcolor_icon',
            [
                'label' => __('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper{{CURRENT_ITEM}} .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $repeater->add_control(
            'bgcolor_icon_hover',
            [
                'label' => __('Background Color Hover', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper{{CURRENT_ITEM}}:hover .elementor-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'iconbox-carousel',
            [
                'label'       => esc_html__('Items', 'extice'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ iconbox_title }}}',
            ]
        );

        $this->add_control(
            'iconbox_layout',
            [
                'label' => esc_html__('Layout', 'extice'),
                'type' => Controls_Manager::SELECT,
                'default' => '1',
                'options' => [
                    '1' => esc_html__('Layout 1', 'extice'),
                    '2' => esc_html__('Layout 2', 'extice'),
                ],
                'frontend_available' => true,
                'render_type' => 'template',
                'prefix_class' => 'iconbox-layout-',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'        => esc_html__('Columns', 'extice'),
                'type'         => \Elementor\Controls_Manager::SELECT,
                'default'      => 1,
                'options'      => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
                'selectors' => [
                    '{{WRAPPER}} .d-grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr)',
                ],
                'condition' => ['enable_carousel!' => 'yes']
            ]
        );

        $this->add_responsive_control(
            'gutter',
            [
                'label'      => esc_html__('Gutter', 'extice'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} .d-grid' => 'grid-gap:{{SIZE}}{{UNIT}}',
                ],
                'condition'  => ['enable_carousel!' => 'yes']
            ]
        );

        $this->add_responsive_control(
            'iconbox_alignment',
            [
                'label'       => esc_html__('Alignment', 'extice'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left'   => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'extice'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'label_block' => false,
                'render_type'        => 'template',
                'default'      => 'left',
                'selectors'   => [
                    '{{WRAPPER}} .elementor-iconbox-item' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'enable_carousel',
            [
                'label' => esc_html__('Enable Carousel', 'extice'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => esc_html__('View', 'extice'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );
        $this->end_controls_section();


        // WRAPPER STYLE
        $this->start_controls_section(
            'section_style_iconbox_wrapper',
            [
                'label' => esc_html__('Wrapper', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,

            ]
        );

        $this->add_responsive_control(
            'margin_box',
            [
                'label'      => esc_html__('Margin', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-iconbox-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_iconbox_wrapper',
            [
                'label'      => esc_html__('Padding', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .grid-item .elementor-icon-box-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_iconbox_wrapper',
            [
                'label' => esc_html__( 'Background Color', 'extice' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper,{{WRAPPER}} .elementor-icon-box-wrapper:before' => '--bg_color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_radius',
            [
                'label'      => esc_html__('Border Radius', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .grid-item .elementor-icon-box-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // icon style

        $this->start_controls_section(
            'section_style_icon',
            [
                'label' => esc_html__( 'Icon', 'extice' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__( 'Color', 'extice' ),
                'type' => Controls_Manager::COLOR,
                'global' => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_width',
            [
                'label' => esc_html__('Width', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_height',
            [
                'label' => esc_html__('Height', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_space',
            [
                'label' => esc_html__( 'Spacing', 'extice' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Size', 'extice' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'em', 'rem', 'vw', 'custom' ],
                'range' => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-icon svg' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Title.
        $this->start_controls_section(
            'section_style_iconbox_title',
            [
                'label' => esc_html__('Title', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_text_color',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_text_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-wrapper:hover .elementor-icon-box-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'selector' => '{{WRAPPER}} .elementor-icon-box-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-icon-box-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Content style
        $this->start_controls_section(
            'section_style_iconbox_content',
            [
                'label' => esc_html__('Content', 'extice'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'content_alignment',
            [
                'label'       => esc_html__('Alignment', 'extice'),
                'type'        => Controls_Manager::CHOOSE,
                'options'     => [
                    'left'   => [
                        'title' => esc_html__('Left', 'extice'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'extice'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'extice'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'      => 'left',
                'selectors'   => [
                    '{{WRAPPER}} .elementor-icon-box-description' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => esc_html__('Color', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'content_color_hover',
            [
                'label'     => esc_html__('Color Hover', 'extice'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-iconbox-item-wrapper:hover .elementor-icon-box-description' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .grid-item .elementor-icon-box-description',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'content_border',
                'selector'  => '{{WRAPPER}} .elementor-icon-box-description',
            ]
        );

        $this->add_responsive_control(
            'content_padding',
            [
                'label'      => esc_html__('Padding', 'extice'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-icon-box-description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        // Carousel options
        $this->add_control_carousel(['enable_carousel' => 'yes']);

    }

    /**
     * Render iconbox widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['iconbox-carousel']) && is_array($settings['iconbox-carousel'])) {
            $this->add_render_attribute('wrapper', 'class', 'elementor-iconbox-item-wrapper');
            $this->add_render_attribute('row', 'class', 'alignment-' . esc_attr($settings['iconbox_alignment']));
            $this->add_render_attribute('row', 'class', 'layout-' . esc_attr($settings['iconbox_layout']));
            // Carousel
            $this->get_data_elementor_columns();
            // Item
            $this->add_render_attribute('item', 'class', 'elementor-iconbox-item');

            $migrated = isset( $settings['__fa4_migrated']['selected_icon'] );
            $is_new = empty( $settings['icon'] ) && Icons_Manager::is_migration_allowed();
            $count = 0;
            ?>

            <div <?php $this->print_render_attribute_string('wrapper'); // WPCS: XSS ok. ?>>
                <div <?php $this->print_render_attribute_string('row'); // WPCS: XSS ok. ?>>
                    <?php foreach ($settings['iconbox-carousel'] as $iconbox):
                        $count ++;
                        ?>
                        <div <?php $this->print_render_attribute_string('item'); // WPCS: XSS ok. ?> data-count="<?php printf('%02d',$count);?>">
                            <div class="elementor-icon-box-wrapper elementor-repeater-item-<?php echo esc_attr($iconbox['_id']); ?>">
                                <div class="elementer-icon-box-inner">

                                    <?php if (!empty($iconbox['icon']) || !empty($iconbox['selected_icon']['value'])) : ?>
                                        <div class="elementor-icon-box-icon">
                                        <span class="elementor-icon">
                                            <?php if ($is_new || $migrated) :
                                                Elementor\Icons_Manager::render_icon($iconbox['selected_icon'], ['aria-hidden' => 'true']);
                                            else : ?>
                                                <i class="<?php echo esc_attr($iconbox['icon']); ?>" aria-hidden="true"></i>
                                            <?php endif; ?>
                                        </span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($iconbox['iconbox_content'])) { ?>
                                        <?php if ($iconbox['iconbox_title']) { ?>
                                            <a href="<?php echo esc_url($iconbox['iconbox_link']['url']); ?>"><h5 class="elementor-icon-box-title"><?php echo sprintf('%s', $iconbox['iconbox_title']); ?></h5></a>
                                        <?php } ?>
                                        <p class="elementor-icon-box-description"><?php echo esc_html($iconbox['iconbox_content']); ?></p>
                                        <?php
                                        if (isset($settings['iconbox_layout']) && $settings['iconbox_layout'] === '2') {
                                            ?>
                                            <span class="iconbox-counter"><?php printf('%02d', $count); ?></span>
                                            <?php
                                        }
                                        ?>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php $this->render_swiper_pagination_navigation();?>
            <?php
        }
    }
}

$widgets_manager->register(new Extice_Elementor_IconboxCarousel());
