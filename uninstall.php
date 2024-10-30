<?php
namespace INSIGHT_METRICS;

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'insight_metrics_fields' );