<?php
session_start();
include_once("dbconnect.php");
include_once("access_control.php");


if (!isset($_SESSION['user_type'])) {
    echo "<script>alert('Access denied. Please login');</script>";
    echo "<script> window.location.replace('loginpage.php')</script>";
    exit;
}





$Email = isset($_SESSION['Email']) ? $_SESSION['Email'] : 'Not Available';
$First_name = isset($_SESSION['First_name']) ? $_SESSION['First_name'] : 'Not Available';
$Last_name = isset($_SESSION['Last_name']) ? $_SESSION['Last_name'] : 'Not Available';
$image_path = isset($_SESSION['Image']) ? $_SESSION['Image'] : 'default_image_path';
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

$Gender = isset($_SESSION['Gender']) ? $_SESSION['Gender'] : 'Not Available';
$Password = isset($_SESSION['Password']) ? $_SESSION['Password'] : 'Not Available';
$Phone_Number = isset($_SESSION['Phone_Number']) ? $_SESSION['Phone_Number'] : 'Not Available';
$Home_Address= isset($_SESSION['Home_Address']) ? $_SESSION['Home_Address'] : 'Not Available';


if ($user_id) {
    $stmt = $conn->prepare("SELECT Image, First_name, Last_name, Gender, Email, Password, Phone_Number, Home_Address FROM user_profile WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $image_path = $row['Image'];
        $First_name = $row['First_name'];
        $Last_name = $row['Last_name'];
        
         $Gender = $row['Gender'];
        $Password = $row['Password'];
        $Phone_Number = $row['Phone_Number'];
         $Home_Address = $row['Home_Address'];
    } else {
        $image_path = 'Not Available';
        $First_name = 'Not Available';
        $Last_name = 'Not Available';
        
          $Gender = 'Not Available';
         $Password = 'Not Available';
       $Phone_Number = 'Not Available';
         $Home_Address = 'Not Available';
    }
} else {
    $image_path = 'Not Available';
    $First_name = 'Not Available';
    $Last_name = 'Not Available';
    
      $Gender = 'Not Available';
         $Password = 'Not Available';
       $Phone_Number = 'Not Available';
         $Home_Address = 'Not Available';
}   
       
//SELECT `user_id`, `Image`, `First_name`, `Last_name`, `Gender`, `Email`, `Password`, `Phone_Number`, `Home_Address`, 
//`otp`, `resettoken`, `resettokenexp`, `user_type` FROM `user_profile` WHERE 1
       

 /*if (isset($_POST['Update'])) {
    include_once("dbconnect.php");

    

    $IMAGE = $_FILES['image'];
    $img_loc = $_FILES['image']['tmp_name'];
    $img_name = $_FILES['image']['name'];
    $img_des = "../res/users/".$img_name;
    move_uploaded_file($img_loc,'../res/users/'.$img_name);

   $First_name  = mysqli_real_escape_string($conn, $_POST["First_name"]);
$Last_name = mysqli_real_escape_string($conn, $_POST["Last_name"]);
$Gender = mysqli_real_escape_string($conn, $_POST["Gender"]);
$Email  = mysqli_real_escape_string($conn, $_POST["Email"]);
$Phone_Number = mysqli_real_escape_string($conn, $_POST['Phone_Number']);
$Home_Address = mysqli_real_escape_string($conn, $_POST['Home_Address']);
  

  

    // Update query
    $sqlupdate = "UPDATE `user_profile` SET `Image`='$img_des', `First_name`='$First_name', `Last_name`='$Last_name', `Gender`='$Gender',
    `Email`='$Email',`Phone_Number`='$Phone_Number', `Home_Address`='$Home_Address' WHERE `user_id`='$user_id'";

    try {
        $conn->exec($sqlupdate);
        
        echo "<script>alert('Update successful')</script>";
        echo "<script>window.location.replace('Profile_user.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Update failed')</script>";
        echo "<script>window.location.replace('dashboarduserpage.php')</script>";
    }
}*/
if (isset($_POST['Update'])) {
    include_once("dbconnect.php");

    if (!empty($_FILES['image']['name'])) {
        $IMAGE = $_FILES['image'];
        $img_loc = $_FILES['image']['tmp_name'];
        $img_name = $_FILES['image']['name'];
        $img_des = "../res/users/" . $img_name;

        if ($IMAGE['error'] === UPLOAD_ERR_OK) {
            $info = getimagesize($img_loc);
            if ($info !== false) {
                if (move_uploaded_file($img_loc, $img_des)) {
                    // Update image query
                    $sqlupdate_image = "UPDATE `user_profile` SET `Image`=:img_des WHERE `user_id`=:user_id";

                    try {
                        $stmt = $conn->prepare($sqlupdate_image);
                        $stmt->bindParam(':img_des', $img_des);
                        $stmt->bindParam(':user_id', $user_id);
                        $stmt->execute();
                    } catch (PDOException $e) {
                        echo "<script>alert('Image update failed')</script>";
                        echo "<script>window.location.replace('dashboarduserpage.php')</script>";
                        exit;
                    }
                } else {
                    echo "<script>alert('Failed to move uploaded file')</script>";
                    echo "<script>window.location.replace('dashboarduserpage.php')</script>";
                    exit;
                }
            } else {
                echo "<script>alert('Not an image file')</script>";
                echo "<script>window.location.replace('dashboarduserpage.php')</script>";
                exit;
            }
        } else {
            echo "<script>alert('File upload error')</script>";
            echo "<script>window.location.replace('dashboarduserpage.php')</script>";
            exit;
        }
    }

    $First_name = $_POST["First_name"];
    $Last_name = $_POST["Last_name"];
    $Gender = $_POST["Gender"];
    $Email = $_POST["Email"];
    $Phone_Number = $_POST['Phone_Number'];
    $Home_Address = $_POST['Home_Address'];

    // Update other data query
    $sqlupdate_data = "UPDATE `user_profile` SET `First_name`=:First_name, `Last_name`=:Last_name, `Gender`=:Gender,
    `Email`=:Email,`Phone_Number`=:Phone_Number, `Home_Address`=:Home_Address WHERE `user_id`=:user_id";

    try {
        $stmt = $conn->prepare($sqlupdate_data);
        $stmt->bindParam(':First_name', $First_name);
        $stmt->bindParam(':Last_name', $Last_name);
        $stmt->bindParam(':Gender', $Gender);
        $stmt->bindParam(':Email', $Email);
        $stmt->bindParam(':Phone_Number', $Phone_Number);
        $stmt->bindParam(':Home_Address', $Home_Address);
        $stmt->bindParam(':user_id', $user_id);

        $stmt->execute();

        echo "<script>alert('Update successful')</script>";
        echo "<script>window.location.replace('Profile_user.php')</script>";
    } catch (PDOException $e) {
        echo "<script>alert('Update failed')</script>";
        echo "<script>window.location.replace('dashboarduserpage.php')</script>";
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../css/dashboard-style.css">
   
    <!----===== Boxicons CSS ===== -->
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    
    <title>Dashboard Sidebar Menu</title> 
    
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
    <link href="../css/style.css" rel="stylesheet"/>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@600&display=swap"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./assets/css/style-index.css">
    <link rel="stylesheet" href="./css/style-page.css">
    <link rel="stylesheet" href="../css/style1.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />

<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>


  <style>
  .td {
    text-align: center;
  }

  .table,td, th {
    border: 1px solid black;
  }
</style>
<style>
  .pagination {
  display: flex;
  justify-content: center;
}

.pagination-list {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0;
}

.pagination-item {
  margin-right: 0.5rem;
}

.pagination-item:last-child {
  margin-right: 0;
}

.pagination-item a {
  display: block;
  padding: 0.5rem;
  border-radius: 0.25rem;
  text-decoration: none;
  color: #333;
  background-color: #fff;
  border: 1px solid #ccc;
}

.pagination-item.active a {
  color: #fff;
  background-color: #333;
}
.body {
  font-family: Arial, sans-serif;
  line-height: 1.6;
}

.container {
  width: 800px;
  margin: 0 auto;
}

.title {
  font-size: 2rem;
  text-align: center;
  margin-bottom: 1rem;
}

.label {
  display: block;
  font-weight: bold;
  margin-bottom: 0.5rem;
}

.input[type="text"],
.input[type="date"],
.textarea {
  padding: 0.5rem;
  font-size: 1rem;
  border-radius: 0.25rem;
  border: 1px solid lightgray;
  
   width: 100%;
  box-sizing: border-box;
  margin-top: 0.5rem;
  margin-bottom: 1rem;
}

.form-control-sm {
  height: 30px;
  width: 200px;
}

.user-details {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
}

.w3-container {
  margin-bottom: 1rem;
}

.input-box,
.input-box3 {
  flex-basis: 48%;
  margin-bottom: 1rem;
}

input[type="file"] {
  margin-top: 1rem;
}

@media screen and (max-width: 767px) {
  .input-box,
  .input-box3 {
    flex-basis: 100%;
  }
}
  
</style>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
    <span class="image">
<img src="<?php echo $image_path; ?>" alt="" width="70" height="70">

    </span>
</div>

                <div class="text logo-text">
  <span class="name"><?php echo $Email ?></span>
  <span class="profession"><?php echo $First_name . ' ' . $Last_name ?></span>
</div>
            </div>
            
            <i class='bx bx-chevron-right toggle'></i>
        </header>

              <div class="menu-bar">
            <div class="menu">

                <li class="search-box">
                    <i class='bx bx-search icon'></i>
                    <input type="text" placeholder="Search...">
                </li>

                <ul class="menu-links">
                    <li class="nav-link">
                        <a href="dashboarduserpage.php">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="Profile_user.php">
                            <i class='bx bxs-user-rectangle icon' ></i>
                            <span class="text nav-text">Profile</span>
                        </a>
                    </li>
                    <li class="nav-link">
                       <a href="CemeteryList.php">
                            <i class='bx bx-list-ul icon'></i>
                            <span class="text nav-text">Cemetery List</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="CemeteryTable.php">
                            <i class='bx bx-table icon' ></i>
                            <span class="text nav-text">Cemetery Table</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="rating_user.php">
                            <i class='bx bxs-edit icon' ></i>
                            <span class="text nav-text">Feedback</span>
                        </a>
                    </li>
                     <li class="nav-link">
                        <a href="mapA_user.php">
                            <i class='bx bxs-map icon' ></i>
                            <span class="text nav-text">Map</span>
                        </a>
                    </li>

                </ul>
            </div>

            <div class="bottom-content">
                <li class="">
                    <a href="loginpage.php">
                        <i class='bx bx-log-out icon' ></i>
                        <span class="text nav-text">Logout</span>
                    </a>
                </li>

                <li class="mode">
                    <div class="sun-moon">
                        <i class='bx bx-moon icon moon'></i>
                        <i class='bx bx-sun icon sun'></i>
                    </div>
                    <span class="mode-text text">Dark mode</span>

                    <div class="toggle-switch">
                        <span class="switch"></span>
                    </div>
                </li>
                
            </div>
        </div>

    </nav>

     <section class="home">
    <div class="container">
      <div class="title">Profile</div>
    <div class="content">
      <form name="Profile_user.php" action="Profile_user.php" enctype="multipart/form-data" method="post" >
        <div class="user-details">
           <div class="w3-container w3-center">
        
        <img class="w3-image" src="<?php echo $image_path; ?>" style="height:100%;width:100px" onerror="this.src='../images/useravatar.png'">
          <input type="file" name="image" id= "" onchange="previewFile()">
    </div>
        
        
                     
      
        
        
            
                 
          <div class="input-box">
            <span class="details">First Name</span>
<input type="text" name="First_name" id="idfirstname" value="<?php echo $First_name ?>" placeholder="First_name" required>          </div>
          <div class="input-box">
            <span class="details">Last Name</span>
    <input type="text" name="Last_name" id="idlastname" value="<?php echo $Last_name ?>" placeholder="Last_name" required>
          </div>
        
<div class="input-box2" >
  <label><b>Gender</b></label>
  <p>
        <select class="form-control form-control-sm" id="small-select" name="Gender">
            <option value="Select" <?php if ($Gender == "Select") echo ' selected="selected"'; ?>>Select</option>
                            <option value="Male" <?php if ($Gender == "Male") echo ' selected="selected"'; ?>>Male</option>
                            <option value="Female" <?php if ($Gender== "Female") echo ' selected="selected"'; ?>>Female</option>
        </select>
    </p>
</div>
        
       
          <div class="input-box">
            <span class="details">Email</span>
            <input type="Email" name="Email" id="idEmail" value="<?php echo $Email ?>" placeholder="Enter your Email" required>
          </div>
          
          
         
          <div class="input-box">
            <span class="details">Phone Number</span>
            <input type="Phone_Number" name="Phone_Number" id="idphonenumber" value="<?php echo $Phone_Number ?>"
                            placeholder="Enter your phone number" required>
          </div>
          <p>
                        <label><b>Home Address</b></label>
        <textarea class="w3-input w3-border w3-round" rows="3" width="100%" name="Home_Address" id="idHome_Address"
        placeholder="Enter your home address" required="" style="width: 651px; height: 58px;"><?php echo $Home_Address ?></textarea></textarea>
</p>
                  
        </div>
        
        <div class="button">
          <input type="submit" name="Update"  value="Update">
          

        </div>
        </form>
            </div>
          </div>
    

  
    </section>


    <script src="../php/js/script.js"></script>
    <script src = "js/preview.js"></script>

      <script>
        function previewFile() {
            const preview = document.querySelector('.w3-image');
            const file = document.querySelector('input[type=file]').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function () {
                // convert image file to base64 string
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>      
</div>




</body>
</html>