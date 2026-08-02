<?php

/**
 * Extice_query control.
 *
 */
class Extice_Query_Control extends \Elementor\Control_Select2 {

    public function get_type() {
        return 'extice_query';
    }

    public function enqueue() {

        wp_enqueue_script('elementor-extice-query-control', get_theme_file_uri('/inc/elementor/elementor-control/select2.js'), ['jquery'], EXTICE_VERSION, true);
    }
}
