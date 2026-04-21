/**
 * This file contains shared functions and utilities used across different parts of the website or application.
 * The goal is to centralize common functionalities, making them easier to maintain and reuse.
 *
 * The `initializeFeaturedSlider()` function is specifically designed to initialize Splide sliders. It ensures that only
 * sliders that haven't been initialized yet are set up, preventing duplicate initialization. Splide itself adds 
 * the 'is-initialized' class to each slider element that has been successfully initialized, so this function 
 * checks for that class before initializing.
 *
 * Usage:
 * - Call the `initializeFeaturedSlider()` function to initialize all Splide sliders that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, ensuring 
 *   consistent behavior across different environments.
 */

class Slider {
	constructor(objSlider, options = {}) {
		this.slider = objSlider;
		this.slides = Array.from(this.slider.querySelectorAll('.cdfslide__slide'));
		this.paginationDots = [];
		this.currentIndex = 0;
		this.autoplayInterval = null;

		// Default options with overrides
		this.options = Object.assign({
			autoplay: true,
			interval: 3000,
			showPagination: true,
			arrowsContainer: null,
			paginationContainer: null,
			loop: true,
		}, options);

		// Declare global references for arrows and pagination containers
		this.arrowsContainer = null;
		this.paginationContainer = null;
		this.isTransitioning = false; // Initialize the flag

		this.setup();
		if (this.options.autoplay) this.startAutoplay();
	}

	setup() {
		this.slides.forEach((slide, index) => {
			slide.classList.toggle('active', index === 0);
			slide.classList.toggle('next', index === 1);
		});

		// Assign arrowsContainer
		this.arrowsContainer = this.slider.querySelector(this.options.arrowsContainer || '.cdfslide__arrows_container');
		if (this.arrowsContainer) {
			this.setupArrows(this.arrowsContainer);
		} else {
			this.createDefaultArrows();
		}

		// Assign paginationContainer
		this.paginationContainer = this.slider.querySelector(this.options.paginationContainer || '.cdfslide__pagination');
		if (this.options.showPagination) {
			if (this.paginationContainer) {
				this.setupPagination(this.paginationContainer);
			} else {
				this.createDefaultPagination();
			}
		}

		// go to first slide
		this.goToSlide(0);
	}

	destroy() {
		// Stop autoplay
		this.resetAutoplay();
	
		// Remove classes from all slides
		this.slides.forEach(slide => {
			slide.classList.remove('active', 'next', 'prev');
		});
	
		// Remove active classes from pagination dots
		this.paginationDots.forEach(dot => dot.classList.remove('active'));
	
		// Remove arrows if they were created by default
		if (this.arrowsContainer && this.arrowsContainer.parentElement) {
			this.arrowsContainer.parentElement.removeChild(this.arrowsContainer);
		}
	
		// Remove pagination if created by default
		if (this.paginationContainer && this.paginationContainer.parentElement) {
			this.paginationContainer.parentElement.removeChild(this.paginationContainer);
		}
	
		// Remove any added classes on the slider element
		this.slider.classList.remove('is-initialized');
	
		// Clear all references
		this.slides = [];
		this.paginationDots = [];
		this.currentIndex = 0;
		this.autoplayInterval = null;
		this.arrowsContainer = null;
		this.paginationContainer = null;
	}	

	createDefaultArrows() {
		const arrowsContainer = document.createElement('div');
		arrowsContainer.className = 'cdfslide__arrows';

		const arrowContainer = document.createElement('div');
		arrowContainer.className = 'cdfslide__arrows_container';

		const prevButton = document.createElement('button');
		prevButton.className = 'cdfslide__arrow slide__arrow--prev';
		prevButton.textContent = 'Previous';

		const nextButton = document.createElement('button');
		nextButton.className = 'cdfslide__arrow slide__arrow--next';
		nextButton.textContent = 'Next';

		arrowContainer.appendChild(prevButton);
		arrowContainer.appendChild(nextButton);
		arrowsContainer.appendChild(arrowContainer);
		this.slider.appendChild(arrowsContainer); // Append to the slider container

		// Setup button event listeners
		prevButton.addEventListener('click', () => {
			this.goToPrevSlide();
			this.resetAutoplay();
		});

		nextButton.addEventListener('click', () => {
			this.goToNextSlide();
			this.resetAutoplay();
		});
	}

	setupArrows(arrowsContainer) {
		const prevButton = arrowsContainer.querySelector('.slide__arrow--prev');
		const nextButton = arrowsContainer.querySelector('.slide__arrow--next');

		prevButton.addEventListener('click', () => {
			this.goToPrevSlide();
			this.resetAutoplay();
		});

		nextButton.addEventListener('click', () => {
			this.goToNextSlide();
			this.resetAutoplay();
		});
	}

	createDefaultPagination() {
		const pagination = document.createElement('ul');
		pagination.className = 'cdfslide__pagination';
	
		// Adjust the loop to go up to slides.length to exclude the cloned slide
		for (let index = 0; index < this.slides.length; index++) {
			const dot = document.createElement('li');
			dot.className = 'pagination-dot';
			if (index === 0) dot.classList.add('active');
			dot.dataset.index = index;
			
			dot.addEventListener('click', () => {
				this.goToSlide(index);
				this.resetAutoplay();
			});
			
			pagination.appendChild(dot);
			this.paginationDots.push(dot);
		}
	
		this.slider.appendChild(pagination);
	}
	
	setupPagination(paginationContainer) {
		this.paginationDots = paginationContainer.querySelectorAll('.pagination-dot');

		this.paginationDots.forEach((dot, index) => {
			if (index === 0) dot.classList.add('active');
			dot.addEventListener('click', () => {
				this.goToSlide(index);
				this.resetAutoplay();
			});
		});
	}
	
	updateArrowTitle(selector, newText) {
		const arrowElement = this.arrowsContainer.querySelector(selector);
		const titleElement = this.arrowsContainer.querySelector(selector+' .arrow-title');

		// Step 1: Add 'animate-out' class to fade out the text
		arrowElement.classList.add('hover-in');
		titleElement.classList.add('animate-out');

		// Step 2: Wait for the animation to complete before updating the text
		titleElement.addEventListener('transitionend', function handleTransition() {
			// Remove the event listener to avoid multiple triggers
			titleElement.removeEventListener('transitionend', handleTransition);

			// Update text
			titleElement.textContent = newText;

			// Remove 'animate-out' and add 'animate-in' to fade back in
			titleElement.classList.remove('animate-out');
			titleElement.classList.add('animate-in');

			// Remove 'animate-in' and 'hover-in' after animation completes
			setTimeout(() => {
				titleElement.classList.remove('animate-in');
				arrowElement.classList.remove('hover-in');
			}, 300);
			
		});
	}

	goToSlide(index) {
	//	const isForward = (this.currentIndex < index);
	//	console.log(isForward);

		// Exit if a transition is already in progress
		if (this.isTransitioning) return;
		this.isTransitioning = true; // Set the flag

		// Handle looping
		if (this.options.loop) {
			this.currentIndex = (index + this.slides.length) % this.slides.length;
		} else {
			this.currentIndex = Math.max(0, Math.min(index, this.slides.length - 1));
		}
		
		this.paginationDots.forEach(dot => dot.classList.remove('active'));

	    // Calculate the next index and set 'next' class
		const nextIndex = (this.currentIndex + 1) % this.slides.length; // Get the next slide index
		const nextSlideTitle = this.slides[nextIndex].getAttribute('data-title');
		this.slides[nextIndex].classList.remove('active', 'prev');
		this.slides[nextIndex].classList.add('next');
	
	    // Calculate the prev index and set 'next' class
		const prevIndex = (this.currentIndex - 1 + this.slides.length) % this.slides.length; // Get the previous slide index
		const prevSlideTitle = this.slides[prevIndex].getAttribute('data-title');
		this.slides[prevIndex].classList.remove('active', 'next');
		this.slides[prevIndex].classList.add('prev');
	
		// Set the new active slide
		this.slides[this.currentIndex].classList.remove('prev', 'next');
		this.slides[this.currentIndex].classList.add('active');

		// Remove classes
		this.slides.forEach((slide, index) => {
            if ((index !== prevIndex) && (index !== nextIndex) && (index !== this.currentIndex)) {
				slide.classList.remove('active', 'prev', 'next');
			}
        });

		// Change the arrow title
		this.updateArrowTitle('.slide__arrow--prev', prevSlideTitle);
		this.updateArrowTitle('.slide__arrow--next', nextSlideTitle);
		
		// Set active dot
		this.paginationDots[this.currentIndex]?.classList.add('active');

		// Reset the transitioning flag after animations complete
		setTimeout(() => {
			this.isTransitioning = false; // Reset the flag
		}, 1500); // Adjust timeout duration to match animation time
	}

	goToNextSlide() {
		this.goToSlide(this.currentIndex + 1);
	}

	goToPrevSlide() {
		this.goToSlide(this.currentIndex - 1);
	}

	startAutoplay() {
		this.autoplayInterval = setInterval(() => {
			this.goToNextSlide();
		}, this.options.interval);
	}

	resetAutoplay() {
		clearInterval(this.autoplayInterval);
		if (this.options.autoplay) this.startAutoplay();
	}
}

// Initialization function
function initializeFeaturedSlider() {
	document.querySelectorAll('.cdb-featured_slider .cdfslide:not(.is-initialized)').forEach(obj => {

		// Check if slider is already initialized and destroy it
		if (obj.cdfslide) {
			obj.cdfslide.destroy();
		//	console.log('destroy');
		}

		// Check for autoplay data attribute
		const autoplay = obj.getAttribute('data-autoplay') === '1';

		const cdfSlider = new Slider(obj, {
			autoplay: autoplay,
			interval: 8000,
			showPagination: true,
			loop: true,
		});
		obj.cdfslide = cdfSlider;
		
		obj.classList.add('is-initialized');
	});
}
