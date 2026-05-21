<?php
// AccessRío Portal - Dynamic iframe loader

// Prevent caching for this page at browser/proxy/CDN layers.
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');
header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');

// Set timezone to Los Angeles (Pacific Time)
date_default_timezone_set('America/Los_Angeles');

$url1 = "https://manuhal.github.io/exp-dev/pages/accessrio.html";
$url2 = "https://manuhal.github.io/exp-dev/pages/accessrio-june1.html";

// Uses server time. After this timestamp, the iframe loads url2.
// $switchAt = new DateTime("2026-05-20 16:00:00"); // TEST: May 20th, 2026 at 4pm PST
$switchAt = new DateTime("2026-06-01 00:00:00"); // REAL: June 1st, 2026 at midnight PST
$now = new DateTime();

// Determine which URL to use based on server time
$selectedUrl = ($now < $switchAt) ? $url1 : $url2;

// Convert to milliseconds for JavaScript checks
$switchTimeMs = $switchAt->getTimestamp() * 1000;

// Track current state at render time
$isBeforeSwitch = $now < $switchAt;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="Expires" content="0" />
	<title>AccessRío</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://rio-hondo-college-public.github.io/static/css/rhc-main.css">

	<style>
		body {
			margin: 0;
			padding: 0;
		}

		.hero {
			min-height: 100vh;
			background: url('https://page.riohondo.edu/wp-content/uploads/2026/05/upcoming-accessrio.webp') center center / cover no-repeat;
			position: relative;
			display: flex;
			align-items: center;
			justify-content: center;
			color: #ffffff;
			text-decoration: none;
			cursor: pointer;
			transition: all 0.4s ease;
			overflow: hidden;
		}

		/* overlay */
		.hero::before {
			content: "";
			position: absolute;
			inset: 0;
			background-color: rgba(var(--rio-med-blue-rgb), 0.9);
			z-index: 1;
			transition: background-color 0.4s ease;
		}

		.hero:hover::before {
			background-color: rgba(var(--rio-med-blue-rgb), 0.8);
		}

		.hero:hover .container {
			transform: scale(1.05);
		}

		.hero p {
			max-width: 720px;
			margin: 1.5rem auto;
			transition: color 0.3s ease;
			font-size: 1.2rem;
		}

		.container {
			width: 100%;
			display: flex;
			flex-direction: column;
			align-items: center;
			padding: 1rem;
			margin: 1rem;
			position: relative;
			z-index: 99;
			transition: transform 0.35s ease;
			transform-origin: center center;
		}

		.container img {
			max-width: 300px;
			height: auto;
		}

		@media (max-width: 360px) {
			.container {
				padding: 0.7rem;
				margin: 0rem;
			}

			.container img {
				max-width: 100%;
			}
		}
	</style>
</head>

<body>
	<main>
		<a id="portal-link" href="<?php echo htmlspecialchars($selectedUrl, ENT_QUOTES, 'UTF-8'); ?>"
			target="_blank" rel="noopener noreferrer" class="hero text-center" title="Preview the new AccessRío Portal">
			<div class="container">
				<img src="https://www.riohondo.edu/wp-content/uploads/2023/08/AccessRIO.png" alt="AccessRío Logo"
					style="margin-bottom: 0.5rem;">
				<p id="main-text" class="py-0 my-0"><?php echo $isBeforeSwitch ? 'Preview the new AccessRío (Test) Portal' : 'Visit the new AccessRío Portal'; ?></p>
				<?php if ($isBeforeSwitch): ?>
				<p id="sub-text" style="font-size: 0.9rem;"><span style="font-weight: bold;">Note: </span>The new
					AccessRío Portal will go live on Monday,&nbsp;June&nbsp;1,&nbsp;2026.</p>
				<?php endif; ?>

			</div>
		</a>
	</main>
	<script>
		// Periodically check switch time to avoid long setTimeout limits (~24.8 days max delay).
		const switchTimeMs = <?php echo $switchTimeMs; ?>;
		const urlAfterSwitch = <?php echo json_encode($url2); ?>;
		const nowMs = Date.now();
		const mainText = document.getElementById('main-text');
		const subText = document.getElementById('sub-text');
		const portalLink = document.getElementById('portal-link');

		function applySwitchedState() {
			if (subText) {
				subText.remove();
			}
			if (mainText) {
				mainText.textContent = 'Visit the new AccessRío Portal';
			}
			if (portalLink) {
				portalLink.href = urlAfterSwitch;
			}
		}

		if (nowMs >= switchTimeMs) {
			applySwitchedState();
		} else {
			const checkIntervalMs = 60 * 1000;
			const intervalId = setInterval(() => {
				if (Date.now() >= switchTimeMs) {
					applySwitchedState();
					clearInterval(intervalId);
				}
			}, checkIntervalMs);
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>