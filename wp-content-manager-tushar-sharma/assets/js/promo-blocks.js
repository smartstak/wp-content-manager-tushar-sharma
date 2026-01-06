document.addEventListener('DOMContentLoaded', () => {
	const container = document.querySelector('.wpcm-promo-wrapper[data-ajax="1"]');
	if (!container || typeof wpcm_promo === 'undefined') {
		return;
	}

	fetch(wpcm_promo.rest_url, {
		method: 'GET',
		headers: {
			'X-WP-Nonce': wpcm_promo.nonce
		}
	})
	.then(res => res.json())
	.then(data => {
		if (data.html) {
			container.innerHTML = data.html;
		} else {
			container.innerHTML = '<p>No promo blocks available.</p>';
		}
	})
	.catch(() => {
		container.innerHTML = '<p>Failed to load promo blocks.</p>';
	});
});
