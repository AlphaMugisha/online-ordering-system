<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>
<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // Delete the item from the database
    $stmt = $conn->prepare("DELETE FROM resto_bar_items WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: admin.php?deleted=1");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>