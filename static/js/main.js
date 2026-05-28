

function urlSwitch(elementId, urlTest) {
	const bannerLink = document.getElementById(elementId);
	if (!bannerLink) return;

	function getParentContext() {
		const referrer = document.referrer;
		if (referrer) {
			return { url: referrer, method: "Referrer" };
		}

		const params = new URLSearchParams(window.location.search);
		const parentUrlParam = params.get("parentUrl");
		if (parentUrlParam) {
			return { url: parentUrlParam, method: "URL Parameter" };
		}
		return {
			url: window.location.href,
			method: "Fallback, Current URL (window.location.href)",
		};
	}

	function getEnv(parentUrl) {
		try {
			const host = new URL(parentUrl).hostname.toLowerCase();
			if (host === "experience-test.elluciancloud.com") return "Test";
			if (host === "experience.elluciancloud.com") return "Prod";
			return "Unknown";
		} catch {
			return "Unknown";
		}
	}

	const { url: finalParentUrl } = getParentContext();
	const env = getEnv(finalParentUrl);

	// Only override the link if Test environment
	if (env === "Test") {
		bannerLink.href = urlTest;
	}
}
