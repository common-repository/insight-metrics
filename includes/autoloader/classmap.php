<?php
/**
 * Exit if called directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

$dir = untrailingslashit( INSIGHT_METRICS_PATH );

return array (
	'INSIGHT_METRICS\\Autoloader\\Init' => $dir . '/includes/autoloader/init.php',
	'INSIGHT_METRICS\\Admin' => $dir . '/includes/admin.php',
	'INSIGHT_METRICS\\Assets' => $dir . '/includes/assets.php',
	'INSIGHT_METRICS\\Dependencies' => $dir . '/includes/dependencies.php',
	'INSIGHT_METRICS\\Plugin' => $dir . '/includes/plugin.php',
	'INSIGHT_METRICS\\Render' => $dir . '/includes/render.php',
	'INSIGHT_METRICS\\Template' => $dir . '/includes/template.php',
);