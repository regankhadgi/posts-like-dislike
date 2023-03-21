<?php
$post_id = (!empty($atts['id']))?intval($atts['id']):get_the_ID();
$like_count = get_post_meta($post_id, 'pld_like_count', true);
$dislike_count = get_post_meta($post_id, 'pld_dislike_count', true);

$pld_settings = get_option('pld_settings');

if (empty($pld_settings['basic_settings']['status']) && empty($shortcode)) {
    // if posts like dislike is disabled from backend
    return;
}
$already_liked = 0;
$href = 'javascript:void(0)';

/**
 * Cookie Restriction Validation
 *
 */
if ($pld_settings['basic_settings']['like_dislike_resistriction'] == 'cookie' && isset($_COOKIE['pld_' . $post_id])) {
    $already_liked = 1;
}

/**
 * IP Restriction Validation
 */
if ($pld_settings['basic_settings']['like_dislike_resistriction'] == 'ip') {
    $liked_ips = get_post_meta($post_id, 'pld_ips', true);
    $user_ip = $this->get_user_IP();
    if (empty($liked_ips)) {
        $liked_ips = array();
    }
    if (in_array($user_ip, $liked_ips)) {
        $already_liked = 1;
    }
}

/**
 * User Logged In validation
 */
if ($pld_settings['basic_settings']['like_dislike_resistriction'] == 'user') {
    if (is_user_logged_in()) {
        $liked_users = get_post_meta($post_id, 'pld_users', true);
        $liked_users = (empty($liked_users)) ? array() : $liked_users;
        $current_user_id = get_current_user_id();
        if (in_array($current_user_id, $liked_users)) {
            $already_liked = 1;
        }
    } else {
        $current_page_url = $this->get_current_page_url();
        $href = (!empty($pld_settings['basic_settings']['login_link'])) ? $pld_settings['basic_settings']['login_link'] : admin_url() . '/wp-login.php?redirect=' . $current_page_url;
    }
}

if (!empty($pld_settings['basic_settings']['display_zero'])) {
    if (empty($like_count)) {
        $like_count = 0;
    }
    if (empty($dislike_count)) {
        $dislike_count = 0;
    }
}
/**
 * Filters like count
 *
 * @param type int $like_count
 * @param type int $post_id
 *
 * @since 1.0.0
 */
$like_count = apply_filters('pld_like_count', $like_count, $post_id);

/**
 * Filters dislike count
 *
 * @param type int $dislike_count
 * @param type int $post_id
 *
 * @since 1.0.0
 */
$dislike_count = apply_filters('pld_dislike_count', $dislike_count, $post_id);

$like_title = isset($pld_settings['basic_settings']['like_hover_text']) ? esc_attr($pld_settings['basic_settings']['like_hover_text']) : __('Like', PLD_TD);
$dislike_title = isset($pld_settings['basic_settings']['dislike_hover_text']) ? esc_attr($pld_settings['basic_settings']['dislike_hover_text']) : __('Dislike', PLD_TD);

//$this->print_array( $pld_settings );
?>
<div
    class="pld-like-dislike-wrap pld-<?php echo esc_attr($pld_settings['design_settings']['template']); ?>">
    <?php
    /**
     * Like Dislike Order
     */
    if ($pld_settings['basic_settings']['display_order'] == 'like-dislike') {
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'dislike_only') {
            include(PLD_PATH . 'inc/views/frontend/like.php');
        }
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'like_only') {
            include(PLD_PATH . 'inc/views/frontend/dislike.php');
        }
    } else {
        /**
         * Dislike Like Order
         */
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'like_only') {
            include(PLD_PATH . 'inc/views/frontend/dislike.php');
        }
        if ($pld_settings['basic_settings']['like_dislike_display'] != 'dislike_only') {
            include(PLD_PATH . 'inc/views/frontend/like.php');
        }
    }
    ?>
</div>