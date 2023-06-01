<?php

// delete_review.php

// Enable error reporting for debugging purposes
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection details
$servername = "localhost";
$username = "jiajunco_cms";
$password = "6G+]EJ+x14Qz";
$dbname = "jiajunco_cmd_db";

$conn = new mysqli($servername, $username, $password, $dbname);

/// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the review_id is provided
if (isset($_POST["review_id"])) {
    $review_id = $_POST["review_id"];

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("DELETE FROM review_table WHERE review_id = ?");
    $stmt->bind_param("i", $review_id);

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(array("status" => "success", "message" => "Review deleted successfully."));
    } else {
        echo json_encode(array("status" => "error", "message" => "Error deleting the review: " . $stmt->error));
    }

    // Close the statement and connection
    $stmt->close();
    exit();
}

?>