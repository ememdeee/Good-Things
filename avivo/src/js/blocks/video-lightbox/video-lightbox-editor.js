// @prepros-prepend "video-lightbox-common.js";

wp.domReady(() => {
	if (typeof wp.data !== 'undefined') {
		let videoLightboxDebounceTimer;
		const DEBOUNCE_DELAY = 300;

		wp.data.subscribe(() => {
			clearTimeout(videoLightboxDebounceTimer);
			videoLightboxDebounceTimer = setTimeout(() => {
				initializeVideoLightbox();
			}, DEBOUNCE_DELAY);
		});
	}
});
