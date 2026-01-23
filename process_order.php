<?php
include 'db.php';
$input = json_decode(file_get_contents('php://input'), true);
if($input) {
    $stmt = $conn->prepare("INSERT INTO orders (table_number, total_amount, payment_method, momo_number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $input['table'], $input['total'], $input['method'], $input['phone']);
    if($stmt->execute()) {
        $oid = $conn->insert_id;
        $stmt_item = $conn->prepare("INSERT INTO order_details (order_id, item_name, item_price) VALUES (?, ?, ?)");
        foreach($input['items'] as $item) {
            $stmt_item->bind_param("isi", $oid, $item['name'], $item['price']);
            $stmt_item->execute();
        }
    }
}
// Inside your process_order.php loop where you save items:
foreach ($data['items'] as $item) {
    $item_name = $item['name'];
    $item_temp = isset($item['temp']) ? $item['temp'] : 'Normal';
    
    $stmt = $conn->prepare("INSERT INTO order_details (order_id, item_name, item_temp) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $order_id, $item_name, $item_temp);
    $stmt->execute();
}
?>