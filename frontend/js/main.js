// Fetch events from the API
async function fetchEvents() {
    const response = await fetch("/api/events");
    const data = await response.json();
  
    // TODO: Render the events list
}

// Mark an event as read
async function markAsRead(id) {
    const response = await fetch(`/api/events/${id}/mark-as-read`, {
        method: "POST"
    });
  
    // TODO: Update the event's visual state to "read" if successful
}

// Fetch stats from the API
async function fetchStats() {
    const response = await fetch("/api/stats");
    const data = await response.json();
  
    // TODO: Render the stats
}

// Initial load
document.addEventListener("DOMContentLoaded", function() {
    fetchEvents();
    fetchStats();
});
    