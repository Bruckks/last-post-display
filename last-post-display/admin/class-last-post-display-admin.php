<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/bruckks
 * @since      1.0.0
 *
 * @package    Last_Post_Display
 * @subpackage Last_Post_Display/admin
 */

class Last_Post_Display_Admin
{
	private $pluginName;
	private $version;
	private static $optionPageSlug = 'lpd_settings';
	private static $optionGroup = 'lpd_settings_group';
	private static $optionName = 'lpd_settings';

	public function __construct( $pluginName, $version ) 
	{
		$this->pluginName = $pluginName;
		$this->version = $version;

		$this->logger = new Last_Post_Display_Logger([
			'dir_name'  => $pluginName . '-logger',
			'channel'   => $pluginName,
			'logs_days' => 30,
		]);
	}

	public static function getOptionName()
	{
		return self::$optionName;
	}

	/**
	 * Register the stylesheets for the admin area.
	 * 
	 */
	public function enqueueStyles() 
	{
		wp_enqueue_style( $this->pluginName, plugin_dir_url( __FILE__ ) . 'css/last-post-display-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 * 
	 */
	public function enqueueScripts() 
	{
		wp_enqueue_script( $this->pluginName, plugin_dir_url( __FILE__ ) . 'js/last-post-display-admin.js', array( 'jquery' ), $this->version, false );
	}
	
	/**
	 * Register Admin Settings Page
	 * 
	 */
	public function initPageSettings()
	{
		add_menu_page(
			'LPD Settings',
			'LPD Settings',
			'manage_options',
			self::$optionPageSlug,
			[ $this, 'lpdSettingsPageCallback' ],
			'dashicons-grid-view',
			25
		);
	}

	/**
	 * Callback Function Form Admin Settings Page
	 * 
	 */	
	public function lpdSettingsPageCallback()
	{
		echo '<div class="wrap">
			<h1>' . get_admin_page_title() . '</h1>
			<p class="lpd__info-message">'.__('To output posts, use the shortcode ', 'last-post-display').'<span>[lpd]</span></p>
			<form method="post" action="options.php">';
			settings_fields( self::$optionGroup );
			do_settings_sections( self::$optionPageSlug );
			submit_button();	
		echo '</form>
		</div>';
	}
	
	/**
	 * Register Admin Settings Page
	 * 
	 */
	public function initFieldsSettings()
	{
		register_setting( self::$optionGroup, self::$optionName );

		add_settings_section(
			'lpd_settings_count_of_post_section',
			__( 'Post Parameters', 'last-post-display' ),
			'',
			self::$optionPageSlug
		);

		add_settings_field(
			'count_of_posts',
			__( 'Count Of Posts', 'last-post-display' ),
			[ $this, 'inputNumberCb'],
			self::$optionPageSlug,
			'lpd_settings_count_of_post_section',
			[
				'label_for' => 'count_of_posts',
				'class' => 'lpd-input',
				'name' => 'count_of_posts',
			]
		);
	}

	/**
	 * Noties Fields Settings
	 * 
	 */
	function inputNumberCb($args)
	{ 
		$options = get_option(self::$optionName);

		$value   = ( !isset( $options[$args['name']] ) ) 
					? null : $options[$args['name']];
		
		echo '<input id="' . esc_attr( self::$optionName . '_' . $args['name'] ) . '" 
		name="' . esc_attr( self::$optionName . '['.$args['name'].']') .'" 
		min="1" type="number" value="'. ( $value ?? 1 ) .'"/>';
	}

	/**
	 * Noties Fields Settings
	 * 
	 */
	public function notiesSaveSettings()
	{
		if (
			isset( $_GET[ 'page' ] )
			&& self::$optionPageSlug == $_GET[ 'page' ]
			&& isset( $_GET[ 'settings-updated' ] )
			&& true == $_GET[ 'settings-updated' ]
		) {
			echo '<div class="notice notice-success is-dismissible"><p>' . __('Settings saved!', 'last-post-display') . '</p></div>';
			$options = get_option(self::$optionName);
			$this->logger->info('Настройки обновлены', $options);
		}
	}

}
