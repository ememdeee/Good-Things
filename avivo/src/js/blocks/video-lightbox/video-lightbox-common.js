function initializeVideoLightbox() {
	window.cdApp = window.cdApp || {};

	// this function only run once
	if (typeof window.cdApp.cdbVideoLightboxInitialized !== 'undefined') {
		return;
	}
	window.cdApp.cdbVideoLightboxInitialized = true;

	// Example: Add click event to open video in lightbox
	document.querySelectorAll('.video-lightbox__trigger').forEach(function(trigger) {
		trigger.addEventListener('click', function(e) {
			e.preventDefault();
			const videoUrl = trigger.getAttribute('href');
			// Implement your lightbox logic here
			alert('Open video: ' + videoUrl);
		});
	});


    const lightboxVideoLinks = document.querySelectorAll('.glightbox-video');
    let lightboxVideo;
    if (lightboxVideoLinks.length > 0) {
        if (cdApp.isIE() || cdApp.isiOS() || cdApp.isSafari()) {
            // console.log('DEBUG: polyfilled version.');
            // polyfilled player
            lightboxVideo = GLightbox({
                // in iphone, youtube play button cannot be clicked. need to click pause first. this is the tweak. autoplay in ios is blocked anyway
                touchNavigation: !cdApp.isiOS(),
                autoplayVideos: !cdApp.isiOS(),        
                selector: '.glightbox-video',
                plyr: {
                    css: 'https://cdn.plyr.io/3.5.6/plyr.css',
                    js: 'https://cdn.plyr.io/3.5.6/plyr.polyfilled.js',
                }
            });         
        } else {
            // console.log('DEBUG: non polyfilled version');
            lightboxVideo = GLightbox({
                selector: '.glightbox-video',
            });         
        }
    
    }


}
