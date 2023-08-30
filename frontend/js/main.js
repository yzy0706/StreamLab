// Fetch events from API
async function fetchEvents() {
  try {
      const response = await fetch('/api/events');
      if (response.ok) {
          const events = await response.json();
          renderEvents(events);
      } else {
          console.error('Failed to fetch events');
      }
  } catch (error) {
      console.error('An error occurred:', error);
  }
}

// Render events to the DOM
function renderEvents(events) {
  const eventList = document.getElementById('eventList');
  eventList.innerHTML = ''; // Clear existing list
  events.forEach((event) => {
      const listItem = document.createElement('li');
      listItem.className = 'event-item' + (event.is_read ? ' read' : '');
      listItem.textContent = event.message;
      listItem.addEventListener('click', () => markAsRead(event.id));
      eventList.appendChild(listItem);
  });
}

// Mark an event as read
async function markAsRead(id) {
  try {
      const response = await fetch(`/api/events/mark-as-read/${id}`, {
          method: 'POST',
      });
      if (response.ok) {
          // Update visual state
          const listItem = document.querySelector(`li[data-id="${id}"]`);
          listItem.classList.add('read');
      } else {
          console.error('Failed to mark event as read');
      }
  } catch (error) {
      console.error('An error occurred:', error);
  }
}

// Initialize
document.addEventListener('DOMContentLoaded', () => {
  fetchEvents();
});
    