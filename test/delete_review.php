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

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST["review_id"])) {
    $review_id = $_POST["review_id"];

    $query = "DELETE FROM review_table WHERE review_id = ?";
    $statement = $conn->prepare($query);

    if (!$statement) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind the parameter to the statement
    if (!$statement->bind_param("i", $review_id)) {
        die("Binding parameters failed: " . $statement->error);
    }

    // Execute the statement
    if (!$statement->execute()) {
        die("Execute failed: " . $statement->error);
    }

    $result = $statement->affected_rows;

    if ($result > 0) {
        echo json_encode(array('status' => 'success', 'message' => 'Review deleted successfully.'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Failed to delete the review.', 'review_id' => $review_id));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Review ID not provided.'));
}

?>

