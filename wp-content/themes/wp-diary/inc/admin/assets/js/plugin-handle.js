/**
 * Get Started button on dashboard notice.
 *
 * @package WP Diary
 */

jQuery(document).ready(function($) {
    var WpAjaxurl       = ogAdminObject.ajax_url;
    var _wpnonce        = ogAdminObject._wpnonce;
    var buttonStatus    = ogAdminObject.buttonStatus;

    /**
     * Popup on click demo import if mysterythemes demo importer plugin is not activated.
     */
    if( buttonStatus === 'disable' ) $( '.wp-diary-demo-import' ).addClass( 'disabled' );

    switch( buttonStatus ) {
        case 'activate' :
            $( '.wp-diary-get-started' ).on( 'click', function() {
                var _this = $( this );
                wp_diary_do_plugin( 'wp_diary_activate_plugin', _this );
            });
            $( '.wp-diary-activate-demo-import-plugin' ).on( 'click', function() {
                var _this = $( this );
                wp_diary_do_plugin( 'wp_diary_activate_plugin', _this );
            });
            break;
        case 'install' :
            $( '.wp-diary-get-started' ).on( 'click', function() {
                var _this = $( this );
                wp_diary_do_plugin( 'wp_diary_install_plugin', _this );
            });
            $( '.wp-diary-install-demo-import-plugin' ).on( 'click', function() {
                var _this = $( this );
                wp_diary_do_plugin( 'wp_diary_install_plugin', _this );
            });
            break;
        case 'redirect' :
            $( '.wp-diary-get-started' ).on( 'click', function() {
                var _this = $( this );
                location.href = _this.data( 'redirect' );
            });
            break;
    }
    
    wp_diary_do_plugin = function ( ajax_action, _this ) {
        $.ajax({
            method : "POST",
            url : WpAjaxurl,
            data : ({
                'action' : ajax_action,
                '_wpnonce' : _wpnonce
            }),
            beforeSend: function() {
                var loadingTxt = _this.data( 'process' );
                _this.addClass( 'updating-message' ).text( loadingTxt );
            },
            success: function( response ) {
                if( response.success ) {
                    var loadedTxt = _this.data( 'done' );
                    _this.removeClass( 'updating-message' ).text( loadedTxt );
                }
                location.href = _this.data( 'redirect' );
            }
        });
    }

    $('.mt-action-btn').click(function(){
        var _this = $(this), actionBtnStatus = _this.data('status'), pluginSlug = _this.data('slug');
        console.log(actionBtnStatus);
        switch(actionBtnStatus){
            case 'install':
                wp_diary_do_free_plugin( 'wp_diary_install_free_plugin', pluginSlug, _this );
                break;

            case 'active':
                wp_diary_do_free_plugin( 'wp_diary_activate_free_plugin', pluginSlug, _this );
                break;
        }

    });

    wp_diary_do_free_plugin = function ( ajax_action, pluginSlug, _this ) {
        $.ajax({
            method : "POST",
            url : WpAjaxurl,
            data : ({
                'action' : ajax_action,
                'plugin_slug': pluginSlug,
                '_wpnonce' : _wpnonce
            }),
            beforeSend: function() {
                var loadingTxt = _this.data( 'process' );
                _this.addClass( 'updating-message' ).text( loadingTxt );
            },
            success: function( response ) {
                if( response.success ) {
                    var loadedTxt = _this.data( 'done' );
                    _this.removeClass( 'updating-message' ).text( loadedTxt );
                }
                location.href = _this.data( 'redirect' );
            }
        });
    }

});