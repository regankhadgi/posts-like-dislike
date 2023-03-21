<?php

defined('ABSPATH') or die('No script kiddies please!!');
$pld_settings = $this->pld_settings;
if (empty($shortcode)) {
    global $post;
    if (empty($post)) {
        return $content;
    }
    $checked_post_types = (!empty($pld_settings['basic_settings']['post_types'])) ? $pld_settings['basic_settings']['post_types'] : array();
    if (!in_array($post->post_type, $checked_post_types)) {
        return $content;
    }
}
/**
 * Don't implement on admin section
 *
 * @since 1.0.0
 */
if (is_admin() && !wp_doing_ajax()) {
    return $content;
}
ob_start();

/**
 * Fires while generating the like dislike html
 *
 * @param type string $content
 *
 * @since 1.0.0
 */
$shortcode = (!empty($shortcode)) ? $shortcode : false;
$atts = (!empty($atts))?$atts:[];
do_action('pld_like_dislike_output', $content, $shortcode, $atts);

$like_dislike_html = ob_get_contents();
ob_end_clean();

if ($pld_settings['basic_settings']['like_dislike_position'] == 'after') {
    /**
     * Filters Like Dislike HTML
     *
     * @param string $like_dislike_html
     * @param array $pld_settings
     *
     * @since 1.0.0
     */
    $content .= apply_filters('pld_like_dislike_html', $like_dislike_html, $pld_settings);
} else {
    $content = apply_filters('pld_like_dislike_html', $like_dislike_html, $pld_settings) . $content;
}
