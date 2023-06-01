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


include_once("dbconnect.php");
 //`cemeteryrecord`
if (isset($_GET['cmid'])) {
    $cmid = $_GET['cmid'];

    // Prepare SQL query with join and column selection
    $sql = "SELECT c.`Grave_ID`, c.`Image`, c.`Name_Deceased`, c.`Years_of_Born`, c.`Years_of_Died`, c.`Location`, c.`Section`, c.`Years_Buried`, p.`Person_ID`, p.`Image1`, p.`Name_Deceased1`
            FROM `cemeteryrecord` AS c
            JOIN `personrecord` AS p
            ON c.`Grave_ID` = p.`Person_ID`
            WHERE c.`Grave_ID` = :cmid";

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':cmid', $cmid, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the result set as an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any rows were returned
    if (count($rows) == 0) {
        // If no rows were returned, show an error message and redirect
        echo "<script>alert('Graves not found.');</script>";
        echo "<script>window.location.replace('CemeteryList.php')</script>";
        exit();
    }
} else {
    // If the cmid parameter was not set, show an error message and redirect
    echo "<script>alert('Page Error.');</script>";
    echo "<script>window.location.replace('CemeteryList.php')</script>";
    exit();
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
    
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-3lTlkQwf9X0b0GheE1jzY8Yu2wCI4vN/4vyRi1Nfo8ScgW9pKjHCEeUUq3Yi8U6kC/6Xd5U6y5U5EIsjxyW9XQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-4vD0Rlm1yPKdK8W26X0guvCJVa0HqOYJ8sFBnEMsFtBnM3qy3/8Q2XcN9N0Rr1zZ+Sy8WCa1cJyKjTB2ze+/oA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <link rel="stylesheet" href="./assets/css/style-index.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
  
 
    .main-container {
        max-width: 1100px;
        margin: 0 auto;
        background-color: #133764;
        color: white;
    }

    .content {
        max-width: 1200px;
        margin-top: 100px;
        display: flex;
        justify-content: center;
    }

    .w3-card {
        width: 200%;
    }

    .image-container {
        width: 200%;
    }

    .header {
        background-color: #133764;
        color: white;
        width: 200%;
    }

    .table-row {
        width: 50%;
        text-align: center;
    }
   

    .icon {
        font-size: 30px;
    }
</style>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="../images/useravatar.png" alt="">
                </span>

                <div class="text logo-text">
                    <span class="name">Name</span>
                    <span class="profession">Email</span>
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
    <div class="main-container w3-container w3-padding">
        <h3>Grave Details</h3>
    </div>
    <br>

    <div class="content w3-main w3-content w3-padding">
        <div class="w3-card">
            <div class="w3-row w3-center">
                <div class="w3-half w3-container ">
                    <?php 
                    $i = 0;
                    foreach ($rows as $cemeterys) {
                        $i++;
                        $image_path = $cemeterys['Image'];
                        $cmid = $cemeterys['Grave_ID'];
                        $Name_Deceased = $cemeterys['Name_Deceased'];
                        $Years_of_Born = $cemeterys['Years_of_Born'];
                        $Years_of_Died = $cemeterys['Years_of_Died'];
                        $Location = $cemeterys['Location'];
                        $Section = $cemeterys['Section'];
                        $Years_Buried = $cemeterys['Years_Buried'];
                        
                        
                        $image_path1 = $cemeterys['Image1'];
                        $prid = $cemeterys['Person_ID'];
                        $Name_Deceased1 = $cemeterys['Name_Deceased1'];
                        
                    }
          echo "<div class='w3-padding w3-center image-container' style='display: flex; justify-content: center;'>
          <a href='$image_path' data-lightbox='cemetery-image'>
              <img class='w3-image' src='$image_path' width='150' height='70' style='border: 10px solid gold; margin-right: 40px;' onerror='this.onerror=null;this.src=\"../res/background.png\"'>
          </a> 
          <a href='$image_path1' data-lightbox='cemetery-image'>
              <img class='w3-image' src='$image_path1' width='150' height='70' style='border: 10px solid black;' onerror='this.onerror=null;this.src=\"../res/background.png\"'>
          </a>
      </div>
  </div>";



                    
                  
                    
                    echo "<br><hr>";
                    echo "<div class='w3-row'><div class='w3-half w3-container w3-center'>
                        <header class='header w3-container'><h5><b>$Name_Deceased</b></h5></header>";

                   

                    echo "<br><table class='table-row'>
                        <tr><td style='width:25%'><b>Born</b></td><td>$Years_of_Born</td></tr>
                        <tr><td style='width:25%'><b>Died</b></td><td>$Years_of_Died</td></tr>
                        <tr><td style='width:25%'><b>Location</b></td><td>$Location</td></tr>
                        <tr><td style='width:25%'><b>Section</b></td><td>$Section</td></tr></table></div>";

                    ?>
                     </div>
            </div>
        </div>
    </div>

        <br>
        
    <!-- col -->
    <!-- footer -->
<footer class="w3-row-padding w3-padding-16 w3-center w3-grey">
  <p class="copyright">
        &copy; 2023 <a href="#">Cemetery Management System</a> All right reserved
      </p>
    </footer>
        </div>
     </div>
  </div>
    

  
    </section>


    <script src="../php/js/script.js"></script>
    
            
</div>




</body>
</html>