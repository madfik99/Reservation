<?php
require 'config.php';
$sql = "SELECT * FROM Reservations ORDER BY reservation_date, reservation_time";
$result = sqlsrv_query($conn, $sql);

echo "<h2>All Reservations</h2><ul>";
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    echo "<li>{$row['name']} - {$row['reservation_date']->format('Y-m-d')} at {$row['reservation_time']->format('H:i')}</li>";
}
echo "</ul>";
?>