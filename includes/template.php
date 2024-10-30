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

class Template {

	private $data = [];
	private $template;

	public function __construct( $template, array $data = [] ) {
		$this->template = $template;
		$this->set_data( $data );
	}

	public function get( $key ) {
		if ( ! isset( $this->data[ $key ] ) ) {
			return null;
		}

		return $this->data[ $key ];
	}

	public function __get( $key ) {
		return $this->get( $key );
	}

	public function __set( $key, $value ) {
		return $this->set( $key, $value );
	}

	public function set_data( array $data ) {
		foreach ( $data as $key => $value ) {
			$this->set( $key, $value );
		}

		return $this;
	}

	public function set( $key, $value ) {
		$this->data[ $key ] = $value;

		return $this;
	}

	public function resolve_template() {

		$paths = apply_filters( 'INSIGHT_METRICS/Template', [ INSIGHT_METRICS_PATH . 'templates' ], $this->template );

		foreach ( $paths as $path ) {
			$file = $path . '/' . $this->template . '.php';

			if ( is_readable( $file ) ) {
				include $file;

				return true;
			}
		}

		return false;
	}


	public function render() {
		ob_start();
		$this->resolve_template();
		return ob_get_clean();
	}

	public static function view( $template, $arg = [] ) {
		$defaults = [];

		$args = wp_parse_args( $arg, $defaults );

		$view = ( !empty($template) && is_array($args) ) ? new Template( $template, $args ) : false;

		return ( (bool) $view ) ? $view->render() : false;
	}

	public static function allowed_html_tags( $template_name ) {

		$allowed_tags = array();

		if( $template_name === 'admin' ){
			$allowed_tags = array(
				'div'   => array( 'class' => array(), 'title' => array(), 'style' => array() ),
				'a'     => array( 'class' => array(), 'target' => array(), 'href' => array(), 'rel' => array(), 'title' => array() ),
				'input' => array( 'class' => array(), 'type' => array(), 'name' => array(), 'value' => array(), 'id' => array(), 'checked' => array(), 'max' => array(), 'min' => array() ),
				'form'  => array( 'method' => array(), 'action' => array() ),
				'table' => array( 'class' => true ),
				'td'    => array( 'valign' => array() ),
				'tr'    => array( 'valign' => array(), 'id' => array(), 'class' => array() ),
				'th'    => array( 'scope' => array() ),
				'label' => array( 'for' => array() ),
				'tbody' => array(),
				'h1'    => array(),
				'h2'    => array(),
				'span'  => array( 'class' => array(), 'data-description' => array() ),
				'p'     => array( 'class' => array() ),
				'ul'    => array( 'class' => array() ),
				'li'    => array( 'class' => array() ),
			);
		}elseif(
			$template_name === 'ga-script/universal-analytics' ||
			$template_name === 'ga-script/global-site-tag' ||
			$template_name === 'ga-script/ga-legacy' ||
			$template_name === 'ga-script/universal-analytics-and-global-site-tag'
		){
			$allowed_tags = array(
				'script' => array(
					'async' => true,
					'src' => array(),
				),
			);
		}

		return $allowed_tags;
	}

}