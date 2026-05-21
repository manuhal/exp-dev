<?php
// AccessRío Portal - Dynamic iframe loader

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

// Convert to milliseconds for JavaScript countdown
$switchTimeMs = $switchAt->getTimestamp() * 1000;
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
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
		<a href="https://experience-test.elluciancloud.com/rhctest?utm_source=luminis_portal&utm_medium=portal&utm_campaign=new_accessrio_promo"
			target="_blank" rel="noopener noreferrer" class="hero text-center" title="Preview the new AccessRío Portal">
			<div class="container">
				<img src="https://www.riohondo.edu/wp-content/uploads/2023/08/AccessRIO.png" alt="AccessRío Logo"
					style="margin-bottom: 0.5rem;">
				<p id="main-text" class="py-0 my-0">Preview the new AccessRío (Test) Portal</p>
				<p id="sub-text" style="font-size: 0.9rem;"><span style="font-weight: bold;">Note: </span>The new
					AccessRío Portal will go live on Monday,&nbsp;June&nbsp;1,&nbsp;2026.</p>

			</div>
		</a>
	</main>
	<script>
		// Auto-reload page at switch time (uses server time, not browser time)
		const switchTimeMs = <?php echo $switchTimeMs; ?>;
		const nowMs = Date.now();
		const msUntilSwitch = switchTimeMs - nowMs;
		const mainText = document.getElementById('main-text');
		const subText = document.getElementById('sub-text');

		if (msUntilSwitch > 0) {
			// Page will auto-reload at the switch time
			setTimeout(() => {
				// remove subText
				if (subText) {
					subText.remove();
				}
				// update mainText to reflect the new AccessRío Portal is live
				if (mainText) {
					mainText.textContent = "Visit the new AccessRío Portal";
				}
			}, msUntilSwitch);
		}
	</script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>