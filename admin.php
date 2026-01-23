<?php
session_start();
// Protect the page - redirect to login if not logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kigali Marriott Hotel | Staff Panel</title>
    <style>
        /* Official Marriott Brand Palette */
        :root { 
            --marriott-red: #B41F3A; 
            --chalkboard: #1C1C1C; 
            --slate: #4D4D4D;
            --linen: #F4F4F4; 
            --white: #FFFFFF;
            --success: #28a745;
        }

        body { 
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; 
            background: var(--linen); 
            margin: 0; 
            padding: 0; 
            color: var(--chalkboard);
        }
        
        .header { 
            background: var(--chalkboard); 
            color: var(--white); 
            padding: 20px 40px; 
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 4px solid var(--marriott-red);
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .header h1 { 
            margin: 0; 
            font-size: 1.4rem; 
            letter-spacing: 1px; 
            font-weight: 400; 
            text-transform: uppercase;
        }

        .logout-link {
            color: var(--white);
            text-decoration: none;
            font-size: 0.8rem;
            border: 1px solid var(--white);
            padding: 6px 15px;
            transition: 0.3s;
        }
        .logout-link:hover {
            background: var(--marriott-red);
            border-color: var(--marriott-red);
        }

        /* Container & Sections */
        .admin-container { max-width: 1250px; margin: 30px auto; padding: 0 20px; }
        
        .section-container { 
            background: var(--white); 
            padding: 25px; 
            margin-bottom: 30px; 
            border: 1px solid #e0e0e0;
        }

        h2 { 
            color: var(--marriott-red); 
            font-size: 1rem; 
            text-transform: uppercase; 
            margin-top: 0; 
            margin-bottom: 20px;
            letter-spacing: 1px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        /* Stats Grid */
        .stats-grid { 
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); 
            gap: 20px; 
            margin-bottom: 30px; 
        }
        .stat-card { 
            background: var(--white); 
            padding: 25px; 
            border: 1px solid #e0e0e0;
            text-align: center; 
        }
        .stat-card h3 { 
            margin: 0; 
            font-size: 0.75rem; 
            color: var(--slate); 
            text-transform: uppercase; 
            letter-spacing: 1px;
        }
        .stat-card p { 
            margin: 10px 0 0; 
            font-size: 1.6rem; 
            font-weight: bold; 
            color: var(--chalkboard); 
        }
        .stat-card.highlight { border-top: 4px solid var(--marriott-red); }

        /* Tables */
        table { width: 100%; border-collapse: collapse; }
        th { 
            background: #f9f9f9; 
            color: var(--slate); 
            padding: 12px; 
            text-align: left; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            border-bottom: 2px solid #eee;
        }
        td { 
            padding: 15px 12px; 
            border-bottom: 1px solid #eee; 
            font-size: 0.9rem; 
            vertical-align: top;
        }

        /* Form Elements */
        .menu-form { 
            display: flex; 
            gap: 10px; 
            flex-wrap: wrap; 
            margin-bottom: 25px; 
            background: #fdfdfd; 
            padding: 20px;
            border: 1px solid #eee;
        }
        input, select { 
            padding: 10px; 
            border: 1px solid #ccc; 
            font-size: 0.9rem; 
            outline: none;
        }
        button[type="submit"] { 
            background: var(--marriott-red); 
            color: white; 
            padding: 10px 25px; 
            border: none; 
            cursor: pointer; 
            text-transform: uppercase; 
            font-weight: bold;
            font-size: 0.8rem;
        }

        /* Utility Buttons */
        .btn-confirm { background: var(--success); color: white; padding: 6px 12px; text-decoration: none; font-size: 0.75rem; font-weight: bold; }
        .btn-delete { background: var(--marriott-red); color: white; padding: 6px 12px; text-decoration: none; font-size: 0.75rem; }
        .btn-status { background: var(--chalkboard); color: white; padding: 6px 12px; text-decoration: none; font-size: 0.75rem; }
        .btn-qr { 
            background: var(--marriott-red); 
            color: white; 
            padding: 12px 25px; 
            text-decoration: none; 
            font-size: 0.8rem; 
            font-weight: bold; 
            text-transform: uppercase;
        }

        .status-badge { padding: 4px 10px; font-size: 0.7rem; font-weight: bold; text-transform: uppercase; }
        .Pending { background: #fff3cd; color: #856404; }
        .Confirmed { background: #d4edda; color: #155724; }
        
        .note-text { font-size: 0.8rem; color: var(--slate); font-style: italic; display: block; margin-top: 5px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Kigali Marriott | Staff Panel</h1>
        <a href="logout.php" class="logout-link">LOGOUT</a>
    </div>

    <div class="admin-container">

        <?php
        $today = date('Y-m-d');
        $sales_query = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE DATE(created_at) = '$today' AND status = 'Confirmed'");
        $daily_total = $sales_query->fetch_assoc()['total'] ?? 0;

        $momo_query = $conn->query("SELECT SUM(total_amount) as total FROM orders WHERE DATE(created_at) = '$today' AND status = 'Confirmed' AND payment_method = 'MoMo'");
        $momo_total = $momo_query->fetch_assoc()['total'] ?? 0;
        $cash_total = $daily_total - $momo_total;
        ?>
        <div class="stats-grid">
            <div class="stat-card highlight">
                <h3>Today's Revenue</h3>
                <p><?php echo number_format($daily_total); ?> RWF</p>
            </div>
            <div class="stat-card">
                <h3>MoMo Transactions</h3>
                <p><?php echo number_format($momo_total); ?> RWF</p>
            </div>
            <div class="stat-card">
                <h3>Cash Settlements</h3>
                <p><?php echo number_format($cash_total); ?> RWF</p>
            </div>
        </div>

        <div class="section-container">
            <h2>Active Guest Orders</h2>
            <table>
                <thead>
                    <tr>
                        <th>Table</th>
                        <th>Selection & Requests</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT o.*, GROUP_CONCAT(CONCAT('<b>', d.item_name, '</b> (', d.item_temp, ')<br><span class=\"note-text\">Note: ', IFNULL(d.special_notes, 'None'), '</span>') SEPARATOR '<br><br>') as items_display 
                            FROM orders o 
                            JOIN order_details d ON o.id = d.order_id 
                            GROUP BY o.id ORDER BY o.id DESC";
                    $res = $conn->query($sql);
                    while($row = $res->fetch_assoc()): ?>
                        <tr>
                            <td><strong>Table <?php echo $row['table_number']; ?></strong></td>
                            <td><?php echo $row['items_display']; ?></td>
                            <td><?php echo number_format($row['total_amount']); ?> RWF</td>
                            <td><?php echo $row['payment_method']; ?></td>
                            <td><span class="status-badge <?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
                            <td>
                                <?php if($row['status'] == 'Pending'): ?>
                                    <a href="confirm.php?id=<?php echo $row['id']; ?>" class="btn-confirm">Confirm</a>
                                <?php else: ?>
                                    <span style="color:var(--success); font-weight:bold; font-size:0.75rem;">SETTLED</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="section-container">
            <h2>Menu Administration</h2>
            <form action="add_product.php" method="POST" class="menu-form">
                <input type="text" name="item_name" placeholder="Item Name" required style="flex:2;">
                <input type="number" name="item_price" placeholder="Price (RWF)" required style="flex:1;">
                <select name="item_category" style="flex:1;">
                    <option value="Food">Dining</option>
                    <option value="Drink">Beverage</option>
                </select>
                <button type="submit">Add Item</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Inventory</th>
                        <th>Control</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $items = $conn->query("SELECT * FROM resto_bar_items ORDER BY category, name");
                    while($item = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['category']; ?></td>
                            <td><?php echo number_format($item['price']); ?></td>
                            <td>
                                <?php if($item['is_available'] == 1): ?>
                                    <span style="color: var(--success); font-weight: bold; font-size:0.75rem;">AVAILABLE</span>
                                <?php else: ?>
                                    <span style="color: var(--marriott-red); font-weight: bold; font-size:0.75rem;">OUT OF STOCK</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="toggle_status.php?id=<?php echo $item['id']; ?>&current=<?php echo $item['is_available']; ?>" class="btn-status">Update</a>
                                <a href="delete_product.php?id=<?php echo $item['id']; ?>" onclick="return confirm('Delete item permanently?')" class="btn-delete">Remove</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div class="section-container">
            <h2>Guest Feedback</h2>
            <table>
                <thead>
                    <tr>
                        <th>Guest</th>
                        <th>Rating</th>
                        <th>Commentary</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $feed = $conn->query("SELECT * FROM guest_feedback ORDER BY created_at DESC LIMIT 5");
                    while($f = $feed->fetch_assoc()): ?>
                        <tr>
                            <td><strong><?php echo $f['customer_name']; ?></strong></td>
                            <td style="color: var(--marriott-red);"><?php echo str_repeat("?", $f['rating']); ?></td>
                            <td>"<?php echo $f['comments']; ?>"</td>
                            <td><?php echo date('d M Y', strtotime($f['created_at'])); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <div style="text-align: center; margin-top: 40px; margin-bottom: 60px;">
            <a href="qr_generator.php" class="btn-qr">Station QR Codes</a>
            <br><br>
            <a href="order_history.php" style="color: var(--slate); font-size: 0.8rem; text-decoration: underline;">Full History Archive</a>
        </div>

    </div>

</body>
</html>