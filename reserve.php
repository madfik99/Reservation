<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $startDateTime = $_POST['start_datetime'];
    $endDateTime = $_POST['end_datetime'];
    $description = $_POST['description'] ?? '';
    $datePrefix = date('ymd');

    // Convert to date and time parts
    $startDate = date('Y-m-d', strtotime($startDateTime));
    $startTime = date('H:i:s', strtotime($startDateTime));
    $endDate = date('Y-m-d', strtotime($endDateTime));
    $endTime = date('H:i:s', strtotime($endDateTime));

    // Step 1: Generate Reservation ID
    $getLastId = "SELECT TOP 1 id FROM Reservations WHERE id LIKE 'R$datePrefix-%' ORDER BY id DESC";
    $stmt = sqlsrv_query($conn, $getLastId);
    $newId = "R$datePrefix-1";
    if ($stmt && sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt);
        $lastNumber = (int) substr($row['id'], strrpos($row['id'], '-') + 1);
        $newId = "R$datePrefix-" . ($lastNumber + 1);
    }

    // Step 2: Check for overlapping reservations
    $grace = 15; // Grace period in minutes
    $check = "
        SELECT *
        FROM Reservations
        WHERE (
            (CAST(reservation_date AS DATETIME) + CAST(reservation_time AS DATETIME)) < DATEADD(MINUTE, ?, CAST(? AS DATETIME))
            AND
            (CAST(reservation_date_end AS DATETIME) + CAST(reservation_end_time AS DATETIME)) > CAST(? AS DATETIME)
        )";
    
    $stmt = sqlsrv_query($conn, $check, [$grace, $endDateTime, $startDateTime]);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        header("Location: index.php?status=unavailable");
        exit();
    }

    // Step 3: Insert reservation
    $insert = "
        INSERT INTO Reservations 
        (id, name, reservation_date, reservation_time, reservation_date_end, reservation_end_time, description) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = [$newId, $name, $startDate, $startTime, $endDate, $endTime, $description];
    $result = sqlsrv_query($conn, $insert, $params);

    if ($result) {
        header("Location: index.php?status=success");
    } else {
        header("Location: index.php?status=error");
    }
    exit();
}
?>
