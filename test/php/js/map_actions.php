<?php



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



$action = $_POST['action'];
$data = $_POST['data'];

switch ($action) {
    case 'insert':
        // Insert mapped area into the database
        $description = $data['description'];
        $coord_perc = $data['coord_perc'];

        $sql = "INSERT INTO mapped_areas (description, coord_perc) VALUES ('$description', '$coord_perc')";
        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        break;

    case 'update':
        // Update mapped area in the database
        $id = $data['id'];
        $description = $data['description'];
        $coord_perc = $data['coord_perc'];

        $sql = "UPDATE mapped_areas SET description='$description', coord_perc='$coord_perc' WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Record updated successfully";
        } else {
            echo "Error updating record: " . $conn->error;
        }
        break;

    case 'delete':
        // Delete mapped area from the database
        $id = $data['id'];

        $sql = "DELETE FROM mapped_areas WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        break;
}





?>