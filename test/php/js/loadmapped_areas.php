<?php
header('Content-Type: application/json');


// Database connection details
$servername = "localhost";
$username = "jiajunco_cms";
$password = "6G+]EJ+x14Qz";
$dbname = "jiajunco_cmd_db";
// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT id, coord_perc, description FROM mapped_areas";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $areas = array();
    while ($row = $result->fetch_assoc()) {
        $areas[] = $row;
    }
    echo json_encode(['status' => 'success', 'areas' => $areas]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No mapped areas found.']);
}

$conn->close();
?>
