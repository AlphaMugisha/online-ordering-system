<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales History</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background: #f9f9f9; }
        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #1a1a1a; color: #d4af37; }
    </style>
</head>
<body>
<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>
    <h1>Historical Sales Data</h1>
    <table>
        <tr>
            <th>Date</th>
            <th>Table</th>
            <th>Total Amount</th>
            <th>Method</th>
            <th>Status</th>
        </tr>
        <?php
        $res = $conn->query("SELECT * FROM orders ORDER BY created_at DESC");
        while($row = $res->fetch_assoc()): ?>
            <tr>
                <td><?php echo date('d M Y, H:i', strtotime($row['created_at'])); ?></td>
                <td>Table <?php echo $row['table_number']; ?></td>
                <td><?php echo number_format($row['total_amount']); ?> RWF</td>
                <td><?php echo $row['payment_method']; ?></td>
                <td><?php echo $row['status']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="admin.php">Back to Dashboard</a>
</body>
</html>