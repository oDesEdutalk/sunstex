<?php

use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Extice_Elementor')) :

    /**
     * The Extice Elementor Integration class
     */
    class Extice_Elementor {
        private $suffix = '';

        public function __construct() {
            $this->suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'register_auto_scripts_frontend']);
            add_action('elementor/elements/categories_registered', [$this, 'register_widget_category']);
            add_action('wp_enqueue_scripts', [$this, 'add_scripts'], 15);
            add_action('wp_enqueue_scripts', [$this, 'add_styles'], 9);
            add_action('elementor/widgets/register', array($this, 'customs_widgets'));
            add_action('elementor/widgets/register', array($this, 'include_widgets'));
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'add_js']);

            // Custom Animation Scroll
            add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

            // Elementor Fix Noitice WooCommerce
            add_action('elementor/editor/before_enqueue_scripts', array($this, 'woocommerce_fix_notice'));

            // Backend
            add_action('elementor/editor/after_enqueue_styles', [$this, 'add_style_editor'], 99);
            add_action('elementor/editor/after_enqueue_scripts', [$this, 'add_scripts_editor'], 99);

            add_filter('elementor/shapes/additional_shapes', [$this, 'additional_shapes'], 10, 1);

            // Add Icon Custom
            add_action('elementor/icons_manager/native', [$this, 'add_icons_native']);
            add_action('elementor/controls/register', [$this, 'add_icons']);

            if (!extice_is_elementor_pro_activated()) {
                require trailingslashit(get_template_directory()) . 'inc/elementor/custom-css.php';
                require trailingslashit(get_template_directory()) . 'inc/elementor/sticky-section.php';
                if (is_admin()) {
                    add_action('manage_elementor_library_posts_columns', [$this, 'admin_columns_headers']);
                    add_action('manage_elementor_library_posts_custom_column', [$this, 'admin_columns_content'], 10, 2);
                }

                require get_theme_file_path('inc/elementor/motion-fx/controls-group.php');
                require get_theme_file_path('inc/elementor/motion-fx/module.php');
            }

            require get_theme_file_path('inc/elementor/modules/page-settings.php');
            if (function_exists('hfe_init')) {
                require get_theme_file_path('inc/elementor/modules/header-settings.php');
            }

            add_filter('elementor/fonts/additional_fonts', [$this, 'additional_fonts']);
            add_action('wp_enqueue_scripts', [$this, 'elementor_kit']);
        }

        public function elementor_kit() {
            $active_kit_id = Elementor\Plugin::$instance->kits_manager->get_active_id();
            Elementor\Plugin::$instance->kits_manager->frontend_before_enqueue_styles();
            $myvals = get_post_meta($active_kit_id, '_elementor_page_settings', true);
            if (!empty($myvals)) {
                $css = '';
                foreach ($myvals['system_colors'] as $key => $value) {
                    $css .= $value['color'] !== '' ? '--' . $value['_id'] . ':' . $value['color'] . ';' : '';
                }

                $var = "body{{$css}}";
                wp_add_inline_style('extice-style', $var);
            }
        }

        public function additional_shapes($additional_shapes) {
            $additional_shapes['extice_wave'] = [
                'title'    => esc_html_x('FootPaw Waves', 'Shapes', 'extice'),
                'path'     => get_theme_file_path('assets/images/shape/waves.svg'),
                'url'      => get_theme_file_uri('assets/images/shape/waves.svg'),
                'has_flip' => true,
            ];
            return $additional_shapes;
        }

        public function additional_fonts($fonts) {
            $fonts['Cal Sans'] = 'system';
            return $fonts;
        }

        public function admin_columns_headers($defaults) {
            $defaults['shortcode'] = esc_html__('Shortcode', 'extice');

            return $defaults;
        }

        public function admin_columns_content($column_name, $post_id) {
            if ('shortcode' === $column_name) {
                ob_start();
                ?>
                <input class="elementor-shortcode-input" type="text" readonly onfocus="this.select()" value="[hfe_template id='<?php echo esc_attr($post_id); ?>']"/>
                <?php
                ob_get_contents();
            }
        }

        public function add_js() {

            wp_enqueue_script('extice-elementor-frontend', get_theme_file_uri('/assets/js/elementor-frontend.js'), ['jquery', 'elementor-frontend'], EXTICE_VERSION);
        }

        public function add_style_editor() {

            wp_enqueue_style('extice-elementor-editor-icon', get_theme_file_uri('/assets/css/admin/elementor/icons.css'), [], EXTICE_VERSION);
        }

        public function add_scripts_editor() {
            if ( Plugin::instance()->editor->is_edit_mode() ) {
                wp_enqueue_script('extice-elementor-nested-element', get_theme_file_uri('/assets/js/elementor-nested-element.js'), ['elementor-common'], EXTICE_VERSION);
            }
        }

        public function add_styles() {
            wp_enqueue_style('e-swiper');
        }

        public function add_scripts() {

            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            wp_enqueue_style('extice-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', EXTICE_VERSION);
            wp_style_add_data('extice-elementor', 'rtl', 'replace');

            // Add Scripts

            $e_swiper_latest     = Plugin::$instance->experiments->is_feature_active('e_swiper_latest');
            $e_swiper_asset_path = $e_swiper_latest ? 'assets/lib/swiper/v8/' : 'assets/lib/swiper/';
            $e_swiper_version    = $e_swiper_latest ? '8.4.5' : '5.3.6';
            wp_register_script(
                'swiper',
                plugins_url('elementor/' . $e_swiper_asset_path . 'swiper.js', 'elementor'),
                [],
                $e_swiper_version,
                true
            );
        }

        public function register_auto_scripts_frontend() {
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            wp_register_script('extice-elementor-swiper', get_theme_file_uri('/assets/js/elementor-swiper' . $suffix . '.js'), array('jquery', 'elementor-frontend'), EXTICE_VERSION, true);
            // Register auto scripts frontend

            $files = glob(get_theme_file_path('/assets/js/elementor/*' . $suffix . '.js'));
            foreach ($files as $file) {
                $file_name = wp_basename($file);
                $handle    = str_replace($suffix . ".js", '', $file_name);
                $scr       = get_theme_file_uri('/assets/js/elementor/' . $file_name);
                if (file_exists($file)) {
                    wp_register_script('extice-elementor-' . $handle, $scr, ['jquery', 'elementor-frontend'], EXTICE_VERSION, true);
                }
            }
        }

        public function register_widget_category($this_cat) {
            $this_cat->add_category(
                'extice-addons',
                [
                    'title' => esc_html__('Extice Addons', 'extice'),
                    'icon'  => 'fa fa-plug',
                ]
            );
            return $this_cat;
        }

        public function add_animations_scroll($animations) {
            $animations['Extice Animation'] = [
                'opal-move-up'    => 'Move Up',
                'opal-move-down'  => 'Move Down',
                'opal-move-left'  => 'Move Left',
                'opal-move-right' => 'Move Right',
                'opal-flip'       => 'Flip',
                'opal-helix'      => 'Helix',
                'opal-scale-up'   => 'Scale',
                'opal-am-popup'   => 'Popup',
            ];

            return $animations;
        }

        public function customs_widgets() {
            $files = glob(get_theme_file_path('/inc/elementor/custom-widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        /**
         * @param $widgets_manager Elementor\Widgets_Manager
         */
        public function include_widgets($widgets_manager) {
            require 'base-swiper-trait.php';
            require 'base-swiper-widget.php';
            $files = glob(get_theme_file_path('/inc/elementor/widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        public function woocommerce_fix_notice() {
            if (extice_is_woocommerce_activated()) {
                remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
                remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
            }
        }


        public function add_icons( $manager ) {
            $new_icons = json_decode( '{"extice-icon-admin":"admin","extice-icon-check-mark":"check-mark","extice-icon-clothespin":"clothespin","extice-icon-coloring":"coloring","extice-icon-email":"email","extice-icon-fabric":"fabric","extice-icon-factory":"factory","extice-icon-knitting":"knitting","extice-icon-layers":"layers","extice-icon-leather":"leather","extice-icon-location-1":"location-1","extice-icon-location":"location","extice-icon-logistics":"logistics","extice-icon-phone-call":"phone-call","extice-icon-phone":"phone","extice-icon-pop-up":"pop-up","extice-icon-quote":"quote","extice-icon-schedule":"schedule","extice-icon-sewing-machine":"sewing-machine","extice-icon-spinning-wheel":"spinning-wheel","extice-icon-star-light":"star-light","extice-icon-technical-support":"technical-support","extice-icon-yarn":"yarn","extice-icon-360":"360","extice-icon-account":"account","extice-icon-angle-down":"angle-down","extice-icon-angle-left":"angle-left","extice-icon-angle-right":"angle-right","extice-icon-angle-up":"angle-up","extice-icon-arrow-down":"arrow-down","extice-icon-arrow-left":"arrow-left","extice-icon-arrow-right":"arrow-right","extice-icon-arrow-up":"arrow-up","extice-icon-ask":"ask","extice-icon-bars":"bars","extice-icon-calendar":"calendar","extice-icon-cart-empty":"cart-empty","extice-icon-cart":"cart","extice-icon-check-square":"check-square","extice-icon-check":"check","extice-icon-circle":"circle","extice-icon-clock":"clock","extice-icon-cloud-download-alt":"cloud-download-alt","extice-icon-comment":"comment","extice-icon-comments":"comments","extice-icon-compare":"compare","extice-icon-contact":"contact","extice-icon-copy":"copy","extice-icon-credit-card":"credit-card","extice-icon-dot-circle":"dot-circle","extice-icon-edit":"edit","extice-icon-envelope":"envelope","extice-icon-expand-alt":"expand-alt","extice-icon-expand":"expand","extice-icon-external-link-alt":"external-link-alt","extice-icon-eye":"eye","extice-icon-favorite":"favorite","extice-icon-file-alt":"file-alt","extice-icon-file-archive":"file-archive","extice-icon-filter":"filter","extice-icon-folder-open":"folder-open","extice-icon-folder":"folder","extice-icon-frown":"frown","extice-icon-gift":"gift","extice-icon-grape":"grape","extice-icon-grid":"grid","extice-icon-grip-horizontal":"grip-horizontal","extice-icon-heart-fill":"heart-fill","extice-icon-heart":"heart","extice-icon-history":"history","extice-icon-home":"home","extice-icon-info-circle":"info-circle","extice-icon-instagram":"instagram","extice-icon-letter":"letter","extice-icon-level-up-alt":"level-up-alt","extice-icon-list":"list","extice-icon-long-left-arrow":"long-left-arrow","extice-icon-long-right-arrow":"long-right-arrow","extice-icon-map-marker-check":"map-marker-check","extice-icon-map-marker":"map-marker","extice-icon-meh":"meh","extice-icon-menu":"menu","extice-icon-minus-circle":"minus-circle","extice-icon-minus":"minus","extice-icon-mobile-android-alt":"mobile-android-alt","extice-icon-money-bill":"money-bill","extice-icon-pencil-alt":"pencil-alt","extice-icon-plus":"plus","extice-icon-quickview":"quickview","extice-icon-quotes":"quotes","extice-icon-random":"random","extice-icon-repeat":"repeat","extice-icon-reply-all":"reply-all","extice-icon-reply":"reply","extice-icon-search":"search","extice-icon-shield-check":"shield-check","extice-icon-shop":"shop","extice-icon-shopping-bag":"shopping-bag","extice-icon-shopping-basket":"shopping-basket","extice-icon-sign-out-alt":"sign-out-alt","extice-icon-size-guide":"size-guide","extice-icon-smile":"smile","extice-icon-spinner":"spinner","extice-icon-square":"square","extice-icon-star":"star","extice-icon-store":"store","extice-icon-sync":"sync","extice-icon-tabs":"tabs","extice-icon-tachometer-alt":"tachometer-alt","extice-icon-thumbtack":"thumbtack","extice-icon-ticket":"ticket","extice-icon-times-circle":"times-circle","extice-icon-times-square":"times-square","extice-icon-times":"times","extice-icon-trophy-alt":"trophy-alt","extice-icon-truck":"truck","extice-icon-user":"user","extice-icon-video":"video","extice-icon-wishlist-empty":"wishlist-empty","extice-icon-wishlist":"wishlist","extice-icon-adobe":"adobe","extice-icon-amazon":"amazon","extice-icon-android":"android","extice-icon-angular":"angular","extice-icon-apper":"apper","extice-icon-apple":"apple","extice-icon-atlassian":"atlassian","extice-icon-behance":"behance","extice-icon-bitbucket":"bitbucket","extice-icon-bitcoin":"bitcoin","extice-icon-bity":"bity","extice-icon-bluetooth":"bluetooth","extice-icon-btc":"btc","extice-icon-centos":"centos","extice-icon-chrome":"chrome","extice-icon-codepen":"codepen","extice-icon-cpanel":"cpanel","extice-icon-discord":"discord","extice-icon-dochub":"dochub","extice-icon-docker":"docker","extice-icon-dribbble":"dribbble","extice-icon-dropbox":"dropbox","extice-icon-drupal":"drupal","extice-icon-ebay":"ebay","extice-icon-facebook-f":"facebook-f","extice-icon-facebook-solid":"facebook-solid","extice-icon-facebook":"facebook","extice-icon-figma":"figma","extice-icon-firefox":"firefox","extice-icon-google-plus":"google-plus","extice-icon-google":"google","extice-icon-grunt":"grunt","extice-icon-gulp":"gulp","extice-icon-html5":"html5","extice-icon-joomla":"joomla","extice-icon-link-brand":"link-brand","extice-icon-linkedin":"linkedin","extice-icon-mailchimp":"mailchimp","extice-icon-opencart":"opencart","extice-icon-paypal":"paypal","extice-icon-pinterest-p":"pinterest-p","extice-icon-reddit":"reddit","extice-icon-skype":"skype","extice-icon-slack":"slack","extice-icon-snapchat":"snapchat","extice-icon-spotify":"spotify","extice-icon-trello":"trello","extice-icon-twitter-x":"twitter-x","extice-icon-vimeo":"vimeo","extice-icon-whatsapp":"whatsapp","extice-icon-wordpress":"wordpress","extice-icon-yoast":"yoast","extice-icon-youtube":"youtube"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

        public function add_icons_native($tabs) {
            $tabs['opal-custom'] = [
                'name'          => 'extice-icon',
                'label'         => esc_html__('Extice Icon', 'extice'),
                'prefix'        => 'extice-icon-',
                'displayPrefix' => 'extice-icon-',
                'labelIcon'     => 'fab fa-font-awesome-alt',
                'ver'           => EXTICE_VERSION,
                'fetchJson'     => get_theme_file_uri('/inc/elementor/icons.json'),
                'native'        => true,
            ];
            return $tabs;
        }

    }

endif;

return new Extice_Elementor();
