<?php
$pld_settings = $this->pld_settings;
?>
<div class="wrap pld-wrap">
    <div class="pld-header"><h3><?php _e('Posts Like Dislike', 'posts-like-dislike'); ?><span class="pld-avatar-holder"><img src="<?php echo PLD_IMG_DIR . '/avatar.jpeg'; ?>"/></span></h3></div>
    <div class="pld-clear"></div>
    <h2 class="nav-tab-wrapper wp-clearfix">
        <?php
        $pld_tabs = array(
            'basic' => array('label' => __('Basic Settings', PLD_TD)),
            'design' => array('label' => __('Design Settings', PLD_TD)),
            'help' => array('label' => __('Help', PLD_TD)),
            'about' => array('label' => __('About Us', PLD_TD))
        );
        /**
         * Filters the tabs
         *
         * @since 1.0.0
         *
         * @param array $pld_tabs
         */
        $pld_tabs = apply_filters('pld_admin_tabs', $pld_tabs);
        $pld_tab_counter = 0;
        foreach ($pld_tabs as $pld_tab => $pld_tab_detail) {
            $pld_tab_counter++;
            ?>
            <a href="javascript:void(0);" class="nav-tab <?php echo ($pld_tab_counter == 1) ? 'nav-tab-active' : ''; ?> pld-tab-trigger" data-settings-ref="<?php echo $pld_tab; ?>"><?php echo $pld_tab_detail['label']; ?></a>
            <?php
        }
        ?>

    </h2>
    <div class="pld-settings-section-wrap">
        <form class="pld-settings-form">
            <?php include(PLD_PATH . 'inc/views/backend/boxes/basic-settings.php'); ?>
            <?php include(PLD_PATH . 'inc/views/backend/boxes/design-settings.php'); ?>
            <?php include(PLD_PATH . 'inc/views/backend/boxes/help.php'); ?>
            <?php include(PLD_PATH . 'inc/views/backend/boxes/about-us.php'); ?>



            <?php
            /**
             * Fires when displaying the tabs section
             *
             * @param array $pld_settings
             *
             * @since 1.0.0
             */
            do_action('pld_admin_tab_section', $pld_settings);
            ?>
            <div class="pld-field-wrap pld-settings-action">
                <label></label>
                <div class="pld-field">
                    <input type="submit" class="pld-settings-save-trigger button-primary" value="<?php _e('Save settings', PLD_TD); ?>"/>
                    <input type="button" class="pld-settings-restore-trigger button-secondary" value="<?php _e('Restore settings', PLD_TD); ?>"/>
                </div>
            </div>
        </form>

    </div>
    <div class="pld-info-wrap" style="display:none;">
        <img src="<?php echo PLD_IMG_DIR . '/ajax-loader.gif'; ?>" class="pld-loader"/>
        <span class="pld-info"><?php _e('Please wait.', PLD_TD); ?></span>
        <span class="dashicons dashicons-dismiss pld-close-info"></span>
    </div>
</div>