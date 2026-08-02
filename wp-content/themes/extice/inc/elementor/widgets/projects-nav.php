<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;


/**
 * Class Extice_Elementor_Project_Navigation
 */
class Extice_Elementor_Project_Navigation extends Elementor\Widget_Base {

    public function get_name() {
        return 'extice-projects-navigation';
    }

    public function get_title() {
        return esc_html__('Extice Project Navigation', 'extice');
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
        return 'eicon-post-navigation';
    }

    public function get_categories() {
        return array('extice-addons');
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Project Navigation', 'extice'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $prev_post = get_previous_post();
        $next_post = get_next_post();;


        if ($next_post) {
            $args['next_text'] = '<span class="nav-content"><span class="reader-text">' . esc_html__('next project', 'extice') . '<i class="extice-icon-angle-right"></i></span><span class="omega title">%title</span></span>';
        }
        if ($prev_post) {
            $args['prev_text'] = '<span class="nav-content"><span class="reader-text"> <i class="extice-icon-angle-left"></i>' . esc_html__('previous project', 'extice') . '</span><span class="omega title">%title</span></span> ';
        }

        the_post_navigation($args);
    }

}

$widgets_manager->register(new Extice_Elementor_Project_Navigation());