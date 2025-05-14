<?php
require 'config.php';

$query = "SELECT name, reservation_date, reservation_time, reservation_date_end, reservation_end_time, description 
          FROM Reservations
          WHERE deleted_at IS NULL"; // Exclude soft-deleted records
$result = sqlsrv_query($conn, $query);

$events = [];

// Function to generate a color from a string
function stringToColor($string) {
    $hash = md5($string); // Hash the string
    return '#' . substr($hash, 0, 6); // Use the first 6 characters as hex color
}

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $startDateTime = $row['reservation_date']->format('Y-m-d') . 'T' . $row['reservation_time']->format('H:i:s');
    $endDateTime = $row['reservation_date_end']->format('Y-m-d') . 'T' . $row['reservation_end_time']->format('H:i:s');

    // Generate a consistent color based on the name
    $color = stringToColor($row['name']);

    $events[] = [
        'title' => $row['name'],
        'start' => $startDateTime,
        'end'   => $endDateTime,
        'color' => $color,
        'description' => $row['description'] ?? ''
    ];
}

echo json_encode($events);
?>
