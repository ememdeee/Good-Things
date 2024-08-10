console.log("Hello");

function showSpecData(){
    console.log("show");
}

// Wait until the DOM is fully loaded
document.addEventListener('DOMContentLoaded', () => {
    // garage Alart Btn
    document.getElementById("garageAlertIcon").addEventListener("click", function() {
        const garagePopup = document.getElementById("garageAlertPopup");
        if (garagePopup.style.display === "block") {
            garagePopup.style.display = "none";
        } else {
            garagePopup.style.display = "block";
        }
    });
    // Testimonial data
    const testimonials = [
        {
            Name: "Mike Erickson",
            Location: "US",
            Testimonial: "This vehicle history report has everything I needed to entice a buyer. I am trying to sell my vehicle and it’s a great alternative to a Carfax at a much better price!!",
            ProfileImage: "https://dummyimage.com/100x100/000/fff&text=ME"
        },
        {
            Name: "Jessica Cummings",
            Location: "CA",
            Testimonial: "I work at an exotic car dealer where it brings a lot more value to the vehicles I sell if I have the window sticker, and a lot of manufacturers do not provide them anymore. This site has helped me close a lot of my deals and I definitely recommend it.",
            ProfileImage: "https://user-images.trustpilot.com/6657cfb0a755efd655228c46/73x73.png"
        },
        {
            Name: "Dennis Millman",
            Location: "US",
            Testimonial: "Absolutely incredible! Was able to get my original window sticker with all factory options! It’s was only $15 and it was all generated in seconds! AMAZING",
            ProfileImage: "https://user-images.trustpilot.com/665928a43a310940e4607ba1/73x73.png"
        },
        {
            Name: "Lorne Hanson",
            Location: "CA",
            Testimonial: "This was my first experience trying to get a vehicle report. I found it very easy to enter the required information and pay the small fee for the report which arrived in less than one minute. The report is very complete and accurate",
            ProfileImage: "https://dummyimage.com/100x100/000/fff&text=LH"
        },
        {
            Name: "Jon J",
            Location: "US",
            Testimonial: "Great report, it gives excellent information about the history of my vehicle. Gives buyers confidence that what I am telling them is actually TRUE!",
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
        sliderHeader.className = "slider-header";

        // Create the profile image element
        const profileImage = document.createElement("img");
        profileImage.className = "profilePict";
        profileImage.src = testimonial.ProfileImage;
        profileImage.alt = `Profile of ${testimonial.Name}`;

        // Create the identity container
        const identity = document.createElement("div");
        identity.className = "identity";

        // Create the name and location container
        // const nameLocation = document.createElement("div");
        // nameLocation.className = "testimonial_name";

        const name = document.createElement("p");
        name.textContent = testimonial.Name;

        const location = document.createElement("p");
        location.textContent = testimonial.Location;

        // Append name and location to the nameLocation div
        
        // Create and add the rating image (assuming it's a static image)
        const ratingImage = document.createElement("img");
        ratingImage.className = "rating";
        ratingImage.src = "asset/stars.svg"; // Replace with actual path to your rating image
        ratingImage.alt = "Rating";
        
        // Append nameLocation and ratingImage to the identity div
        identity.appendChild(name);
        identity.appendChild(location);
        identity.appendChild(ratingImage);

        // Append profileImage and identity to the sliderHeader div
        sliderHeader.appendChild(profileImage);
        sliderHeader.appendChild(identity);

        // Create the testimonial paragraph
        const testimonialParagraph = document.createElement("p");
        testimonialParagraph.className = "slider-testimonial";
        testimonialParagraph.textContent = testimonial.Testimonial;

        // Append sliderHeader, dateParagraph, and testimonialParagraph to the slide div
        slide.appendChild(sliderHeader);
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
    // end slider

    // tabs 
    function handleTabClick(tabListSelector, dataContainerSelector) {
        document.querySelectorAll(tabListSelector).forEach(tab => {
            tab.addEventListener('click', function() {
                // Remove 'active' class from all tabs in this tab list
                const parentTabList = tab.closest('.tabList');
                parentTabList.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                // Add 'active' class to the clicked tab
                this.classList.add('active');

                // Remove 'active' class from all data containers in this section
                document.querySelectorAll(dataContainerSelector).forEach(container => container.classList.remove('active'));
                // Add 'active' class to the corresponding data container
                document.getElementById(this.dataset.target).classList.add('active');
            });
        });
    }
    // Initialize the tab functionality for both tab lists
    handleTabClick('.marketTabs .tab', '.marketData .dataContainer');
    handleTabClick('.spesificationsTabs .tab', '.dataContainer');
});