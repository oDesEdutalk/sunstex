<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;

class Extice_Video_Popup extends Elementor\Widget_Base
{

    public function get_name()
    {
        return 'extice-video-popup';
    }

    public function get_title()
    {
        return esc_html__('Extice Video Popup', 'extice');
    }

    public function get_icon()
    {
        return 'eicon-youtube';
    }

    public function get_script_depends()
    {
        return ['extice-elementor-video', 'magnific-popup'];
    }

    public function get_style_depends()
    {
        return ['magnific-popup'];
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'section_videos',
            [
                'label' => esc_html__('General', 'extice'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'video_link',
            [
                'label' => esc_html__('Link to', 'extice'),
                'type' => Controls_Manager::TEXT,
                'description' => esc_html__('Support video from Youtube and Vimeo', 'extice'),
                'placeholder' => esc_html__('https://your-link.com', 'extice'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'extice'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Tile', 'extice'),
                'default' => esc_html__('Play', 'extice'),
            ]
        );

        $this->add_control(
            'icon_font',
            [
                'label' => esc_html__('Icon Font', 'extice'),
                'type' => Controls_Manager::ICONS,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'background_video',
            [
                'label' => esc_html__('Background', 'extice'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name' => 'thumbnail',
                'default' => 'full',
                'separator' => 'none',
            ]
        );


        $this->end_controls_section();

        //Wrapper
        $this->start_controls_section(
            'section_video_wrapper',
            [
                'label' => esc_html__('Wrapper', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_wrapper_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_wrapper_margin',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'video_wrapper_border_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em', 'rem', 'vw', 'custom'],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();

        //Icon
        $this->start_controls_section(
            'section_video_style',
            [
                'label' => esc_html__('Icon', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'video_icon_size',
            [
                'label' => esc_html__('Font Size', 'extice'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .extice-video-popup .elementor-video-icon' => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .extice-video-popup .elementor-video-icon svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_video_style');

        $this->start_controls_tab(
            'tab_video_normal',
            [
                'label' => esc_html__('Normal', 'extice'),
            ]
        );

        $this->add_control(
            'video_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .extice-video-popup .elementor-video-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .extice-video-popup .elementor-video-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_bg_color',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .extice-video-popup .elementor-video-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'icon_border_color',
            [
                'label' => esc_html__('Border Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-icon' => '--icon_border: {{VALUE}};',
                ],
            ]
        );
        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_video_hover',
            [
                'label' => esc_html__('Hover', 'extice'),
            ]
        );

        $this->add_control(
            'video_hover_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .extice-video-popup:hover .elementor-video-icon' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .extice-video-popup:hover .elementor-video-icon svg' => 'fill: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'video_bg_color_hover',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .extice-video-popup:hover .elementor-video-icon' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'video_hover_box_shadow',
                'selector' => '{{WRAPPER}} .extice-video-popup:hover .elementor-video-icon',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_video_width',
            [
                'label' => esc_html__('Width/Height', 'extice'),
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
                'size_units' => ['%', 'px', 'vw'],
                'range' => [
                    '%' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-video-icon' => '--play_width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //title
        $this->start_controls_section(
            'section_video_title',
            [
                'label' => esc_html__('Title', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}} .extice-video-popup .elementor-video-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'selector' => '{{WRAPPER}} .extice-video-popup .elementor-video-title',
            ]
        );

        $this->end_controls_section();

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();


        $this->add_render_attribute('wrapper', 'class', 'elementor-video-wrapper');
        $this->add_render_attribute('wrapper', 'class', 'extice-video-popup');

        $this->add_render_attribute('button', 'class', 'elementor-video-popup elementor-video-icon');
        $this->add_render_attribute('button', 'role', 'button');
        if (!empty($settings['video_link'])) {
            $this->add_render_attribute('button', 'href', esc_url($settings['video_link']));
        }
        $this->add_render_attribute('button', 'data-effect', 'mfp-zoom-in');

        $titleHtml = !empty($settings['title']) ? '<span class="elementor-video-title">' . $settings['title'] . '</span>' : '';

        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <div class="elementor-video-content">
                <a <?php $this->print_render_attribute_string('button'); ?>>
                    <?php printf('%s', $titleHtml); ?>
                    <?php \Elementor\Icons_Manager::render_icon($settings['icon_font'], ['aria-hidden' => 'true']); ?>
                </a>
                <?php if (!empty($settings['background_video']['url'])) : ?>
                    <span class="image-hover">
                        <?php echo Group_Control_Image_Size::get_attachment_image_html($settings, 'thumbnail', 'background_video'); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

}

$widgets_manager->register(new Extice_Video_Popup());
