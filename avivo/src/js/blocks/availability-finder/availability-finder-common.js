
function initializeAvailabilityFinder() {
	window.cdApp = window.cdApp || {};

	// this function only run once
	if (typeof window.cdApp.cdbAvailabilityFinderInitialized !== 'undefined') {
		return;
	}
	window.cdApp.cdbAvailabilityFinderInitialized = true;


  
// console.log('DEBUG: initializeAvailabilityFinder');

const locationInput = document.getElementById('availability-finder__location-input');
const searchButton = document.getElementById('availability-finder__search-button');

const result = document.querySelectorAll('.availability-finder__result');
const resultSupported = document.querySelector('.availability-finder__result--supported');
const resultNotSupported = document.querySelector('.availability-finder__result--notsupported');
const resultNotFound = document.querySelector('.availability-finder__result--notfound');

let allSuburbs = [];
let supportedStatus = {};

// Use async/await to fetch data from JSON files
async function loadData() {
    try {
        const [suburbsResponse, statusResponse] = await Promise.all([
            fetch('/wp-content/themes/avivo/js/suburbs.json'),
            fetch('/wp-content/themes/avivo/js/supported-status.json')
        ]);

        if (!suburbsResponse.ok || !statusResponse.ok) {
            throw new Error('Failed to load JSON data.');
        }

        allSuburbs = await suburbsResponse.json();
        supportedStatus = await statusResponse.json();

        // console.log('DEBUG: Data loaded', allSuburbs, supportedStatus);
    } catch (error) {
        console.error('Error loading data:', error);

        let title = resultNotFound.querySelector('.availability-finder__result-title');
        let description = resultNotFound.querySelector('.availability-finder__result-description');
        if (title) {
          title.textContent = `An error occurred while loading data. Please try again later.`;
        }
        description.style.display = 'none';

        resultSupported.style.display = 'none';
        resultNotSupported.style.display = 'none';
        resultNotFound.style.display = 'block';


    }
}

function renderResult(location, isSupported) {
    if (isSupported) {
        let title = resultSupported.querySelector('.availability-finder__result-title');
        if (title) {
            title.textContent = `${location}`;
        }

        resultSupported.style.display = 'block';
        resultNotSupported.style.display = 'none';
        resultNotFound.style.display = 'none';
    } else {
        let title = resultNotSupported.querySelector('.availability-finder__result-title');
        if (title) {
            title.textContent = `${location}`;
        }
        resultSupported.style.display = 'none';
        resultNotSupported.style.display = 'block';
        resultNotFound.style.display = 'none';
    }
}

function renderNotFoundMessage(location) {
    
    let title = resultNotFound.querySelector('.availability-finder__result-title');
    if (title) {
        title.textContent = `${location}`;
    }

    resultSupported.style.display = 'none';
    resultNotSupported.style.display = 'none';
    resultNotFound.style.display = 'block';
}

function handleSearch() {
    const input = locationInput.value.trim().toLowerCase();
    if (!input) {

        // hide all result
        result.forEach(r => r.style.display = 'none');

        return;
    }

    // Check if the input is a postcode (assuming it's a number)
    const isPostcode = !isNaN(input) && input.length >= 4;
    let foundSuburb = null;

    if (isPostcode) {
        const suburbData = allSuburbs.find(item => item['@postcode'] === input);
        if (suburbData) {
            foundSuburb = suburbData['@suburb'];
        }
    } else {
        const suburbData = allSuburbs.find(item => item['@suburb'].toLowerCase() === input);
        if (suburbData) {
            foundSuburb = suburbData['@suburb'];
        }
    }

    if (foundSuburb) {
        const isSupported = supportedStatus[foundSuburb];
        const locationDisplay = foundSuburb;
        renderResult(locationDisplay, isSupported);
    } else {
        renderNotFoundMessage(locationInput.value.trim());
    }
}

// Attach event listeners
searchButton.addEventListener('click', handleSearch);
locationInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        handleSearch();
    }
});

// Initial data load
loadData();
}

