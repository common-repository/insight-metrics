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

class Plugin {

	/**
	 * @var null;
	 */
	protected static $_instance = null;

	/**
	 * @var string
	 */
	private $basename;

	/**
	 * Throw error on object clone
	 *
	 * The whole idea of the singleton design pattern is that there is a single
	 * object therefore, we don't want the object to be cloned.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Not Allowed', 'insight-metrics' ), '1.0.0' );
	}

	/**
	 * Disable unserializing of the class
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Not Allowed', 'insight-metrics' ), '1.0.0' );
	}

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

		$this->basename = INSIGHT_METRICS_PLUGIN_BASENAME;

		add_filter( 'plugin_action_links', [$this,'add_settings_link'], 1, 2 );
		add_filter( 'network_admin_plugin_action_links', [$this,'add_settings_link'], 1, 2 );

		/**
		 * Fires after WordPress has finished loading
		 * but before any headers are sent.
		 */
		add_action( 'plugins_loaded', [$this,'load_classes'], 9 );
	}

	/**
	 * Load gettext translate for our text domain.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function load__plugin_textdomain() {
		load_plugin_textdomain(
			'insight-metrics',
			false,
			basename( dirname( __FILE__ ) ) . '/languages'
		);
	}

	/**
	 * Add a settings link to the left row in the plugin overview screen
	 *
	 * @param array  $links
	 * @param string $file
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function add_settings_link( $links, $file ) {
		if ( $file !== $this->basename ) {
			return $links;
		}

		$page = admin_url( 'admin.php?page=insight-metrics' );
		$main = [];
		$main[] = '<a href="'. $page .'">'. esc_html__( 'Set GA', 'insight-metrics' ) .'</a>';

		return array_merge( $main, $links );
	}

	/**
	 * Register plugin classes.
	 *
	 * @since 1.0.0
	 *
	 * @return array
	 */
	public function load_classes() {
		return [
			$this->load__plugin_textdomain(),
			Admin::instance(),
			Render::instance(),
		];
	}
}

/**
 * Construct main function.
 *
 * @return INSIGHT_METRICS/Plugin->instance
 * @since 1.0.0
 */
function INSIGHT_METRICS() {
	return Plugin::instance();
}


/**
 * Initialized and
 * For loading external resources
 */
INSIGHT_METRICS();