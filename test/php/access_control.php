<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include_once("dbconnect.php");

if (!isset($_SESSION['sessionid']) || !isset($_SESSION['user_type'])) {
    echo "<script>alert('Access denied. Please login');</script>";
    echo "<script> window.location.replace('loginpage.php')</script>";
    exit;
}

$adminPages = [
    "dashboardadminpage.php",
    "ManageCemetery_admin.php",
    "ManageMap.php",
    "rating.php",
    "mapA.php",
    "mapB.php",
    "mapC.php",
    "mapD.php",
    "ManageProfile_admin.php",
    "AddPerson.php",
    "GraveDetails.php",
     "ManageContact.php",
  
];

$userPages = [
    "dashboarduserpage.php",
    "Profile_user.php",
    "CemeteryList.php",
    "CemeteryTable.php",
    "rating_user.php",
    "mapA_user.php",
    "mapB_user.php",
    "mapC_user.php",
    "mapD_user.php",
    "GraveDetails_user.php",
   
];

$currentFile = basename($_SERVER['PHP_SELF']);
if ($_SESSION['user_type'] === "admin" && in_array($currentFile, $userPages)) {
    echo "<script>alert('Access denied. Unauthorized access');</script>";
    echo "<script> window.location.replace('dashboardadminpage.php')</script>";
    exit;
}

if ($_SESSION['user_type'] === "user" && in_array($currentFile, $adminPages)) {
    echo "<script>alert('Access denied. Unauthorized access');</script>";
    echo "<script> window.location.replace('dashboarduserpage.php')</script>";
    exit;
}
?>
