<?php

defined('ABSPATH') or die('No script kiddies please!!');

if (!class_exists('PLD_Admin')) {

    class PLD_Admin extends PLD_Library {

        function __construct() {
            parent::__construct();
            add_action('admin_menu', array($this, 'pld_admin_menu'));

            /**
             * Plugin Settings link in plugins screen
             *
             */
            add_filter('plugin_action_links_' . PLD_BASENAME, array($this, 'add_setting_link'));

            /**
             * Settings save action
             */
            add_action('wp_ajax_pld_settings_save_action', array($this, 'save_settings'));
            add_action('wp_ajax_nopriv_pld_settings_save_action', array($this, 'no_permission'));

            /**
             * Settings restore action
             */
            add_action('wp_ajax_pld_settings_restore_action', array($this, 'restore_settings'));
            add_action('wp_ajax_nopriv_pld_settings_restore_action', array($this, 'no_permission'));

            /**
             * Count Info Meta Box
             */
            add_action('add_meta_boxes', array($this, 'render_count_info_metabox'));

            /**
             * Save posts like dislike meta box
             */
            add_action('save_post', array($this, 'save_pld_metabox'));
        }

        function pld_admin_menu() {
            add_options_page(__('Posts Like Dislike', 'posts-like-dislike'), __('Posts Like Dislike', 'posts-like-dislike'), 'manage_options', 'posts-like-dislike', array($this, 'pld_settings'));
        }

        function pld_settings() {
            include(PLD_PATH . 'inc/views/backend/settings.php');
        }

        function save_settings() {
            if (isset($_POST['_wpnonce']) && wp_verify_nonce($_POST['_wpnonce'], 'pld-backend-ajax-nonce')) {
                $_POST = stripslashes_deep($_POST);
                parse_str($_POST['settings_data'], $settings_data);
                $settings_data = $this->sanitize_array($settings_data);
                $pld_settings = $settings_data['pld_settings'];
                /**
                 * Fires before storing the settings array into database
                 *
                 * @param type array $settings_data - before sanitization
                 * @param type array $pld_settings - after sanitization
                 *
                 * @since 1.0.0
                 */
                do_action('pld_before_save_settings', $settings_data, $pld_settings);

                /**
                 * Filters the settings stored in the database
                 *
                 * @param type array $pld_settings
                 *
                 * @since 1.0.0
                 */
                update_option('pld_settings', apply_filters('pld_settings', $pld_settings));
                die(__('Settings saved successfully', PLD_TD));
            } else {
                die('No script kiddies please!!');
            }
        }

        function no_permission() {
            die('No script kiddies please!!');
        }

        function restore_settings() {
            $default_settings = $this->get_default_settings();
            update_option('pld_settings', $default_settings);
            die(__('Settings restored successfully.Redirecting...', PLD_TD));
        }

        /**
         * Adds settings link
         *
         * @since 1.0.0
         */
        function add_setting_link($links) {
            $settings_link = array(
                '<a href="' . admin_url('options-general.php?page=posts-like-dislike') . '">' . __('Settings', PLD_TD) . '</a>',
            );
            return array_merge($links, $settings_link);
        }

        function render_count_info_metabox() {
            $pld_settings = $this->pld_settings;
            $post_types = (!empty($pld_settings['basic_settings']['post_types'])) ? $pld_settings['basic_settings']['post_types'] : array();
            if (empty($pld_settings['basic_settings']['hide_counter_info_metabox']) && !empty($post_types)) {
                add_meta_box('pld-count-info', esc_html__('Posts Like Dislike', 'posts-like-dislike'), array($this, 'render_count_info_html'), $post_types, 'normal');
            }
        }

        function render_count_info_html($post) {
            $post_id = $post->ID;
            $like_count = get_post_meta($post_id, 'pld_like_count', true);
            $dislike_count = get_post_meta($post_id, 'pld_dislike_count', true);
            include(PLD_PATH . '/inc/views/backend/pld-metabox.php');
        }

        function save_pld_metabox($post_id) {
            $nonce_name = isset($_POST['pld_metabox_nonce_field']) ? $_POST['pld_metabox_nonce_field'] : '';
            $nonce_action = 'pld_metabox_nonce';

            // Check if nonce is valid.
            if (!wp_verify_nonce($nonce_name, $nonce_action)) {
                return;
            }

            // Check if user has permissions to save data.
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }

            // Check if not an autosave.
            if (wp_is_post_autosave($post_id)) {
                return;
            }

            // Check if not a revision.
            if (wp_is_post_revision($post_id)) {
                return;
            }
            if (isset($_POST['pld_like_count'], $_POST['pld_dislike_count'])) {
                $pld_like_count = sanitize_text_field($_POST['pld_like_count']);
                $pld_dislike_count = sanitize_text_field($_POST['pld_dislike_count']);
                update_post_meta($post_id, 'pld_like_count', $pld_like_count);
                update_post_meta($post_id, 'pld_dislike_count', $pld_dislike_count);
            } else {
                return;
            }
        }

    }

    new PLD_Admin();
}
