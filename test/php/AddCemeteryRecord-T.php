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
if (isset($_POST['submit'])) {
    


    $IMAGE = $_FILES['image'];
    $img_loc = $_FILES['image']['tmp_name'];
    $img_name = $_FILES['image']['name'];
    $img_des = "../res/cemeterys/".$img_name;
    move_uploaded_file($img_loc,'../res/cemeterys/'.$img_name); 
    
    $Name_Deceased = $_POST["Name_Deceased"];
    $Years_of_Born = date('Y-m-d', strtotime($_POST['dateofbirth']));
    $Years_of_Died = date('Y-m-d', strtotime($_POST['Years_of_Died']));
    $Location = $_POST["Location"];
    $Section = $_POST["Section"];
    $Years_Buried = $_POST["Years_Buried"];


   
  

   

    $sqlinsert = "INSERT INTO `cemeteryrecord`(`Image`,`Name_Deceased`, `Years_of_Born`,`Years_of_Died`, `Location`, `Section`, `Years_Buried`) 
     VALUES ('$img_des','$Name_Deceased','$Years_of_Born','$Years_of_Died', '$Location', '$Section', '$Years_Buried')";
 
    try {
      $conn-> exec($sqlinsert);
     
          echo "<script>alert('Success')</script>";
          echo "<script>window.location.replace('ManageCemetery_admin.php')</script>";
      
  } catch (PDOException $e) {
          echo "<script>alert('Insert Failed');</script>";
          echo "<script>window.location.replace('AddCemeteryRecord.php')</script>";
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
    
    <title>Add Cemetery Record</title> 
    
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
      <h1 class="title">Add Cemetery</h1>
      <div class="content">
        <form name="AddCemeteryRecord-T.phpForm" action="AddCemeteryRecord-T.php" enctype="multipart/form-data" method="post">
          <div class="user-details">
            <div class="w3-container w3-center">
              <img class="w3-image" src="../images/useravatar.png" style="height:100%;width:100px">
              <input type="file" name="image" id="" onchange="previewFile()">
            </div>
            <div class="input-box">
              <label class="details"><b>Name_Deceased</b></label>
              <input type="text" name="Name_Deceased" id="idName_Deceased" placeholder="Name_Deceased" required>
            </div>
            <div class="input-box">
              <label class="details">Years_Buried</label>
              <input type="text" name="Years_Buried" id="idYears_Buried" placeholder="Years_Buried" required>
            </div>
            <p>
              <label><b>Years_of_Born</b></label>
<input type="date" name="dateofbirth" class="form-control" onchange="calculateYearsBuried()" />
            </p>
            <p>
              <label><b>Years_of_Died</b></label>
<input type="date" name="Years_of_Died" class="form-control" onchange="calculateYearsBuried()" />
            </p>
            
            <div class="input-box3">
              <label><b>Section</b></label>
              <p>
                <select class="form-control form-control-sm" id="small-select" name="Section">
                  <option value="Select" selected>Select</option>
                  <option value="A">A</option>
                  <option value="B">B</option>
                   <option value="C">C</option>
                  <option value="D">D</option>
                </select>
              </p>
            </div>
            <p>
              <label><b>Location</b></label>
              <textarea class="w3-input w3-border w3-round" rows="3" width="100%" name="Location" id="idLocation" placeholder="Enter your Location" required="" style="width: 651px; height: 58px;"></textarea>
            </p>
          </div>
          <div class="button">
                  <input type="submit" name="submit"  value="Submit">
                </div>
        </form>
            </div>
          </div>
    

  
    </section>


    <script src="../php/js/script.js"></script>
    <script src = "js/preview.js"></script>
    <script>
  function calculateYearsBuried() {
    const dateOfBirthInput = document.querySelector('input[name="dateofbirth"]');
    const dateOfDiedInput = document.querySelector('input[name="Years_of_Died"]');
    const yearsBuriedInput = document.querySelector('input[name="Years_Buried"]');

    const dateOfBirth = new Date(dateOfBirthInput.value);
    const dateOfDied = new Date(dateOfDiedInput.value);

    if (dateOfBirth && dateOfDied && dateOfDied > dateOfBirth) {
      const yearsBuried = dateOfDied.getFullYear() - dateOfBirth.getFullYear();
      yearsBuriedInput.value = yearsBuried;
    } else {
      yearsBuriedInput.value = "";
    }
  }
</script>
            
</div>




</body>
</html>