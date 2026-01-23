<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("UPDATE orders SET status='Confirmed' WHERE id=$id");
header("Location: admin.php");
?>