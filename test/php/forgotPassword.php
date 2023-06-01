<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home2/jiajunco/public_html/book/PHPMailer/src/Exception.php';
require '/home2/jiajunco/public_html/book/PHPMailer/src/PHPMailer.php';
require '/home2/jiajunco/public_html/book/PHPMailer/src/SMTP.php';
include_once("dbconnect.php");

function sendmail($Email,$reset_token){
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'mail.jiajun0701.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'cms@jiajun0701.com';
        $mail->Password   = '7~o{F}Iy{M[w';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('cms@jiajun0701.com');
        $mail->addAddress($Email);

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset link form Aatmaninfo';
        $mail->Body = "
    <html>
    <body>
        <p>
            We got a request from you to reset your password!
            <br>
            Click the link below:
            <br>
            <a href='http://jiajun0701.com/test/php/updatePassword.php?Email=$Email&reset_token=$reset_token'>Reset Password</a>
        </p>
    </body>
    </html>
";



        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

if (isset($_POST['send-link'])) {
    $Email = $_POST['Email'];

    $sql = "SELECT * FROM `user_profile` WHERE Email = :Email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Email', $Email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        $reset_token = bin2hex(random_bytes(16));
        date_default_timezone_set('Asia/kolkata');
        $date = date("Y-m-d");

        $sql = "UPDATE `user_profile` SET resettoken = :reset_token, resettokenexp = :date WHERE Email = :Email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':reset_token', $reset_token);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':Email', $Email);

        if ($stmt->execute() && sendmail($Email,$reset_token)) {
            echo "
                <script>
                    alert('Password reset link sent to email.');
                    window.location.href='index.php'    
                </script>"; 
        } else {
            echo "
                <script>
                    alert('Something went wrong.');
                    window.location.href='forgotPassword.php'
                </script>";
        }
    } else {
        echo "
            <script>
                alert('Email Address Not Found');
                window.location.href='forgotPassword.php'
            </script>";
    }   
}
?>

    <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <div class="container d-flex justify-content-center mt-5 pt-5">
        <div class="card mt-5" style="width:500px">
            <div class="card-header">
                <h1 class="text-center">Forgot Password</h1>
            </div>
            <div class="card-body">
                <form action="forgotPassword.php" method="post">
                    <div class="mt-4">
                         <label><b>Email</b></label>
                        <input class="w3-input w3-round-xxlarge w3-border" type="Email" name="Email" id="idEmail"
                            placeholder="Enter your Email" required>
                    </div>
                    <div class="mt-4 text-end">
                        <input type="submit" name="send-link" class="btn btn-primary">
                        <a href="loginpage.php" class="btn btn-danger">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>