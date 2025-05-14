<?php
require 'config.php';

$query = "SELECT name, reservation_date, reservation_time, reservation_date_end, reservation_end_time, description FROM Reservations";
$result = sqlsrv_query($conn, $query);

$events = [];
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $startDateTime = $row['reservation_date']->format('Y-m-d') . 'T' . $row['reservation_time']->format('H:i:s');
    $endDateTime = $row['reservation_date_end']->format('Y-m-d') . 'T' . $row['reservation_end_time']->format('H:i:s');

    $events[] = [
        'title' => $row['name'],
        'start' => $startDateTime,
        'end'   => $endDateTime,
        'color' => 'red',
        'description' => $row['description'] ?? ''
    ];
}

echo json_encode($events);
?>
