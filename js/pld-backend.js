jQuery(document).ready(function ($) {
    var info_timer;
    /**
     * Tab Show and hide
     */
    $('.pld-wrap .nav-tab').click(function () {
        var settings_ref = $(this).data('settings-ref');
        $('.pld-wrap .nav-tab').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.pld-settings-section').hide();
        $('.pld-settings-section[data-settings-ref="' + settings_ref + '"]').show();
        if (settings_ref == 'help' || settings_ref == 'about') {
            $('.pld-settings-action').hide();
        } else {
            $('.pld-settings-action').show();
        }

    });

    /**
     * Template Preview Toggle
     */
    $('.pld-template-dropdown').change(function () {
        var template = $(this).val();
        if (template != 'custom') {
            $('.pld-custom-ref').hide();
            $('.pld-template-ref').show();
            $('.pld-each-template-preview').hide();
            $('.pld-each-template-preview[data-template-ref="' + template + '"]').show();
        } else {
            $('.pld-each-template-preview').hide();
            $('.pld-template-ref').hide();
            $('.pld-custom-ref').show();
        }

    });

    /**
     * Colorpicker Initialize
     */
    $('.pld-colorpicker').wpColorPicker();

    /**
     * Open Media Uploader
     */
    $('.pld-file-uploader').click(function () {
        var selector = $(this);

        var image = wp.media({
            title: 'Upload Image',
            // mutiple: true if you want to upload multiple files at once
            multiple: false
        }).open()
                .on('select', function (e) {
                    // This will return the selected image from the Media Uploader, the result is an object
                    var uploaded_image = image.state().get('selection').first();
                    // We convert uploaded_image to a JSON object to make accessing it easier
                    // Output to the console uploaded_image
                    console.log(uploaded_image);
                    var image_url = uploaded_image.toJSON().url;
                    // Let's assign the url value to the input field
                    selector.parent().find('input[type="text"]').val(image_url);
                    selector.parent().find('.pld-preview-holder').html('<img src="' + image_url + '"/>');
                });
    });

    /**
     * Save Settings
     */
    $('.pld-settings-form').submit(function (e) {
        e.preventDefault();

        var settings_data = $(this).serialize();
        $.ajax({
            type: 'post',
            url: pld_admin_js_object.admin_ajax_url,
            data: {
                action: 'pld_settings_save_action',
                settings_data: settings_data,
                _wpnonce: pld_admin_js_object.admin_ajax_nonce
            },
            beforeSend: function (xhr) {
                clearTimeout(info_timer);
                $('.pld-info-wrap').slideDown(500);
                $('.pld-info').html(pld_admin_js_object.messages.wait)
                $('.pld-loader').show();
            },
            success: function (res) {
                $('.pld-loader').hide();
                $('.pld-info').html(res);
                info_timer = setTimeout(function () {
                    $('.pld-info-wrap').slideUp(500);
                }, 5000);

            }
        });
    });

    /**
     * Close Info 
     * 
     */
    $('.pld-close-info').click(function () {
        $(this).parent().slideUp(500);
    });

    /**
     * Default settings restore
     */
    $('.pld-settings-restore-trigger').click(function () {
        if (confirm(pld_admin_js_object.messages.restore_confirm)) {
            $.ajax({
                type: 'post',
                url: pld_admin_js_object.admin_ajax_url,
                data: {
                    action: 'pld_settings_restore_action',
                    _wpnonce: pld_admin_js_object.admin_ajax_nonce
                },
                beforeSend: function (xhr) {
                    clearTimeout(info_timer);
                    $('.pld-info-wrap').slideDown(500);
                    $('.pld-info').html(pld_admin_js_object.messages.wait)
                    $('.pld-loader').show();
                },
                success: function (res) {
                    $('.pld-loader').hide();
                    $('.pld-info').html(res);
                    location.reload();


                }
            });
        }
    });

    /**
     * Class show hide on select dropdown toggle
     */
    $('body').on('change', '.pld-toggle-trigger', function () {
        var toggle_class = $(this).data('toggle-class');
        var toggle_value = $(this).val();
        $('.' + toggle_class).hide();
        $('.' + toggle_class + '[data-toggle-value="' + toggle_value + '"]').show();
    });
});