<div class="pld-settings-section" data-settings-ref="basic">
    <div class="pld-field-wrap">
        <label><?php _e('Status', PLD_TD); ?></label>
        <div class="pld-field">
            <input type="checkbox" name="pld_settings[basic_settings][status]" class="pld-form-field" value="1" <?php echo (!empty($pld_settings['basic_settings']['status'])) ? 'checked="checked"' : ''; ?>/>
            <p class="description"><?php _e('Please check to enable posts like and dislike in frontend', PLD_TD); ?></p>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php esc_html_e('Post Types', PLD_TD); ?></label>
        <div class="pld-field">
            <?php
            $post_types = get_post_types(array('public' => true), 'object');
            $checked_post_types = (!empty($pld_settings['basic_settings']['post_types'])) ? $pld_settings['basic_settings']['post_types'] : array();
            foreach ($post_types as $post_type_name => $post_type_object) {
                ?>
                <label class="pld-checkbox-label"><input type="checkbox" name="pld_settings[basic_settings][post_types][]" value="<?php echo esc_attr($post_type_name); ?>" <?php echo (in_array($post_type_name, $checked_post_types)) ? 'checked="checked"' : ''; ?> class="pld-form-field"/><?php echo esc_attr($post_type_object->label); ?></label>
                <?php
            }
            ?>
            <p class="description"><?php esc_html_e('Please uncheck all of these if you are wiling to generate the like dislike icon through custom function.', PLD_TD); ?></p>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php _e('Like Dislike Positiion', PLD_TD); ?></label>
        <div class="pld-field">
            <select name="pld_settings[basic_settings][like_dislike_position]" class="pld-form-field">
                <option value="after" <?php selected($pld_settings['basic_settings']['like_dislike_position'], 'after'); ?>><?php _e('After Post', PLD_TD); ?></option>
                <option value="before" <?php selected($pld_settings['basic_settings']['like_dislike_position'], 'before'); ?>><?php _e('Before Post', PLD_TD); ?></option>
            </select>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php _e('Like Dislike Display', PLD_TD); ?></label>
        <div class="pld-field">
            <select name="pld_settings[basic_settings][like_dislike_display]" class="pld-form-field">
                <option value="both" <?php selected($pld_settings['basic_settings']['like_dislike_display'], 'both'); ?>><?php _e('Display Both', PLD_TD); ?></option>
                <option value="like_only" <?php selected($pld_settings['basic_settings']['like_dislike_display'], 'like_only'); ?>><?php _e('Display Like Only', PLD_TD); ?></option>
                <option value="dislike_only" <?php selected($pld_settings['basic_settings']['like_dislike_display'], 'dislike_only'); ?>><?php _e('Display Dislike Only', PLD_TD); ?></option>
            </select>
            <p class="description"><?php _e('Please choose where you want to display the like dislike buttons', PLD_TD); ?></p>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php _e('Like Dislike Restriction', PLD_TD); ?></label>
        <div class="pld-field">
            <select name="pld_settings[basic_settings][like_dislike_resistriction]" class="pld-form-field pld-toggle-trigger" data-toggle-class="pld-login-link">
                <option value="cookie" <?php selected($pld_settings['basic_settings']['like_dislike_resistriction'], 'cookie'); ?>><?php _e('Cookie Restriction', PLD_TD); ?></option>
                <option value="ip" <?php selected($pld_settings['basic_settings']['like_dislike_resistriction'], 'ip'); ?>><?php _e('IP Restriction', PLD_TD); ?></option>
                <option value="user" <?php selected($pld_settings['basic_settings']['like_dislike_resistriction'], 'user'); ?>><?php _e('Logged In User Restriction', PLD_TD); ?></option>
                <option value="no" <?php selected($pld_settings['basic_settings']['like_dislike_resistriction'], 'no'); ?>><?php _e('No Restriction', PLD_TD); ?></option>
            </select>
            <p class="description"><?php _e('Please choose the restriction you want to assign to likers and dislikers', PLD_TD); ?></p>
        </div>
    </div>
    <div class="pld-field-wrap pld-login-link" data-toggle-value="user" <?php $this->display_none($pld_settings['basic_settings']['like_dislike_resistriction'], 'user'); ?>>
        <label><?php _e('Login Link', PLD_TD); ?></label>
        <div class="pld-field">
            <input type="text" name="pld_settings[basic_settings][login_link]" class="pld-form-field" value="<?php echo (!empty($pld_settings['basic_settings']['login_link'])) ? esc_url($pld_settings['basic_settings']['login_link']) : ''; ?>"/>
            <p class="description"><?php esc_html_e('Please enter the login link where users will be redirected while trying to like or dislike without logging in. Please leave blank if you don\'t want to redirect users to login page.', PLD_TD); ?></p>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php _e('Like Dislike Display Order', PLD_TD); ?></label>
        <div class="pld-field">
            <select name="pld_settings[basic_settings][display_order]" class="pld-form-field">
                <option value="like-dislike" <?php selected($pld_settings['basic_settings']['display_order'], 'like-dislike'); ?>><?php _e('Like Dislike', PLD_TD); ?></option>
                <option value="dislike-like" <?php selected($pld_settings['basic_settings']['display_order'], 'dislike-like'); ?>><?php _e('Dislike Like', PLD_TD); ?></option>
            </select>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php _e("Like hover text", PLD_TD); ?></label>
        <div class="pld-field">
            <input type="text" name="pld_settings[basic_settings][like_hover_text]" class="pld-form-field" value="<?php echo isset($pld_settings['basic_settings']['like_hover_text']) ? esc_attr($pld_settings['basic_settings']['like_hover_text']) : ''; ?>" placeholder="<?php _e("Like", PLD_TD); ?>"/>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php _e("Dislike hover text", PLD_TD); ?></label>
        <div class="pld-field">
            <input type="text" name="pld_settings[basic_settings][dislike_hover_text]" class="pld-form-field" value="<?php echo isset($pld_settings['basic_settings']['dislike_hover_text']) ? esc_attr($pld_settings['basic_settings']['dislike_hover_text']) : ''; ?>" placeholder="<?php _e('Dislike', PLD_TD); ?>"/>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php esc_html_e('Display 0(Zero) by default', 'posts-like-dislike'); ?></label>
        <div class="pld-field">
            <input type="checkbox" name="pld_settings[basic_settings][display_zero]" class="pld-form-field" value="1" <?php echo (!empty($pld_settings['basic_settings']['display_zero'])) ? 'checked="checked"' : ''; ?>/>
            <p class="description"><?php _e('Please check if you want to show 0 for no likes and dislikes', PLD_TD); ?></p>
        </div>
    </div>
    <div class="pld-field-wrap">
        <label><?php esc_html_e('Hide Counter Info Metabox', 'posts-like-dislike'); ?></label>
        <div class="pld-field">
            <input type="checkbox" name="pld_settings[basic_settings][hide_counter_info_metabox]" class="pld-form-field" value="1" <?php echo (!empty($pld_settings['basic_settings']['hide_counter_info_metabox'])) ? 'checked="checked"' : ''; ?>/>
            <p class="description"><?php _e('Please check if you want to hide the counter info metabox in the post edit screen. ', PLD_TD); ?></p>
        </div>
    </div>
</div>