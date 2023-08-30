<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="header">
        <h1>Dashboard</h1>
    </div>
    <div class="main-content">
        <!-- Stats squares -->
        <div class="stats-square" id="total-revenue">Total Revenue: $0</div>
        <div class="stats-square" id="new-followers">New Followers: 0</div>
        <div class="stats-square" id="top-items">Top Items: None</div>
        <div class="clearfix"></div>

        <!-- Event list -->
        <ul class="event-list">
            <!-- Events will be populated here dynamically -->
        </ul>
    </div>
    <script>
        // Fetch initial batch of events
        document.addEventListener("DOMContentLoaded", function() {
            fetchEvents();
        });

        // Function to fetch events
        function fetchEvents() {
            fetch('/api/events')  // Replace with your actual API endpoint
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
    </script>
</body>
</html>
