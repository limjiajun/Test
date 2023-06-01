<?php
session_start();
include_once("dbconnect.php");
include_once("access_control.php");


if (!isset($_SESSION['user_type'])) {
    echo "<script>alert('Access denied. Please login');</script>";
    echo "<script> window.location.replace('loginpage.php')</script>";
    exit;
}



include_once("dbconnect.php");

if (isset($_POST['submit'])) {
    $operation = $_POST['submit'];
    $cmid = $_POST['cmid'];
    $Name_Deceased = $_POST["Name_Deceased"];
    $Years_of_Born = date('Y-m-d', strtotime($_POST['dateofbirth']));
    $Years_of_Died = date('Y-m-d', strtotime($_POST['Years_of_Died']));
    $Location = $_POST["Location"];
    $Section = $_POST["Section"];
    $Years_Buried = $_POST["Years_Buried"];

    $sqlupdate = "UPDATE `cemeteryrecord` SET `Name_Deceased`='$Name_Deceased',`Years_of_Born`='$Years_of_Born',
    `Years_of_Died`='$Years_of_Died ',`Location`='$Location',`Section`='$Section ',`Years_Buried`='$Years_Buried' WHERE  `Grave_ID` = '$cmid'";
//Grave_ID "UPDATE `cemeteryrecord` SET `Grave_ID`='[value-1]',`Name_Deceased`='[value-2]',`Years_of_Born`='[value-3]',
//    `Years_of_Died`='[value-4]',`Location`='[value-5]',`Section`='[value-6]',`Years_Buried`='[value-7]' WHERE  `Grave_ID` = '$cmid'";
    try {
        $conn->exec($sqlupdate);
        if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
            uploadImage($cmid);
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('UpdateCemeteryTable.php')</script>";
        } else {
            echo "<script>alert('Success')</script>";
            echo "<script>window.location.replace('UpdateCemeteryTable.php')</script>";
        }
      } catch (PDOException $e) {
        echo "<script>alert('Failed')</script>";
        echo "<script>window.location.replace('UpdateCemeteryTable.php?submit=details&cmid=$cmid')</script>";
    }
}

function uploadImage($filename)
{
    $target_dir = "../res/cemetery/";
    $target_file = $target_dir . $filename . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'details') {
        $cmid = $_GET['cmid'];
        $sqlproduct = "SELECT * FROM cemeteryrecord WHERE Grave_ID = '$cmid'";
        $stmt = $conn->prepare($sqlproduct);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            foreach ($rows as $cemeterys) {
              $cmid = $cemeterys['Grave_ID'];
              $Name_Deceased = $cemeterys['Name_Deceased'];
              $Years_of_Born = $cemeterys['Years_of_Born'];
              $Years_of_Died = $cemeterys['Years_of_Died'];
              $Location = $cemeterys['Location'];
              $Section = $cemeterys['Section'];
              $Years_Buried = $cemeterys['Years_Buried'];
            
        }
    }else{
        echo "<script>alert('No records found')</script>";
        echo "<script>window.location.replace('CemeteryTable.php')</script>";
    }
}
}else{
echo "<script>alert('Success')</script>";
echo "<script>window.location.replace('CemeteryTable.php')</script>";
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>MY CMS</title>
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
  </head>

    <script>
    function hamburgerMenu() {
      var x = document.getElementById("idMenuBar");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else {
        x.className = x.className.replace(" w3-show", "");
      }
    }
  </script>

<body>
    <!-- Top navigation bar -->
    <div class="w3-bar w3-black w3-padding-16" id="navBar">
      <a href="adminpage.php" class="w3-bar-item w3-button w3-wide">
        <b>CMS</b></a
      >
      <a href="userTable.php" class="w3-bar-item w3-button w3-hide-small">User Profile</a>
      <a href="cemeteryRecord.php" class="w3-bar-item w3-button w3-hide-small"
        >Cemetery Record</a>
      
      <a href="CemeteryTable.php" class="w3-bar-item w3-button w3-hide-small">VIEW CEMETERY RECORD</a>
      <a href="#profile" class="w3-bar-item w3-button w3-hide-small">Feedback</a>
      <!-- Right-sided navbar links -->
      <div class="w3-right">
        <a href="index.php" class="w3-bar-item w3-button w3-hide-small"
          >LOGOUT</a
        >
      </div>
      <!-- Hide right-floated links on small screens and replace them with a menu icon -->

      <a
        href="javascript:void(0)"
        class="w3-bar-item w3-button w3-right w3-hide-large w3-hide-medium"
        onclick="hamburgerMenu()"
      >
        <i class="fa fa-bars"></i>
      </a>
    </div>

    <div class="w3-grey">
        
            <h3>Update Product</h3>

        </div>
    </div>
    <div class="w3-bar w3-grey">
        <a href="UpdateCemeteryTable.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
    <div class="w3-content w3-padding-32">
        <form class="w3-card w3-padding" action="UpdateCemeteryTable.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
            <div class="w3-container w3-grey">
                <h3>Your Record</h3>
            </div>
            <div class="w3-container w3-center">
                <img class="w3-image w3-margin" src="../res/cemetery/<?php echo $cmid . '.png' ?>" style="height:100%;width:400px"><br>
                <input type="file" name="fileToUpload" onchange="previewFile()">
            </div>
            <hr>
            <input type="hidden" name="cmid" value="<?php echo $cmid ?>">
            <div class="w3-row-padding">
            <div class="" style="padding-right:4px">
  <br>
  <p>
  <label><b>Name_Deceased</b></label>
                        <input class="w3-input w3-round-xxlarge w3-border" type="Name_Deceased" name="Name_Deceased" id="idName_Deceased"value="<?php echo $Name_Deceased?>"required>
                    </p>
                    <p>
                      
                        <label><b>Years_of_Born</b></label>
                        
                                <input type="date" name="dateofbirth" class="form-control" value="<?php echo $Years_of_Born?>"required>
                                
                    </p>
                    <p>
                        <label><b>Years_of_Died</b></label>
                       
                                <input type="date" name="Years_of_Died" class="form-control" value="<?php echo $Years_of_Died?>"required>
                    </p>
                    
                    <p>
                        <label><b>Location</b></label>
                        <input class="w3-input w3-round-xxlarge w3-border" type="Location" name="Location" id="idLocation" value="<?php echo $Location?>"required>
</p>



<div class="w3-center" style="padding-right:4px">
<label><b>Section</b></label>
                    <p> <select class="w3-input w3-block w3-round w3-border" name="Section">
                            
                            <option value="Select" <?php if ($Section == "Select") echo ' selected="selected"'; ?>>Select</option>
                            <option value="A" <?php if ($Section == "A") echo ' selected="selected"'; ?>>A</option>
                            <option value="B" <?php if ($Section == "B") echo ' selected="selected"'; ?>>B</option>
                              <option value="C" <?php if ($Section == "C") echo ' selected="selected"'; ?>>C</option>
                            <option value="D" <?php if ($Section == "D") echo ' selected="selected"'; ?>>D</option>

                        </select>
                    </p>
                </div>
                
                        <label><b>Years_Buried</b></label>
                        <input class="w3-input w3-round-xxlarge w3-border" type="Years_Buried" name="Years_Buried" id="idYears_Buried"value="<?php echo $Years_Buried?>"required>
                    </p>
                    <p>
                      
                     
                    <p>
                        <input type="submit" class="w3-btn w3-round-xxlarge w3-block w3-grey" name="submit" value="Update">
                    </p>
        
                    </div>
                    
                    </form>

              </div>
          </div>


      </div>
      
      <!-- col -->
        </div>
     </div>
  </div>
    <!-- header -->

  <!-- footer -->
  <footer class="w3-row-padding w3-padding-16 w3-center w3-grey">
  <h6>© 2023 Cemetery Management System</h6>
    </footer>
  </body>
</html>