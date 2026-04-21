/**
 * This file contains shared functions and utilities used throughout the website or application.
 * The aim is to centralize commonly used functionality, making it easier to maintain and reuse across different parts.
 *
 * The `initializePostGrid()` function is specifically designed to initialize Post Grid functionality. It ensures
 * that only FAQ elements that haven't been initialized yet are set up, preventing duplicate initialization. 
 * Typically, a class like 'is-initialized' is added to each FAQ element once it's been successfully initialized, 
 * so this function checks for that class before proceeding.
 *
 * Usage:
 * - Call the `initializePostGrid()` function to initialize all Post Grid elements that haven't been initialized yet.
 * - This function is versatile and can be used both in the front-end and within the block editor, providing 
 *   consistent behavior across different environments.
 */
 
// Function to initialize the toggle
function initializePostGrid() {
    // Select all FAQ question buttons within the featured FAQ block
	document.querySelectorAll('.cdb-post_grid:not(.is-initialized)').forEach(block => {
		block.addEventListener('click', () => {
		});
	
		// Add the 'is-initialized' class to prevent multiple listeners
		block.classList.add('is-initialized');
		//console.log('toggle initialized');


		

		var ajaxUrl = block.getAttribute('data-ajax-url');
		var postPerPage = block.getAttribute('data-post-per-page');
		var useAjax = block.getAttribute('data-use-ajax');
		useAjax = useAjax === 'true';

		// console.log('DEBUG: ajaxUrl',ajaxUrl, 'postPerPage', postPerPage, useAjax);

		if (!useAjax) {
			return false;
		}
		
    let page = 0;
    let loading = false;

		let $loadMore = block.querySelector('.post-grid__load-more');
		let $loader = block.querySelector('.post-grid__loader');
		let $posts = block.querySelector('.post-grid__posts'); // wrapper for posts

		let activeCategory = '';


		function loadPosts(reset) {
			if (loading) return;
			loading = true;
			page++;
			$loader.style.display = 'block';
			$loadMore.disabled = true;

			fetch(ajaxUrl, {
					method: 'POST',
					headers: {
							'Content-Type': 'application/x-www-form-urlencoded',
					},
					body: new URLSearchParams({
							action: 'load_more',
							page: page,
							category: activeCategory
					})
			})
			.then(response => response.text())
			.then(data => {
				$loader.style.display = 'none';
				$loadMore.disabled = false;

					if (data) {
							// quick and dirty way to check if there are more posts to load. its not accurate, but it works for now
							// if count is less than postPerPage, then we have reached the end of posts
							let count = (new DOMParser().parseFromString(data, 'text/html')).querySelectorAll('.post-card').length;
							if (count < postPerPage) {
								$loadMore.style.display = 'none';
							} else {
								$loadMore.style.display = 'inline-flex';
							}

							if (reset) {
								$posts.innerHTML = data;
							} else {
								$posts.insertAdjacentHTML('beforeend', data);
							}

							loading = false;
					} else {
							$loadMore.style.display = 'none';
					}
			});
		}

    $loadMore.addEventListener('click', function(ev) {
			loadPosts(false);
			ev.preventDefault();
    });

		// // category filter
		// let $categories = block.querySelector('.post-grid__categories');
		// let $categoryLinks = $categories.querySelectorAll('a');

		// $categoryLinks.forEach(function($link) {
		// 		$link.addEventListener('click', function(ev) {
		// 				ev.preventDefault();
		// 				let category = $link.getAttribute('data-category');
		// 				// console.log('Category clicked:', category);
		// 				// Add your AJAX call or other logic here to filter posts by category
		// 				// ev.stopPropagation();

		// 				$categoryLinks.forEach(function($link) {
		// 						$link.classList.remove('active');
		// 				});

		// 				$link.classList.add('active');

		// 				activeCategory = category;
		// 				page = -1;
		// 				$posts.innerHTML = '';
		// 				loadPosts(true);
		// 		});
		// });
		


	});
	




	
}

