<?php
// Icon List
use Elementor\Controls_Manager;
add_action( 'elementor/element/icon-list/section_icon/before_section_end', function ( $element, $args ) {
    $element->add_control(
        'icon_list_style_theme',
        [
            'label' => esc_html__('Theme Style', 'extice'),
            'type' => Controls_Manager::SWITCHER,
            'default' => '',
            'prefix_class' => 'icon-list-style-extice-',
        ]
    );
}, 10, 2 );
