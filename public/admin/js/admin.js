function updateGreeting() {
    var currentDate = new Date();
    var currentHour = currentDate.getHours();

    var greetingElement = document.getElementById('greeting');

    if (greetingElement) {
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
}

// Ensure the DOM is fully loaded before running the script
document.addEventListener('DOMContentLoaded', function() {
    // Call the function initially to set the greeting
    updateGreeting();

    // Update the greeting every minute
    setInterval(updateGreeting, 60000);
});