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

// Get the data from the contact form
$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$message = $_POST['message'];

// Prepare the email
$email_to = "cms@jiajun0701.com";
$subject = "New message from " . $name;
$email_body = "Name: " . $name . "\n";
$email_body .= "Phone: " . $phone . "\n";
$email_body .= "Email: " . $email . "\n";
$email_body .= "Message: " . $message . "\n";

// Send the email
$from_email = "$email"; // Replace this with your custom "From" address
$headers = "From: " . $from_email . "\r\n" .
           "Reply-To: " . $email . "\r\n";
$mail_result = mail($email_to, $subject, $email_body, $headers);

// Insert data into the database
$sql = "INSERT INTO emails (email_from, email_to, subject, message, sent_at) VALUES (?, ?, ?, ?, NOW())";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ssss", $from_email, $email_to, $subject, $message);
    $stmt->execute();
    $stmt->close();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close the database connection
$conn->close();

// Display a success or failure message based on the email sending result
// Display a success or failure message based on the email sending result
if ($mail_result) {
    echo "
        <script>
            window.location.href='index.html?status=success';
        </script>";
} else {
    echo "
        <script>
            window.location.href='index.html?status=failure';
        </script>";
}


?>
