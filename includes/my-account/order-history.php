<?php

// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $email = $_SESSION['user_email'];
    $user_sql = "SELECT id FROM site_user WHERE email_address = '$email'";
    $user_result = $conn->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $site_user_id = $user_row['id'];

    // Truy vấn dữ liệu từ bảng shop_order
    $sql = "SELECT id, order_date, order_status_id, order_total, shipment_tracking_id FROM shop_order WHERE site_user_id = $site_user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Hiển thị dữ liệu trong bảng
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>#" . $row['id'] . "</td>";
            echo "<td>" . $row['order_date'] . "</td>";

            // Lấy tên trạng thái đơn hàng từ bảng order_status
            $status_sql = "SELECT status FROM order_status WHERE id = " . $row['order_status_id'];
            $status_result = $conn->query($status_sql);
            $status_name = $status_result->fetch_assoc()['status'];

            echo "<td>" . $status_name . "</td>";
            echo "<td>$" . number_format($row['order_total'], 2) . "</td>";
            echo "<td>" . $row['shipment_tracking_id'] . "</td>";
            echo "<td><a href='../../order/order-detail.php?id=" . $row['id'] . "' class='view-button'>View</a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='5'>No orders found</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>Please log in to view your orders</td></tr>";
}
?>
