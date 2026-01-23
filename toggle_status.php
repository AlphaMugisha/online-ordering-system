<?php
include 'db.php';

if (isset($_GET['id']) && isset($_GET['current'])) {
    $id = $_GET['id'];
    $new_status = ($_GET['current'] == 1) ? 0 : 1;

    $stmt = $conn->prepare("UPDATE resto_bar_items SET is_available = ? WHERE id = ?");
    $stmt->bind_param("ii", $new_status, $id);
    $stmt->execute();
    
    header("Location: admin.php");
}
?>