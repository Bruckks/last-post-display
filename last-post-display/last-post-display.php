<?php

/**
 * @link              https://github.com/bruckks
 * @since             1.0.0
 * @package           Last_Post_Display
 *
 * @wordpress-plugin
 * Plugin Name:       Last Post Display
 * Plugin URI:        https://github.com/bruckks
 * Description:       Display recent posts with shortcode.
 * Version:           1.0.0
 * Author:            bruckks
 * Author URI:        https://github.com/bruckks
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       last-post-display
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'LAST_POST_DISPLAY_VERSION', '1.0.0' );
define( 'LAST_POST_DISPLAY_ROOTPATH', plugins_url() );

require_once plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

function activateLastPostDisplay() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-last-post-display-activator.php';
	Last_Post_Display_Activator::activate();
}

function deactivateLastPostDisplay() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-last-post-display-deactivator.php';
	Last_Post_Display_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activateLastPostDisplay' );
register_deactivation_hook( __FILE__, 'deactivateLastPostDisplay' );

require plugin_dir_path( __FILE__ ) . 'includes/class-last-post-display.php';

function runLastPostDisplay() {
	$plugin = new Last_Post_Display();
	$plugin->run();
}
runLastPostDisplay();