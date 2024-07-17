<?php
/**
 * Plugin Name: YITH WooCommerce Badge Management
 * Plugin URI: https://yithemes.com/themes/plugins/yith-woocommerce-badges-management/
 * Description: Highlight discounts, offers and products features using <strong>custom graphic badges.</strong> <a href="https://yithemes.com/" target="_blank">Get more plugins for your e-commerce shop on <strong>YITH</strong></a>
 * Version: 3.8.0
 * Author: YITH
 * Author URI: https://yithemes.com/
 * Text Domain: yith-woocommerce-badges-management
 * Domain Path: /languages/
 * WC requires at least: 8.8
 * WC tested up to: 9.0
 *
 * @package YITH\BadgeManagement
 * @author  YITH <plugins@yithemes.com>
 * @version 3.8.0
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

if ( ! function_exists( 'is_plugin_active' ) ) {
	require_once ABSPATH . 'wp-admin/includes/plugin.php';
}

/**
 * WooCommerce missing notice
 */
function yith_wcbm_install_woocommerce_admin_notice() {
	?>
	<div class="error">
		<p><?php esc_attr_e( 'YITH WooCommerce Badge Management is enabled but not effective. It requires WooCommerce in order to work.', 'yith-woocommerce-badges-management' ); ?></p>
	</div>
	<?php
}

/**
 * Free-Premium notice
 */
function yith_wcbm_install_free_admin_notice() {
	?>
	<div class="error">
		<p><?php esc_attr_e( 'You can\'t activate the free version of YITH WooCommerce Badge Management while you are using the premium one.', 'yith-woocommerce-badges-management' ); ?></p>
	</div>
	<?php
}

if ( ! function_exists( 'yith_plugin_registration_hook' ) ) {
	require_once 'plugin-fw/yit-plugin-registration-hook.php';
}
register_activation_hook( __FILE__, 'yith_plugin_registration_hook' );


! defined( 'YITH_WCBM_VERSION' ) && define( 'YITH_WCBM_VERSION', '3.8.0' );

! defined( 'YITH_WCBM_FREE_INIT' ) && define( 'YITH_WCBM_FREE_INIT', plugin_basename( __FILE__ ) );

! defined( 'YITH_WCBM' ) && define( 'YITH_WCBM', true );

! defined( 'YITH_WCBM_FILE' ) && define( 'YITH_WCBM_FILE', __FILE__ );

! defined( 'YITH_WCBM_SLUG' ) && define( 'YITH_WCBM_SLUG', 'yith-woocommerce-badges-management' );

! defined( 'YITH_WCBM_URL' ) && define( 'YITH_WCBM_URL', plugin_dir_url( __FILE__ ) );

! defined( 'YITH_WCBM_DIR' ) && define( 'YITH_WCBM_DIR', plugin_dir_path( __FILE__ ) );

! defined( 'YITH_WCBM_PLUGIN_OPTIONS_PATH' ) && define( 'YITH_WCBM_PLUGIN_OPTIONS_PATH', YITH_WCBM_DIR . 'plugin-options/' );

! defined( 'YITH_WCBM_ASSETS_PATH' ) && define( 'YITH_WCBM_ASSETS_PATH', YITH_WCBM_DIR . 'assets/' );

! defined( 'YITH_WCBM_ASSETS_IMAGES_PATH' ) && define( 'YITH_WCBM_ASSETS_IMAGES_PATH', YITH_WCBM_ASSETS_PATH . 'images/' );

! defined( 'YITH_WCBM_TEMPLATES_PATH' ) && define( 'YITH_WCBM_TEMPLATES_PATH', YITH_WCBM_DIR . 'templates/' );

! defined( 'YITH_WCBM_VIEWS_PATH' ) && define( 'YITH_WCBM_VIEWS_PATH', YITH_WCBM_DIR . 'views/' );

! defined( 'YITH_WCBM_ASSETS_URL' ) && define( 'YITH_WCBM_ASSETS_URL', YITH_WCBM_URL . 'assets/' );

! defined( 'YITH_WCBM_ASSETS_CSS_URL' ) && define( 'YITH_WCBM_ASSETS_CSS_URL', YITH_WCBM_ASSETS_URL . 'css/' );

! defined( 'YITH_WCBM_ASSETS_JS_URL' ) && define( 'YITH_WCBM_ASSETS_JS_URL', YITH_WCBM_ASSETS_URL . 'js/' );

! defined( 'YITH_WCBM_INCLUDES_PATH' ) && define( 'YITH_WCBM_INCLUDES_PATH', YITH_WCBM_DIR . 'includes/' );

! defined( 'YITH_WCBM_COMPATIBILITY_PATH' ) && define( 'YITH_WCBM_COMPATIBILITY_PATH', YITH_WCBM_INCLUDES_PATH . 'compatibility/' );

! defined( 'YITH_WCBM_PLUGIN_NAME' ) && define( 'YITH_WCBM_PLUGIN_NAME', 'YITH WooCommerce Badge Management' );

if ( ! function_exists( 'yith_wcbm_init' ) ) {
	/**
	 * Init function.
	 */
	function yith_wcbm_init() {
		load_plugin_textdomain( 'yith-woocommerce-badges-management', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

		require_once 'includes/functions.yith-wcbm.php';
		require_once 'includes/functions.yith-wcbm-deprecated.php';
		require_once 'includes/data-stores/class-yith-wcbm-simple-data-store-cpt.php';
		require_once 'includes/data-stores/class-yith-wcbm-badge-data-store-cpt.php';

		require_once 'includes/objects/class-yith-wcbm-badge.php';

		require_once 'includes/class-yith-wcbm.php';
		require_once 'includes/class-yith-wcbm-admin.php';
		require_once 'includes/class-yith-wcbm-badges.php';
		require_once 'includes/class-yith-wcbm-install.php';
		require_once 'includes/class-yith-wcbm-frontend.php';
		require_once 'includes/class-yith-wcbm-post-types.php';
		require_once 'includes/compatibility/class-yith-wcbm-compatibility.php';

		// Let's start the game!
		yith_wcbm();
	}
}

add_action( 'yith_wcbm_init', 'yith_wcbm_init' );

if ( ! function_exists( 'yith_wcbm_install' ) ) {
	/**
	 * Install function
	 */
	function yith_wcbm_install() {

		if ( ! function_exists( 'WC' ) ) {
			add_action( 'admin_notices', 'yith_wcbm_install_woocommerce_admin_notice' );
		} elseif ( defined( 'YITH_WCBM_PREMIUM' ) ) {
			add_action( 'admin_notices', 'yith_wcbm_install_free_admin_notice' );
			deactivate_plugins( plugin_basename( __FILE__ ) );
		} else {
			do_action( 'yith_wcbm_init' );
		}
	}
}

add_action( 'plugins_loaded', 'yith_wcbm_install', 11 );

/* Plugin Framework Version Check */
if ( ! function_exists( 'yit_maybe_plugin_fw_loader' ) && file_exists( plugin_dir_path( __FILE__ ) . 'plugin-fw/init.php' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'plugin-fw/init.php';
}
yit_maybe_plugin_fw_loader( plugin_dir_path( __FILE__ ) );
