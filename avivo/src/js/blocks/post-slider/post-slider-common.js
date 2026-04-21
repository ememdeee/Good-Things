function initializePostSlider() {
  // console.log('DEBUG: hello im post slider');

	// Initialize Splide slider for elements that haven't been initialized
	document.querySelectorAll('.cdb-post_slider').forEach(function ($section) {
		
    var sliderStyle = $section.getAttribute('data-slider-style');

    var $slider = $section.querySelector('.splide');
    
		// Check if Splide is already initialized and destroy it
		if ($slider.splide) {
			$slider.splide.destroy();
		}

		// Check for autoplay data attribute
		const autoplay = $slider.getAttribute('data-autoplay') === '1';

    var sliderOptions = {
      type: 'slide',
      speed: 400,
      autoplay: autoplay,
      perPage: 4,
      perMove: 1,
      gap: 40,
      arrows: false,
      pagination: true,
			breakpoints: {
				768: {
          gap: 20,
					perPage: 1,
          padding: {
            right: '15%',
            left: '0%',
          },  
				},
				1200: {
					perPage: 2,
				},
			}
    };

    if (sliderStyle === 'peeking') {
      Object.assign(sliderOptions, {
        perPage: 2,
        speed: 600,
        // gap: 60,
        arrows: true,
        pagination: false,
        padding: {
          right: '20%',
          left: '0%',
        },
      });
    }

		// Initialize Splide with the autoplay option
		const splideInstance = new Splide($slider, sliderOptions);

		// Mount splide slider
		splideInstance.mount();
		//console.log('slider initialized, autoplay: '+autoplay);

		$slider.splide = splideInstance;
	});

}