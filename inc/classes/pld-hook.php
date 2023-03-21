<?php

if (!class_exists('PLD_Hooks')) {
    class PLD_Hooks extends PLD_Library
    {
        public function __construct()
        {
            parent::__construct();
            add_filter('the_content', array($this, 'posts_like_dislike'), 200); // hook to add html for like dislike
            add_action('pld_like_dislike_output', array($this, 'generate_like_dislike_html'), 10, 3);
            add_action('wp_head', array($this, 'custom_styles'));
            add_shortcode('posts_like_dislike', array($this, 'render_pld_shortcode'));
        }

        public function posts_like_dislike($content)
        {
            include(PLD_PATH . '/inc/cores/like-dislike-render.php');
            return $content;
        }

        public function render_pld_shortcode($atts)
        {
            $content = '';
            $shortcode = true;
            include(PLD_PATH . '/inc/cores/like-dislike-render.php');
            return $content;
        }

        public function generate_like_dislike_html($content, $shortcode, $atts)
        {
            include(PLD_PATH . '/inc/views/frontend/like-dislike-html.php');
        }

        public function custom_styles()
        {
            $pld_settings = $this->pld_settings;
            echo "<style>";
            if ($pld_settings['design_settings']['icon_color'] != '') {
                echo 'a.pld-like-dislike-trigger {color: ' . esc_attr($pld_settings['design_settings']['icon_color']) . ';}';
            }
            if ($pld_settings['design_settings']['count_color'] != '') {
                echo 'span.pld-count-wrap {color: ' . esc_attr($pld_settings['design_settings']['count_color']) . ';}';
            }
            if (!empty($pld_settings['design_settings']['already_liked_disliked_color'])) {
                echo 'a.pld-prevent.pld-undo-trigger  {color: ' . esc_html($pld_settings['design_settings']['already_liked_disliked_color']) . ';}';
            }
            echo "</style>";
        }
    }

    new PLD_Hooks();
}
