<?php
header('Content-Type: application/json');

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Connect to the database
    $conn = new mysqli('localhost', 'username', 'password', 'database');

    if ($conn->connect_error) {
        die('Connection failed: ' . $conn->connect_error);
    }

    $stmt = $conn->prepare('SELECT id, name FROM products WHERE name LIKE ?');
    $searchTerm = '%' . $conn->real_escape_string($query) . '%';
    $stmt->bind_param('s', $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([]);
}
?>
