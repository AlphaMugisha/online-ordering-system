<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['customer_name'];
    $rating = $_POST['rating'];
    $comments = $_POST['comments'];

    $stmt = $conn->prepare("INSERT INTO guest_feedback (customer_name, rating, comments) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $rating, $comments);
    $stmt->execute();
    header("Location: index.php?thanks=1");
}
?>