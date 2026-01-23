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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['item_name'];
    $price = $_POST['item_price'];
    $category = $_POST['item_category'];

    $stmt = $conn->prepare("INSERT INTO resto_bar_items (name, price, category) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $name, $price, $category);

    if ($stmt->execute()) {
        header("Location: admin.php?success=1");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>