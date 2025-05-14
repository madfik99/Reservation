<?php
require 'config.php';

// SQL query to fetch all reservations
$sql = "SELECT * FROM Reservations ORDER BY reservation_date, reservation_time";
$result = sqlsrv_query($conn, $sql);

// Check for SQL query errors
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

echo "<h2>All Reservations</h2>";

// Check if there are any results
if (sqlsrv_has_rows($result)) {
    echo "<ul>";
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        // Convert reservation date and time to DateTime objects if necessary
        $start = new DateTime($row['reservation_date']->format('Y-m-d') . ' ' . $row['reservation_time']->format('H:i'));
        $end = new DateTime($row['reservation_date_end']->format('Y-m-d') . ' ' . $row['reservation_end_time']->format('H:i'));

        echo "<li>{$row['name']} – from {$start->format('Y-m-d H:i')} to {$end->format('Y-m-d H:i')}</li>";
    }
    echo "</ul>";
} else {
    echo "<p>No reservations found.</p>";
}

?>
