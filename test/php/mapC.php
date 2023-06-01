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
    
    <title>MAP C</title> 
    
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



<title>Mapping Map C</title>
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
                            <span class="text nav-text">Search Cemetery</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="rating.php">
                            <i class='bx bxs-edit icon' ></i>
                            <span class="text nav-text">Manage Feedback</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="mapA.php">
                            <i class='bx  bxs-map icon' ></i>
                            <span class="text nav-text">Manage Map</span>
                        </a>
                    </li>
                  <li class="nav-link">
                        <a href="ManageContact.php">
                            <i class='bx  bxs-contact icon' ></i>
                            <span class="text nav-text">Manage Contact</span>
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
         <a class="nav-link" href="mapA.php">Block A</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapB.php">Block B</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapC.php">Block C</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="mapD.php">Block D</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

 <div class="container py-3" id="page-container">
  <h3>Dynamically Map Area on an Image</h3>
  <hr>
<!-- Image Map Generated by http://www.image-map.net/ -->
<img src="https://jiajun0701.com/test/res/maps/map_C%20%281%29.png" usemap="#image-map">

<map name="image-map">
    <area target="_blank" alt="Kenneth William Davies" title="Kenneth William Davies" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=21" coords="73,26,94,35" shape="rect">
    <area target="_blank" alt="Clement Christopher Denis" title="Clement Christopher Denis" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=22" coords="95,23,116,34" shape="rect">
    <area target="_blank" alt="Victor Keith Alured Denne" title="Victor Keith Alured Denne" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=23" coords="130,26,152,36" shape="rect">
    <area target="_blank" alt="Able Seaman John Francis Durnin" title="Able Seaman John Francis Durnin" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=24" coords="152,25,170,36" shape="rect">
    <area target="_blank" alt="Francis Henry Hawkins" title="Francis Henry Hawkins" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=25" coords="183,24,205,34" shape="rect">
    <area target="_blank" alt="Pvt A. J. Fee" title="Pvt A. J. Fee" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=26" coords="207,25,228,36" shape="rect">
    <area target="_blank" alt="W. G. Hignett" title="W. G. Hignett" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=27" coords="263,25,286,35" shape="rect">
    <area target="_blank" alt="Khoo Chye Hong" title="Khoo Chye Hong" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=28" coords="297,25,319,35" shape="rect">
    <area target="_blank" alt="B. Hornby" title="B. Hornby" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=29" coords="38,34,59,46" shape="rect">
    <area target="_blank" alt="Sarah Jane Nissen Houston" title="Sarah Jane Nissen Houston" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=30" coords="74,35,96,47" shape="rect">
    <area target="_blank" alt="Ethel Mary" title="Ethel Mary" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=61" coords="97,35,116,44" shape="rect">
    <area target="_blank" alt="Raymond Maurice Barrett" title="Raymond Maurice Barrett" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=62" coords="129,36,151,46" shape="rect">
    <area target="_blank" alt="Dorothy Bennie" title="Dorothy Bennie" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=63" coords="150,35,171,46" shape="rect">
    <area target="_blank" alt="Thomas Lyons Beckingham" title="Thomas Lyons Beckingham" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=64" coords="184,35,206,46" shape="rect">
    <area target="_blank" alt="Mary Elizabeth Booker" title="Mary Elizabeth Booker" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=65" coords="208,37,228,46" shape="rect">
    <area target="_blank" alt="Charles William Booker" title="Charles William Booker" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=66" coords="262,36,284,46" shape="rect">
    <area target="_blank" alt="Harriett Brooman" title="Harriett Brooman" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=67" coords="298,36,318,46" shape="rect">
    <area target="_blank" alt="James Brooman" title="James Brooman" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=68" coords="73,48,97,59" shape="rect">
    <area target="_blank" alt="Eleanor Edith Brown" title="Eleanor Edith Brown" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=69" coords="96,45,118,56" shape="rect">
    <area target="_blank" alt="Mary Eliza Canning" title="Mary Eliza Canning" href="https://jiajun0701.com/test/php/GraveDetails.php?cmid=70" coords="127,46,151,57" shape="rect">
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