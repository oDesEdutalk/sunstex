<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!extice_is_contactform_activated()) {
    return;
}

use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class Extice_Elementor_ContactForm extends Elementor\Widget_Base
{

    public function get_name()
    {
        return 'extice-contactform';
    }

    public function get_title()
    {
        return esc_html__('Extice Contact Form', 'extice');
    }

    public function get_categories()
    {
        return array('extice-addons');
    }

    public function get_icon()
    {
        return 'eicon-form-horizontal';
    }

    protected function register_controls()
    {
        $this->start_controls_section(
            'contactform7',
            [
                'label' => esc_html__('General', 'extice'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );
        $cf7 = get_posts('post_type="wpcf7_contact_form"&numberposts=-1');
        $contact_forms[''] = esc_html__('Please select form', 'extice');
        if ($cf7) {
            foreach ($cf7 as $cform) {
                $contact_forms[$cform->ID] = $cform->post_title;
            }
        } else {
            $contact_forms[0] = esc_html__('No contact forms found', 'extice');
        }

        $this->add_control(
            'cf_id',
            [
                'label' => esc_html__('Select contact form', 'extice'),
                'type' => Controls_Manager::SELECT,
                'options' => $contact_forms,
                'default' => ''
            ]
        );

        $this->add_control(
            'form_name',
            [
                'label' => esc_html__('Form name', 'extice'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Contact form', 'extice'),
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'ct_form_style_input',
            [
                'label' => esc_html__('Input', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .wpcf7-form input[type=text], 
                {{WRAPPER}} .wpcf7-form input[type=number], 
                {{WRAPPER}} .wpcf7-form input[type=email], 
                {{WRAPPER}} .wpcf7-form input[type=tel], 
                {{WRAPPER}} .wpcf7-form input[type=search],
                {{WRAPPER}} .wpcf7-form textarea',
            ]
        );

        $this->start_controls_tabs('tabs_input_style');

        $this->start_controls_tab(
            'tab_input_normal',
            [
                'label' => esc_html__('Normal', 'extice'),
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=number]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=email]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=url]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=date]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=password]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=search]' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form textarea' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type="date"]:before' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_background_color',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=number]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=email]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=url]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=date]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=password]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=search]' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form textarea' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_color_placeholder',
            [
                'label' => esc_html__('Color Placeholder', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=number]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=email]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=url]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=date]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=password]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=search]::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])::placeholder' => 'color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form textarea::placeholder' => 'color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_color_border',
            [
                'label' => esc_html__('Border Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=number]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=email]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=url]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=date]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=password]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=search]' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form textarea' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_input_focus',
            [
                'label' => esc_html__('Focus', 'extice'),
            ]
        );

        $this->add_control(
            'input_background_focus',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=number]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=email]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=url]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=date]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=password]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=search]:focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple]):focus' => 'background-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form textarea:focus' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'input_border_color_focus',
            [
                'label' => esc_html__('Border Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=number]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=email]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=url]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=date]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=password]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form input[type=search]:focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple]):focus' => 'border-color: {{VALUE}}',
                    '{{WRAPPER}} .wpcf7-form textarea:focus' => 'border-color: {{VALUE}}',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'input_border',
            [
                'label' => esc_html__('Border Width', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=number]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=email]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=url]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=date]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=password]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=search]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form textarea' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=number]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=email]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=url]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=date]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=password]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=search]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_margin',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=number]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=email]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=url]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=date]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=password]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=search]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .wpcf7-form input[type=text]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=number]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=email]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=tel]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=url]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=date]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=password]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form select:not([size]):not([multiple])' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .wpcf7-form textarea' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        //Button
        $this->start_controls_section(
            'ct_form_style_button',
            [
                'label' => esc_html__('Button', 'extice'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'submit_typography',
                'selector' => '{{WRAPPER}} button',
            ]
        );

        $args = [];
        $default_args = [
            'section_condition' => [],
            'alignment_control_prefix_class' => 'elementor%s-align-',
            'alignment_default' => '',
        ];
        $args = wp_parse_args($args, $default_args);    

        $this->add_responsive_control(
            'align',
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
                    'justify' => [
                        'title' => esc_html__('Justified', 'extice'),
                        'icon' => 'eicon-text-align-justify',
                    ],
                ],
                'prefix_class' => $args['alignment_control_prefix_class'],
                'default' => $args['alignment_default'],
                'condition' => $args['section_condition'],
            ]
        );

        $this->start_controls_tabs('tabs_button_style');

        $this->start_controls_tab(
            'tab_button_normal',
            [
                'label' => esc_html__('Normal', 'extice'),
            ]
        );

        $this->add_control(
            'button_background',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color',
            [
                'label' => esc_html__('Text Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_button_hover',
            [
                'label' => esc_html__('Hover', 'extice'),
            ]
        );

        $this->add_control(
            'button_background_hover',
            [
                'label' => esc_html__('Background Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_color_hover',
            [
                'label' => esc_html__('Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_border_color_hover',
            [
                'label' => esc_html__('Border Color', 'extice'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} button:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'border',
                'selector' => '{{WRAPPER}} button[type=submit]',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => esc_html__('Padding', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'button_margin',
            [
                'label' => esc_html__('Margin', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'extice'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();
        if (!$settings['cf_id']) {
            return;
        }
        $args['id'] = $settings['cf_id'];
        $args['title'] = $settings['form_name'];

        echo extice_do_shortcode('contact-form-7', $args);
    }
}

$widgets_manager->register(new Extice_Elementor_ContactForm());
