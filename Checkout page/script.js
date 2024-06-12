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

    // Testimonial data
    const testimonials = [
        {
            Name: "Mike Erickson",
            Location: "US",
            Testimonial: "This vehicle history report has everything I needed to entice a buyer. I am trying to sell my vehicle and it’s a great alternative to a Carfax at a much better price!!",
            Date: "July 24, 2023",
            ProfileImage: "https://dummyimage.com/100x100/000/fff&text=ME"
        },
        {
            Name: "Jessica Cummings",
            Location: "CA",
            Testimonial: "I work at an exotic car dealer where it brings a lot more value to the vehicles I sell if I have the window sticker, and a lot of manufacturers do not provide them anymore. This site has helped me close a lot of my deals and I definitely recommend it.",
            Date: "May 28, 2024",
            ProfileImage: "https://user-images.trustpilot.com/6657cfb0a755efd655228c46/73x73.png"
        },
        {
            Name: "Dennis Millman",
            Location: "US",
            Testimonial: "Absolutely incredible! Was able to get my original window sticker with all factory options! It’s was only $15 and it was all generated in seconds! AMAZING",
            Date: "May 29, 2024",
            ProfileImage: "https://user-images.trustpilot.com/665928a43a310940e4607ba1/73x73.png"
        },
        {
            Name: "Lorne Hanson",
            Location: "CA",
            Testimonial: "This was my first experience trying to get a vehicle report. I found it very easy to enter the required information and pay the small fee for the report which arrived in less than one minute. The report is very complete and accurate",
            Date: "April 22, 2024",
            ProfileImage: "https://dummyimage.com/100x100/000/fff&text=LH"
        },
        {
            Name: "Jon J",
            Location: "US",
            Testimonial: "Great report, it gives excellent information about the history of my vehicle. Gives buyers confidence that what I am telling them is actually TRUE!",
            Date: "May 07, 2024",
            ProfileImage: "https://dummyimage.com/100x100/000/fff&text=BH"
        }
    ];

    // Function to inject testimonials into the DOM
    const wrappers = document.querySelectorAll(".testimonial_data_wrapper");
    const paginations = document.querySelectorAll(".pagination")

    testimonials.forEach(testimonial => {
        // Create the testimonial container
        const slide = document.createElement("div");
        slide.className = "slide";

        const dot = document.createElement("span");
        dot.className = "dot";

        // Create the slider header
        const sliderHeader = document.createElement("div");
        sliderHeader.className = "slider-header flex";

        // Create the profile image element
        const profileImage = document.createElement("img");
        profileImage.className = "profilePict";
        profileImage.src = testimonial.ProfileImage;
        profileImage.alt = `Profile of ${testimonial.Name}`;

        // Create the identity container
        const identity = document.createElement("div");
        identity.className = "identity flex flex_col";

        // Create the name and location container
        const nameLocation = document.createElement("div");
        nameLocation.className = "testimonial_name";

        const name = document.createElement("p");
        name.textContent = testimonial.Name;

        const location = document.createElement("p");
        location.textContent = testimonial.Location;

        // Append name and location to the nameLocation div
        nameLocation.appendChild(name);
        nameLocation.appendChild(location);

        // Create and add the rating image (assuming it's a static image)
        const ratingImage = document.createElement("img");
        ratingImage.className = "rating";
        ratingImage.src = "assets/stars.svg"; // Replace with actual path to your rating image
        ratingImage.alt = "Rating";

        // Append nameLocation and ratingImage to the identity div
        identity.appendChild(nameLocation);
        identity.appendChild(ratingImage);

        // Append profileImage and identity to the sliderHeader div
        sliderHeader.appendChild(profileImage);
        sliderHeader.appendChild(identity);

        // Create the date paragraph
        const dateParagraph = document.createElement("p");
        dateParagraph.className = "slider-date bold";
        dateParagraph.innerHTML = `Date of experience: <span class="date">${testimonial.Date}</span>`;

        // Create the testimonial paragraph
        const testimonialParagraph = document.createElement("p");
        testimonialParagraph.className = "slider-testimonial";
        testimonialParagraph.textContent = testimonial.Testimonial;

        // Append sliderHeader, dateParagraph, and testimonialParagraph to the slide div
        slide.appendChild(sliderHeader);
        slide.appendChild(dateParagraph);
        slide.appendChild(testimonialParagraph);

        // Append the slide div to the wrapper
        wrappers.forEach(wrapper => {
            // add testimonial
            const slideClone = slide.cloneNode(true);
            wrapper.appendChild(slideClone);
        });
        // Append the dot span to the pagination
        paginations.forEach(pagination => {
            // Add a dot for each testimonial
            const dotClone = dot.cloneNode(true);
            pagination.appendChild(dotClone);
        });
    });

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

    // validate input field

    const letterOnlyInputs = document.querySelectorAll('.lettersOnly');
    const capitalizeOnlyInputs = document.querySelectorAll('.capitalize');
    const numberOnlyInputs = document.querySelectorAll('.numberOnly');
    const expireInputs = document.querySelectorAll('.expire');
    const cvcInputs = document.querySelectorAll('.cvc');

    // Iterate over each input field and attach the event listener
    letterOnlyInputs.forEach((inputField) => {
        inputField.addEventListener('keydown', (event) => {
            // Regular expression to allow only letters (a-z, A-Z)
            const regex = /^[a-zA-Z]$/;

            // Get the character from the key event
            const char = event.key;

            // Check if the key is not a letter and is not one of the allowed control keys
            if (!regex.test(char) && !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key)) {
                event.preventDefault(); // Prevent input
            }
        });
    });
    // Iterate over each input field and attach the event listener
    capitalizeOnlyInputs.forEach((inputField) => {
        inputField.addEventListener('input', (event) => {
            // Capitalize the input value
            inputField.value = inputField.value.toUpperCase();
        });
    });

    numberOnlyInputs.forEach((inputField) => {
        inputField.addEventListener('keydown', (event) => {
            // Regular expression to allow only numbers (0-9)
            const regex = /^[0-9]$/;

            // Get the character from the key event
            const char = event.key;

            // Check if the key is not a number and is not one of the allowed control keys
            if (!regex.test(char) && !['Backspace', 'Delete', 'ArrowLeft', 'ArrowRight'].includes(event.key)) {
                event.preventDefault(); // Prevent input
            }
        });
    });

    expireInputs.forEach((inputField) => {
        inputField.addEventListener('input', (event) => {
            // Get the input value
            let value = event.target.value;
            
            // Allow only numbers and "/"
            value = value.replace(/[^\d/]/g, '');

            // If the length of the value is 3 and the last character is not "/", automatically add "/"
            if (value.length === 3 && value.charAt(2) !== '/') {
                value = value.substring(0, 2) + '/' + value.charAt(2);
            }

            // Limit the input to 4 characters
            value = value.substring(0, 5);

            // Update the input value
            event.target.value = value;
        });
    });
    
    cvcInputs.forEach((inputField) => {
        inputField.addEventListener('input', (event) => {
            // Get the input value
            let value = event.target.value;
            
            // Allow only numbers
            value = value.replace(/[^\d]/g, '');

            // Limit the input to 3 characters
            value = value.substring(0, 3);

            // Update the input value
            event.target.value = value;
        });
    });

    // Instruction popup
    const instructionsElements = document.querySelectorAll('.instructionsElement');
    const instructionsWrapper = document.getElementById('instructionsWrapper');
    
    // Define the function to toggle the instruction popup
    const toggleInstructionPopup = function () {
        instructionsWrapper.classList.toggle('active');
    };
    
    // Add a click event listener to each 'instructionsElement'
    instructionsElements.forEach(element => {
        element.addEventListener('click', toggleInstructionPopup);
    });
});