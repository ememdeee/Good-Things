// Get the elements
const toggleCheckbox = document.getElementById('card-toogle');
const inputCardSection = document.getElementById('input-card');
const savedCardSection = document.getElementById('saved-card');

function toggleCardSections() {
    if (toggleCheckbox.checked) {
      // If "Use saved card" is checked
      inputCardSection.classList.add('hidden');
      savedCardSection.classList.remove('hidden');
    } else {
      // If "Use saved card" is unchecked
      inputCardSection.classList.remove('hidden');
      savedCardSection.classList.add('hidden');
    }
}

// Add event listener to the checkbox
toggleCheckbox.addEventListener('change', toggleCardSections);

toggleCardSections(); // Apply the current checkbox state