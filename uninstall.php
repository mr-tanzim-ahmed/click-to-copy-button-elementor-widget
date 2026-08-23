<?php
/**
 * Click to Copy Button Elementor Widget — Uninstall
 *
 * Fired when the plugin is deleted (not just deactivated) from
 * the WordPress admin. Cleans up any data the plugin may have
 * stored in the database.
 *
 * @package Click_To_Copy_Elementor_Widget
 */

// Exit if not called by WordPress.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/*
 * Clear caches when the plugin is uninstalled so the site doesn't
 * serve stale CSS/JS from the deleted plugin.
 */

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
