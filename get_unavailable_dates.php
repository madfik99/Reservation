<?php
require 'config.php';

// Include description in the SELECT query
$query = "SELECT name, reservation_date, reservation_time, description FROM Reservations";
$result = sqlsrv_query($conn, $query);

$events = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $startDateTime = $row['reservation_date']->format('Y-m-d') . 'T' . $row['reservation_time']->format('H:i:s');

    $events[] = [
        'title' => $row['name'],
        'start' => $startDateTime,
        'color' => 'red',
        'description' => $row['description'] ?? ''  // Pass description to JS
    ];
}

echo json_encode($events);
?>
