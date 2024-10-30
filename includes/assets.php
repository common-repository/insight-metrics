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

class Assets {

	protected $asset;
	protected $handle;
	protected $location;
	protected $dependencies;

	public function __construct( $asset, $handle, $location = null, array $dependencies = [] ) {
		$this->asset = $asset;
		$this->handle = $handle;
		$this->location = $location;
		$this->dependencies = $dependencies;
	}


	public function register() {
		if ( null === $this->location && null === $this->asset ) {
			return;
		}

		if ( $this->asset == 'style' ) {

			wp_register_style(
				$this->handle,
				$this->location,
				$this->dependencies,
				INSIGHT_METRICS_VERSION
			);

		}elseif ( $this->asset == 'script' ) {

			wp_register_script(
				$this->handle,
				$this->location,
				$this->dependencies,
				INSIGHT_METRICS_VERSION
			);

		}else{
			return;
		}

	}


	public function enqueue() {

		if ( $this->asset == 'style' ) {

			if ( wp_style_is( $this->handle ) ) {
				return;
			}

			if ( ! wp_style_is( $this->handle, 'registered' ) ) {
				$this->register();
			}

			wp_enqueue_style( $this->handle );

		}elseif ( $this->asset == 'script' ) {

			if ( wp_script_is( $this->handle ) ) {
				return;
			}

			if ( ! wp_script_is( $this->handle, 'registered' ) ) {
				$this->register();
			}

			wp_enqueue_script( $this->handle );

		}else{
			return;
		}

	}

	public function localize(){
		if ( $this->asset == 'script' ) {

			wp_localize_script( $this->handle, 'INSIGHT_METRICS', apply_filters( 'INSIGHT_METRICS/Localize/Script', [] ) );

		}
	}

}