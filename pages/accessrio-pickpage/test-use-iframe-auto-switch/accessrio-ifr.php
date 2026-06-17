<?php
// AccessRío Portal - Dynamic iframe loader

// Prevent caching for this page at browser/proxy/CDN layers.
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

// Set timezone to Los Angeles (Pacific Time)
date_default_timezone_set('America/Los_Angeles');

// $url1 = "https://manuhal.github.io/exp-dev/pages/accessrio.html";
// $url2 = "https://manuhal.github.io/exp-dev/pages/accessrio-june1.html";

$url1 = "https://page.riohondo.edu/ar/accessrio-preview.html";
$url2 = "https://page.riohondo.edu/ar/accessrio-new.html";

// Uses server time. After this timestamp, the iframe loads url2.
// $switchAt = new DateTime("2026-05-21 13:20:00"); // TEST
$switchAt = new DateTime("2026-06-01 00:00:00"); // REAL: June 1st, 2026 at midnight PST
$now = new DateTime();

// Determine which URL to use based on server time
$selectedUrl = ($now < $switchAt) ? $url1 : $url2;

// Convert to milliseconds for JavaScript countdown
$switchTimeMs = $switchAt->getTimestamp() * 1000;
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>AccessRío Portal</title>
	<style>
		html,
		body {
			margin: 0;
			padding: 0;
			width: 100%;
			height: 100%;
			overflow: hidden;
			background: #ffffff;
		}

		#content-frame {
			border: 0;
			width: 100%;
			height: 100%;
			display: block;
		}
	</style>
</head>
<body>
	<iframe id="content-frame" title="AccessRío Portal" src="<?php echo htmlspecialchars($selectedUrl, ENT_QUOTES, 'UTF-8'); ?>"></iframe>

	<script>
		const switchTimeMs = <?php echo $switchTimeMs; ?>;
		const eUrl1 = <?php echo json_encode(base64_encode($url1)); ?>;
		const eUrl2 = <?php echo json_encode(base64_encode($url2)); ?>;
		const contentFrame = document.getElementById('content-frame');

		function applyFrameSource() {
			const targetUrl = Date.now() < switchTimeMs ? atob(eUrl1) : atob(eUrl2);
			if (contentFrame && contentFrame.src !== targetUrl) {
				contentFrame.src = targetUrl;
			}
		}

		applyFrameSource();

		const checkIntervalMs = 60 * 1000;
		const intervalId = setInterval(() => {
			applyFrameSource();
			if (Date.now() >= switchTimeMs) {
				clearInterval(intervalId);
			}
		}, checkIntervalMs);
	</script>
</body>
</html>
