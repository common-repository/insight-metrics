<?php
/**
 * Insight Metrics - Integrate Google Analytics with WordPress
 *
 * Plugin Name: Insight Metrics
 * Plugin URI:  https://justwebtime.com/
 * Description: Effortlessly intergrate Google Analytics to your WordPress site.
 * Version:     1.0.3
 * Author:      justwebtime.com
 * Author URI:  https://justwebtime.com/
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: insight-metrics
 * Domain Path: /languages
 * Requires at least: 4.9
 * Tested up to: 6.4.1
 * Requires PHP: 5.6.20
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

// If this file was called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

/**
 * Define commonly used across the plugin and elsewhere.
 *
 * @since    1.0.0
 */
if( !defined( 'INSIGHT_METRICS_VERSION' ) ){
	define( 'INSIGHT_METRICS_VERSION', '1.0.3' );
}

if( !defined( 'INSIGHT_METRICS_FILE' ) ){
	define( 'INSIGHT_METRICS_FILE', __FILE__ );
}

if( !defined( 'INSIGHT_METRICS_BASENAME' ) ){
	define( 'INSIGHT_METRICS_BASENAME', basename(INSIGHT_METRICS_FILE) );
}

if( !defined( 'INSIGHT_METRICS_PLUGIN_BASENAME' ) ){
	define( 'INSIGHT_METRICS_PLUGIN_BASENAME', plugin_basename(INSIGHT_METRICS_FILE) );
}

if( !defined( 'INSIGHT_METRICS_PATH' ) ){
	define( 'INSIGHT_METRICS_PATH', plugin_dir_path(INSIGHT_METRICS_FILE) );
}

if( !defined( 'INSIGHT_METRICS_URL' ) ){
	define( 'INSIGHT_METRICS_URL', plugin_dir_url(INSIGHT_METRICS_FILE) );
}

/**
 * Register Autoloader.
 *
 * @since    1.0.0
 */
function Insight_Metrics_register_autoload(){
	$dir = untrailingslashit( INSIGHT_METRICS_PATH );

	require_once $dir . '/includes/autoloader/init.php';

	$class_map  = $dir . '/includes/autoloader/classmap.php';
	$autoloader = INSIGHT_METRICS\Autoloader\Init::instance();

	if ( is_readable( $class_map ) ) {
		$autoloader->register_class_map( require $class_map );
	} else {
		$autoloader->register_prefix( 'INSIGHT_METRICS', $dir . '/includes' );
	}
}

Insight_Metrics_register_autoload();

/**
 * Check for dependencies, abort if not met.
 *
 * @since    1.0.0
 */
function Insight_Metrics_check_dependencies_and_install(){
	$dir = untrailingslashit( INSIGHT_METRICS_PATH );

	require_once $dir . '/includes/dependencies.php';

	$dependencies = INSIGHT_METRICS\Dependencies::instance();

	// Check here
	$dependencies->required_php( '5.6.20' );
	$dependencies->required_wp( '4.6' );

	if ( $dependencies->has_missing() ) {
		return;
	}else{
		require( $dir . '/includes/plugin.php' );
	}
}

Insight_Metrics_check_dependencies_and_install();