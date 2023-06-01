<?php
$servername = "localhost";
$username = "jiajunco_cms";
$password = "6G+]EJ+x14Qz";
$dbname = "jiajunco_cmd_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $sql . "<br>" . $e->getMessage();
}
?>