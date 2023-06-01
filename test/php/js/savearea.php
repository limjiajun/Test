<?php

header('Content-Type: application/json');

// Database connection details
$servername = "localhost";
$username = "jiajunco_cms";
$password = "6G+]EJ+x14Qz";
$dbname = "jiajunco_cmd_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]));
}

$action = isset($_POST['action']) ? $_POST['action'] : null;
$data = isset($_POST['data']) ? $_POST['data'] : null;

if ($action && $data) {
    switch ($action) {
        case 'insert':
            $sql = "INSERT INTO mapped_areas (coord_perc, description) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $data['coord_perc'], $data['description']);
            $result = $stmt->execute();

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Mapped area inserted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error inserting mapped area: ' . $stmt->error]);
            }
            $stmt->close();
            break;

        case 'update':
            $sql = "UPDATE mapped_areas SET coord_perc = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $data['coord_perc'], $data['description'], $data['id']);
            $result = $stmt->execute();

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Mapped area updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error updating mapped area: ' . $stmt->error]);
            }
            $stmt->close();
            break;

        case 'delete':
            $sql = "DELETE FROM mapped_areas WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $data['id']);
            $result = $stmt->execute();

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Mapped area deleted successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Error deleting mapped area: ' . $stmt->error]);
            }
            $stmt->close();
            break;

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action specified.']);
            break;
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request. Action or data is missing.']);
}

?>