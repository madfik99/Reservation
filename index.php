<!DOCTYPE html>
<html>
<head>
  <title>Reservation System</title>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" />
  <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/themes/light-border.css" />
  <!-- Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      margin-top: 120px; /* Ensure content is not hidden behind the fixed navbar */
      margin-bottom: 70px;
    }

    header {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      background-color:rgb(0, 0, 0);
      padding: 10px 0;
      z-index: 1000;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .navbar-title {
      color: white;
      font-size: 20px;
      font-weight: bold;
    }

    .navbar-links {
      display: flex;
      gap: 20px;
    }

    .navbar-links a {
      color: white;
      text-decoration: none;
      font-size: 16px;
      font-weight: 600;
      padding: 10px 20px;
      border-radius: 5px;
      transition: background-color 0.3s ease;
    }

    .navbar-links a:hover {
      background-color:rgb(92, 92, 92);
    }

    select {
      background-color: transparent;
      color: white;
      font-size: 16px;
      font-weight: 600;
      padding: 10px 20px;
      border: 2px solid white;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    select:hover {
      background-color: #0056b3;
      color: #ffffff;
    }


    select:focus {
      border-color: #0056b3;
      outline: none;
    }

    input[type="text"], input[type="date"], input[type="time"] {
      padding: 5px;
      margin-bottom: 10px;
      width: 200px;
    }

    #calendar {
      max-width: 900px;
      margin: 0 auto;
      margin-top: 20px;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.4);

      display: flex;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background-color: #fefefe;
      padding: 20px;
      border: 1px solid #888;
      width: 400px;
      border-radius: 8px;
      text-align: center;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      position: relative;
    }

    .modal-content form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .modal-content input[type="text"],
    .modal-content input[type="submit"] {
      width: 90%;
      padding: 8px;
      margin: 8px 0;
      box-sizing: border-box;
      border: 1px solid #ccc;
      border-radius: 4px;
    }

    .modal-content input[type="submit"] {
      background-color: #4CAF50;
      color: white;
      font-weight: bold;
      cursor: pointer;
    }

    .modal-content h2 {
      margin-bottom: 20px;
    }

    .modal.show {
      display: flex;
    }


    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    /* Styling for navigation buttons */
    .fc-header-toolbar {
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .fc-toolbar-chunk {
      display: flex;
      align-items: center;
    }

    .fc-toolbar-title {
      font-size: 16px;
      text-align: center;
      flex-grow: 1;
    }

    .fc-button {
      font-size: 12px !important;
      padding: 4px 8px !important;
    }

    .calendar-controls-combined {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: 15px;
      margin-top: 20px;
      height: 30px; /* Fixed height to enforce alignment */
      line-height: 0; /* Reset line-height at container level */
    }

    .calendar-controls-combined button {
      background-color:rgb(90, 90, 90);
      color: white;
      border: none;
      font-size: 12px;
      width: 90px;
      height: 30px;
      cursor: pointer;
      border-radius: 4px;
      display: inline-block;
      line-height: 30px;
      text-align: center;
      margin: 0;
      padding: 0;
      vertical-align: top;
      box-sizing: border-box;
      position: relative;
      top: 0;
    }

    .calendar-controls-combined button#prevMonthButton,
    .calendar-controls-combined button#nextMonthButton {
      font-size: 14px;
      width: 30px;
      height: 30px;
      line-height: 30px;
    }

    /* Force override any inherited styles */
    .calendar-controls-combined button,
    .calendar-controls-combined button#prevMonthButton,
    .calendar-controls-combined button#nextMonthButton {
      vertical-align: top !important;
      line-height: 30px !important;
      margin: 0 !important;
      padding: 0 !important;
    }


    .navbar-links select {
      background: none;
      border: none;
      color: white;
      font-size: 16px;
      font-weight: bold;
      padding: 0 15px;
      cursor: pointer;
      appearance: none;
      -webkit-appearance: none;
      -moz-appearance: none;
      text-decoration: none;
    }

    
    .navbar-links select:hover {
      color: #ddd;
    }


  </style>
</head>
<body>

<!-- Navbar -->
  <header>
    <nav>
      <div class="navbar-title">RS</div>
      <div class="navbar-links">
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#related">Related</a>
        <select id="carSelect" onchange="handleCarSelection(this)">
          <option value="">Car Variants</option>
          <option value="index2.php">NETA X</option>
          <option value="index3.php">NETA V</option>
        </select>
      </div>

    </nav>
  </header>

<?php if (isset($_GET['status'])): ?>
  <p id="statusMessage" style="color: <?= $_GET['status'] === 'success' ? 'green' : ($_GET['status'] === 'unavailable' ? 'orange' : 'red') ?>;">
    <?php
      switch ($_GET['status']) {
        case 'success': echo "✅ Reservation successful."; break;
        case 'unavailable': echo "⚠️ The selected date/time is unavailable."; break;
        case 'error': echo "❌ Reservation failed. Please try again."; break;
      }
    ?>
  </p>
<?php endif; ?>

<!-- Calendar -->
<center><h2>Reservations Calendar</h2></center>
<div id='calendar'></div>

<!-- Combined control bar: Prev, Reservation, Next -->
<div class="calendar-controls-combined">
  <button id="prevMonthButton"><</button>
  <button id="toggleFormButton">Reservation</button>
  <button id="nextMonthButton">></button>
</div>

<!-- Modal for reservation details -->
<div id="reservationModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeDetails">×</span>
    <h3>Reservation Details</h3>
    <p><strong>Name:</strong> <span id="modalName"></span></p>
    <p><strong>Date:</strong> <span id="modalDate"></span></p>
    <p><strong>Date:</strong> <span id="modalDate"></span> to <span id="modalDateEnd"></span></p>
    <p><strong>Time:</strong> <span id="modalTime"></span></p>
    <p><strong>Time:</strong> <span id="modalTime"></span> to <span id="modalTimeEnd"></span></p>
    <p><strong>Description:</strong> <span id="modalDescription"></span></p>
  </div>
</div>

<!-- Modal for reservation form -->
<div id="reservationFormModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeForm">×</span>
    <h2>Make a Reservation</h2>
    <form method="POST" action="reserve.php">
      Name: <input type="text" name="name" required><br>
      Start Date & Time: <input type="text" id="startDateTime" name="start_datetime" required><br>
      End Date & Time: <input type="text" id="endDateTime" name="end_datetime" required><br>
      Description: <input type="text" name="description" maxlength="255"><br>
      <input type="submit" value="Reserve">
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6/dist/tippy-bundle.umd.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    let calendarEl = document.getElementById('calendar');
    document.getElementById("reservationModal").style.display = "none";
    document.getElementById("reservationFormModal").style.display = "none";

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        events: 'get_unavailable_dates.php',
        eventDidMount: function(info) {
            tippy(info.el, {
                content: info.event.title,
                animation: 'scale',
                theme: 'light-border'
            });
        },
        eventClick: function(info) {
            document.getElementById("modalName").innerText = info.event.title;
            document.getElementById("modalDate").innerText = info.event.start.toLocaleDateString();
            document.getElementById("modalTime").innerText = info.event.start.toLocaleTimeString();
            document.getElementById("modalDateEnd").innerText = info.event.end ? info.event.end.toLocaleDateString() : "-";
            document.getElementById("modalTimeEnd").innerText = info.event.end ? info.event.end.toLocaleTimeString() : "-";
            document.getElementById("modalDescription").innerText = info.event.extendedProps.description;
            document.getElementById("reservationModal").style.display = "flex";
        }
    });

    calendar.render();

    if (window.location.search.includes("status=success")) {
      setTimeout(function() {
        calendar.refetchEvents();
        const msg = document.getElementById("statusMessage");
        if (msg) msg.style.display = "none";
        window.history.replaceState(null, null, window.location.pathname);
      }, 1000);
    }


    // Flatpickr setup for start and end date/time
    const endPicker = flatpickr("#endDateTime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today"
    });

    flatpickr("#startDateTime", {
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        minDate: "today",
        onChange: function(selectedDates, dateStr, instance) {
            endPicker.set('minDate', dateStr); // Update end datepicker minDate based on selected start date
        }
    });

    // Modal close buttons
    document.getElementById("closeDetails").onclick = function() {
        document.getElementById("reservationModal").style.display = "none";
    };

    document.getElementById("closeForm").onclick = function() {
        document.getElementById("reservationFormModal").style.display = "none";
    };

    // Show the reservation form modal when the button is clicked
    document.getElementById("toggleFormButton").onclick = function() {
        document.getElementById("reservationFormModal").style.display = "flex";
    };

    // Close modals when clicking outside of them
    window.onclick = function(event) {
        if (event.target == document.getElementById("reservationModal")) {
            document.getElementById("reservationModal").style.display = "none";
        }
        if (event.target == document.getElementById("reservationFormModal")) {
            document.getElementById("reservationFormModal").style.display = "none";
        }
    };

    // Hide status message and reset URL
    if (window.location.search.includes("status=")) {
        setTimeout(function() {
            const msg = document.getElementById("statusMessage");
            if (msg) msg.style.display = "none";
            window.history.replaceState(null, null, window.location.pathname);
        }, 3000);
    }

    // Custom navigation buttons functionality
    document.getElementById("prevMonthButton").onclick = function() {
        calendar.prev();
    };

    document.getElementById("nextMonthButton").onclick = function() {
        calendar.next();
    };

    // Reminder Logic: Check for reservations ending within 15 minutes
    setInterval(() => {
        const now = new Date();

        // Loop through all events
        calendar.getEvents().forEach(event => {
            if (event.end) {
                const endTime = new Date(event.end);
                const diffInMs = endTime - now;
                const diffInMinutes = Math.floor(diffInMs / 60000);

                // If the reservation is ending in less than or equal to 15 minutes, show the reminder
                if (diffInMinutes > 0 && diffInMinutes <= 15 && !event.extendedProps.notified) {
                    alert(`⏰ Reminder: Reservation for "${event.title}" ends in ${diffInMinutes} minutes.`);
                    event.setExtendedProp('notified', true); // Flag to prevent multiple notifications
                }
            }
        });
    }, 60000); // Check every 60 seconds
});

function handleCarSelection(selectElement) {
      const selectedValue = selectElement.value;
      if (selectedValue) {
        window.location.href = selectedValue; // Redirect to the selected page
      }
    }
</script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


</body>
</html>