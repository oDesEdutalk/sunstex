<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Extice_Elementor_Media_Custom_Field')) :

    /**
     * The main Extice_Elementor_Css_Filters class
     */
    class Extice_Elementor_Media_Custom_Field {
        public function __construct() {
            add_filter('attachment_fields_to_edit', [$this, 'attachment_fields'], 10, 2);
            add_action('wp_ajax_save-attachment-compat', [$this, 'ajax_media_fields'], 0, 1);
            add_action('edit_attachment', [$this, 'update_attachment_meta'], 1);
        }

        public function update_attachment_meta($post_id) {
            $nonce = $_REQUEST['nonce_attachment_extice_custom_media_link'] ?? false;

            // Bail if the nonce check fails.
            if (empty($nonce) || !wp_verify_nonce($nonce, 'update_attachment_extice_custom_media_link')) {
                return;
            }

            $extice_custom_media_link = isset($_POST['attachments'][$post_id]['extice_custom_media_link'])
                ? wp_kses_post($_POST['attachments'][$post_id]['extice_custom_media_link'])
                : false;

            update_post_meta($post_id, 'extice_custom_media_link', $extice_custom_media_link);

            return;
        }

        public function ajax_media_fields() {
            $nonce = $_REQUEST['nonce_attachment_extice_custom_media_link'] ?? false;

            // Bail if the nonce check fails.
            if (empty($nonce) || !wp_verify_nonce($nonce, 'update_attachment_extice_custom_media_link')) {
                return;
            }

            // Bail if the post ID is empty.
            $post_id = intval($_POST['id']);
            if (empty($post_id)) {
                return;
            }

            // Update the post.
            $meta = $_POST['attachments'][$post_id]['extice_custom_media_link'] ?? '';
            $meta = sanitize_text_field($meta);
            update_post_meta($post_id, 'extice_custom_media_link', $meta);

            clean_post_cache($post_id);
        }

        public function attachment_fields($fields, $post) {
            $meta = get_post_meta($post->ID, 'extice_custom_media_link', true);

            $fields['extice_custom_media_link'] = [
                'label'        => esc_html__('Custom Link', 'extice'),
                'input'        => 'text',
                'value'        => $meta,
                'show_in_edit' => true,
                'extra_rows'   => [
                    'nonce' => wp_nonce_field(
                        'update_attachment_extice_custom_media_link', // Action.
                        'nonce_attachment_extice_custom_media_link', // Nonce name.
                        true, // Output referer?
                        false // Echo?
                    ),
                ],
            ];

            return $fields;
        }
    }

endif;

new Extice_Elementor_Media_Custom_Field();
