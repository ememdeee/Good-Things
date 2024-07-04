// Function to open the popup
function openPopup() {
    document.getElementById('popup').style.display = 'flex';
}

// Function to close the popup
function closePopup() {
    document.getElementById('popup').style.display = 'none';
}

function checkTheftByVin() {
    let dataAvailability = true;

    const button = document.getElementById("checkVin");
    const noData = document.getElementById("no_data");
    const btnSection = document.getElementById("check-theft");

    button.innerHTML = "Please Wait...";
    button.disabled = true;

    noData.classList.add("none");

    setTimeout(() => {
        if (dataAvailability === true) {
            btnSection.classList.add("none");

            const theftDynamicDatas = document.querySelectorAll(".theft-dynamic-data");

            theftDynamicDatas.forEach((theftDynamicData) => {
                theftDynamicData.classList.remove("none");
            });
        } else {
            button.innerHTML = button.getAttribute("aria-label");
            noData.classList.remove("none");
        }
        button.disabled = true;
    }, 5000); // 5 seconds delay
}

// Function to simulate data submission
function reportThefData() {
    let dataFormat = true; 

    const button = document.getElementById("submitData");
    const popupTitle = document.getElementById("popupTitle");
    const popupDesc = document.getElementById("popupDesc");
    const popupBtn = document.getElementById("popupBtn");

    button.innerHTML = "Please Wait...";
    button.disabled = true; 

    setTimeout(() => {
        if (dataFormat === true) {
            popupTitle.innerHTML = "Data Submitted!";
            popupDesc.innerHTML = "Your data has been successfully submitted to the database. Thank you for your contribution!";
            popupBtn.style.backgroundColor = "#4CAF50";
        } else {
            popupTitle.innerHTML = "Submission Failed!";
            popupDesc.innerHTML = "Some fields are missing or incorrect: one, two, three. Please fill in all required fields and try again.";
            popupBtn.style.backgroundColor = "#f44336";
        }
        
        openPopup(); 
        button.innerHTML = button.getAttribute("aria-label");
        button.disabled = false; 
    }, 5000); // 5 seconds delay
}