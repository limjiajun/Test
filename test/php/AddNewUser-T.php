
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
$image_path = isset($_SESSION['Image']) ? $_SESSION['Image'] : 'default_image_path'; // Replace 'default_image_path' with the path to your default image
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null; // Retrieve user_id from the session

if ($user_id) {
    $stmt = $conn->prepare("SELECT Image, First_name, Last_name FROM user_profile WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $image_path = $row['Image'];
        $First_name = $row['First_name'];
        $Last_name = $row['Last_name'];
    } else {
        $image_path = 'Not Available';
        $First_name = 'Not Available';
        $Last_name = 'Not Available';
    }
} else {
    $image_path = 'Not Available';
    $First_name = 'Not Available';
    $Last_name = 'Not Available';
}

if (isset($_POST['New'])) {
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
  }else{
      $user_type = 'user';
  }


    $sqlinsert = "INSERT INTO `user_profile`(`Image`,`First_name`, `Last_name`, `Gender`,  `Email`, `Password`, `Phone_Number`, `Home_Address`, `otp`, `user_type`) 
    VALUES ('$img_des','$First_name ','$Last_name','$Gender','$Email','$Password','$Phone_Number','$Home_Address','$otp','$user_type')";


 
    try {
      $conn-> exec($sqlinsert);
     
      
        
          echo "<script>alert('Success')</script>";
          echo "<script>window.location.replace('AddNewUser-T.php')</script>";
      
  } catch (PDOException $e) {
          echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('AddNewUser-T.php')</script>";
  }    
}



?>





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
    
    <title>Add New User</title> 
    
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
.home {
    display: flex;
    justify-content: center;
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
                        <a href="dashboardadminpage.php">
                            <i class='bx bx-home-alt icon' ></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="ManageProfile_admin.php">
                            <i class='bx bxs-user-rectangle icon' ></i>
                            <span class="text nav-text">Manage Profile</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="ManageCemetery_admin.php">
                            <i class='bx bx-first-aid icon'></i>
                            <span class="text nav-text">Manage Cemetery</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="ManageMap.php">
                            <i class='bx bx-table icon' ></i>
                            <span class="text nav-text">Manage Map</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="rating.php">
                            <i class='bx bx-heart icon' ></i>
                            <span class="text nav-text">Manage Feedback</span>
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

            <div class="title">Add New Users</div>
            <div class="content">
              <form name="AddNewUser-TForm" action="AddNewUser-T.php" enctype="multipart/form-data" method="post" >
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
                    <input  type="Password" name="Password" id="idPassword"
                                    placeholder="Enter your password" required>
                  </div>
                  <div class="input-box">
                    <span class="details">Confirm Password</span>
                    <input type="Password" name="Password" id="idreenterpassword"
                                    placeholder="Confirm your password" required>
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
                  <input type="submit" name="New"  value="New">
                </div>
                
              </form>
            </div>
          </div>
    

  
    </section>


    <script src="../php/js/script.js"></script>
    <script src = "js/preview.js"></script>
            
</div>




</body>
</html>