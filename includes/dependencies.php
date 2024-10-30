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

/**
 * Show a notice when plugin dependencies are not met
 * @version 1.0.0
 */
final class Dependencies {

	/**
	 * @var self;
	 */
	protected static $instance;

	/**
	 * Basename of this plugin
	 * @var string
	 */
	private $basename;

	/**
	 * @var string
	 */
	private $version;

	/**
	 * Missing dependency messages
	 * @var string[]
	 */
	private $messages = [];

	/**
	 * @param string $basename
	 * @param string $version
	 */
	public function __construct() {
		$this->basename = INSIGHT_METRICS_PLUGIN_BASENAME;
		$this->version  = INSIGHT_METRICS_VERSION;
	}

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
	 * Check current PHP version
	 *
	 * @param string $version
	 *
	 * @return bool
	 */
	public function required_php( $version ) {
		if ( ! version_compare( PHP_VERSION, $version, '>=' ) ) {
			$message = sprintf(
				esc_html__( 'PHP %s+ is required. Your server currently runs PHP %s.', 'insight-metrics' ),
				$version,
				PHP_VERSION
			);

			$this->add_missing( $message, 'PHP Version' );

			return false;
		}

		return true;
	}


	/**
	 * Check current WordPress version
	 *
	 * @param string $version
	 *
	 * @return bool
	 */
	public function required_wp( $version ) {
		if ( ! version_compare( get_bloginfo('version'), $version, '>=' ) ) {
			$message = sprintf(
				esc_html__( 'WordPress Version %s+ is required. Your WordPress currently runs Version %s.', 'insight-metrics' ),
				$version,
				PHP_VERSION
			);

			$this->add_missing( $message, 'WordPress Version' );

			return false;
		}

		return true;
	}

	/**
	 * Register hooks
	 */
	private function register() {
		add_action( 'after_plugin_row_' . $this->basename, [ $this, 'display_notice' ], 5 );
		add_action( 'admin_head', [ $this, 'display_notice_css' ] );
	}

	/**
	 * @return bool
	 */
	public function has_missing() {
		return ! empty( $this->messages );
	}

	/**
	 * Club multipple errors into one.
	 *
	 * @return bool
	 */
	public function add_missing( $message, $key ) {
		if ( ! $this->has_missing() ) {
			$this->register();
		}

		$this->messages[ $key ] = $this->sanitize_message( $message );
	}

	/**
	 * @param string $message
	 *
	 * @return string
	 */
	private function sanitize_message( $message ) {
		return wp_kses( $message, [
			'a' => [
				'href'   => true,
				'target' => true,
			],
		] );
	}

	/**
	 * Show a warning when dependencies are not met
	 */
	public function display_notice() {
		$intro = "This plugin can't load because";
		?>

		<tr class="plugin-update-tr <?php echo esc_html( $this->is_plugin_active() ? 'active' : 'inactive' ); ?>">
			<td colspan="4" class="plugin-update colspanchange">
				<div class="update-message notice inline notice-error notice-alt">
					<?php if ( count( $this->messages ) > 1 )  : ?>
						<p>
							<?php echo esc_html( $intro . ':' ); ?>
						</p>

						<ul>
							<?php foreach ( $this->messages as $message ) : ?>
								<li><?php echo esc_html( $message ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php else : ?>
						<p>
							<?php echo esc_html( $intro . ' ' . current( $this->messages ) ); ?>
						</p>
					<?php endif; ?>
				</div>
			</td>
		</tr>

		<?php
	}

	/**
	 * Load additional CSS for the warning
	 */
	public function display_notice_css() {
		?>

		<style>
			.plugins tr[data-plugin='<?php echo esc_html( $this->basename ); ?>'] th,
			.plugins tr[data-plugin='<?php echo esc_html( $this->basename ); ?>'] td {
				box-shadow: none;
			}
		</style>

		<?php
	}

	/**
	 * @return bool
	 */
	private function is_plugin_active() {
		return is_multisite() && is_network_admin()
			? is_plugin_active_for_network( $this->basename )
			: is_plugin_active( $this->basename );
	}

}