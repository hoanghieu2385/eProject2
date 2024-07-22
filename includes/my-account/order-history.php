<?php
// Kiểm tra xem người dùng đã đăng nhập chưa
if (isset($_SESSION['login']) && $_SESSION['login'] === true) {
    $email = $_SESSION['user_email'];
    $user_sql = "SELECT id FROM site_user WHERE email_address = '$email'";
    $user_result = $conn->query($user_sql);
    $user_row = $user_result->fetch_assoc();
    $site_user_id = $user_row['id'];

    // Determine the number of orders per page and the current page
    $ordersPerPage = 10;
    $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
    $offset = ($currentPage - 1) * $ordersPerPage;

    // Truy vấn dữ liệu từ bảng shop_order
    $sql = "SELECT id, order_date, order_status_id, order_total, shipment_tracking_id FROM shop_order WHERE site_user_id = $site_user_id ORDER BY id DESC LIMIT $ordersPerPage OFFSET $offset";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Hiển thị dữ liệu trong bảng
        echo "<table class='order-table'>";
        echo "<thead>
            <tr>
            <th>Order</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
            <th>Shipment tracking id</th>
            <th></th>
            </tr>
        </thead>";
        echo "<tbody>";
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
        echo "</tbody>";

        // Fetch the total number of orders for the user
        $totalOrdersQuery = "SELECT COUNT(*) as total FROM shop_order WHERE site_user_id = $site_user_id";
        $totalOrdersResult = $conn->query($totalOrdersQuery);
        $totalOrdersData = $totalOrdersResult->fetch_assoc();
        $totalOrders = $totalOrdersData['total'];
        $totalPages = ceil($totalOrders / $ordersPerPage);

        // Display the pagination links
        echo "<tfoot>
        <tr>
            <td colspan='12' class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            echo "<a href='?section=order-History&page=$i'>$i</a> ";
        }
        echo "</td>
        </tr>
        </tfoot>";
        echo "</table>";
    } else {
        echo "<tr><td colspan='5'>No orders found</td></tr>";
    }
} else {
    echo "<tr><td colspan='5'>Please log in to view your orders</td></tr>";
}
