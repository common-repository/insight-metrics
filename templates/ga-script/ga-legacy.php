<?php
namespace INSIGHT_METRICS;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}

$google_analytics_id = $this->google_analytics_id;
?><!-- Start Google Analytics Legacy -->
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', '<?php echo esc_html( $google_analytics_id ); ?>']);
	_gaq.push(['_trackPageview']);
	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
<!-- End Google Analytics Legacy -->
