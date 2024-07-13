<?php

/**
 * The file that defines the core plugin class
 *
 * @link       https://github.com/ViktarTsimashkou
 * @since      1.0.0
 *
 * @package    Last_Post_Display
 * @subpackage Last_Post_Display/includes
 */

class Last_Post_Display {

	protected $loader;
	protected $pluginName;
	protected $version;

	public function __construct() 
	{
		if ( defined( 'LAST_POST_DISPLAY_VERSION' ) ) {
			$this->version = LAST_POST_DISPLAY_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->pluginName = 'last-post-display';

		$this->loadDependencies();
		$this->setLocale();
		$this->defineAdminHooks();
		$this->definePublicHooks();
	}

	private function loadDependencies() 
	{
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-last-post-display-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-last-post-display-utils.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-last-post-display-logger.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-last-post-display-i18n.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-last-post-display-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-last-post-display-public.php';		

		$this->loader = new Last_Post_Display_Loader();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 * 
	 */
	private function setLocale()
	{
		$plugin_i18n = new Last_Post_Display_i18n();
		$this->loader->addAction( 'plugins_loaded', $plugin_i18n, 'loadPluginTextdomain' );
	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 * 
	 * @access   private
	 */
	private function defineAdminHooks()
	{
		$pluginAdmin = new Last_Post_Display_Admin( $this->getPluginName(), $this->getVersion() );

		$this->loader->addAction( 'admin_enqueue_scripts', $pluginAdmin, 'enqueueStyles' );
		$this->loader->addAction( 'admin_enqueue_scripts', $pluginAdmin, 'enqueueScripts' );
		$this->loader->addAction( 'admin_menu', $pluginAdmin, 'initPageSettings' );
		$this->loader->addAction( 'admin_init', $pluginAdmin, 'initFieldsSettings' );
		$this->loader->addAction( 'admin_notices', $pluginAdmin, 'notiesSaveSettings' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function definePublicHooks() 
	{
		$pluginPublic = new Last_Post_Display_Public( $this->getPluginName(), $this->getVersion() );

		$this->loader->addAction( 'wp_enqueue_scripts', $pluginPublic, 'enqueueStyles' );
		$this->loader->addAction( 'wp_enqueue_scripts', $pluginPublic, 'enqueueScripts' );

		$pluginPublic->addShortcodeLpd();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run()
	{
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function getPluginName()
	{
		return $this->pluginName;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @return    Last_Post_Display_Loader    Orchestrates the hooks of the plugin.
	 */
	public function getLoader()
	{
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 */
	public function getVersion()
	{
		return $this->version;
	}
}
