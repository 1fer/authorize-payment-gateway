<?php
/**
 * This file belongs to the YIT Plugin Framework.
 *
 * This source file is subject to the GNU GENERAL PUBLIC LICENSE (GPL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.gnu.org/licenses/gpl-3.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
} // Exit if accessed directly


! defined( 'PGA_CORE_PLUGIN' )                  && define( 'PGA_CORE_PLUGIN', true);
! defined( 'PGA_CORE_PLUGIN_PATH' )             && define( 'PGA_CORE_PLUGIN_PATH', dirname(__FILE__) );
! defined( 'PGA_CORE_PLUGIN_URL' )              && define( 'PGA_CORE_PLUGIN_URL', untrailingslashit( plugins_url( '/', __FILE__ ) ) );
! defined( 'PGA_CORE_PLUGIN_TEMPLATE_PATH' )    && define( 'PGA_CORE_PLUGIN_TEMPLATE_PATH', PGA_CORE_PLUGIN_PATH .  '/templates' );

include_once( 'yit-functions.php' );
include_once( 'yit-woocommerce-compatibility.php' );
include_once( 'yit-plugin-registration-hook.php' );
include_once( 'lib/yit-metabox.php' );
include_once( 'lib/yit-plugin-panel.php' );
include_once( 'lib/yit-plugin-panel-wc.php' );
include_once( 'lib/yit-ajax.php' );
include_once( 'lib/yit-plugin-subpanel.php' );
include_once( 'lib/yit-plugin-common.php' );
include_once( 'lib/yit-plugin-gradients.php');
include_once( 'lib/yit-theme-licence.php');
include_once( 'lib/yit-video.php');
include_once( 'lib/yit-upgrade.php');
include_once( 'lib/yit-pointers.php');
include_once( 'lib/yit-icons.php');
include_once( 'lib/yit-assets.php');
include_once( 'lib/yit-debug.php');
include_once( 'lib/yith-dashboard.php' );
include_once( 'lib/privacy/yit-privacy.php' );
include_once( 'lib/privacy/yit-privacy-plugin-abstract.php' );
include_once( 'lib/promo/yith-promo.php' );

/* === Gutenberg Support === */
if( class_exists( 'WP_Block_Type_Registry' ) ){
	include_once( 'lib/yith-gutenberg.php' );
}

// load from theme folder...
load_textdomain( 'yith-plugin-fw', get_template_directory() . '/core/plugin-fw/yith-plugin-fw-' . apply_filters( 'plugin_locale', get_locale(), 'yith-plugin-fw' ) . '.mo' )

// ...or from plugin folder
|| load_textdomain( 'yith-plugin-fw', dirname(__FILE__) . '/languages/yith-plugin-fw-' . apply_filters( 'plugin_locale', get_locale(), 'yith-plugin-fw' ) . '.mo' );

if( ! function_exists( 'yith_add_action_links' ) ){
	/**
	 * Action Links
	 *
	 * add the action links to plugin admin page
	 *
	 * @param $links | links plugin array
	 *
	 * @return   mixed Array
	 * @author Panevnyk Roman <panevnyk.roman@gmail.com>
	 * @return mixed
	 * @use      plugin_action_links_{$plugin_file_name}
	 */
	function yith_add_action_links( $links, $panel_page = '', $is_premium = false ) {
		$links = is_array( $links ) ? $links : array();
		if( ! empty( $panel_page )  ){
			$links[] = sprintf( '<a href="%s">%s</a>', admin_url( "admin.php?page={$panel_page}" ), _x( 'Settings', 'Action links',  'yith-plugin-fw' ) );
		}
		return $links;
	}
}

/* === WooCommerce Update Message === */

/*if( apply_filters( 'yit_fw_wc_update_message_hook', true )
    &&
    ( function_exists( 'WC' ) && ! version_compare( WC()->version, '2.7', '>=' ) )
    && ! isset( $_COOKIE['yith_wc_2_7_notice'] )
){
    add_action( 'admin_notices', 'yit_fw_wc_update_message', 15 );
    add_action( 'admin_enqueue_scripts', 'yit_plugin_fw_dismissable_notice', 20 );

    if( ! function_exists( 'yit_fw_wc_update_message' ) ){
        function yit_fw_wc_update_message(){
            ?>
            <div id="yith-notice-is-dismissable" class="yith-wc-update-message notice notice-error is-dismissible">
                <?php $message = 'the new WooCommerce version 2.7 will be soon released. <strong>Before</strong> proceeding with the update, please verify the plugins you are using are already compatible. You can check the compatibility status of YITH products'; ?>
                <?php $url = 'https://support.yithemes.com/hc/en-us/articles/215945378-Theme-and-Plugin-compatibility-with-WordPress-and-WooCommerce'; ?>
                <p><?php printf( '<strong>%s</strong> - %s <a href="%s" target="_blank">HERE</a>.', 'Please note', $message, $url ); ?></p>
            </div>
            <?php
        }
    }

    if( ! function_exists( 'yit_plugin_fw_dismissable_notice' ) ){
        function yit_plugin_fw_dismissable_notice(){
            $assets_path          = str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) . '/assets/';
            wp_enqueue_script( 'jquery-cookie', $assets_path . 'js/jquery-cookie/jquery.cookie.min.js', array( 'jquery' ), '1.4.1', true);
            $js = "jQuery( document ).ready( function(){
                jQuery( '#yith-notice-is-dismissable' ).find('.notice-dismiss').on( 'click', function(){
                    jQuery.cookie('yith_wc_2_7_notice', 'dismiss', { path: '/' });
                } );
            } ); ";

            wp_add_inline_script( 'jquery-cookie', $js );
        }
    }
}*/

/* ========================== */
