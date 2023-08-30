// Fetch initial batch of events
document.addEventListener("DOMContentLoaded", function() {
    fetchEvents();
});

// Function to fetch events
function fetchEvents() {
    fetch('/api/events')  // Replace with your API endpoint
        .then(response => response.json())
        .then(data => {
            renderEvents(data);
        })
        .catch((error) => console.error('Error:', error));
}

// Function to render events
function renderEvents(data) {
    const eventList = document.querySelector('.event-list');
    eventList.innerHTML = "";  // Clear the current list
    data.forEach(event => {
        const listItem = document.createElement('li');
        listItem.className = 'event-item';
        listItem.innerHTML = `${event.user} ${event.action} ${event.detail}`;
        eventList.appendChild(listItem);
    });
}

// Function to mark an event as read
function markAsRead(id) {
    fetch(`/api/events/mark-as-read/${id}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update the event's visual state to "read"
            const eventItem = document.querySelector(`.event-item[data-id='${id}']`);
            eventItem.classList.add('read');
        }
    })
    .catch((error) => console.error('Error:', error));
}
