<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '/home2/jiajunco/public_html/book/PHPMailer/src/Exception.php';
require '/home2/jiajunco/public_html/book/PHPMailer/src/PHPMailer.php';
require '/home2/jiajunco/public_html/book/PHPMailer/src/SMTP.php';



if (isset($_POST['Register'])) {
    include_once("dbconnect.php");

    $IMAGE = $_FILES['image'];
    $img_loc = $_FILES['image']['tmp_name'];
    $img_name = $_FILES['image']['name'];
    $img_des = "../res/users/".$img_name;
    move_uploaded_file($img_loc,'../res/users/'.$img_name);

    $First_name  = $_POST["First_name"];
    $Last_name = $_POST["Last_name"];
    $Gender = $_POST["Gender"];
    $Email  = $_POST["Email"];
    $Password = sha1($_POST["Password"]);
    $Phone_Number = $_POST['Phone_Number'];
    $Home_Address = $_POST['Home_Address'];
    $otp = rand(10000,99999);




    if(!empty($_POST['user_type']) && in_array($_POST['user_type'], ['admin','user'])){
        $user_type = $_POST['user_type'];
    } else {
        $user_type = 'user';
    }

    $sqlinsert = "INSERT INTO `user_profile`(`Image`,`First_name`, `Last_name`, `Gender`, `Email`, `Password`, `Phone_Number`, `Home_Address`, `otp`, `user_type`) 
    VALUES ('$img_des','$First_name','$Last_name','$Gender','$Email','$Password','$Phone_Number','$Home_Address','$otp','$user_type')";

    try {
        $conn->exec($sqlinsert);
        sendMail($Email, $otp);

        echo "<script>alert('Success')</script>";
        echo "<script>window.location.replace('loginpage.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('re.php')</script>";
    }    
}


function sendMail($Email,$otp){
    $mail = new PHPMailer(true);
     try {
    $mail->SMTPDebug = 0;                                               //Disable verbose debug output
    $mail->isSMTP();                                                    //Send using SMTP
    $mail->Host       = 'mail.jiajun0701.com';                          //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                           //Enable SMTP authentication
    $mail->Username   = 'cms@jiajun0701.com';  
    $mail->Password   = '7~o{F}Iy{M[w';                                 //7~o{F}Iy{M[w
    $mail->SMTPSecure = 'tls';         
    $mail->Port       = 587;
    $from = "cms@jiajun0701.com";
    $to = $Email;
    $subject = 'CMS - Please verify your account';
    $message = "<h2>Welcome to Cemetery Management System</h2> <p>Thank you for registering your account with us. To complete your registration please click the following.<p>
    <p><button><a href ='http://jiajun0701.com/test/php/verify.php?Email=$Email&otp=$otp'>Verify Here</a></button>";
    
    $mail->setFrom($from,"CMS Admin");
    $mail->addAddress($to);                                             //Add a recipient
    
    //Content
    $mail->isHTML(true);                                                //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $message;
    $mail->send();
                return true;
        } catch (Exception $e) {
                return false;
        }
    }
?>


 <!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Account</title>
    <link rel="stylesheet" href="../css/style1.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@600&display=swap" rel="stylesheet"/>
    
    <script src = "./js/preview.js"></script>
  </head>


  <body>
    
    
    
    
 
  
    
    
  <div class="container">
      
    <div class="title">Registration</div>
    <div class="content">
        
      <form name="registrationForm" action="re.php" enctype="multipart/form-data" method="post" onsubmit="return validateForm()">
    

        <div class="user-details">
           <div class="w3-container w3-center">

                <img class="w3-image" src="../images/useravatar.png" style="height:100%;width:100px">
                      <input type="file" name="image" id= "" onchange="previewFile()">                 
        

                    </div>
            
                   
        
        
          <div class="input-box">
            <span class="details">First Name</span>
            <input  type="First_name" name="First_name" id="idfirstname" placeholder="First_name" required>
          </div>
          <div class="input-box">
            <span class="details">Last Name</span>
            <input type="Last_name" name="Last_name"  id = "idlastname" placeholder="Last_name" required>
          </div>
        
<div class="input-box2" >
  <label><b>Gender</b></label>
  <p> 
    <select class="form-control form-control-sm" id="small-select"name="Gender"> 
      <option value="Select" selected>Select</option>
      <option value="Male">Male</option>
      <option value="Female">Female</option>
    </select>
  </p>
</div>
        
       
          <div class="input-box">
            <span class="details">Email</span>
            <input type="Email" name="Email" id="idEmail" placeholder="Enter your Email" required>
          </div>
          
          <div class="input-box">
    <span class="details">Password</span>
    <input type="Password" name="Password" id="idPassword" placeholder="Enter your password" title="Password must be at least 8 characters, contain at least one lowercase letter, one uppercase letter, and one number" required>
</div>

          <div class="input-box">
            <span class="details">Confirm Password</span>
            <input type="Password" name="Password" id="idreenterpassword"
                            placeholder="Confirm your password" title="Password must be at least 8 characters, contain at least one lowercase letter, one uppercase letter, and one number" required>
          </div>

          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="Phone_Number" name="Phone_Number" id="idphonenumber"
                            placeholder="Enter your phone number" required>
          </div>
          <p>
                        <label><b>Home Address</b></label>
        <textarea class="w3-input w3-border w3-round" rows="3" width="100%" name="Home_Address" id="idHome_Address" 
        placeholder="Enter your home address" required="" style="width: 651px; height: 58px;"></textarea>
</p>
                  
        </div>
        
        <div class="button">
          <input type="submit" name="Register"  value="Register">
        </div>
         <div class="w3-center"> <p>Already register?? <a href="loginpage.php"><b>Back to LOGIN</b> </a></p></div>
      </form>

    </div>
  </div>
 <script>
    function validateEmail(email) {
      var re = /^[\w-]+(\.[\w-]+)*@([\w-]+\.)+[a-zA-Z]{2,7}$/;
      return re.test(email);
    }

    function validatePassword(password) {
      var hasLowerCase = /[a-z]/.test(password);
      var hasUpperCase = /[A-Z]/.test(password);
      var hasNumber = /\d/.test(password);
      var hasValidLength = password.length >= 8;

      return hasLowerCase && hasUpperCase && hasNumber && hasValidLength;
    }

    function validateForm() {
      let firstName = document.getElementById("idfirstname").value;
      let lastName = document.getElementById("idlastname").value;
      let email = document.getElementById("idEmail").value;
      let password = document.getElementById("idPassword").value;
      let confirmPassword = document.getElementById("idreenterpassword").value;
      let phoneNumber = document.getElementById("idphonenumber").value;
      let homeAddress = document.getElementById("idHome_Address").value;
      let gender = document.getElementById("small-select").value;

      // Validate first name
      if (firstName == "") {
        alert("First name must be filled out");
        return false;
      }

      // Validate last name
      if (lastName == "") {
        alert("Last name must be filled out");
        return false;
      }

      // Validate email format
      if (!validateEmail(email)) {
        alert("Please enter a valid email");
        return false;
      }

      // Validate password strength
      if (!validatePassword(password)) {
        alert("Password must be at least 8 characters, contain at least one lowercase letter, one uppercase letter, and one number");
        return false;
      }

      // Validate confirm password
      if (confirmPassword == "") {
        alert("Confirm password must be filled out");
        return false;
      }

      // Validate phone number
      if (phoneNumber == "") {
        alert("Phone number must be filled out");
        return false;
      }

      // Validate home address
      if (homeAddress == "") {
        alert("Home address must be filled out");
        return false;
      }

      // Validate gender
      if (gender == "Select") {
        alert("Gender must be selected");
        return false;
      }

      // Check if password and confirm password match
      if (password !== confirmPassword) {
        alert("Passwords do not match");
        return false;
      }

      return true;
    }
  </script>
</body>
</html>
