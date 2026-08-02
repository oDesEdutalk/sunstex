<?php
// Image Box
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;

add_action( 'elementor/element/image-box/section_style_content/before_section_end', function ( $element, $args ) {

    $element->add_control(
        'title_color_hover',
        [
            'label' => esc_html__( 'Title Hover Color', 'extice' ),
            'type' => Controls_Manager::COLOR,
            'default' => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-image-box-title:hover' => 'color: {{VALUE}};',
            ],
            'global' => [
                'default' => Global_Colors::COLOR_PRIMARY,
            ],
        ]
    );

}, 10, 2 );
