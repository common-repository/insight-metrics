<?php
namespace INSIGHT_METRICS;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}
?>
<div class="wrap insight-metrics">
	<h1 class="wp-heading-inline"><?php esc_html_e( 'Insight Metrics - Intergrate Google Analytics to WordPress', 'insight-metrics' ); ?></h1>
	<hr class="wp-header-end">
	<?php settings_errors(); ?>
	<div class="clear"></div>
	<div class="content">
		<div class="insight-metrics-content">
			<form method="post" action="options.php">
				<?php settings_fields( 'insight_metrics_options' ); ?>
				<table class="form-table">
					<?php $fields = get_option( 'insight_metrics_fields' ); ?>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Enable Google Analytics', 'insight-metrics' ); ?><span class="dashicons dashicons-editor-help" data-description="<?php esc_html_e( 'This setting allows you to activate or deactivate the integration of Google Analytics on your WordPress website', 'insight-metrics' ); ?>"></span></th>
						<td><input type="checkbox" name="insight_metrics_fields[activate]" value="1" <?php checked( 1, isset($fields['activate']) ) ?>/></td>
					</tr>
					<?php $analytics_mode = isset( $fields['analytics_mode'] ) ? esc_html( $fields['analytics_mode'] ) : ''; ?>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Analytics Mode', 'insight-metrics' ); ?><span class="dashicons dashicons-editor-help" data-description="<?php esc_html_e( 'This setting allows you to select the preferred mode for integrating Google Analytics tracking code into your WordPress website', 'insight-metrics' ); ?>"></span></th>
						<td>
							<p><input type="radio" class="analytics_mode" id="analyticsjs" name="insight_metrics_fields[analytics_mode]" value="analyticsjs" <?php echo (  $analytics_mode == 'analyticsjs' || empty($analytics_mode) ) ? 'checked="checked"' : ''; ?> ><label for="analyticsjs"><?php esc_html_e( 'Universal Analytics -- analytics.js', 'insight-metrics' ); ?></label></p>
							<p><input type="radio" class="analytics_mode" id="gtagjs" name="insight_metrics_fields[analytics_mode]" value="gtagjs" <?php echo ( $analytics_mode == 'gtagjs' )? 'checked="checked"' : ''; ?> ><label for="gtagjs"><?php esc_html_e( 'Global Site Tag -- gtag.js', 'insight-metrics' ); ?></label></p>
							<p><input type="radio" class="analytics_mode" id="ga_legacy" name="insight_metrics_fields[analytics_mode]" value="ga_legacy" <?php echo ( $analytics_mode == 'ga_legacy' )? 'checked="checked"' : ''; ?> ><label for="ga_legacy"><?php esc_html_e( 'Google Analytics Legacy -- ga.js', 'insight-metrics' ); ?></label></p>
							<p><input type="radio" class="analytics_mode" id="both" name="insight_metrics_fields[analytics_mode]" value="both" <?php echo ( $analytics_mode == 'both' )? 'checked="checked"' : ''; ?> ><label for="both"><?php esc_html_e( 'Both -- (analytics.js + gtag.js)', 'insight-metrics' ); ?></label></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Google Analytics ID', 'insight-metrics' ); ?><span class="dashicons dashicons-editor-help" data-description="<?php esc_html_e( 'Enter the unique tracking ID provided by Google Analytics for your website. This ID is necessary for connecting the plugin with your Google Analytics account and enabling data tracking and analysis', 'insight-metrics' ); ?>"></span></th>
						<td><input type="text" name="insight_metrics_fields[google_analytics_id]" value="<?php echo isset( $fields['google_analytics_id'] ) ? esc_html( $fields['google_analytics_id'] ) : ''; ?>"><p class="insight-metrics-notice"><?php esc_html_e( 'If you have an existing Universal Analytics property, the tracking ID format is likely to be "UA-XXXXXXXXX-X." If you have a GA4 property, the tracking ID format is likely to be "G-XXXXXXXXXX."', 'insight-metrics' ); ?></p></td>
					</tr>
					<?php $position = isset( $fields['position'] ) ? esc_html( $fields['position'] ) : ''; ?>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Position', 'insight-metrics' ); ?><span class="dashicons dashicons-editor-help" data-description="<?php esc_html_e( 'This setting allows you to choose where to place the Google Analytics tracking code in your WordPress website', 'insight-metrics' ); ?>"></span></th>
						<td>
							<p><input type="radio" class="position" id="header" name="insight_metrics_fields[position]" value="header" <?php echo ( $position == 'header' || empty($position) )? 'checked="checked"' : ''; ?> ><label for="header"><?php esc_html_e( 'Header', 'insight-metrics' ); ?></label></p>
							<p><input type="radio" class="position" id="footer" name="insight_metrics_fields[position]" value="footer" <?php echo ( $position == 'footer')? 'checked="checked"' : ''; ?> ><label for="footer"><?php esc_html_e( 'Footer', 'insight-metrics' ); ?></label></p>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Priority', 'insight-metrics' ); ?><span class="dashicons dashicons-editor-help" data-description="This number determines the placement order of GA code in header or footer. 1 being highest"></span></th>
						<td><input type="number" name="insight_metrics_fields[priority]" value="<?php echo isset( $fields['priority'] ) ? esc_html( $fields['priority'] ) : '1'; ?>" max="10" min="1"></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php esc_html_e( 'Include logged-in users', 'insight-metrics' ); ?><span class="dashicons dashicons-editor-help" data-description="<?php esc_html_e( 'Enable to include Google Analytics code to logged-in users also', 'insight-metrics' ); ?>"></span></th>
						<td><input type="checkbox" name="insight_metrics_fields[also_logged_in]" value="1" <?php checked( 1, isset($fields['also_logged_in']) ) ?>/></td>
					</tr>
				</table>
				<p class="submit">
					<input type="submit" class="button-primary" value="<?php echo !empty($fields) ? esc_html__( 'Update', 'insight-metrics' ) : esc_html__( 'Save', 'insight-metrics' ); ?>" />
				</p>
			</form>
		</div>
		<div class="google-analytics-sidebar">
			<div class="google-analytics-articles author">
				<div class="header">
					<h2><?php esc_html_e( 'Justwebtime', 'insight-metrics' ); ?></h2>
					<span><?php esc_html_e( 'Author', 'insight-metrics' ); ?></span>
				</div>
				<div class="main">
					<ul>
						<li><a target="_blank" rel="noopener noreferrer" href="https://justwebtime.com/"><?php esc_html_e( 'Website', 'insight-metrics' ); ?></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://justwebtime.com/blog/"><?php esc_html_e( 'Blog', 'insight-metrics' ); ?></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://justwebtime.com/tools/"><?php esc_html_e( 'Tools and Converter', 'insight-metrics' ); ?></a></li>
					</ul>
				</div>
			</div>
			<div class="google-analytics-articles">
				<div class="header">
					<h2><?php esc_html_e( 'Google Privacy & Terms', 'insight-metrics' ); ?></h2>
				</div>
				<div class="main">
					<ul>
						<li><a target="_blank" rel="noopener noreferrer" href="https://www.google.com/intl/en/policies/privacy/"><?php esc_html_e( 'Privacy', 'insight-metrics' ); ?></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://www.google.com/intl/en/policies/terms/"><?php esc_html_e( 'Terms', 'insight-metrics' ); ?></a></li>
					</ul>
				</div>
			</div>
			<div class="google-analytics-articles">
				<div class="header">
					<h2><?php esc_html_e( 'Google Analytics Useful Articles', 'insight-metrics' ); ?></h2>
				</div>
				<div class="main">
					<ul>
						<li><a target="_blank" rel="noopener noreferrer" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/"><?php esc_html_e( 'Universal Analytics - analytics.js', 'insight-metrics' ); ?></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://developers.google.com/analytics/devguides/collection/gtagjs/"><?php esc_html_e( 'Global Site Tag - gtag.js', 'insight-metrics' ); ?></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://developers.google.com/analytics/devguides/collection/gajs/"><?php esc_html_e( 'Google Analytics Legacy - ga.js', 'insight-metrics' ); ?></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/creating-trackers#working_with_multiple_trackers"><?php esc_html_e( 'Google Analytics multiple trackers', 'insight-metrics' ); ?></a></li>
						<li><a target="_blank" rel="noopener noreferrer" href="https://developers.google.com/analytics/devguides/collection/analyticsjs/user-opt-out"><?php esc_html_e( 'Google Analytics user opt-out', 'insight-metrics' ); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="clear"></div>
</div>
<div class="clear"></div>