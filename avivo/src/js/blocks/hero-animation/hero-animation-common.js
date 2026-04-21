/**
 * This file contains shared functions and utilities used across different parts of the website or application.
 * The goal is to centralize common functionalities, making them easier to maintain and reuse.
 *
 */
 
function initializeHeroAnimation() {
	window.cdApp = window.cdApp || {};

	// this function only run once
	if (typeof window.cdApp.cdbHeroAnimationInitialized !== 'undefined') {
		return;
	}
	window.cdApp.cdbHeroAnimationInitialized = true;

        // Global counter for unique IDs
        let animationInstanceCounter = 0;

        // Function to generate a unique ID
        function generateUniqueId(prefix) {
            return `${prefix}-${animationInstanceCounter++}-${Math.random().toString(36).substr(2, 9)}`;
        }

        // --- Main animation setup function ---
        function setupPathAnimation(animationContainer) {
            const svgElement = animationContainer.querySelector('.animated-svg');
            // Select by class, as ID will be dynamic
            const basePathTemplate = svgElement.querySelector('.base-path-template');

            // Retrieve configuration from data attributes
            const imageSrc = animationContainer.dataset.imageSrc;
            const strokeColor = animationContainer.dataset.strokeColor;
            const strokeWidth = parseFloat(animationContainer.dataset.strokeWidth || '158');
            const animationDuration = parseFloat(animationContainer.dataset.animationDuration || '2000');
            const fadeDuration = parseFloat(animationContainer.dataset.fadeDuration || '1000');
            const fadeOffset = parseFloat(animationContainer.dataset.fadeOffset || '-500');
            const aspectRatioString = animationContainer.dataset.aspectRatio || '1000/600';
            const paddingFactor = parseFloat(animationContainer.dataset.paddingFactor || '1.2');

            let [baseAspectWidth, baseAspectHeight] = aspectRatioString.split('/').map(Number);
            if (isNaN(baseAspectWidth) || isNaN(baseAspectHeight) || baseAspectHeight === 0) {
                console.warn("Invalid data-aspect-ratio. Using default 1000/600.");
                baseAspectWidth = 1000;
                baseAspectHeight = 600;
            }

            // console.log(`DEBUG: Aspect Ratio: ${baseAspectWidth}/${baseAspectHeight}`);

            if (!imageSrc || !strokeColor || !basePathTemplate) {
                console.error("Missing required data attributes or base SVG path template element for an animation instance.");
                return;
            }

            // --- Function to create SVG elements ---
            const createSvgElement = (tagName, attributes = {}) => {
                const element = document.createElementNS('http://www.w3.org/2000/svg', tagName);
                for (const key in attributes) {
                    if (key.startsWith('xlink:')) {
                        element.setAttributeNS('http://www.w3.org/1999/xlink', key, attributes[key]);
                    } else {
                        element.setAttribute(key, attributes[key]);
                    }
                }
                return element;
            };

            // --- Calculate Bounding Box and Adjusted ViewBox ---
            const tempPath = basePathTemplate.cloneNode(true);
            svgElement.appendChild(tempPath);
            const bbox = tempPath.getBBox();
            svgElement.removeChild(tempPath);

            const effectivePadding = strokeWidth * paddingFactor;

            const viewBoxX = bbox.x - effectivePadding;
            const viewBoxY = bbox.y - effectivePadding;
            const viewBoxWidth = bbox.width + (effectivePadding * 2);
            const viewBoxHeight = bbox.height + (effectivePadding * 2);

            svgElement.setAttribute('viewBox', `${viewBoxX} ${viewBoxY} ${viewBoxWidth} ${viewBoxHeight}`);

            const newAspectRatio = viewBoxWidth / viewBoxHeight;
            animationContainer.style.paddingBottom = `${(1 / newAspectRatio) * 100}%`;

            // --- Dynamically create remaining SVG elements with unique IDs ---
            const uniqueIdPrefix = generateUniqueId('anim'); // Unique prefix for this instance

            const defs = createSvgElement('defs');
            svgElement.appendChild(defs);

            const photoPatternId = `${uniqueIdPrefix}-photoPattern`;
            const pattern = createSvgElement('pattern', {
                id: photoPatternId,
                patternUnits: 'userSpaceOnUse',
                // x: `${-1 * strokeWidth * paddingFactor}`, y: `${-1 * strokeWidth * paddingFactor}`,
                x: '0', y: '0',
                width: viewBoxWidth + (strokeWidth * paddingFactor * 2),
                height: viewBoxHeight + (strokeWidth * paddingFactor * 2)
            });
            defs.appendChild(pattern);

            const curveImageId = `${uniqueIdPrefix}-curveImage`;
            const curveImage = createSvgElement('image', {
                id: curveImageId,
                'xlink:href': imageSrc,
                x: '0', y: '0',
                width: '100%', height: '100%',
                preserveAspectRatio: 'xMidYMid slice'
            });
            pattern.appendChild(curveImage);

            const imageStrokePathId = `${uniqueIdPrefix}-imageStrokePath`;
            const imageStrokePath = basePathTemplate.cloneNode(true);
            imageStrokePath.id = imageStrokePathId;
            imageStrokePath.setAttribute('stroke', `url(#${photoPatternId})`); // Use unique pattern ID
            imageStrokePath.setAttribute('stroke-width', strokeWidth);
            imageStrokePath.setAttribute('stroke-linecap', 'round');
            imageStrokePath.style.opacity = '0';
            svgElement.appendChild(imageStrokePath);

            const solidStrokePathId = `${uniqueIdPrefix}-solidStrokePath`;
            const solidStrokePath = basePathTemplate.cloneNode(true);
            solidStrokePath.id = solidStrokePathId;
            solidStrokePath.setAttribute('stroke', strokeColor);
            solidStrokePath.setAttribute('stroke-width', strokeWidth);
            solidStrokePath.setAttribute('stroke-linecap', 'round');
            solidStrokePath.style.opacity = '0';
            svgElement.appendChild(solidStrokePath);

            // Hide the base path template (by class selector now)
            basePathTemplate.style.display = 'none';

            // --- Animation Logic ---
            const startAnimations = () => {
                const pathLength = solidStrokePath.getTotalLength();

                if (!pathLength || isNaN(pathLength)) {
                    console.error(`Error: Could not get valid path length for animation instance ${uniqueIdPrefix}.`);
                    return;
                }

                solidStrokePath.style.opacity = '1';
                imageStrokePath.style.opacity = '1';

                solidStrokePath.style.strokeDasharray = pathLength + ' ' + pathLength;
                solidStrokePath.style.strokeDashoffset = pathLength;

                imageStrokePath.style.strokeDasharray = pathLength + ' ' + pathLength;
                imageStrokePath.style.strokeDashoffset = pathLength;

                const timeline = anime.timeline({
                    easing: 'easeInOutSine',
                    duration: animationDuration,
                    autoplay: false,
                    begin: function() {
                        animationContainer.classList.add('animation-container--animate');
                        animationContainer.classList.remove('animation-container--done');
                    },
                    complete: function() {
                        animationContainer.classList.remove('animation-container--animate');
                        animationContainer.classList.add('animation-container--done');
                    }
                });

                timeline.add({
                    targets: [solidStrokePath, imageStrokePath],
                    strokeDashoffset: [pathLength, 0],
                    duration: animationDuration
                })
                .add({
                    targets: solidStrokePath,
                    opacity: 0,
                    duration: fadeDuration,
                    easing: 'easeOutQuad',
                    offset: fadeOffset
                });

                timeline.play();
            };

            // --- Image Loading Check ---
            if (curveImage.complete) {
                startAnimations();
            } else {
                curveImage.addEventListener('load', startAnimations);
                curveImage.addEventListener('error', () => {
                    console.error(`Error: Image failed to load for animation instance ${uniqueIdPrefix}. Falling back to solid color path only.`);
                    solidStrokePath.style.opacity = '1';
                    imageStrokePath.style.opacity = '0';
                    const pathLength = solidStrokePath.getTotalLength();
                    if (pathLength && !isNaN(pathLength)) {
                        solidStrokePath.style.strokeDasharray = pathLength + ' ' + pathLength;
                        solidStrokePath.style.strokeDashoffset = pathLength;
                        anime({
                            targets: solidStrokePath,
                            strokeDashoffset: [pathLength, 0],
                            duration: animationDuration,
                            easing: 'easeInOutSine',
                            loop: false,
                            begin: function() {
                                animationContainer.classList.add('animation-container--animate');
                                animationContainer.classList.remove('animation-container--done');
                            },
                            complete: function() {
                                animationContainer.classList.remove('animation-container--animate');
                                animationContainer.classList.add('animation-container--done');
                            }
                        });
                    }
                });
            }
        } // End of setupPathAnimation function


	document.querySelectorAll('.cdb-hero_animation').forEach(function (obj) {
		if (!obj.classList.contains('is-initialized')) {
			// 'is-initialized' to prevent re-initialization
			obj.classList.add('is-initialized');
			
			const animationContainers = obj.querySelectorAll('.animation-container');
            animationContainers.forEach(container => {
                  setupPathAnimation(container);
            });			
		}
	});
}
