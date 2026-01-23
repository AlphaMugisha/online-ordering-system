<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) { header("Location: login.php"); exit(); }
include 'db.php';

// Change this to your actual live website URL after you host it
$baseUrl = "http://yourdomain.com/index.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>QR Code Generator - Luxor</title>
    <style>
        body { font-family: sans-serif; background: #f0f0f0; padding: 20px; text-align: center; }
        .qr-card { background: white; padding: 20px; margin: 10px; display: inline-block; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .print-btn { background: #d4af37; padding: 10px 20px; border: none; cursor: pointer; font-weight: bold; margin-bottom: 20px; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print">
        <h1>Generate Table QR Codes</h1>
        <p>Enter the number of tables in your restaurant:</p>
        <form method="GET">
            <input type="number" name="num_tables" value="5" min="1">
            <button type="submit" class="print-btn">Generate</button>
        </form>
        <button class="print-btn" onclick="window.print()" style="background:#1a1a1a; color:#d4af37;">Print All Codes</button>
        <br><a href="admin.php">Back to Dashboard</a>
    </div>

    <div id="qr-container">
        <?php
        if (isset($_GET['num_tables'])) {
            $tables = $_GET['num_tables'];
            for ($i = 1; $i <= $tables; $i++) {
                $tableUrl = $baseUrl . "?table=" . $i;
                $qrUrl = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" . urlencode($tableUrl) . "&choe=UTF-8";
                echo "
                <div class='qr-card'>
                    <h3>TABLE $i</h3>
                    <img src='$qrUrl' alt='QR Code for Table $i'>
                    <p style='font-size: 0.8rem;'>Scan to Order</p>
                </div>";
            }
        }
        ?>
    </div>
</body>
</html>