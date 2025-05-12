<?php
$serverName = "localhost"; // Update with your server name
$connectionOptions = [
    "Database" => "reservation_system",
    "Uid" => "sa",
    "PWD" => "abc123"
];

$conn = sqlsrv_connect($serverName, $connectionOptions);

if (!$conn) {
    die(print_r(sqlsrv_errors(), true));
}
?>
