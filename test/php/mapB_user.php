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




$sqlproduct = "SELECT * FROM user_profile";
$stmt = $conn->prepare($sqlproduct);
$stmt->execute();





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
    <linkrel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link
      href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@600&display=swap" rel="stylesheet"/>


<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>



 <title>Mapping</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./script_mapA.js"></script>
    
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/rwdImageMaps/1.6/jquery.rwdImageMaps.min.js"></script>
  
    
    <!-- Custom Css -->
    <style>
         :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }
        
        html,
        body {
            height: 100%;
            width: 100%;
            font-family: Apple Chancery, cursive;
        }
        
        #fp-canvas-container {
            height: 65vh;
            width: calc(100%);
            position: relative;
        }
        
        .fp-img,
        .fp-canvas,
        .fp-canvas-2 {
            position: absolute;
            width: calc(100%);
            height: calc(100%);
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        #fp-map {
            position: absolute;
            width: calc(100%);
            height: calc(100%);
            top: 0;
            left: 0;
            z-index: 1;
        }
        
        .fp-canvas {
            z-index: 2;
            background: #0000000d;
            cursor: crosshair;
        }
        
        #fp-map {
            z-index: 2;
        }
        
        area {
            position: absolute;
        }
        
        area:hover {
            background: #cbcbcb0f;
        }
        
        #save,
        #cancel {
            display: none;
        }
    </style>
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

   

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient" id="topNavBar">
  <div class="container">
    <a class="navbar-brand" href="">
      Map Area 
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
         <a class="nav-link" href="mapA_user.php">Block A</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapB_user.php">Block B</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapC_user.php">Block C</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapD_user.php">Block D</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

 <div class="container py-3" id="page-container">
  <h3>Dynamically Map Area on an Image</h3>
  <hr>
<!-- Image Map Generated by http://www.image-map.net/ -->
<img src="https://jiajun0701.com/test/res/maps/map_B%20%281%29.png" usemap="#image-map">

<map name="image-map">
 
    <area target="_blank" alt="Noel_H_T_Frost" title="Noel_H_T_Frost" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=11" coords="99,29,125,43" shape="rect">
    <area target="_blank" alt="Cpl W C Byde" title="Cpl W C Byde" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=12" coords="196,31,226,46" shape="rect">
    <area target="_blank" alt="WO F. Cain" title="WO F. Cain" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=13" coords="239,29,271,45" shape="rect">
    <area target="_blank" alt="Corp R. Carus" title="Corp R. Carus" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=14" coords="384,31,411,44" shape="rect">
    <area target="_blank" alt="R. C. F. Cooper" title="R. C. F. Cooper" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=15" coords="414,28,440,45" shape="rect">
    <area target="_blank" alt="Hiepke ?an Crommers" title="Hiepke ?an Crommers" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=16" coords="483,29,511,44" shape="rect">
    <area target="_blank" alt="Michael Vaughan Curtis" title="Michael Vaughan Curtis" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=17" coords="527,29,570,45" shape="rect">
    <area target="_blank" alt="Zuxin Dai" title="Zuxin Dai" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=18" coords="98,43,128,58" shape="rect">
    <area target="_blank" alt="Joseph Dass" title="Joseph Dass" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=19" coords="196,47,226,59" shape="rect">
    <area target="_blank" alt="David Anthony Dass" title="David Anthony Dass" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=20" coords="242,46,269,58" shape="rect">
    <area target="_blank" alt="Ghin Hye Tan" title="Ghin Hye Tan" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=51" coords="315,46,339,59" shape="rect">
    <area target="_blank" alt="Ghin Chong Tan" title="Ghin Chong Tan" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=52" coords="340,44,367,56" shape="rect">
    <area target="_blank" alt="Maria F.F Mathieu Stewart" title="Maria F.F Mathieu Stewart" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=53" coords="384,45,412,58" shape="rect">
    <area target="_blank" alt="Molly Alice Eckersall Toolseram" title="Molly Alice Eckersall Toolseram" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=54" coords="413,45,440,57" shape="rect">
    <area target="_blank" alt="Capt Stephen Charles Toolseram" title="Capt Stephen Charles Toolseram" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=55" coords="456,43,484,57" shape="rect">
    <area target="_blank" alt="Kanagasabapathy Vanniasingham" title="Kanagasabapathy Vanniasingham" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=56" coords="484,45,510,58" shape="rect">
    <area target="_blank" alt="John Charles William Weber" title="John Charles William Weber" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=57" coords="31,57,53,70" shape="rect">
    <area target="_blank" alt="Nathan Kesagar Vanniasingham" title="Nathan Kesagar Vanniasingham" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=58" coords="55,57,82,72" shape="rect">
    <area target="_blank" alt="Lucy Nallammah Vanniasingham" title="Lucy Nallammah Vanniasingham" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=59" coords="96,58,128,71" shape="rect">
    <area target="_blank" alt="Regina Stewart Weber" title="Regina Stewart Weber" href="https://jiajun0701.com/test/php/GraveDetails_user.php?cmid=60" coords="171,59,196,70" shape="rect">
</map>
</div>




    <script src="../php/js/script.js"></script>
<script>
  $(document).ready(function() {
    $('img[usemap]').rwdImageMaps();
  });
  </script>

</body>
</html>