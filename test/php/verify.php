<?php
include 'dbconnect.php';

if (isset($_GET['Email']) && isset($_GET['otp'])) {
    $Email = $_GET['Email'];
    $otp = $_GET['otp'];

    // Check if the OTP matches the one in the database
    $sql = "SELECT * FROM user_profile WHERE Email = :Email AND otp = :otp";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Email', $Email);
    $stmt->bindParam(':otp', $otp);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        // Update the OTP to '1' in the database
        $sqlUpdate = "UPDATE user_profile SET otp = '1' WHERE Email = :Email";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bindParam(':Email', $Email);
        $stmtUpdate->execute();

        echo "Your account has been verified successfully. You can now log in.";
               echo "<script> window.location.replace('loginpage.php')</script>";

    } else {
        echo "Invalid verification link or the account has already been verified.";
               echo "<script> window.location.replace('re.php')</script>";

    }
} else {
    echo "Invalid request. Please use the verification link sent to your email.";

}
?>


