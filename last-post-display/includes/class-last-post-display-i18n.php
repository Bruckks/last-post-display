<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://github.com/ViktarTsimashkou
 * @since      1.0.0
 *
 * @package    Last_Post_Display
 * @subpackage Last_Post_Display/includes
 */

class Last_Post_Display_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function loadPluginTextdomain() {

		load_plugin_textdomain(
			'last-post-display',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}

}
