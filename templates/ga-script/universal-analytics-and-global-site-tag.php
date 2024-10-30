<?php
namespace INSIGHT_METRICS;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

$google_analytics_id = $this->google_analytics_id;

if( $google_analytics_id ){
	$template = 'ga-script/universal-analytics';

	$template_output = Template::view( $template, array(
		'google_analytics_id' => esc_html( $google_analytics_id ),
	));

	$allowed_html_tags = Template::allowed_html_tags( $template );
	$safe_template_output = wp_kses( $template_output, $allowed_html_tags );
	echo $safe_template_output;
}

$template = 'ga-script/global-site-tag';

$template_output = Template::view( $template, array(
	'google_analytics_id' => esc_html( $google_analytics_id ),
));

$allowed_html_tags = Template::allowed_html_tags( $template );
$safe_template_output = wp_kses( $template_output, $allowed_html_tags );
echo $safe_template_output;
?>