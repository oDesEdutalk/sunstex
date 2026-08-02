<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Class Extice_Project
 */
class Extice_Project
{
    public $post_type = 'extice_project';
    static $instance;

    public static function getInstance()
    {
        if (!isset(self::$instance) && !(self::$instance instanceof Extice_Project)) {
            self::$instance = new Extice_Project();
        }

        return self::$instance;
    }

    public function __construct()
    {
        add_action('init', [$this, 'create_projects']);
    }

    /**
     * @return void
     */
    public function create_projects()
    {

        $labels = array(
            'name' => esc_html__('Projects', 'extice'),
            'singular_name' => esc_html__('Project', 'extice'),
            'add_new' => esc_html__('Add New Project', 'extice'),
            'add_new_item' => esc_html__('Add New Project', 'extice'),
            'edit_item' => esc_html__('Edit Project', 'extice'),
            'new_item' => esc_html__('New Project', 'extice'),
            'view_item' => esc_html__('View Project', 'extice'),
            'search_items' => esc_html__('Search Projects', 'extice'),
            'not_found' => esc_html__('No Projects found', 'extice'),
            'not_found_in_trash' => esc_html__('No Projects found in Trash', 'extice'),
            'parent_item_colon' => esc_html__('Parent Project:', 'extice'),
            'menu_name' => esc_html__('Projects', 'extice'),
        );

        $labels = apply_filters('extice_project_labels', $labels);
        $slug_field = apply_filters('extice_project_slug', 'projects');

        extice_function_to_call('post_type', [$this->post_type,
                array(
                    'labels' => $labels,
                    'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
                    'public' => true,
                    'has_archive' => false,
                    'rewrite' => array('slug' => $slug_field),
                    'menu_position' => 5,
                    'categories' => array(),
                )
            ]
        );
    }

}

Extice_Project::getInstance();
