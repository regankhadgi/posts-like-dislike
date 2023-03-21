<?php

if (!class_exists('PLD_Enqueue')) {

    class PLD_Enqueue {

        /**
         * Includes all the frontend and backend JS and CSS enqueues
         * 
         * @since 1.0.0
         */
        function __construct() {
            add_action('wp_enqueue_scripts', array($this, 'register_frontend_assets'));
            add_action('admin_enqueue_scripts', array($this, 'register_backend_assets'));
        }

        function register_frontend_assets() {
            $pld_settings = get_option('pld_settings');
            if (empty($pld_settings['design_settings']['disable_fontawesome'])) {
                /**
                 * Fontawesome 5 support 
                 * 
                 * @version 1.0.6
                 */
                wp_enqueue_style('pld-font-awesome', PLD_CSS_DIR . '/fontawesome/css/all.min.css', array(), PLD_VERSION);
            }
            wp_enqueue_style('pld-frontend', PLD_CSS_DIR . '/pld-frontend.css', array(), PLD_VERSION);
            wp_enqueue_script('pld-frontend', PLD_JS_DIR . '/pld-frontend.js', array('jquery'), PLD_VERSION);
            $ajax_nonce = wp_create_nonce('pld-ajax-nonce');

            $js_object = array('admin_ajax_url' => admin_url('admin-ajax.php'), 'admin_ajax_nonce' => $ajax_nonce);
            wp_localize_script('pld-frontend', 'pld_js_object', $js_object);
        }

        function register_backend_assets($hook) {
            wp_enqueue_style('wp-color-picker');
            wp_enqueue_media();
            wp_enqueue_style('pld-admin-css', PLD_CSS_DIR . '/pld-backend.css', array(), PLD_VERSION);
            wp_enqueue_script('pld-admin-js', PLD_JS_DIR . '/pld-backend.js', array('jquery', 'wp-color-picker'), PLD_VERSION);
            $ajax_nonce = wp_create_nonce('pld-backend-ajax-nonce');
            $messages = array('wait' => __('Please wait', PLD_TD), 'restore_confirm' => __('Are you sure you want to restore default settings?', PLD_TD));
            $js_object = array('admin_ajax_url' => admin_url('admin-ajax.php'), 'admin_ajax_nonce' => $ajax_nonce, 'messages' => $messages);
            wp_localize_script('pld-admin-js', 'pld_admin_js_object', $js_object);
        }
    }

    new PLD_Enqueue();
}
