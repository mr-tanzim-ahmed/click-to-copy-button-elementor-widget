<?php
/**
 * Plugin Name: Click to Copy Button Elementor Widget
 * Plugin URI: https://github.com/mr-tanzim-ahmed/click-to-copy-button-elementor-widget
 * Description: Adds a "Click to Copy" button widget to Elementor. Great for coupon codes, referral links, API keys, or any short text a visitor needs to copy in one tap — with a Safari/iOS-safe clipboard fallback and full Elementor style controls.
 * Version: 1.1.0
 * Requires at least: 6.0
 * Requires PHP: 7.4
 * Requires Plugins: elementor
 * Elementor tested up to: 3.26
 * Elementor Pro tested up to: 3.26
 * Author: Tanzim Ahmed
 * Author URI: https://github.com/mr-tanzim-ahmed
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: click-to-copy-elementor-widget
 * Domain Path: /languages
 */

// Exit if this file is loaded directly instead of through WordPress.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CTCEW_PATH', plugin_dir_path( __FILE__ ) );
define( 'CTCEW_URL', plugin_dir_url( __FILE__ ) );
define( 'CTCEW_VERSION', '1.1.0' );
define( 'CTCEW_MIN_ELEMENTOR_VERSION', '3.5.0' );
define( 'CTCEW_MIN_PHP_VERSION', '7.4' );

/**
 * Clear caches when the plugin is deactivated so the site doesn't
 * serve stale CSS/JS.
 */
function ctcew_clear_caches_on_deactivation() {
	// 1. Elementor CSS Cache
	if ( class_exists( '\Elementor\Plugin' ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}

	// 2. WP Rocket Cache
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}

	// 3. LiteSpeed Cache
	if ( has_action( 'litespeed_purge_all' ) ) {
		do_action( 'litespeed_purge_all' );
	}

	// 4. Autoptimize Cache
	if ( class_exists( 'autoptimizeCache' ) ) {
		autoptimizeCache::clearall();
	}

	// 5. W3 Total Cache
	if ( function_exists( 'w3tc_flush_all' ) ) {
		w3tc_flush_all();
	}

	// 6. WP Super Cache
	if ( function_exists( 'wp_cache_clear_cache' ) ) {
		wp_cache_clear_cache();
	}
}
register_deactivation_hook( __FILE__, 'ctcew_clear_caches_on_deactivation' );

/**
 * Make sure Elementor (and the versions it needs) are actually available
 * before we try to register anything. If something's missing, we show a
 * friendly admin notice instead of letting the site fatal-error.
 */
function ctcew_check_requirements() {

	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action(
			'admin_notices',
			function () {
				echo '<div class="notice notice-warning"><p>';
				esc_html_e( 'Click to Copy Button requires Elementor to be installed and activated.', 'click-to-copy-elementor-widget' );
				echo '</p></div>';
			}
		);
		return false;
	}

	if ( ! version_compare( ELEMENTOR_VERSION, CTCEW_MIN_ELEMENTOR_VERSION, '>=' ) ) {
		add_action(
			'admin_notices',
			function () {
				echo '<div class="notice notice-warning"><p>';
				printf(
					/* translators: %s: the minimum Elementor version required */
					esc_html__( 'Click to Copy Button requires Elementor version %s or newer. Please update Elementor.', 'click-to-copy-elementor-widget' ),
					esc_html( CTCEW_MIN_ELEMENTOR_VERSION )
				);
				echo '</p></div>';
			}
		);
		return false;
	}

	if ( version_compare( PHP_VERSION, CTCEW_MIN_PHP_VERSION, '<' ) ) {
		add_action(
			'admin_notices',
			function () {
				echo '<div class="notice notice-warning"><p>';
				printf(
					/* translators: %s: the minimum PHP version required */
					esc_html__( 'Click to Copy Button requires PHP version %s or newer. Please ask your host to update PHP.', 'click-to-copy-elementor-widget' ),
					esc_html( CTCEW_MIN_PHP_VERSION )
				);
				echo '</p></div>';
			}
		);
		return false;
	}

	return true;
}

/**
 * Load the widget class and register it with Elementor.
 */
function ctcew_register_widget( $widgets_manager ) {
	require_once CTCEW_PATH . 'widgets/class-click-to-copy-widget.php';
	$widgets_manager->register( new \Click_To_Copy_Widget() );
}
add_action(
	'elementor/widgets/register',
	function ( $widgets_manager ) {
		if ( ctcew_check_requirements() ) {
			ctcew_register_widget( $widgets_manager );
		}
	}
);

/**
 * Give the widget its own category in the Elementor panel so it's easy
 * to find instead of getting lost among the "General" widgets.
 */
add_action(
	'elementor/elements/categories_registered',
	function ( $elements_manager ) {
		$elements_manager->add_category(
			'click-to-copy',
			[
				'title' => __( 'Click to Copy', 'click-to-copy-elementor-widget' ),
				'icon'  => 'fa fa-plug',
			]
		);
	}
);

/**
 * Register the widget's CSS and JS. We only register them here —
 * Elementor actually enqueues them (once per page, no matter how many
 * times the widget is used) via get_style_depends() / get_script_depends()
 * on the widget class itself, both on the live site and inside the editor
 * preview, which is what keeps style-panel changes updating instantly.
 */
function ctcew_register_assets() {
	$asset_version = CTCEW_VERSION . '.' . filemtime( CTCEW_PATH . 'assets/click-to-copy.js' );
	
	wp_register_style(
		'ctcew-style',
		CTCEW_URL . 'assets/click-to-copy.css',
		[],
		$asset_version
	);
	wp_register_script(
		'ctcew-script',
		CTCEW_URL . 'assets/click-to-copy.js',
		[],
		$asset_version,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'ctcew_register_assets' );
add_action( 'elementor/frontend/before_enqueue_scripts', 'ctcew_register_assets' );
