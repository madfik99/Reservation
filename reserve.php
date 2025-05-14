<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $startDateTime = $_POST['start_datetime'];
    $endDateTime = $_POST['end_datetime'];
    $description = $_POST['description'] ?? '';
    $datePrefix = date('ymd');

    // Extract date and time
    $startDate = date('Y-m-d', strtotime($startDateTime));
    $startTime = date('H:i:s', strtotime($startDateTime));
    $endDate = date('Y-m-d', strtotime($endDateTime));
    $endTime = date('H:i:s', strtotime($endDateTime));

    // Step 1: Generate Reservation ID (include all records, even soft-deleted ones)
    $getLastId = "SELECT TOP 1 id FROM Reservations WHERE id LIKE 'R$datePrefix-%' ORDER BY id DESC";
    $stmt = sqlsrv_query($conn, $getLastId);
    $newId = "R$datePrefix-1";
    if ($stmt && sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt);
        $lastNumber = (int) substr($row['id'], strrpos($row['id'], '-') + 1);
        $newId = "R$datePrefix-" . ($lastNumber + 1);
    }


    // Step 2: Overlap check
    $check = "
        SELECT *
        FROM Reservations
        WHERE deleted_at IS NULL
          AND (
              (
                CAST(reservation_date AS DATETIME) + CAST(reservation_time AS DATETIME)
                < ?
              )
              AND (
                CAST(reservation_date_end AS DATETIME) + CAST(reservation_end_time AS DATETIME)
                > ?
              )
          )
    ";
    $stmt = sqlsrv_query($conn, $check, [$endDateTime, $startDateTime]);
    if ($stmt === false) {
        die("❌ Overlap Check Error:<br><pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
    }

    if (sqlsrv_has_rows($stmt)) {
        header("Location: index.php?status=unavailable");
        exit();
    }

    // Step 3: Insert into Reservations
    $insert = "
        INSERT INTO Reservations 
        (id, name, reservation_date, reservation_time, reservation_date_end, reservation_end_time, description) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
    $params = [
        $newId,
        $name,
        $startDate,
        $startTime,
        $endDate,
        $endTime,
        $description
    ];

    $result = sqlsrv_query($conn, $insert, $params);

    if ($result === false) {
        die("❌ Insert Failed:<br><pre>" . print_r(sqlsrv_errors(), true) . "</pre>");
    } else {
        header("Location: index.php?status=success");
        exit();
    }
}
?>
