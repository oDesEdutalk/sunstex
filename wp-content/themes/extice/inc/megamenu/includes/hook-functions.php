<?php

defined('ABSPATH') || exit();

/**
 * Hook to delete post elementor related with this menu
 */
add_action("before_delete_post", "extice_megamenu_on_delete_menu_item", 9);
function extice_megamenu_on_delete_menu_item($post_id) {
    if (is_nav_menu_item($post_id)) {
        $related_id = extice_megamenu_get_post_related_menu($post_id);
        if ($related_id) {
            wp_delete_post($related_id, true);
        }
    }
}


add_filter('elementor/editor/footer', 'extice_megamenu_add_back_button_inspector');
function extice_megamenu_add_back_button_inspector() {
    if (!isset($_GET['extice-menu-editable']) || !$_GET['extice-menu-editable']) {
        return;
    }
    ?>
    <script type="text/template" id="tmpl-elementor-panel-footer-content">
        <div id="elementor-panel-footer-back-to-admin" class="elementor-panel-footer-tool elementor-leave-open tooltip-target" data-tooltip="<?php esc_attr_e('Back', 'extice'); ?>">
            <i class="eicon-close" aria-hidden="true"></i>
        </div>
        <div id="elementor-panel-footer-settings" class="elementor-panel-footer-tool elementor-leave-open tooltip-target" data-tooltip="<?php esc_attr_e('Settings', 'extice'); ?>">
            <i class="eicon-cog" aria-hidden="true"></i>
            <span class="elementor-screen-only"><?php echo esc_html__('Page Settings', 'extice'); ?></span>
        </div>
        <div id="elementor-panel-footer-navigator" class="elementor-panel-footer-tool tooltip-target" data-tooltip="<?php esc_attr_e('Navigator', 'extice'); ?>">
            <i class="eicon-navigator" aria-hidden="true"></i>
            <span class="elementor-screen-only">
                    <?php echo esc_html__('Navigator', 'extice'); ?>
                </span>
        </div>
        <div id="elementor-panel-footer-responsive" class="elementor-panel-footer-tool">
            <i class="eicon-device-desktop tooltip-target" aria-hidden="true" data-tooltip="<?php esc_attr_e('Responsive Mode', 'extice'); ?>"></i>
            <span class="elementor-screen-only">
					<?php echo esc_html__('Responsive Mode', 'extice'); ?>
				</span>
        </div>
        <div id="elementor-panel-footer-history" class="elementor-panel-footer-tool elementor-leave-open tooltip-target" data-tooltip="<?php esc_attr_e('History', 'extice'); ?>">
            <i class="eicon-history" aria-hidden="true"></i>
            <span class="elementor-screen-only"><?php echo esc_html__('History', 'extice'); ?></span>
        </div>
        <div id="elementor-panel-footer-saver-publish" class="elementor-panel-footer-tool">
            <button id="elementor-panel-saver-button-publish" class="elementor-button elementor-button-success elementor-saver-disabled">
					<span class="elementor-state-icon">
						<i class="eicon-loading eicon-animation-spin" aria-hidden="true"></i>
					</span>
                <span id="elementor-panel-saver-button-publish-label">
						<?php echo esc_html__('Publish', 'extice'); ?>
					</span>
            </button>
        </div>
        <div id="elementor-panel-saver-save-options" class="elementor-panel-footer-tool">
            <button id="elementor-panel-saver-button-save-options" class="elementor-button elementor-button-success tooltip-target elementor-disabled" data-tooltip="<?php esc_attr_e('Save Options', 'extice'); ?>">
                <i class="eicon-caret-up" aria-hidden="true"></i>
                <span class="elementor-screen-only"><?php echo esc_html__('Save Options', 'extice'); ?></span>
            </button>
        </div>
    </script>

    <?php
}

add_action('wp_ajax_extice_load_menu_data', 'extice_megamenu_load_menu_data');
function extice_megamenu_load_menu_data() {
    $nonce   = !empty($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
    $menu_id = !empty($_POST['menu_id']) ? absint($_POST['menu_id']) : false;
    if (!wp_verify_nonce($nonce, 'extice-menu-data-nonce') || !$menu_id) {
        wp_send_json(array(
            'message' => esc_html__('Access denied', 'extice')
        ));
    }

    $data = extice_megamenu_get_item_data($menu_id);

    $data = $data ? $data : array();
    if (isset($_POST['istop']) && absint($_POST['istop']) == 1) {
        if (class_exists('Elementor\Plugin')) {
            if (isset($data['enabled']) && $data['enabled']) {
                $related_id = extice_megamenu_get_post_related_menu($menu_id);
                if (!$related_id) {
                    extice_megamenu_create_related_post($menu_id);
                    $related_id = extice_megamenu_get_post_related_menu($menu_id);
                }

                if ($related_id && isset($_REQUEST['menu_id']) && is_admin()) {
                    $url                      = Elementor\Plugin::instance()->documents->get($related_id)->get_edit_url();
                    $data['edit_submenu_url'] = add_query_arg(array('extice-menu-editable' => 1), $url);
                }
            } else {
                $url                      = admin_url();
                $data['edit_submenu_url'] = add_query_arg(array('extice-menu-createable' => 1, 'menu_id' => $menu_id), $url);
            }
        }
    }

    $results = apply_filters('extice_menu_settings_data', array(
        'status' => true,
        'data'   => $data
    ));

    wp_send_json($results);

}

add_action('wp_ajax_extice_update_menu_item_data', 'extice_megamenu_update_menu_item_data');
function extice_megamenu_update_menu_item_data() {
    $nonce = !empty($_POST['nonce']) ? sanitize_text_field($_POST['nonce']) : '';
    if (!wp_verify_nonce($nonce, 'extice-update-menu-item')) {
        wp_send_json(array(
            'message' => esc_html__('Access denied', 'extice')
        ));
    }

    $settings = !empty($_POST['extice-menu-item']) ? ($_POST['extice-menu-item']) : array();
    $menu_id  = !empty($_POST['menu_id']) ? absint($_POST['menu_id']) : false;

    do_action('extice_before_update_menu_settings', $settings);


    extice_megamenu_update_item_data($menu_id, $settings);

    do_action('extice_menu_settings_updated', $settings);
    wp_send_json(array('status' => true));
}

add_action('admin_footer', 'extice_megamenu_underscore_template');
function extice_megamenu_underscore_template() {
    global $pagenow;
    if ($pagenow === 'nav-menus.php') { ?>
        <script type="text/html" id="tpl-extice-menu-item-modal">
            <div id="extice-modal" class="extice-modal">
                <div class="extice-modal-overlay"></div>
                <div id="extice-modal-body" class="<%= data.edit_submenu === true ? 'edit-menu-active' : ( data.is_loading ? 'loading' : '' ) %>">
                    <% if ( data.edit_submenu !== true && data.is_loading !== true ) { %>
                    <form id="menu-edit-form">
                        <% } %>
                        <div class="extice-modal-content">
                            <% if ( data.edit_submenu === true ) { %>
                            <iframe src="<%= data.edit_submenu_url %>"/>
                            <% } else if ( data.is_loading === true ) { %>
                            <i class="fa fa-spin fa-spinner"></i>
                            <% } else { %>
                            <div class="form-group toggle-select-setting">
                                <label for="icon"><?php esc_html_e('Icon', 'extice') ?></label>
                                <select id="icon" name="extice-menu-item[icon]" class="form-control extice-input-switcher extice-input-switcher-true" data-target=".icon-custom" data-target2=".icon-custom-image" data-target3=".icon-color">
                                    <option value="" <%= data.icon == '' ? ' selected' : '' %>><?php echo esc_html__('No Use', 'extice') ?></option>
                                    <option value="1" <%= data.icon == 1 ? ' selected' : '' %>><?php echo esc_html__('Custom Class', 'extice') ?></option>
                                    <option value="2" <%= data.icon == 2 ? ' selected' : '' %>><?php echo esc_html__('Custom Image', 'extice') ?></option>
                                    <?php foreach (extice_megamenu_get_fontawesome_icons() as $value) : ?>
                                        <option value="<?php echo 'extice-icon-' . esc_attr($value) ?>"<%= data.icon == '<?php echo 'extice-icon-' . esc_attr($value) ?>' ? ' selected' : '' %>><?php echo esc_html($value) ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="form-group icon-custom-image toggle-select-setting elementor-hidden" style="display: flex;">
                                <label for="icon-custom-image"><?php esc_html_e('Icon Image', 'extice') ?></label>
                                <input type="hidden" name="extice-menu-item[icon_custom_image]" class="input" id="icon-custom-image"/>
                                <input type="hidden" name="extice-menu-item[icon_custom_image_url]" class="input" id="icon-custom-image-url"/>
                                <div class="megamenu-icon-image-wrapper">
                                    <% if (data.icon_custom_image_url !== ''){%>
                                    <img src="<%= data.icon_custom_image_url %>" style="margin-right:10px;padding:0;max-height:32px;float:none;" alt="">
                                    <% } %>
                                </div>
                                <button id="edit-megamenu-image" class="edit-megamenu-image button button-primary button-large">
                                    <?php esc_html_e('Choose image', 'extice') ?>
                                </button>
                                <button style="margin-left:10px" id="edit-megamenu-image-remove" class="edit-megamenu-image-remove button button-primary button-large">
                                    <?php esc_html_e('Remove image', 'extice') ?>
                                </button>
                            </div>
                            <div class="form-group icon-custom toggle-select-setting elementor-hidden">
                                <label for="icon-custom"><?php esc_html_e('Icon Class Name', 'extice') ?></label>
                                <input type="text" name="extice-menu-item[icon-custom]" class="input" id="icon-custom"/>
                            </div>
                            <div class="form-group icon-color toggle-select-setting elementor-hidden">
                                <label for="icon_color"><?php esc_html_e('Icon Color', 'extice') ?></label>
                                <input class="color-picker" name="extice-menu-item[icon_color]" value="<%= data.icon_color %>" id="icon_color"/>
                            </div>
                            <div class="form-group icon-color toggle-select-setting elementor-hidden">
                                <label for="icon_size"><?php esc_html_e('Icon Size', 'extice') ?></label>
                                <input type="text" name="extice-menu-item[icon_size]" value="<%= data.icon_size %>" id="icon_size"/>
                                <span class="unit">px</span>
                            </div>
                            <div class="form-group icon-color toggle-select-setting elementor-hidden">
                                <label for="color"><?php esc_html_e('Color', 'extice') ?></label>
                                <input class="color-picker" name="extice-menu-item[color]" value="<%= data.color %>" id="color"/>
                            </div>
                            <div class="form-group">
                                <label for="css-custom"><?php esc_html_e('Custom Css Class', 'extice') ?></label>
                                <input type="text" name="extice-menu-item[custom_css_class]" class="input" id="css-custom"/>
                            </div>
                            <div class="form-group">
                                <label for="badge_title"><?php esc_html_e('Badges Title', 'extice') ?></label>
                                <input class="form-control" name="extice-menu-item[badge_title]" value="<%= data.badge_title %>" id="badge_title"/>
                            </div>
                            <div class="form-group">
                                <label for="badge_color"><?php esc_html_e('Badges Color', 'extice') ?></label>
                                <input class="color-picker" name="extice-menu-item[badge_color]" value="<%= data.badge_color %>" id="badge_color"/>
                            </div>
                            <div class="form-group">
                                <label for="badges_bg_color"><?php esc_html_e('Badges Bg Color', 'extice') ?></label>
                                <input class="color-picker" name="extice-menu-item[badges_bg_color]" value="<%= data.badges_bg_color %>" id="badges_bg_color"/>
                            </div>

                            <div class="form-group submenu-setting toggle-select-setting">
                                <label><?php esc_html_e('Mega Submenu Enabled', 'extice') ?></label>
                                <select name="extice-menu-item[enabled]" class="extice-input-switcher extice-input-switcher-true" data-target=".submenu-width-setting">
                                    <option value="1"
                                    <%= data.enabled == 1? 'selected':''
                                    %>> <?php esc_html_e('Yes', 'extice') ?></opttion>
                                    <option value="0"
                                    <%= data.enabled == 0? 'selected':''
                                    %>><?php esc_html_e('No', 'extice') ?></opttion>
                                </select>
                                <button id="edit-megamenu" class="button button-primary button-large">
                                    <?php esc_html_e('Edit Megamenu Submenu', 'extice') ?>
                                </button>
                            </div>

                            <div class="form-group submenu-width-setting toggle-select-setting elementor-hidden">
                                <label><?php esc_html_e('Sub Megamenu Width', 'extice') ?></label>
                                <select name="extice-menu-item[customwidth]" class="extice-input-switcher extice-input-switcher-true" data-target=".submenu-subwidth-setting">
                                    <option value="1"
                                    <%= data.customwidth == 1? 'selected':''
                                    %>> <?php esc_html_e('Yes', 'extice') ?></opttion>
                                    <option value="0"
                                    <%= data.customwidth == 0? 'selected':''
                                    %>><?php esc_html_e('Full Width', 'extice') ?></opttion>
                                    <option value="2"
                                    <%= data.customwidth == 2? 'selected':''
                                    %>><?php esc_html_e('Stretch Width', 'extice') ?></opttion>
                                    <option value="3"
                                    <%= data.customwidth == 3? 'selected':''
                                    %>><?php esc_html_e('Container Width', 'extice') ?></opttion>
                                </select>
                            </div>

                            <div class="form-group submenu-width-setting submenu-subwidth-setting toggle-select-setting elementor-hidden">
                                <label for="menu_subwidth"><?php esc_html_e('Sub Mega Menu Max Width', 'extice') ?></label>
                                <input type="text" name="extice-menu-item[subwidth]" value="<%= data.subwidth?data.subwidth:'600' %>" class="input" id="menu_subwidth"/>
                                <span class="unit">px</span>
                            </div>

                            <div class="form-group submenu-width-setting submenu-subwidth-setting toggle-select-setting elementor-hidden">
                                <label><?php esc_html_e('Sub Mega Menu Position Left', 'extice') ?></label>
                                <select name="extice-menu-item[menuposition]">
                                    <option value="0"
                                    <%= data.menuposition == 0? 'selected':''
                                    %>><?php esc_html_e('No', 'extice') ?></opttion>
                                    <option value="1"
                                    <%= data.menuposition == 1? 'selected':''
                                    %>> <?php esc_html_e('Yes', 'extice') ?></opttion>
                                </select>
                            </div>

                            <% } %>
                        </div>
                        <% if ( data.is_loading !== true && data.edit_submenu !== true ) { %>
                        <div class="extice-modal-footer">
                            <a href="#" class="close button"><%= extice_memgamnu_params.i18n.close %></a>
                            <?php wp_nonce_field('extice-update-menu-item', 'nonce') ?>
                            <input name="menu_id" value="<%= data.menu_id %>" type="hidden"/>
                            <button type="submit" class="button button-primary button-large menu-save pull-right"><%=
                                extice_memgamnu_params.i18n.submit %>
                            </button>
                        </div>
                        <% } %>
                        <% if ( data.edit_submenu !== true && data.is_loading !== true ) { %>
                    </form>
                    <% } %>
                </div>
            </div>
        </script>
    <?php }
}







