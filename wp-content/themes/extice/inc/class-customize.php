<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Extice_Customize')) {

    class Extice_Customize {


        public function __construct() {
            add_action('customize_register', array($this, 'customize_register'));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         */
        public function customize_register($wp_customize) {

            /**
             * Theme options.
             */
            require_once get_theme_file_path('inc/customize-control/button-switch.php');

            $this->init_extice_blog($wp_customize);
            $this->init_extice_scroll($wp_customize);

            $this->init_extice_social($wp_customize);

            if (extice_is_woocommerce_activated()) {
                $this->init_woocommerce($wp_customize);
            }

            do_action('extice_customize_register', $wp_customize);
        }

        public function init_extice_scroll($wp_customize) {

            $wp_customize->add_section('extice_settings', array(
                'title' => esc_html__('Extice Settings', 'extice'),
            ));

            $wp_customize->add_setting('extice_options_smooth_scroll', array(
                'type'              => 'option',
                'default'           => '',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control(new Extice_Customize_Control_Button_Switch( $wp_customize, 'extice_options_smooth_scroll', array(
                'section' => 'extice_settings',
                'label' => esc_html__( 'Enable', 'extice' ),
                'description' => esc_html__('Smooth Scroll On Windows', 'extice'),
            ) ));

            $wp_customize->add_setting('extice_options_enable_backtop', array(
                'type'              => 'option',
                'default'           => '',
                'sanitize_callback' => 'extice_sanitize_button_switch',
            ));

            $wp_customize->add_control(new Extice_Customize_Control_Button_Switch($wp_customize, 'extice_options_enable_backtop', array(
                'section'   => 'extice_settings',
                'transport' => 'refresh',
                'label'     => esc_html__('Enable back to top', 'extice'),
            )));
        }


        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_extice_blog($wp_customize) {

            $wp_customize->add_section('extice_blog_archive', array(
                'title' => esc_html__('Blog', 'extice'),
            ));

            // =========================================
            // Select Style
            // =========================================

            $wp_customize->add_setting('extice_options_blog_style', array(
                'type'              => 'option',
                'default'           => 'standard',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_blog_style', array(
                'section' => 'extice_blog_archive',
                'label'   => esc_html__('Blog style', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'standard' => esc_html__('Blog Standard', 'extice'),
                    //====start_premium
                    'grid'  => esc_html__('Blog Grid', 'extice'),
                    'list'     => esc_html__('Blog List', 'extice'),
                    //====end_premium
                ),
            ));

            $wp_customize->add_setting('extice_options_blog_columns', array(
                'type'              => 'option',
                'default'           => 1,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_blog_columns', array(
                'section' => 'extice_blog_archive',
                'label'   => esc_html__('Colunms', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'extice'),
                    2 => esc_html__('2', 'extice'),
                    3 => esc_html__('3', 'extice'),
                    4 => esc_html__('4', 'extice'),
                ),
            ));

            $wp_customize->add_setting('extice_options_blog_archive_sidebar', array(
                'type'              => 'option',
                'default'           => 'right',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_blog_archive_sidebar', array(
                'section' => 'extice_blog_archive',
                'label'   => esc_html__('Sidebar Position', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'extice'),
                    'right' => esc_html__('Right', 'extice'),
                ),
            ));

        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_extice_social($wp_customize) {

            $wp_customize->add_section('extice_social', array(
                'title' => esc_html__('Socials', 'extice'),
            ));
            $wp_customize->add_setting('extice_options_social_share', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_social_share', array(
                'type'    => 'checkbox',
                'section' => 'extice_social',
                'label'   => esc_html__('Show Social Share', 'extice'),
            ));
            $wp_customize->add_setting('extice_options_social_share_facebook', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_social_share_facebook', array(
                'type'    => 'checkbox',
                'section' => 'extice_social',
                'label'   => esc_html__('Share on Facebook', 'extice'),
            ));
            $wp_customize->add_setting('extice_options_social_share_twitter', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_social_share_twitter', array(
                'type'    => 'checkbox',
                'section' => 'extice_social',
                'label'   => esc_html__('Share on Twitter', 'extice'),
            ));
            $wp_customize->add_setting('extice_options_social_share_linkedin', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_social_share_linkedin', array(
                'type'    => 'checkbox',
                'section' => 'extice_social',
                'label'   => esc_html__('Share on Linkedin', 'extice'),
            ));
            $wp_customize->add_setting('extice_options_social_share_google-plus', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_social_share_google-plus', array(
                'type'    => 'checkbox',
                'section' => 'extice_social',
                'label'   => esc_html__('Share on Google+', 'extice'),
            ));

            $wp_customize->add_setting('extice_options_social_share_pinterest', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_social_share_pinterest', array(
                'type'    => 'checkbox',
                'section' => 'extice_social',
                'label'   => esc_html__('Share on Pinterest', 'extice'),
            ));
            $wp_customize->add_setting('extice_options_social_share_email', array(
                'type'              => 'option',
                'capability'        => 'edit_theme_options',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_social_share_email', array(
                'type'    => 'checkbox',
                'section' => 'extice_social',
                'label'   => esc_html__('Share on Email', 'extice'),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_woocommerce($wp_customize) {

            $wp_customize->add_panel('woocommerce', array(
                'title' => esc_html__('Woocommerce', 'extice'),
            ));

            $wp_customize->add_section('extice_woocommerce_archive', array(
                'title'      => esc_html__('Archive', 'extice'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            $wp_customize->add_setting('extice_options_woocommerce_archive_width', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_woocommerce_archive_width', array(
                'section' => 'extice_woocommerce_archive',
                'label'   => esc_html__('Width', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'default'  => esc_html__('Default width', 'extice'),
                    'full'   => esc_html__('Full width', 'extice'),
                    //====end_premium
                ),
            ));
            $wp_customize->add_setting('extice_options_woocommerce_archive_layout', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_woocommerce_archive_layout', array(
                'section' => 'extice_woocommerce_archive',
                'label'   => esc_html__('Layout Style', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'default'  => esc_html__('Sidebar', 'extice'),
                    //====start_premium
                    'canvas'   => esc_html__('Canvas Filter', 'extice'),
                    'menu'     => esc_html__('Menu Filter', 'extice'),
                    'dropdown' => esc_html__('Dropdown Filter', 'extice'),
                    'drawing'  => esc_html__('Drawing Filter', 'extice'),
                    //====end_premium
                ),
            ));

            $wp_customize->add_setting('extice_options_woocommerce_archive_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_woocommerce_archive_sidebar', array(
                'section' => 'extice_woocommerce_archive',
                'label'   => esc_html__('Sidebar Position', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'extice'),
                    'right' => esc_html__('Right', 'extice'),

                ),
            ));

            $wp_customize->add_setting('extice_options_woocommerce_shop_pagination', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('extice_options_woocommerce_shop_pagination', array(
                'section' => 'extice_woocommerce_archive',
                'label'   => esc_html__('Products pagination', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'default'  => esc_html__('Pagination', 'extice'),
                    'more-btn' => esc_html__('Load More', 'extice'),
                    'infinit'  => esc_html__('Infinit Scroll', 'extice'),
                ),
            ));

            // =========================================
            // Single Product
            // =========================================

            $wp_customize->add_section('extice_woocommerce_single', array(
                'title'      => esc_html__('Single Product', 'extice'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
            ));

            $wp_customize->add_setting('extice_options_single_product_gallery_layout', array(
                'type'              => 'option',
                'default'           => 'horizontal',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('extice_options_single_product_gallery_layout', array(
                'section' => 'extice_woocommerce_single',
                'label'   => esc_html__('Layout Style', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'horizontal'     => esc_html__('Horizontal', 'extice'),
                    'vertical'       => esc_html__('Vertical', 'extice'),
                    'sticky'         => esc_html__('Sticky', 'extice'),
                    'gallery'        => esc_html__('Gallery', 'extice'),
                    'collage'        => esc_html__('Collage', 'extice'),
                    'without-thumb'  => esc_html__('Without Thumb', 'extice'),
                    'sticky-summary' => esc_html__('Sticky Summary', 'extice'),
                ),
            ));

            $wp_customize->add_section('extice_woocommerce_product', array(
                'title'      => esc_html__('Product Block', 'extice'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
            ));

            $wp_customize->add_setting('extice_options_woocommerce_product_hover', array(
                'type'              => 'option',
                'default'           => 'none',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('extice_options_woocommerce_product_hover', array(
                'section' => 'extice_woocommerce_product',
                'label'   => esc_html__('Animation Image Hover', 'extice'),
                'type'    => 'select',
                'choices' => array(
                    'none'          => esc_html__('None', 'extice'),
                    'bottom-to-top' => esc_html__('Bottom to Top', 'extice'),
                    'top-to-bottom' => esc_html__('Top to Bottom', 'extice'),
                    'right-to-left' => esc_html__('Right to Left', 'extice'),
                    'left-to-right' => esc_html__('Left to Right', 'extice'),
                    'swap'          => esc_html__('Swap', 'extice'),
                    'fade'          => esc_html__('Fade', 'extice'),
                    'zoom-in'       => esc_html__('Zoom In', 'extice'),
                    'zoom-out'      => esc_html__('Zoom Out', 'extice'),
                ),
            ));

        }
    }
}
return new Extice_Customize();
