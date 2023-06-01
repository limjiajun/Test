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

//SELECT `Grave_ID`, `Name_Deceased`, `Years_of_Born`, `Years_of_Died`, `Location`, `Section`, `Years_Buried` FROM `cemeteryrecord` WHERE 1
if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $cmid= $_GET['cmid'];
        $sqldeletepr = "DELETE FROM `cemeteryrecord` WHERE Grave_ID = '$cmid'";
        $conn->exec($sqldeletepr);
        echo "<script>alert('Record deleted')</script>";
    }

} else {
    $sqlproduct = "SELECT * FROM cemeteryrecord ";
}

$results_per_page = 25;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
} else {
    $pageno = 1;
}

// Calculate the starting and ending indexes for the current page
$start_index = ($pageno - 1) * $results_per_page + 1;
$end_index = $start_index + $results_per_page - 1;

// Display the range for the current page
echo "Displaying range: $start_index - $end_index";

$sqlproduct = "SELECT * FROM `cemeteryrecord`";
$stmt = $conn->prepare($sqlproduct);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);

// Calculate the starting and ending page numbers for the pagination
$start_page = ($pageno - 1) * 10 + 1;
$end_page = $start_page + 9;

// Adjust the end page if it exceeds the total number of pages
if ($end_page > $number_of_page) {
    $end_page = $number_of_page;
}

$sqlproduct = $sqlproduct . " LIMIT " . ($start_index - 1) . ", $results_per_page";
$stmt = $conn->prepare($sqlproduct);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();


function truncate($string, $length, $dots = "...")
{
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}
if (isset($_POST['submit'])) {
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $option = isset($_POST['option']) ? $_POST['option'] : '';

    $rows = searchUser($conn, $title, $option);
} else {
    // Your existing code to fetch cemetery records without search.
}


// Initialize the $option variable
$option = '';

// Check if the 'option' value is set in the POST data
if (isset($_POST['option'])) {
    $option = $_POST['option'];
}
$title = '';
// Check if the 'title' value is set in the POST data
if (isset($_POST['title'])) {
    $title = $_POST['title'];
}
function searchUser($conn, $title, $option) {
    if ($option == "All") {
        $sql = "SELECT * FROM cemeteryrecord WHERE Name_Deceased LIKE :title";
        $stmt = $conn->prepare($sql);
        $title = '%' . $title . '%';
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM cemeteryrecord WHERE Name_Deceased LIKE :title AND Section = :section";
        $stmt = $conn->prepare($sql);
        $title = '%' . $title . '%';
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':section', $option, PDO::PARAM_STR);
    }

    if (!empty($sql)) {
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return [];
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
    
    <title>List of Deceased Persons</title> 
    
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

<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-3lTlkQwf9X0b0GheE1jzY8Yu2wCI4vN/4vyRi1Nfo8ScgW9pKjHCEeUUq3Yi8U6kC/6Xd5U6y5U5EIsjxyW9XQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-4vD0Rlm1yPKdK8W26X0guvCJVa0HqOYJ8sFBnEMsFtBnM3qy3/8Q2XcN9N0Rr1zZ+Sy8WCa1cJyKjTB2ze+/oA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
  }
  

    
   /* Responsive styles */
    @media print {
      .print-button {
        display: block;
      }

      @page {
        size: 1245px 668px;
      }

      body {
        width: 1245px;
        height: 668px;
        margin: auto;
      }

      header, footer {
        display: none;
      }
    }

    @media (max-width: 480px) {
      .print-button {
        display: block;
        width: 100%;
        padding: 10px 20px;
        font-size: 16px;
        background-color: #000;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
      }

      .print-button:hover {
        background-color: #222;
      }
      
      body {
        padding: 10px;
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
                            <span class="text nav-text">Manage List of Deceased Persons</span>
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

    
    <section class="home">
        
        <div style="max-width:1100px; margin:0 auto">
   <div class="w3-header w3-center w3-padding w3-animate-opacity">
        <a href="../images/geomodel_grave_mapping_2.png" data-lightbox="myimage">
            <img src="../images/geomodel_grave_mapping_2.png" alt="Description of the image" style="width:50%; height:300px;">
        </a>
    </div>
    
    
    
    
    </div>
        <div style="background-color: #133764; color:white">
            <div class="w3-container w3-center">
                <h3><strong>Manage List of Deceased Persons</strong></h3>
         <a href="AddPerson.php" class="w3-bar-item w3-button w3-white w3-border w3-border-black w3-round-xlarge w3-right">Add Image Person</a>
         <a href="AddCemeteryRecord-T.php" class="w3-bar-item w3-button w3-white w3-border w3-border-black w3-round-xlarge w3-right">New Deceased Persons</a>
            </div>
            
        </div>
        <br>

       <div class="w3-card w3-padding w3-margin">
      <header>   

          <p>Search</p>
      </header>
      <div class="w3-container w3-row">
<form method="POST" action="ManageCemetery_admin.php">
    <div class="w3-third w3-padding">
        <input class="w3-input w3-border w3-round" name="title" type="text" id="idtitle" maxlength="100" value="<?php echo htmlspecialchars($title); ?>">
    </div>
    <div class="w3-third w3-padding">
        <select class="w3-select w3-border w3-round" id="idoption" name="option">
            <option disabled value> -- select search option -- </option>
            <option value="All" <?php echo $option === 'All' ? 'selected' : ''; ?>>All</option>
            <option value="A" <?php echo $option === 'A' ? 'selected' : ''; ?>>A</option>
            <option value="B" <?php echo $option === 'B' ? 'selected' : ''; ?>>B</option>
             <option value="C" <?php echo $option === 'C' ? 'selected' : ''; ?>>C</option>
            <option value="D" <?php echo $option === 'D' ? 'selected' : ''; ?>>D</option>
        </select>
    </div>
    <div class="w3-third w3-padding">
        <button class="w3-btn w3-round w3-blue w3-block" name="submit" value="submit" id="idsubmit">Search</button>
    </div>
</form>

</div>

    <!-- Add the search results display logic here -->
    <div class="search-results">
        <?php if (count($rows) > 0): ?>
            <!-- Display search results in a table, list, or any other format -->
            <?php foreach ($rows as $row): ?>
                <!-- Display each record -->
            <?php endforeach; ?>
        <?php else: ?>
            <p>No records found for the search term "<?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?>" in the "<?php echo htmlspecialchars($option, ENT_QUOTES, 'UTF-8'); ?>" section.</p>
        <?php endif; ?>
    </div>
</div>
<div class="w3-container w3-center">
                <h3><strong> List of Deceased Persons</strong></h3>
<a href="#" class="w3-bar-item w3-button w3-white w3-border w3-border-black w3-round-xlarge w3-right" onclick="printPage()">Print</a>
</div>
    <div class="w3-margin w3-border" style="overflow-x:auto;">
        
        <?php
        $i = 0;
        echo "<table class='w3-table w3-striped w3-bordered' style='width:95%'>
         <tr><th style='width:5%'>Grave_ID</th><th style='width:15%'>Image</th><th style='width:15%'>Name_Deceased</th><th style='width:15%'>Years_of_Born</th><th style='width:10%'>Years_of_Died</th>
         <th>Location</th><th>Section</th><th>Years_Buried</th><th>Operations</th></tr>";
        foreach ($rows as $cemeterys) {
            ////SELECT `user_id`, `First_name`, `Last_name`, `Gender`, `Identity_card_number`, `Email`, `Password`,
// `Phone_Number`, `Home_Address`, `otp`, `user_type` FROM `user_profile` WHERE 1
            $i++;
            $image_path1= $cemeterys['Image'];

            $cmid = $cemeterys['Grave_ID'];
            $Name_Deceased = $cemeterys['Name_Deceased'];
            $Years_of_Born = $cemeterys['Years_of_Born'];
            $Years_of_Died = $cemeterys['Years_of_Died'];
            $Location = $cemeterys['Location'];
            $Section = $cemeterys['Section'];
            $Years_Buried = $cemeterys['Years_Buried'];
            
            
            echo "<tr><td>$i</td><td> <a href='$image_path1' data-lightbox='cemetery-image'>
                            <img class='w3-image' src='$image_path1' width='150' height='70' onerror='this.onerror=null;this.src=\"../res/background.png\"'>
                        </a></td><td>$Name_Deceased</td><td>$Years_of_Born</td><td>$Years_of_Died</td><td>$Location</td>
            <td>$Section</td><td>$Years_Buried</td>
           <td><button class='btn'><a href='ManageCemetery_admin.php?submit=delete&cmid=$cmid' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>
            <button class='btn'><a href='Cemetery_update.php?submit=details&cmid=$cmid' class='fa fa-edit'></a></button></td></tr>";
        }
        ////SELECT `Grave_ID`, `Name_Deceased`, `Years_of_Born`, `Years_of_Died`, `Location`, `Section`, `Years_Buried` FROM `cemeteryrecord` WHERE 1

        //CemeteryTable
        echo "</table>";
        ?>
    </div>
    <br>
  <nav class="pagination">
  <ul class="pagination-list">
    <?php
    for ($page = 1; $page <= $number_of_page; $page++) {
      echo '<li class="pagination-item';
      if ($page == $pageno) {
        echo ' active';
      }
      echo '"><a href="ManageCemetery_admin.php?pageno=' . $page . '" aria-label="Page ' . $page . '">' . $page . '</a></li>';
    }
    ?>
  </ul>
</nav>
    
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
 <script>
    function printPage() {
      // Request full screen mode
      if (document.documentElement.requestFullscreen) {
        document.documentElement.requestFullscreen();
      }

      // Print the page
      window.print();
    }
  </script>
            
</div>




</body>
</html>