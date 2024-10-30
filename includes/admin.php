<?php
namespace INSIGHT_METRICS;

/**
 * Exit if called directly
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

class Admin {

	/**
	 * @var self;
	 */
	protected static $instance;

	/**
	 * Runs as soon as this class is called through instance()
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', [$this, 'register_menu'], 12 );
		add_action( 'admin_init', [$this, 'register_settings_fields'] );
	}

	public function register_menu(){

		$menu = add_menu_page(
			esc_html__( 'Insight Metrics', 'insight-metrics' ),
			esc_html__( 'Analytics', 'insight-metrics' ),
			'manage_options',
			'insight-metrics',
			[$this, 'template'],
			'dashicons-google'
		);

		add_action( 'load-' . $menu, [$this, 'load_menu'], 10, 0 );
	}

	public function template(){
		$template_name = 'admin';
		$template_output = Template::view( $template_name );
		$allowed_html_tags = Template::allowed_html_tags( $template_name );
		$safe_template_output = wp_kses( $template_output, $allowed_html_tags );
		echo $safe_template_output;
	}

	public function load_menu(){
		// Adding Styles
		$style = new Assets( 'style', 'insight-metrics-style', INSIGHT_METRICS_URL . 'assets/style.css' );
		$style->enqueue();

		// Adding Scripts
		$script = new Assets( 'script', 'insight-metrics-script', INSIGHT_METRICS_URL . 'assets/script.js', ['jquery'] );
		$script->enqueue();
		$script->localize();
	}

	/**
	 * Register option for setting to be saved
	 *
	 * @return field
	 * @since 1.0.0
	 */
	public function register_settings_fields() {
		register_setting(
			'insight_metrics_options',
			'insight_metrics_fields'
		);
	}

}