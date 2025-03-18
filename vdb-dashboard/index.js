// Pricing data - easy to modify
const pricingData = {
    plans: [
        {
            id: 'enterprise',
            name: 'Enterprise',
            label: 'BEST FOR ENTERPRISE',
            labelColorClass: 'bg-orange-100 text-primary',
            monthlyPrice: 2500,
            yearlyPrice: 2000,
            monthlyOriginal: 3125,
            yearlyOriginal: 30000,
            creditPrice: 0.05,
            features: [
                'Includes choice of All APIs!',
                '50,000 credits included!',
                '$0.05 per second limit!',
                '$0.06 Overage Fees per API call',
                'Priority support!'
            ],
            recommended: {
                min: 3, // 50K
                max: 6  // 5M+
            }
        },
        {
            id: 'premium-plus',
            name: 'Premium Plus',
            label: 'SUITABLE FOR GROWING BUSINESSES',
            labelColorClass: 'bg-blue-100 text-blue-600',
            monthlyPrice: 800,
            yearlyPrice: 640,
            monthlyOriginal: 1000,
            yearlyOriginal: 9600,
            creditPrice: 0.08,
            features: [
                'Includes choice of 15 APIs!',
                '10,000 credits included!',
                '$0.08 per second limit!',
                '$0.10 Overage Fees per API call',
                'Priority support!'
            ],
            recommended: {
                min: 2, // 10K
                max: 3  // 50K
            }
        },
        {
            id: 'premium',
            name: 'Premium',
            label: 'SUITABLE FOR MEDIUM SCALE USAGE',
            labelColorClass: 'bg-blue-50 text-blue-700',
            monthlyPrice: 500,
            yearlyPrice: 400,
            monthlyOriginal: 625,
            yearlyOriginal: 6000,
            creditPrice: 0.10,
            features: [
                'Includes choice of 8 APIs!',
                '5,000 credits included!',
                '$0.10 per second limit!',
                '$0.12 Overage Fees per API call'
            ],
            recommended: {
                min: 1, // 5K
                max: 2  // 10K
            }
        },
        {
            id: 'standard',
            name: 'Standard',
            label: 'SUITABLE FOR MEDIUM SCALE USAGE',
            labelColorClass: 'bg-green-100 text-green-700',
            monthlyPrice: 360,
            yearlyPrice: 288,
            monthlyOriginal: 450,
            yearlyOriginal: 4320,
            creditPrice: 0.12,
            features: [
                'Includes choice of 7 APIs!',
                '3,000 credits included!',
                '$0.12 per second limit!',
                '$0.15 Overage Fees per API call'
            ],
            recommended: {
                min: 1, // 5K
                max: 1  // 5K
            }
        },
        {
            id: 'basic',
            name: 'Basic',
            label: 'SUITABLE FOR SMALL SCALE USAGE',
            labelColorClass: 'bg-purple-100 text-purple-700',
            monthlyPrice: 180,
            yearlyPrice: 144,
            monthlyOriginal: 225,
            yearlyOriginal: 2160,
            creditPrice: 0.12,
            features: [
                'Includes choice of 5 APIs!',
                '1,500 credits included!',
                '$0.12 per second limit!',
                '$0.18 Overage Fees per API call'
            ],
            recommended: {
                min: 0, // 1K
                max: 0  // 1K
            }
        },
        {
            id: 'starter',
            name: 'Starter',
            label: 'GREAT FOR GETTING STARTED',
            labelColorClass: 'bg-amber-100 text-amber-700',
            monthlyPrice: 100,
            yearlyPrice: 80,
            monthlyOriginal: 125,
            yearlyOriginal: 1200,
            creditPrice: 0.20,
            features: [
                'Includes choice of 3 APIs!',
                '500 credits included!',
                '$0.20 per second limit!',
                '$0.24 Overage Fees per API call'
            ],
            recommended: {
                min: 0, // 1K
                max: 0  // 1K
            }
        }
    ],
    apiCallsOptions: [
        '1K',
        '5K',
        '10K',
        '50K',
        '100K',
        '1M+',
        '5M+'
    ]
};

// DOM Elements
const tabButtons = document.querySelectorAll('.tab-btn');
const tabPanes = document.querySelectorAll('.tab-pane');
const billingToggle = document.getElementById('billing-toggle');
const apiCallsSlider = document.getElementById('api-calls-slider');
const sliderActiveTrack = document.getElementById('slider-active-track');
const apiCallsValue = document.getElementById('api-calls-value');
const pricingCardsContainer = document.getElementById('pricing-cards');
const billingOptions = document.querySelectorAll('.billing-option');

// State
let currentBillingCycle = 'monthly';
let currentApiCallsIndex = 3; // Default to 50K
let previousRecommendedPlanId = null;

// Initialize the page
function init() {
    // Set up event listeners
    setupTabsListeners();
    setupBillingToggleListener();
    setupSliderListener();
    
    // Initial render
    updateApiCallsValue();
    updateSliderTrack();
    renderPricingCards();
}

// Tab functionality
function setupTabsListeners() {
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and panes
            tabButtons.forEach(btn => {
                btn.classList.remove('text-primary', 'bg-white', 'rounded-lg');
                btn.classList.add('text-gray-600', 'border-transparent', 'bg-gray-200', 'rounded-none');
            });
            
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
                pane.classList.remove('active');
            });
            
            // Add active class to clicked button and corresponding pane
            button.classList.remove('text-gray-600', 'border-transparent', 'rounded-none');
            button.classList.add('text-primary', 'bg-white', 'rounded-lg');
            
            const tabId = button.getAttribute('data-tab');
            const pane = document.getElementById(tabId);
            pane.classList.remove('hidden');
            pane.classList.add('active');
        });
    });
}

// Billing toggle functionality
function setupBillingToggleListener() {
    billingToggle.addEventListener('change', () => {
      currentBillingCycle = billingToggle.checked ? 'yearly' : 'monthly';
      console.log(currentBillingCycle);
      
      // Update toggle appearance
      const toggleSlider = billingToggle.nextElementSibling;
      
      if (billingToggle.checked) {
        // For yearly billing
        toggleSlider.classList.add('bg-primary');
        toggleSlider.classList.remove('bg-gray-300');
        
        // Add a class to move the bullet
        toggleSlider.classList.add('before:translate-x-6');
        toggleSlider.classList.remove('before:translate-x-0');
      } else {
        // For monthly billing
        toggleSlider.classList.remove('bg-primary');
        toggleSlider.classList.add('bg-gray-300');
        
        // Reset the bullet position
        toggleSlider.classList.remove('before:translate-x-6');
        toggleSlider.classList.add('before:translate-x-0');
      }
      
      // Update text styling
      const billingOptions = document.querySelectorAll('.billing-option');
      billingOptions.forEach((option, index) => {
        if (index === 0) { // Monthly
          option.classList.toggle('text-gray-800', currentBillingCycle === 'monthly');
          option.classList.toggle('text-gray-500', currentBillingCycle === 'yearly');
        } else { // Yearly
          option.classList.toggle('text-gray-800', currentBillingCycle === 'yearly');
          option.classList.toggle('text-gray-500', currentBillingCycle === 'monthly');
        }
      });
      
      // Re-render pricing cards with new billing cycle
      renderPricingCards();
    });
}

// Slider functionality
function setupSliderListener() {
    apiCallsSlider.addEventListener('input', () => {
        currentApiCallsIndex = parseInt(apiCallsSlider.value);
        updateApiCallsValue();
        updateSliderTrack();
        renderPricingCards();
    });
}

// Update the displayed API calls value
function updateApiCallsValue() {
    apiCallsValue.textContent = pricingData.apiCallsOptions[currentApiCallsIndex];
}

// Update the slider active track width
function updateSliderTrack() {
    const percent = (currentApiCallsIndex / (pricingData.apiCallsOptions.length - 1)) * 100;
    sliderActiveTrack.style.width = `${percent}%`;
}

// Render pricing cards based on current state
function renderPricingCards() {
    pricingCardsContainer.innerHTML = '';

    let recommendedPlanId = null;
    
    pricingData.plans.forEach(plan => {
        // Determine if this plan should be recommended for the current API calls selection
        const isRecommended = 
            currentApiCallsIndex >= plan.recommended.min && 
            currentApiCallsIndex <= plan.recommended.max;

        if (isRecommended) {
            recommendedPlanId = plan.id;
            }
        
        // Get price based on billing cycle
        const price = currentBillingCycle === 'monthly' ? plan.monthlyPrice : plan.yearlyPrice;
        const originalPrice = currentBillingCycle === 'monthly' ? plan.monthlyOriginal : plan.yearlyOriginal;
        const period = currentBillingCycle === 'monthly' ? '/month' : '/year';
        
        // Calculate savings percentage
        const savingsPercent = Math.round((1 - (price / originalPrice)) * 100);
        
        // Create card element
        const card = document.createElement('div');
        card.id = `plan-${plan.id}`;
        card.className = `bg-white rounded-lg px-4 md:px-6 py-6 shadow-sm transition-all duration-300 hover:shadow-md hover:-translate-y-1 border ${isRecommended ? 'relative border-primary' : 'border-[#CCCCCC]'}`;

        // Card content with Tailwind classes
        let cardContent = '';
        
        // Add recommended badge if applicable
        if (isRecommended) {
            cardContent += `
                <div class="absolute -top-3 left-1/2 transform -translate-x-1/2 bg-primary text-white text-xs font-medium py-1 px-4 rounded-full whitespace-nowrap">
                    ✓ Recommended for your volume
                </div>
            `;
        }
        
        // Add the rest of the card content
        cardContent += `
            <span class="inline-block text-xs font-semibold py-1 px-3 rounded-full text-center ${plan.labelColorClass} mb-3">${plan.label}</span>
            <h3 class="text-lg font-semibold mb-1">${plan.name}</h3>
            <div class="text-2xl font-bold mb-1">$${price.toLocaleString()}<span class="text-sm font-normal text-gray-500 ml-1">${period}</span></div>
            <div class="mb-4">
                <span class="text-sm text-gray-500 line-through mr-2">$${originalPrice.toLocaleString()}${currentBillingCycle === 'yearly' ? '/year' : '/month'}</span>
                <span class="text-xs font-medium bg-success-light text-success px-2 py-0.5 rounded-full">Save ${savingsPercent}%</span>
            </div>
            <div class="text-sm text-gray-500 mb-5">$${plan.creditPrice.toFixed(2)} per credit</div>
            <button class="w-full py-2.5 px-4 border border-gray-800 rounded text-sm font-medium hover:bg-gray-50 transition-colors mb-5">
                Select API services with this plan
            </button>
            <ul class="space-y-2">
                ${plan.features.map(feature => `
                    <li class="flex items-start text-sm">
                        <svg class="h-5 w-5 text-success flex-shrink-0 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        ${feature}
                    </li>
                `).join('')}
            </ul>
        `;
        
        card.innerHTML = cardContent;
        
        // Add card to container
        pricingCardsContainer.appendChild(card);
    });

    // Highlight the newly recommended plan if it changed
    if (recommendedPlanId && recommendedPlanId !== previousRecommendedPlanId) {
        const recommendedCard = document.getElementById(`plan-${recommendedPlanId}`);
        if (recommendedCard) {
            // Remove any existing animations
            recommendedCard.classList.remove('card-highlight');
            
            // Trigger reflow to restart animation
            void recommendedCard.offsetWidth;
            
            // Add animation class
            recommendedCard.classList.add('card-highlight');
        }
        
        previousRecommendedPlanId = recommendedPlanId;
    }
}

// Initialize the page when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize the page
    init();
});

// ========================================================================================= //

// Popup Requeswt Additional Premium Package Credits
// DOM Elements
const modalOverlay = document.getElementById('modal-overlay');
const modalContainer = document.getElementById('modal-container');
const closeModalBtn = document.getElementById('close-modal');
const impactDescription = document.getElementById('impact-description');
const characterCount = document.getElementById('character-count');
const errorMessage = document.getElementById('error-message');
const submitRequestBtn = document.getElementById('submit-request');

// Constants
const MIN_CHARS = 50;

// Functions
function showRequestCreditsModal() {
    // First make the overlay visible but still transparent
    modalOverlay.classList.remove('pointer-events-none');
    
    // Trigger a reflow to ensure the transition works
    void modalOverlay.offsetWidth;
    
    // Fade in the overlay
    modalOverlay.classList.add('opacity-100');
    
    // Animate in the modal
    setTimeout(() => {
        modalContainer.classList.add('opacity-100', 'scale-100');
        modalContainer.classList.remove('scale-95', 'opacity-0');
    }, 50); // Small delay for better visual effect
    
    // Prevent scrolling when modal is open
    document.body.style.overflow = 'hidden';
}

function closeRequestCreditsModal() {
    // Animate out the modal
    modalContainer.classList.remove('opacity-100', 'scale-100');
    modalContainer.classList.add('scale-95', 'opacity-0');
    
    // Fade out the overlay
    modalOverlay.classList.remove('opacity-100');
    
    // Make the overlay non-interactive after animation completes
    setTimeout(() => {
        modalOverlay.classList.add('pointer-events-none');
        document.body.style.overflow = ''; // Re-enable scrolling
    }, 300); // Match the duration in the CSS
    resetForm();
}

// Event Listeners
closeModalBtn.addEventListener('click', closeRequestCreditsModal);

// Close when clicking outside the modal
modalOverlay.addEventListener('click', (e) => {
    if (e.target === modalOverlay) {
        closeRequestCreditsModal();
    }
});

// Close on escape key
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && !modalOverlay.classList.contains('pointer-events-none')) {
        closeRequestCreditsModal();
    }
});

function resetForm() {
    impactDescription.value = '';
    updateCharacterCount();
    errorMessage.classList.add('hidden');
}

function updateCharacterCount() {
    const currentLength = impactDescription.value.length;
    characterCount.textContent = `${currentLength}/${MIN_CHARS} characters`;

    // Enable/disable submit button based on character count
    if (currentLength >= MIN_CHARS) {
        submitRequestBtn.disabled = false;
        errorMessage.classList.add('hidden');
        characterCount.classList.remove('opacity-100'); // Correct syntax - no equals sign
        characterCount.classList.add('opacity-0'); // Correct syntax - no equals sign
    } else {
        submitRequestBtn.disabled = true;
        characterCount.classList.remove('opacity-0'); // Correct syntax - no equals sign
        characterCount.classList.add('opacity-100'); // Should be opacity-100, not opacity-1
    }
}

function submitRequest() {
    const description = impactDescription.value;

    if (description.length < MIN_CHARS) {
        errorMessage.classList.remove('hidden');
        return;
    }

    // Log the input message to console
    console.log('Credit request submitted:', description);

    // Close the modal after submission
    closeRequestCreditsModal();

    // You could add an AJAX request here to send the data to your server
}

// Update character count as user types
impactDescription.addEventListener('input', updateCharacterCount);

// Handle form submission
submitRequestBtn.addEventListener('click', submitRequest);

// Make the function available globally
window.showRequestCreditsModal = showRequestCreditsModal;

// For testing purposes, you can uncomment this line to show the modal on page load
// showRequestCreditsModal();

// ========================================================================================= //

// Push Notification Popup
// Get DOM elements
const offerPopup = document.getElementById('offer-popup');
const acceptButton = document.getElementById('accept-offer');
const declineButton = document.getElementById('decline-offer');

// Function to show the popup
function showOfferPopup() {
    offerPopup.classList.remove('translate-y-full', 'opacity-0');
    offerPopup.classList.add('translate-y-0', 'opacity-100');
}

// Function to hide the popup
function hideOfferPopup() {
    offerPopup.classList.remove('translate-y-0', 'opacity-100');
    offerPopup.classList.add('translate-y-full', 'opacity-0');
}

// Function to handle user acceptance
function acceptOffer() {
console.log('User accepted the offer');
hideOfferPopup();

// You can add additional logic here, like:
// - Applying a discount
// - Redirecting to checkout
// - Storing the choice in localStorage
}

// Function to handle user decline
function declineOffer() {
console.log('User declined the offer');
hideOfferPopup();

// You can add additional logic here, like:
// - Tracking decline reasons
// - Setting a cookie to not show again
}

// Add event listeners
acceptButton.addEventListener('click', acceptOffer);
declineButton.addEventListener('click', declineOffer);

// Expose the function to the global scope so it can be called from anywhere
window.showSpecialOffer = showOfferPopup;
// showOfferPopup();

// ========================================================================================= //
