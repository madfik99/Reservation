<?php
require 'config.php';

$sql = "SELECT * FROM Reservations ORDER BY reservation_date, reservation_time";
$result = sqlsrv_query($conn, $sql);

echo "<h2>All Reservations</h2><ul>";
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $start = $row['reservation_date']->format('Y-m-d') . ' at ' . $row['reservation_time']->format('H:i');
    $end = $row['reservation_date_end']->format('Y-m-d') . ' at ' . $row['reservation_end_time']->format('H:i');
    echo "<li>{$row['name']} – from {$start} to {$end}</li>";
}
echo "</ul>";

?>