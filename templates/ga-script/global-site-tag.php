<?php
namespace INSIGHT_METRICS;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

$google_analytics_id = $this->google_analytics_id;
?><!-- Start Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_html( $google_analytics_id ); ?>"></script>
<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', '<?php echo esc_html( $google_analytics_id ); ?>');
</script>
<!-- End Global site tag (gtag.js) - Google Analytics -->
