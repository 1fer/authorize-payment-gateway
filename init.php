<?php
/**
 * Plugin Name: WooCommerce Authorize.net Payment Gateway
 * Description: Custom paymnet gateway for Authorize.net
 * Version: 1.0.0
 * Author: Panevnyk Roman
 * 
 * WC requires at least: 2.5.0
 * WC tested up to: 3.7.0
 *
 * @author Panevnyk Roman <panevnyk.roman@gmail.com>
 * @version 1.0.0
 */

if( ! defined( 'ABSPATH' ) ){
	exit;
}

// Register WP_Pointer Handling
if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );

if ( ! defined( 'PG_WCAUTHNET' ) ) {
	define( 'PG_WCAUTHNET', true );
}

if( ! defined( 'PG_WCAUTHNET_VERSION' ) ){
	define( 'PG_WCAUTHNET_VERSION', '1.1.12' );
}

if ( ! defined( 'PG_WCAUTHNET_URL' ) ) {
	define( 'PG_WCAUTHNET_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'PG_WCAUTHNET_DIR' ) ) {
	define( 'PG_WCAUTHNET_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'PG_WCAUTHNET_INIT' ) ) {
	define( 'PG_WCAUTHNET_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'PG_WCAUTHNET_FREE_INIT' ) ) {
	define( 'PG_WCAUTHNET_FREE_INIT', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'PG_WCAUTHNET_FILE' ) ) {
	define( 'PG_WCAUTHNET_FILE', __FILE__ );
}

if ( ! defined( 'PG_WCAUTHNET_INC' ) ) {
	define( 'PG_WCAUTHNET_INC', PG_WCAUTHNET_DIR . 'includes/' );
}

if ( ! defined( 'PG_WCAUTHNET_SLUG' ) ) {
	define( 'PG_WCAUTHNET_SLUG', 'yith-woocommerce-authorizenet-payment-gateway' );
}

/* Plugin Framework Version Check */
if( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( PG_WCAUTHNET_DIR . 'plugin-fw/init.php' ) ) {
	require_once( PG_WCAUTHNET_DIR . 'plugin-fw/init.php' );
}
yit_maybe_plugin_fw_loader( PG_WCAUTHNET_DIR  );

if( ! function_exists( 'yith_wcauthnet_constructor' ) ) {
	function yith_wcauthnet_constructor(){
		load_plugin_textdomain( 'yith-woocommerce-authorizenet-payment-gateway', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		// Load required classes and functions
		$sub_path = version_compare( WC()->version, '2.6', '<' ) ? 'legacy/' : '';

		require_once( PG_WCAUTHNET_INC . $sub_path . 'class.yith-wcauthnet-credit-card-gateway.php' );
		require_once( PG_WCAUTHNET_INC . 'class.yith-wcauthnet.php' );

		if( is_admin() ){
			require_once( PG_WCAUTHNET_INC . 'class.yith-wcauthnet-admin.php' );

			PG_WCAUTHNET_Admin();
		}
	}
}
add_action( 'yith_wcauthnet_init', 'yith_wcauthnet_constructor' );

if( ! function_exists( 'yith_wcauthnet_install' ) ) {
	function yith_wcauthnet_install() {

		if ( ! function_exists( 'is_plugin_active' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		}

		if ( ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', 'yith_wcauthnet_install_woocommerce_admin_notice' );
		}
		else {
			do_action( 'yith_wcauthnet_init' );
		}
	}
}
add_action( 'plugins_loaded', 'yith_wcauthnet_install', 11 );

if( ! function_exists( 'yith_wcauthnet_install_woocommerce_admin_notice' ) ) {
	function yith_wcauthnet_install_woocommerce_admin_notice() {
		?>
		<div class="error">
			<p><?php echo sprintf( __( '%s is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-authorizenet-payment-gateway' ), 'YITH WooCommerce Authorize.net Payment Gateway' ); ?></p>
		</div>
	<?php
	}
}