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

//SELECT `user_id`, `First_name`, `Last_name`, `Gender`, `Identity_card_number`, `Email`, `Password`,
// `Phone_Number`, `Home_Address`, `otp`, `user_type` FROM `user_profile` WHERE 1
if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'delete') {
        $prid = $_GET['prid'];
        $sqldeletepr = "DELETE FROM `user_profile` WHERE user_id = '$prid'";
        $conn->exec($sqldeletepr);
        echo "<script>alert('Record deleted')</script>";
    }

  
  
} else {
    $sqlproduct = "SELECT * FROM user_profile";
}

$results_per_page = 5;
if (isset($_GET['pageno'])) {
     $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
     $pageno = 1;
    $page_first_result = 0;
}
$sqlproduct = "SELECT * FROM user_profile";
$stmt = $conn->prepare($sqlproduct);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlproduct = $sqlproduct . " LIMIT $page_first_result , $results_per_page";
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

    $rows = searchUserRecords($conn, $title, $option);

    if (count($rows) == 0) {
        echo "No records found.";
    } else {
        // Display the records or process them as needed.
    }
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

function searchUserRecords($conn, $title, $option) {
    $title = '%' . $title . '%';

    if ($option == "All") {
        $sql = "SELECT * FROM user_profile WHERE 
                First_name LIKE :title OR
                Last_name LIKE :title OR
                Gender LIKE :title OR
                Email LIKE :title OR
                Phone_Number LIKE :title OR
                Home_Address LIKE :title";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
    } else if($option == "admin" || $option == "user") {
        $sql = "SELECT * FROM user_profile WHERE 
                (First_name LIKE :title OR
                Last_name LIKE :title OR
                Gender LIKE :title OR
                Email LIKE :title OR
                Phone_Number LIKE :title OR
                Home_Address LIKE :title) AND
                user_type = :user_type";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':user_type', $option, PDO::PARAM_STR);
    } else {
        $sql = "SELECT * FROM user_profile WHERE 
                (First_name LIKE :title OR
                Last_name LIKE :title OR
                Gender LIKE :title OR
                Email LIKE :title OR
                Password LIKE :title OR
                Phone_Number LIKE :title OR
                Home_Address LIKE :title) AND
                Section = :section";
        $stmt = $conn->prepare($sql);
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

<link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.5.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-1CmrxMRARb6aLqgBO7yyAxTOQE2AKb9GfXnEo760AUcUmFx3ibVJJAzGytlQcNXd" crossorigin="anonymous"></script>

<!----======== lightbox functionality ======== -->
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

  <section class="home">
        
        <div style="max-width:1100px; margin:0 auto">

        <div style="background-color: #133764; color:white">
            <div class="w3-container">
                <h3><strong>Manage Profile</strong></h3>
        <a href="AddNewUser-T.php" class="w3-bar-item w3-button w3-right">New User</a>
  
            </div>
        </div>
        <br>

       <div class="w3-card w3-padding w3-margin">
      <header>   

          <p>Search</p>
      </header>
      <div class="w3-container w3-row">
<form method="POST" action="ManageProfile_admin.php">
    <div class="w3-third w3-padding">
        <input class="w3-input w3-border w3-round" name="title" type="text" id="idtitle" maxlength="100" value="<?php echo htmlspecialchars($title); ?>">
    </div>
    <div class="w3-third w3-padding">
        <select class="w3-select w3-border w3-round" id="idoption" name="option">
            <option disabled value> -- select search option -- </option>
            <option value="All" <?php echo $option === 'All' ? 'selected' : ''; ?>>All</option>
            <option value="admin" <?php echo $option === 'admin' ? 'selected' : ''; ?>>admin</option>
            <option value="user" <?php echo $option === 'user' ? 'selected' : ''; ?>>user</option>
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

    <div class="w3-margin w3-border" style="overflow-x:auto;">
        <?php
        $i = 0;
        echo "<table class='w3-table w3-striped w3-bordered' style='width:95%'>
         <tr><th style='width:5%'>User_id</th><th style='width:15%'>Image</th><th style='width:15%'>First_name</th><th style='width:15%'>Last_name</th><th style='width:10%'>Gender</th>
         <th>Email</th><th>Password</th><th>Phone_Number</th><th>Home_Address</th><th>user_type</th><th>Operations</th></tr>";
        foreach ($rows as $products) {
            ////SELECT `user_id`, `First_name`, `Last_name`, `Gender`, `Identity_card_number`, `Email`, `Password`,
// `Phone_Number`, `Home_Address`, `otp`, `user_type` FROM `user_profile` WHERE 1
            $i++;
            $image_path= $products['Image'];

            $prid = $products['user_id'];
            $First_name = $products['First_name'];
            $Last_name = $products['Last_name'];
            $Gender = $products['Gender'];
         
            $Email = $products['Email'];
            $Password = $products['Password'];
            $Phone_Number = $products['Phone_Number'];
            $Home_Address= $products['Home_Address'];
            $user_type= $products['user_type'];
            
            
            echo "<tr><td>$i</td><td> <a href='$image_path' data-lightbox='cemetery-image'>
                            <img class='w3-image' src='$image_path' width='250' height='100' onerror='this.onerror=null;this.src=\"../res/background.png\"'>
                        </a></td><td>$First_name</td><td>$Last_name</td><td>$Gender</td><td>$Email</td>
            <td>$Password</td><td>$Phone_Number</td><td>$Home_Address</td><td>$user_type</td>
            <td><button class='btn'><a href='ManageProfile_admin.php?submit=delete&prid=$prid' class='fa fa-trash' onclick=\"return confirm('Are you sure?')\"></a></button>
           </td></tr>";
        }
        //userTable
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
      echo '"><a href="ManageProfile_admin.php?pageno=' . $page . '" aria-label="Page ' . $page . '">' . $page . '</a></li>';
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
    
            
</div>




</body>
</html>