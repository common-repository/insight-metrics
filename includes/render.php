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

class Render {

	/**
	 * @var null;
	 */
	protected static $_instance = null;

	/**
	 * Runs as soon as this class is called through instance()
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {

		$this->final_output();
	}

	/**
	 * final_output.
	 */
	public function final_output() {

		$fields = get_option( 'insight_metrics_fields' );

		$activate_ga = isset( $fields['activate'] ) ? esc_html( $fields['activate'] ) : false;
		$position    = isset( $fields['position'] ) ? esc_html( $fields['position'] ) : 'header';
		$priority    = isset( $fields['priority'] ) ? esc_html( $fields['priority'] ) : '1';

		// This step ensures that $priority is at least 1 and does not exceed the value of 10.
		$priority    = max(1, min($priority, 10));

		// It ensures that if it is not 'header' or 'footer', sets it to 'header'.
		$position    = ( $position !== 'header' && $position !== 'footer' ) ? 'header' : $position;

		if( $activate_ga ){
			if( $position == 'header' ){
				add_action( 'wp_head', [$this,'output_template'], $priority );
			}elseif( $position == 'footer' ){
				add_action( 'wp_footer', [$this,'output_template'], $priority );
			}
		}
	}

	public function output_template() {

		$fields = get_option( 'insight_metrics_fields' );

		$analytics_mode = isset( $fields['analytics_mode'] ) ? esc_html( $fields['analytics_mode'] ) : 'analyticsjs';
		$google_analytics_id = isset( $fields['google_analytics_id'] ) ? esc_html( $fields['google_analytics_id'] ) : false;
		$also_logged_in = isset( $fields['also_logged_in'] ) ? esc_html( $fields['also_logged_in'] ) : false;

		$is_user_logged_in = is_user_logged_in() && ( current_user_can( 'update_core' ) || current_user_can( 'manage_options' ) ) ? true : false;
		if ( ! empty( $google_analytics_id ) ) {
			if ( ! $is_user_logged_in || !empty( $also_logged_in ) ) {
				if( $analytics_mode == 'analyticsjs' ){
					$template = 'ga-script/universal-analytics';
				}elseif( $analytics_mode == 'gtagjs' ){
					$template = 'ga-script/global-site-tag';
				}elseif( $analytics_mode == 'ga_legacy' ){
					$template = 'ga-script/ga-legacy';
				}elseif( $analytics_mode == 'both' ){
					$template = 'ga-script/universal-analytics-and-global-site-tag';
				}else{
					return;
				}
			}else{
				return;
			}
		}else{
			return;
		}

		$template_output = Template::view( $template, array(
			'google_analytics_id' => esc_html( $google_analytics_id ),
		));

		$allowed_html_tags = Template::allowed_html_tags( $template );
		$safe_template_output = wp_kses( $template_output, $allowed_html_tags );
		echo $safe_template_output;
	}

}