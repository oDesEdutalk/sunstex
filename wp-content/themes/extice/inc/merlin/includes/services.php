<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Extice_Service
 */
class Extice_Services {
    public $post_type = 'extice_services';
    static $instance;

    public static function getInstance() {
        if (!isset(self::$instance) && !(self::$instance instanceof Extice_Services)) {
            self::$instance = new Extice_Services();
        }

        return self::$instance;
    }

    public function __construct() {
        add_action('init', [$this, 'create_services']);
        if (extice_is_cmb2_activated()) {
            add_action('init', [$this, 'setup_metabox']);
        }
    }

    public function setup_metabox() {
        add_action('cmb2_admin_init', [$this, 'metabox_services']);
    }

    public function metabox_services() {
        $cmb2 = new_cmb2_box(array(
            'id'           => 'extice_services_setting',
            'title'        => esc_html__('Infomation', 'extice'),
            'object_types' => array('extice_services'),
        ));

        $cmb2->add_field(array(
            'name'    => esc_html__('Service Icon', 'extice'),
            'id'      => 'services_icon_class',
            'type'    => 'file',
            'options' => array(
                'url' => true,
            ),
        ));
    }


    /**
     * @return void
     */
    public function create_services() {

        $labels = array(
            'name'               => esc_html__('Services', 'extice'),
            'singular_name'      => esc_html__('Service', 'extice'),
            'add_new'            => esc_html__('Add New Service', 'extice'),
            'add_new_item'       => esc_html__('Add New Service', 'extice'),
            'edit_item'          => esc_html__('Edit Service', 'extice'),
            'new_item'           => esc_html__('New Service', 'extice'),
            'view_item'          => esc_html__('View Service', 'extice'),
            'search_items'       => esc_html__('Search Services', 'extice'),
            'not_found'          => esc_html__('No Services found', 'extice'),
            'not_found_in_trash' => esc_html__('No Services found in Trash', 'extice'),
            'parent_item_colon'  => esc_html__('Parent Service:', 'extice'),
            'menu_name'          => esc_html__('Services', 'extice'),
        );

        $labels     = apply_filters('extice_services_labels', $labels);
        $slug_field = apply_filters('extice_services_slug', 'services');

        extice_function_to_call('post_type', [$this->post_type,
            array(
                'labels'        => $labels,
                'supports'      => array('title', 'editor', 'thumbnail', 'excerpt'),
                'public'        => true,
                'has_archive'   => false,
                'rewrite'       => array('slug' => $slug_field),
                'menu_position' => 5,
            )
            ]
        );
    }

}

Extice_Services::getInstance();
