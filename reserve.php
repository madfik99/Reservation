<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $date = date('Y-m-d', strtotime($_POST['date']));
    $time = date('H:i:s', strtotime($_POST['time']));
    $description = $_POST['description'] ?? '';  // Get the description if provided, else default to empty string.
    $datePrefix = date('ymd');  // Get the current date in YYMMDD format (e.g., '250512')

    // Step 1: Get the last reservation ID for today
    $getLastId = "SELECT TOP 1 id FROM Reservations WHERE id LIKE 'R$datePrefix-%' ORDER BY id DESC";
    $stmt = sqlsrv_query($conn, $getLastId);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Step 2: Generate the next reservation ID
    $newId = "R$datePrefix-1"; // Default to 1 if no records are found
    if (sqlsrv_has_rows($stmt)) {
        $row = sqlsrv_fetch_array($stmt);
        $lastId = $row['id'];

        // Extract the last number from the ID (e.g., 'R250512-5' -> 5)
        $lastNumber = (int) substr($lastId, strlen($lastId) - 1);
        
        // Increment the last number by 1
        $newId = "R$datePrefix-" . ($lastNumber + 1);
    }

    // Step 3: Check if the reservation time is available
    $check = "SELECT * FROM Reservations WHERE CAST(reservation_date AS DATE) = ? AND CAST(reservation_time AS TIME) = ?";
    $stmt = sqlsrv_query($conn, $check, [$date, $time]);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    if (sqlsrv_has_rows($stmt)) {
        header("Location: index.php?status=unavailable");
        exit();
    } else {
        // Step 4: Insert the reservation with the auto-generated ID, including description
        $insert = "INSERT INTO Reservations (id, name, reservation_date, reservation_time, description) VALUES (?, ?, ?, ?, ?)";
        $params = [$newId, $name, $date, $time, $description];
        $result = sqlsrv_query($conn, $insert, $params);

        if ($result) {
            header("Location: index.php?status=success");
        } else {
            header("Location: index.php?status=error");
        }
        exit();
    }
}
?>
