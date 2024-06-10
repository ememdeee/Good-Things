// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // Cache elements for the first set (payment methods)
    const paymentButtons = {
        stripe: document.getElementById('stripeBtn'),
        paypal: document.getElementById('paypalBtn'),
        gumroad: document.getElementById('gumroadBtn')
    };

    const paymentSections = {
        stripe: document.getElementById('stripe'),
        paypal: document.getElementById('paypal'),
        gumroad: document.getElementById('gumroad')
    };

    // Cache elements for the second set (additional options)
    const optionButtons = {
        creditCard: document.getElementById('creditCardBtn'),
        bankTranfer: document.getElementById('bankTranferBtn')
    };

    const optionSections = {
        creditCard: document.getElementById('creditCard'),
        bankTranfer: document.getElementById('bankTranfer')
    };

    // Add click event listeners to payment method buttons
    Object.keys(paymentButtons).forEach(key => {
        paymentButtons[key].addEventListener('click', () => toggleActiveState(paymentButtons, paymentSections, key));
    });

    // Add click event listeners to additional option buttons
    Object.keys(optionButtons).forEach(key => {
        optionButtons[key].addEventListener('click', () => toggleActiveState(optionButtons, optionSections, key));
    });

    // Function to toggle active class
    function toggleActiveState(buttons, sections, activeKey) {
        // Remove 'active' class from all buttons in the current set
        Object.values(buttons).forEach(button => button.classList.remove('active'));

        // Remove 'active' class from all sections in the current set
        Object.values(sections).forEach(section => section.classList.remove('active'));

        // Add 'active' class to the clicked button in the current set
        buttons[activeKey].classList.add('active');

        // Add 'active' class to the corresponding section in the current set
        sections[activeKey].classList.add('active');
    }

    // testimonial js
    const sliderWrappers = document.querySelectorAll('.slider-wrapper');

    sliderWrappers.forEach(wrapper => {
        const slides = wrapper.querySelectorAll('.slide');
        const dots = wrapper.querySelectorAll('.dot');
        const leftArrow = wrapper.querySelector('.arrow.left');
        const rightArrow = wrapper.querySelector('.arrow.right');

        let currentSlideIndex = 0;

        function showSlide(index) {
            if (index >= slides.length) {
                currentSlideIndex = 0;
            } else if (index < 0) {
                currentSlideIndex = slides.length - 1;
            } else {
                currentSlideIndex = index;
            }

            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));

            slides[currentSlideIndex].classList.add('active');
            dots[currentSlideIndex].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentSlideIndex + 1);
        }

        function prevSlide() {
            showSlide(currentSlideIndex - 1);
        }

        function currentSlide(index) {
            showSlide(index);
        }

        rightArrow.addEventListener('click', nextSlide);
        leftArrow.addEventListener('click', prevSlide);
        dots.forEach((dot, index) => {
            dot.addEventListener('click', () => currentSlide(index));
        });

        showSlide(currentSlideIndex); // Initialize the first slide
    });

    // popup
    const tranferReceiptPopup = document.getElementById('tranferReceiptPopup');
    const receiptOverlay = document.getElementById('receiptOverlay');
    const receiptCloseIcon = document.getElementById('close-icon');
    const receiptTrigger = document.getElementById('submitReceiptOnline');
    
    const toggleReceiptPopup = function () {
        tranferReceiptPopup.classList.toggle('active');
    };

    receiptOverlay.addEventListener('click', toggleReceiptPopup);
    receiptCloseIcon.addEventListener('click', toggleReceiptPopup);
    receiptTrigger.addEventListener('click', toggleReceiptPopup);
});
