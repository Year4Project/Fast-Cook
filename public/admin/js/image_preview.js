
// image_preview.js
function previewImage(event) {
    var reader = new FileReader();
    reader.onload = function() {
        var output = document.getElementById('imagePreview');
        output.innerHTML = '<img src="' + reader.result + '" style="max-width:100%;max-height:100%;">';
    }
    reader.readAsDataURL(event.target.files[0]);
}

// Function to update greeting based on time of day
function updateGreeting() {
    var currentDate = new Date();
    var currentHour = currentDate.getHours();

    var greetingElement = document.getElementById('greeting');

    if (currentHour < 12) {
        greetingElement.textContent = 'Good Morning!';
        greetingElement.className = 'morning';
    } else if (currentHour < 18) {
        greetingElement.textContent = 'Good Afternoon!';
        greetingElement.className = 'afternoon';
    } else {
        greetingElement.textContent = 'Good Night!';
        greetingElement.className = 'night';
    }
}

// Call the function initially to set the greeting
updateGreeting();

// Update the greeting every minute
setInterval(updateGreeting, 60000);


function toggleDescription(element) {
    var description = element.parentNode.previousSibling;
    description.classList.toggle('full-description');
    if (description.classList.contains('full-description')) {
        element.innerHTML = 'Read less';
    } else {
        element.innerHTML = 'Read more';
    }
}