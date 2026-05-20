<?php
// AccessRío Portal - Dynamic iframe loader using server-side timing
// Uses server time to determine which content to display

// Set timezone to Los Angeles (Pacific Time)
date_default_timezone_set('America/Los_Angeles');

$url1 = "https://manuhal.github.io/exp-dev/pages/accessrio.html";
$url2 = "https://manuhal.github.io/exp-dev/pages/accessrio-june1.html";

// Uses server time. After this timestamp, the iframe loads url2.
$switchAt = new DateTime("2026-05-20 12:00:00"); // TEST: May 20th, 2026 at 12pm PST
// $switchAt = new DateTime("2026-06-01 00:00:00"); // REAL: June 1st, 2026 at midnight PST
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
	<iframe id="content-frame" title="AccessRío Portal" src="<?php echo htmlspecialchars($selectedUrl); ?>"></iframe>

	<script>
		// Auto-reload page at switch time (uses server time, not browser time)
		const switchTimeMs = <?php echo $switchTimeMs; ?>;
		const nowMs = Date.now();
		const msUntilSwitch = switchTimeMs - nowMs;

		if (msUntilSwitch > 0) {
			// Page will auto-reload at the switch time
			setTimeout(() => {
				location.reload();
			}, msUntilSwitch);
		}
	</script>
</body>
</html>
