<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/ViktarTsimashkou
 * @since      1.0.0
 *
 * @package    Last_Post_Display
 * @subpackage Last_Post_Display/public
 */

class Last_Post_Display_Public
{
	private $pluginName;
	private $version;

	public function __construct( $pluginName, $version )
	{
		$this->pluginName = $pluginName;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 */
	public function enqueueStyles()
	{
		wp_enqueue_style( $this->pluginName, plugin_dir_url( __FILE__ ) . 'css/last-post-display-public.css', [], $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 */
	public function enqueueScripts()
	{
		wp_enqueue_script( $this->pluginName, plugin_dir_url( __FILE__ ) . 'js/last-post-display-public.js', ['jquery'], $this->version, false );
	}

	public function addShortcodeLpd()
	{
		add_shortcode( 'lpd', [$this, 'shortcodeLpdFunc'] );
	}

	public function shortcodeLpdFunc(array $atts)
	{
		$options = get_option(Last_Post_Display_Admin::getOptionName());
		$args = [
			'post_type' => 'post',
			'posts_per_page' => $options['count_of_posts'] ?? 9,
			'orderby'  => 'date',
			'order' => 'DESC'
		];
		$query = new WP_Query( $args ); ?>

		<div class="lpd-section">
			<div class="lpd-section__container">
				<div class="lpd-section__wrapper">
					<?php if ( $query->have_posts() ) { 
						while ( $query->have_posts() ) {
							$query->the_post();
							include 'partials/last-post-display-public-display.php';
						}
					} else { ?>
						<div class="lpd__nothing"><?php _e('Posts not found', 'last-post-display'); ?></div>
					<?php } ?>
				</div>
			</div>
		</div>
		<?php wp_reset_postdata();
	}
}
