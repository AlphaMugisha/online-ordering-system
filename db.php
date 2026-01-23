<?php
$host = "localhost";
$user = "root"; 
$pass = ""; // Change to "root" if you are using a Mac (MAMP)
$db   = "hotel_resto";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
