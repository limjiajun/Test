<?php
$servername = "localhost";
$username = "jiajunco_cms";
$password = "6G+]EJ+x14Qz";
$dbname = "jiajunco_cmd_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    foreach ($data as $mapped_area) {
        $stmt = $conn->prepare("INSERT INTO mapped_areas (coord_perc, description) VALUES (:coord_perc, :description)");
        $stmt->bindParam(':coord_perc', $mapped_area['coord_perc']);
        $stmt->bindParam(':description', $mapped_area['description']);
        $stmt->execute();
    }

    echo json_encode(['message' => 'Mapped areas successfully saved to database.']);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
