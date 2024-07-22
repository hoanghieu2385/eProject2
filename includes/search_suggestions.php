<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project2";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the search query from the GET request
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Prepare the SQL statement to search for albums and artists
$sql = "SELECT 'album' as type, p.id, p.album as name, p.product_image as image, p.current_price as price, a.full_name as artist 
        FROM product p 
        JOIN artist a ON p.artist_id = a.id 
        WHERE p.album LIKE ?
        UNION
        SELECT 'artist' as type, a.id, a.full_name as name, NULL as image, NULL as price, NULL as artist 
        FROM artist a
        WHERE a.full_name LIKE ?
        LIMIT 10";

$stmt = $conn->prepare($sql);
$searchTerm = "%$query%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$suggestions = array();
while ($row = $result->fetch_assoc()) {
    $suggestions[] = array(
        'type' => $row['type'],
        'id' => $row['id'],
        'name' => $row['name'],
        'image' => '../uploads/' . $row['image'],
        'price' => $row['price'],
        'artist' => $row['artist']
    );
}

// Return the results as JSON
header('Content-Type: application/json');
echo json_encode($suggestions);

$stmt->close();
$conn->close();
