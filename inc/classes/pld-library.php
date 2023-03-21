<?php

if (!class_exists('PLD_Library')) {

    class PLD_Library {

        var $pld_settings;

        function __construct() {
            $this->pld_settings = get_option('pld_settings');
        }

        function print_array($array) {
            echo "<pre>";
            print_r($array);
            echo "</pre>";
        }

        /**
         * Returns default settings array
         *
         * @return array
         *
         * @since 1.0.0
         */
        function get_default_settings() {
            $default_settings = array();
            $default_settings['basic_settings']['status'] = 0;
            $default_settings['basic_settings']['like_dislike_position'] = 'after';
            $default_settings['basic_settings']['like_dislike_display'] = 'both';
            $default_settings['basic_settings']['like_dislike_resistriction'] = 'cookie';
            $default_settings['basic_settings']['display_order'] = 'like-dislike';
            $default_settings['basic_settings']['like_hover_text'] = '';
            $default_settings['basic_settings']['dislike_hover_text'] = '';
            $default_settings['design_settings']['template'] = 'template-1';
            $default_settings['design_settings']['like_icon'] = '';
            $default_settings['design_settings']['dislike_icon'] = '';
            $default_settings['design_settings']['icon_color'] = '';
            $default_settings['design_settings']['count_color'] = '';
            /**
             * Filters deault settings
             *
             * @param type array $default_settings
             *
             * @since 1.0.0
             */
            return apply_filters('pld_default_settings', $default_settings);
        }

        /**
         * Returns visitors IP address
         *
         * @return string $ip
         *
         * @since 1.0.0
         */
        function get_user_IP() {
            $client = (!empty($_SERVER['HTTP_CLIENT_IP'])) ? $_SERVER['HTTP_CLIENT_IP'] : '';
            $forward = (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : '';
            $remote = (!empty($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : '';

            if (filter_var($client, FILTER_VALIDATE_IP)) {
                $ip = $client;
            } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
                $ip = $forward;
            } else {
                $ip = $remote;
            }

            return $ip;
        }

        /**
         * Sanitizes Multi Dimensional Array
         * @param array $array
         * @param array $sanitize_rule
         * @return array
         *
         * @since 1.0.0
         */
        function sanitize_array($array = array(), $sanitize_rule = array()) {
            if (!is_array($array) || count($array) == 0) {
                return array();
            }

            foreach ($array as $k => $v) {
                if (!is_array($v)) {

                    $default_sanitize_rule = (is_numeric($k)) ? 'html' : 'text';
                    $sanitize_type = isset($sanitize_rule[$k]) ? $sanitize_rule[$k] : $default_sanitize_rule;
                    $array[$k] = $this->sanitize_value($v, $sanitize_type);
                }
                if (is_array($v)) {
                    $array[$k] = $this->sanitize_array($v, $sanitize_rule);
                }
            }

            return $array;
        }

        /**
         * Sanitizes Value
         *
         * @param type $value
         * @param type $sanitize_type
         * @return string
         *
         * @since 1.0.0
         */
        function sanitize_value($value = '', $sanitize_type = 'text') {
            switch ($sanitize_type) {
                case 'html':
                    return $this->sanitize_html($value);
                    break;
                case 'none':
                    return $value;
                    break;
                default:
                    return sanitize_text_field($value);
                    break;
            }
        }

        /**
         * Sanitizes the content by bypassing allowed html
         *
         * @param string $text
         * @return string
         *
         * @since 1.0.0
         */
        function sanitize_html($text) {
            $allowed_html = wp_kses_allowed_html('post');
            return wp_kses($text, $allowed_html);
        }

        /**
         * Prints display none
         *
         * @param string $param1
         * @param string $param2
         *
         * @since 1.0.5
         */
        function display_none($param1, $param2) {
            if ($param1 != $param2) {
                echo 'style="display:none"';
            }
        }

        /**
         * Returns current page URL
         *
         * @since 1.0.5
         */
        function get_current_page_url() {
            if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                $url = "https://";
            else
                $url = "http://";
            // Append the host(domain name, ip) to the URL.
            $url .= $_SERVER['HTTP_HOST'];

            // Append the requested resource location to the URL
            $url .= $_SERVER['REQUEST_URI'];

            return $url;
        }
    }
}
