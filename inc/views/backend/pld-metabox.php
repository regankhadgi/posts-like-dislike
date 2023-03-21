<?php
defined('ABSPATH') or die('No script kiddies please!!');
wp_nonce_field('pld_metabox_nonce', 'pld_metabox_nonce_field');
?>
<div class="pld-field-wrap">
    <label><?php esc_html_e('Like Count', 'posts-like-dislike'); ?></label>
    <div class="pld-field">
        <input type="text" name="pld_like_count" value="<?php echo esc_attr($like_count); ?>"/>
    </div>
</div>
<div class="pld-field-wrap">
    <label><?php esc_html_e('Dislike Count', 'posts-like-dislike'); ?></label>
    <div class="pld-field">
        <input type="text" name="pld_dislike_count" value="<?php echo esc_attr($dislike_count); ?>"/>
    </div>
</div>