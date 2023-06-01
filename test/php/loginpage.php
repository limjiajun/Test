<?php


if (isset($_POST['LOGIN'])) {
    include 'dbconnect.php';
  
    $Email = $_POST['Email'];
    $Password = sha1($_POST['Password']);
    $otp = '1';
    $sqllogin = "SELECT * FROM user_profile WHERE Email = '$Email' AND Password= '$Password' AND otp='$otp'";

    $stmt = $conn->prepare($sqllogin);
    $stmt->execute();
    $user = $stmt->fetch();

    if ($user) {
        $user_id = $user['user_id'];
        $First_name = $user['First_name'];
        $Last_name = $user['Last_name'];
        $image_path = $user['Image'];
        $user_type = $user["user_type"];
        
        
        $Gender= $user['Gender'];
        $Email = $user['Email'];
        $Password = $user['Password'];
        $Phone_Number = $user['Phone_Number'];
        $Home_Address = $user['Home_Address'];


//SELECT `user_id`, `Image`, `First_name`, `Last_name`, `Gender`, `Email`, `Password`, `Phone_Number`, `Home_Address`, 
//`otp`, `resettoken`, `resettokenexp`, `user_type` FROM `user_profile` WHERE 1

        session_start();
        $_SESSION["sessionid"] = session_id();
        $_SESSION["user_id"] = $user_id;
        $_SESSION["Email"] = $Email;
        $_SESSION['First_name'] = $First_name;
        $_SESSION['Last_name'] = $Last_name;
        $_SESSION['Image'] = $image_path;
        
        $_SESSION["Gender"] = $Gender;
        $_SESSION['Password'] = $Password;
        $_SESSION['Phone_Number'] = $Phone_Number;
        $_SESSION['Home_Address'] = $Home_Address;
        $_SESSION['user_type'] = $user_type;

        
        



        if ($user_type == "user") {
            echo "<script>alert('Login success');</script>";
            echo "<script>window.location.replace('dashboarduserpage.php')</script>";
        } elseif ($user_type == "admin") {
            echo "<script>alert('Login success');</script>";
            echo "<script>window.location.replace('dashboardadminpage.php')</script>";
        } else {
            echo "<script>alert('Login failed: Invalid user type');</script>";
            echo "<script>window.location.replace('loginpage.php')</script>";
        }
    } else {
        echo "<script>alert('Login failed');</script>";
        echo "<script>window.location.replace('loginpage.php')</script>";
    }
}
?>


<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CMS TEst</title>

  <!-- 
    - favicon link
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/style-index.css">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">


  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css">
  <link href="http://fonts.googleapis.com/css?family=Cookie" rel="stylesheet" type="text/css">
  
  
    <link rel="stylesheet" href="../css/style-login.css">
    
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css" />
   
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"
    />
    <link
      href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@600&display=swap"
      rel="stylesheet"
    />
  </head>
  
  <body>

 <script src = "js/login.js"></script>

  <body onload = "loadCookies()">
      <header>
    <div class="header-left">
        <div class="logo">
          <img src="../assets/images/Logo123.png" alt="CMS logo" width="100">
        </div>
        <nav>
            <ul>
                <li>
                    <a href="index.html" class="active">Home</a>
                </li>
                <li>
                    <a href="about.html">About</a>
                </li>
                <li>
                    <a href="contact.html">Contact</a>
                </li>
                <li>
                  <a href="map.html">Location</a>
              </li>
            </ul>
            <div class="login-signup">
          <a href="./loginpage.php">Login</a> or <a href="./re.php">Signup</a>
          </div>
      </nav>
  </div>
  <div class="header-right">
      <div class="login-signup">
          <a href="./loginpage.php">Login</a> or <a href="./re.php">Signup</a>
      </div>
      <div class="hamburger">
          <div></div>
          <div></div>
          <div></div>
          <div></div>
      </div>
  </div>
</header>

    <div class="wrapper">
      <div class="title">Login Form</div>
      <form name="loginForm" action="loginpage.php" method="post">
        <div class="field">
          <input  type="Email" name="Email" id="idemail"
                         required>
          <label>Email Address</label>
        </div>

        <div class="field">
          <input type="password" name="Password" id="idpassword"
                         required>
          <label>Password</label>

        </div>
        <div class="content">
          <div class="checkbox">
            <input type="checkbox"  name="rememberme" type="checkbox" id="idremember" onclick="rememberMe()">
            <label for="remember-me">Remember me</label>
          </div>


          

          <div class="pass-link"><a href="forgotPassword.php">Forgot password?</a></div>
        </div>
        <div class="field">
        <input type="submit" name="LOGIN"  value="LOGIN">
        
        </div>
        <div class="signup-link">Not a member? <a href="re.php">Signup now</a></div>
      </form>
    </div>
    <!-- 
    - #FOOTER
  -->

  <footer class="footer-distributed">

    <div class="footer-left">
        <h3><span>Cemetery Management System</span></h3>
  
        <p class="footer-links">
            <a href="#">Home</a>
            |
            <a href="#">About</a>
            |
            <a href="#">Contact</a>
            |
            
        </p>
  
        <p class="footer-company-name">Copyright © 2023 <strong>CMS-Web</strong> All rights reserved</p>
    </div>
  
    <div class="footer-center">
        <div>
            <i class="fa fa-map-marker"></i>
            <p>
              <strong>Address:</strong>
              <br> 5, Lengkok Barat, George Town,
              <br>10450 George Town, 
              <br>Pulau Pinang
          </p>
        </div>
  
        <div>
            <i class="fa fa-phone"></i>
            <p>  <a href="tel:+607313335000">Call us at 07-3331-5000</a>  </p>
  
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="mailto:cms@gmail.com">cms@gmail.com</a></p>
        </div>
    </div>
    <div class="footer-right">
        <p class="footer-company-about">
            <span>About Us</span>
            
        </p>
        <div class="footer-icons">
            <a href="#"><i class="fa fa-facebook"></i></a>
            <a href="#"><i class="fa fa-instagram"></i></a>
           
            <a href="#"><i class="fa fa-twitter"></i></a>
            
        </div>
    </div>
  </footer>
    
    
    <script>
    hamburger = document.querySelector(".hamburger");
    nav = document.querySelector("nav");
    hamburger.onclick = function() {
        nav.classList.toggle("active");
    }
  </script>
    
    
    
    
     <script>
    let cookieConsent = getCookie("user_cookie_content");
    if (cookieConsent != ""){
      document.getElementById("cookieNotice").style.display = "none";
    } else {
      document.getElementById("cookieNotice").style.display = "block";
    }
  </script>
  
   <!-- 
    - js link and file
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
  
  
 <style>
     
     

:root {

  /**
   * colors
   */

  --maximum-yellow-red: hsl(37, 100%, 68%);
  --royal-blue-dark: hsl(231, 61%, 22%);
  --silver-chalice: hsl(0, 0%, 70%);
  --oxford-blue: hsl(231, 100%, 8%);
  --bittersweet: hsl(2, 100%, 69%);
  --french-rose: hsl(342, 90%, 61%);
  --davys-gray: hsl(180, 3%, 28%);
  --cool-gray: hsl(240, 13%, 62%);
  --platinum: hsl(0, 0%, 92%);
  --white-2: hsl(0, 0%, 98%);
  --white: hsl(0, 0%, 100%);
  --black: hsl(0, 0%, 0%);
  --rythm: hsl(240, 9%, 53%);

  /**
   * typography
   */

  --ff-poppins: "Poppins", sans-sarif;

  --fs-1: 32px;
  --fs-2: 26px;
  --fs-3: 22px;
  --fs-4: 18px;
  --fs-5: 15px;
  --fs-6: 14px;

  --fw-700: 700;
  --fw-600: 600;
  --fw-500: 500;

  /**
   * transition
   */

  --transition: 0.25s ease-in-out;

}





/*-----------------------------------*\ 
 * #RESET
\*-----------------------------------*/

*, *::before, *::after {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

li { list-style: none; }

a { text-decoration: none; }

a,
img,
button,
span,
ion-icon,
label,
input,
textarea { display: block; }

button {
  font: inherit;
  background: none;
  border: none;
  cursor: pointer;
}

textarea,
input {
  font: inherit;
  background: none;
  border: none;
  width: 100%;
}

:is(input, textarea):focus { outline: none; }

:focus { outline-offset: 4px; }

html {
  font-family: var(--ff-poppins);
  scroll-behavior: smooth;
}

body {
  background: var(--white);
  overflow-x: hidden;
}

::-webkit-scrollbar { width: 10px; }

::-webkit-scrollbar-track { background: var(--white); }

::-webkit-scrollbar-thumb { background: hsl(0, 0%, 50%); }





/*-----------------------------------*\ 
 * #REUSED STYLE
\*-----------------------------------*/

.container { padding: 0 15px; }

.h1,
.h2,
.h3 {
  font-weight: var(--fw-600);
  line-height: 1.3;
  text-transform: capitalize;
}

.h1 {
  color: var(--oxford-blue);
  font-size: var(--fs-1);
}

.h2 { font-size: var(--fs-2); }

.h3 {
  color: var(--oxford-blue);
  font-size: var(--fs-3);
}

.h4 {
  color: var(--royal-blue-dark);
  font-size: var(--fs-5);
  font-weight: var(--fw-600);
}

.btn {
  font-size: var(--fs-6);
  text-transform: uppercase;
  font-weight: var(--fw-600);
  padding: 10px 40px;
  border: 1px solid;
  border-radius: 6px;
}

.btn-primary {
  background: blue; /*  color */
  border-color: blue; /* add border color to match */
  color: var(--white);
}

.btn-primary:is(:hover, :focus) { background: lightblue; /* change hover and focus background color */}


.btn-secondary:is(:hover, :focus) { background: hsla(0, 33%, 98%, 0.1); }





/*-----------------------------------*\ 
 * #HEADER
\*-----------------------------------*/

header {
  position: relative;
  padding: 35px 0;
  z-index: 2;
}

header .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar-menu-btn {
  font-size: 30px;
  padding: 5px;
}

.navbar {
  position: absolute;
  top: calc(100% - 15px);
  left: 15px;
  right: 15px;
  background: var(--maximum-yellow-red);
  max-height: 0;
  visibility: hidden;
  pointer-events: none;
  transition: var(--transition);
  transform-origin: top;
  overflow: hidden;
}

.navbar.active {
  visibility: visible;
  pointer-events: all;
  max-height: 280px;
}

.navbar-list { padding: 10px; }

.nav-item:not(:last-child) { border-bottom: 1px solid hsla(0, 0%, 100%, 0.2); }

.nav-link {
  font-size: var(--fs-6);
  color: var(--royal-blue-dark);
  font-weight: var(--fw-600);
  padding: 15px 10px;
  opacity: 0;
  transition: opacity var(--transition);
}

.nav-link:is(:hover, :focus) { background: hsla(0, 0%, 100%, 0.2); }

.navbar.active .nav-link {
  transition-delay: 0.2s;
  opacity: 1;
}

.navbar .btn-primary { display: none; }





/*-----------------------------------*\ 
 * #HERO
\*-----------------------------------*/

.hero {
  position: relative;
  padding: 130px 0 140px;
  z-index: 1;
}

.hero-content { text-align: center; }

.hero-title,
.hero-text { margin-bottom: 40px; }

.hero-text {
  font-size: var(--fs-4);
  color: var(--oxford-blue);
}

.hero .btn-primary { margin-inline: auto; }

.hero-banner { display: none; }

.shape-content {
  position: absolute;
  width: 900px;
  top: -230px;
  right: -300px;
  z-index: -1;
}





/*-----------------------------------*\ 
 * #ABOUT
\*-----------------------------------*/

.about {
  position: relative;
  z-index: 1;
  background: url("../images/about-bg1.png") no-repeat;
  background-position: center;
  background-size: cover;
  padding: 120px 0;
  text-align: center;
}

.about-top { margin-bottom: 120px; }

.about .h2 { color: var(--white); }

.about-top .section-title { margin-bottom: 20px; }

.about-top .section-text {
  color: var(--white);
  font-size: var(--fs-4);
  margin-bottom: 60px;
}

.about-list {
  display: grid;
  grid-template-columns: 1fr;
  gap: 30px;
}

.about-card {
  background: var(--white);
  padding: 40px;
  border-radius: 12px;
  box-shadow: 0 2px 4px hsla(226, 83%, 50%, 0.1);
}

.card-icon {
  color: var(--bittersweet);
  font-size: 45px;
  width: max-content;
  margin-inline: auto;
  margin-bottom: 15px;
}

.about-card .card-title { margin-bottom: 15px; }

.about-card .card-text { color: var(--davys-gray); }

.about-bottom-banner { margin-bottom: 120px; }

.about-bottom-banner img {
  width: 100%;
  height: 100%;
}

.about-bottom .section-title { margin-bottom: 20px; }

.about-bottom .section-text {
  color: var(--white);
  font-size: var(--fs-4);
  margin-bottom: 40px;
}

.about-bottom .btn-secondary {
  color: var(--white);
  margin-inline: auto;
}





/*-----------------------------------*\ 
 * #FEATURES
\*-----------------------------------*/

.features {
  padding: 120px 0;
  text-align: center;
}

.features .section-title {
  color: var(--royal-blue-dark);
  margin-bottom: 20px;
}

.features .section-text {
  color: var(--rythm);
  font-size: var(--fs-4);
  margin-bottom: 120px;
}

.features-item:first-child { margin-bottom: 100px; }

.features-item-banner {
  max-width: 350px;
  margin-inline: auto;
  margin-bottom: 60px;
}

.features-item-banner img { width: 100%; }

.features-item .item-title {
  color: var(--royal-blue-dark);
  margin-bottom: 20px;
}

.features-item .item-text {
  color: var(--rythm);
  font-size: var(--fs-4);
}





/*-----------------------------------*\ 
 * #CTA
\*-----------------------------------*/

.cta { padding: 120px 0; }

.cta-card {
  background: linear-gradient(to top, var(--bittersweet) 0, var(--french-rose));
  padding: 80px 36px;
  border-radius: 20px;
  text-align: center;
}

.cta-title {
  color: var(--white);
  font-size: var(--fs-1);
  font-weight: var(--fw-600);
  line-height: 1.3;
  margin-bottom: 20px;
}

.cta-text {
  color: var(--white);
  font-size: var(--fs-6);
  margin-bottom: 50px;
}

.cta input {
  color: var(--white);
  padding: 10px 15px;
  border-bottom: 1px solid;
  margin-bottom: 30px;
}

.cta input::placeholder { color: inherit; }

.cta .btn-secondary {
  color: var(--white);
  margin-inline: auto;
}





/*-----------------------------------*\ 
 * #CONTACT
\*-----------------------------------*/

.contact { margin-bottom: 120px; }

.contact-content { margin-bottom: 50px; }

.contact-title {
  color: var(--royal-blue-dark);
  margin-bottom: 60px;
  text-align: center;
  font-weight: var(--fw-500) !important;
}

.contact-banner img { width: 100%; }

.input-wrapper { margin-bottom: 30px; }

.input-label {
  color: var(--oxford-blue);
  font-size: var(--fs-6);
  font-weight: var(--fw-600);
  margin-bottom: 10px;
}

.input-field {
  border-bottom: 1px solid var(--platinum);
  padding: 7px 0;
  font-size: var(--fs-6);
}

.input-field::placeholder { color: var(--silver-chalice); }

textarea {
  max-height: 300px;
  min-height: 100px;
  height: 100px;
  resize: vertical;
}





/*-----------------------------------*\ 
 * #FOOTER
\*-----------------------------------*/

footer { background: var(--white-2); }

.footer-top { padding: 80px 0 50px; }

.footer-brand { margin-bottom: 20px; }

footer .logo { margin-bottom: 30px; }

.footer-text {
  color: var(--rythm);
  font-size: var(--fs-6);
  margin-bottom: 20px;
}

.social-list {
  display: flex;
  justify-content: flex-start;
  gap: 20px;
}

.social-link {
  color: var(--rythm);
  font-size: var(--fs-4);
  margin-bottom: 10px;
}

.social-link:is(:hover, :focus) { color: var(--french-rose); }

.footer-link-list:not(:last-child) { margin-bottom: 30px; }

.footer-link-list .link-title { margin-bottom: 15px; }

.footer-link {
  color: var(--cool-gray);
  font-size: var(--fs-6);
  margin-bottom: 10px;
  max-width: 150px;
}

.footer-link:is(:hover, :focus) { color: var(--french-rose); }

.footer-bottom {
  padding: 20px 15px;
  border-top: 1px solid hsla(0, 0%, 18%, 0.2);
}

.copyright {
  color: var(--cool-gray);
  text-align: center;
  font-size: var(--fs-6);
}

.copyright a {
  display: inline-block;
  color: var(--cool-gray);
}

.copyright a:is(:hover, :focus) { color: var(--french-rose); }





/*-----------------------------------*\ 
 * #GO TO TOP
\*-----------------------------------*/

.go-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  z-index: 5;
  width: 50px;
  height: 50px;
  background: linear-gradient(-45deg, var(--maximum-yellow-red), var(--french-rose));
  box-shadow: 0 2px 4px hsla(0, 0%, 0%, 0.25);
  display: grid;
  place-items: center;
  border-radius: 50%;
  color: var(--white);
  font-size: 22px;
  opacity: 0;
  visibility: hidden;
  pointer-events: none;
  transition: var(--transition);
}

.go-top.active {
  opacity: 1;
  visibility: visible;
  pointer-events: all;
}





/*-----------------------------------*\ 
 * #RESPONSIVE
\*-----------------------------------*/

/**
 * responsive for larger than 450px 
 */

@media (min-width: 450px) {

  /**
   * CUSTOM PROPERTY 
   */

  :root {

    /**
     * typography
     */

    --fs-1: 60px;

  }



  /**
   * REUESED STYLE 
   */

  .h1,
  .h2 { font-weight: var(--fw-700); }

  .btn { padding-block: 15px; }



  /**
   * HEADER 
   */

  .navbar {
    left: auto;
    width: 300px;
  }



  /**
   * HERO 
   */

  .hero { padding: 140px 0 160px; }

  .shape-content {
    top: -70px;
    right: -260px;
  }



  /**
   * ABOUT 
   */

  .about-card .card-title { padding-inline: 40px; }

  .about-bottom-banner {
    max-width: 400px;
    margin-inline: auto;
    margin-bottom: 40px;
  }

  .about-bottom-content { padding-inline: 50px; }



  /**
   * FEATURES
   */

  .features .h2 { --fs-2: 32px; }



  /**
   * CTA
   */

  .cta-title { --fs-1: 42px; }

  .cta-form {
    display: flex;
    justify-content: center;
    align-items: flex-end;
    gap: 30px;
  }

  .cta input { margin-bottom: 0; }

  .cta .btn-secondary { min-width: max-content; }



  /**
   * CONTACT
   */

  .contact-title { --fs-2: 32px; }

  .contact-banner {
    max-width: 300px;
    margin-inline: auto;
  }

}





/**
 * responsive for larger than 560px 
 */

@media (min-width: 560px) {

  /**
   * REUESED STYLE 
   */

  .container {
    max-width: 550px;
    margin-inline: auto;
  }



  /**
   * HEADER
   */

  .navbar-wrapper { position: relative; }

  .navbar {
    top: calc(100% + 15px);
    right: 0;
  }



  /**
   * HERO, ABOUT
   */

  .hero-content,
  .about-bottom-content { text-align: left; }

  .hero .btn-primary,
  .about-bottom .btn-secondary { margin-inline: 0; }

  .shape-content {
    top: -156px;
    right: -152px;
  }



  /**
   * FOOTER
   */

  .footer-brand { margin-bottom: 40px; }

  .footer-link-box {
    display: grid;
    grid-template-columns: 1fr 1fr;
  }

}





/**
 * responsive for larger than 768px 
 */

@media (min-width: 768px) {

  /**
   * CUSTOM PROPERTY 
   */

  :root {

    /**
     * typography
     */

    --fs-2: 35px;
    --fs-4: 20px;

  }



  /**
   * REUSED STYLE
   */

  .container { max-width: 740px; }



  /**
   * ABOUT
   */

  .about-list { grid-template-columns: 1fr 1fr; }

  .about-card {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    align-items: center;
  }

  .about-card .card-title { padding-inline: 0; }



  /**
   * CONTACT
   */

  .contact-title { --fs-2: 42px; }

}





/**
 * responsive for larger than 1024px 
 */

@media (min-width: 1024px) {

  /**
   * REUSED STYLE
   */

  .container { max-width: 950px; }



  /**
   * HEADER
   */

  .navbar-menu-btn { display: none; }

  .navbar {
    max-height: unset;
    visibility: visible;
    position: static;
    width: auto;
    background: none;
    pointer-events: all;
    overflow: visible;
    display: flex;
  }

  .navbar-list {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-right: 20px;
  }

  .nav-link {
    opacity: 1;
    padding: 0 15px;
  }

  .navbar .btn-primary { display: block; }



  /**
   * HERO
   */

  .hero-content { max-width: 550px; }

  .hero-banner {
    display: block;
    position: absolute;
    top: 60%;
    right: 0;
    transform: translateY(-50%);
    width: 500px;
    padding-top: 500px;
    background: url("./assets/images/hero-banner1.png") no-repeat;
    background-size: contain;
  }



  /**
   * ABOUT
   */

  .about-top .section-text {
    max-width: 650px;
    margin-inline: auto;
  }

  .about-list { grid-template-columns: repeat(3, 1fr); }

  .about-bottom {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .about-bottom-banner {
    margin-bottom: 0;
    height: 330px;
  }

  .about-bottom-content {
    padding-inline: 0;
    width: 50%;
  }



  /**
   * FEATURES
   */

  .features :is(.section-title, .section-text) {
    max-width: 650px;
    margin-inline: auto;
  }

  .features-item {
    display: flex;
    align-items: center;
    gap: 50px;
  }

  .features-item-banner {
    margin-inline: 0;
    margin-bottom: 0;
  }

  .feature-item-content {
    width: 50%;
    text-align: left;
  }

  .features-item:last-child { flex-direction: row-reverse; }



  /**
   * CTA
   */

  .cta-card > * {
    max-width: 500px;
    margin-inline: auto;
  }



  /**
   * CONTACT
   */

  .contact .container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 50px;
  }

  .contact-content { max-width: 400px; }

  .contact-title { text-align: left; }

  .contact-form { width: 50%; }



  /**
   * FOOTER
   */

  .footer-top .container {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 50px;
  }

  .footer-brand,
  .footer-link-list:not(:last-child) { margin-bottom: 0; }

  .footer-link-box {
    grid-template-columns: repeat(4, 1fr);
    gap: 50px;
  }

  
}





/**
 * responsive for larger than 1200px 
 */

@media (min-width: 1200px) {

  /**
   * CUSTOM PROPERTY 
   */

  :root {

    /**
     * typography
     */

    --fs-2: 42px;

  }



  /**
   * REUSED STYLE
   */

  .container { max-width: 1150px; }



  /**
   * HERO
   */

  .hero-banner { right: 100px; }



  /**
   * ABOUT
   */

  .about-bottom-banner { height: 400px; }



  /**
   * FEATURES
   */

  .features .h2 { --fs-2: 42px; }

  .features :is(.section-title, .section-text) { max-width: 850px; }


  * {
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    text-decoration: none;
    list-style: none;
    font-family: "ubuntu";
}
img {
    width: 100%;
}
header {
    height: 70px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 50px;
    background: #0b2239;
}
header .header-left {
    display: flex;
    align-items: center;
}
header .header-left .logo {
    width: 140px;
}
header .header-left nav {
    margin-left: 50px;
}
header .header-left nav ul {
    display: flex;
}
nav ul li a {
    display: block;
    color: #cfd9e0;
    font-size: 18px;
    padding: 5px 10px;
    transition: 0.2s;
}
nav ul li a:hover,
nav ul li a.active {
    color: #fff;
}
nav .login-signup {
    display: none;
}
header .header-right {
    display: flex;
    align-items: center;
}
header .login-signup {
    color: #cfd9e0;
    font-weight: bold;
}
header .login-signup a {
    display: inline-block;
    color: #0b2239;
    background: #4ad295;
    padding: 5px 12px;
    border-radius: 5px;
}
header .header-right .hamburger {
    margin-left: 20px;
    cursor: pointer;
    display: none;
}
header .header-right .hamburger div {
    width: 30px;
    height: 2px;
    margin: 6px 0;
    background: #fff;
}
@media only screen and (max-width: 1000px) {
    header {
        padding: 0 20px;
    }
    header .header-right .hamburger {
        display: block;
    }
    header .header-left nav {
        margin: 0;
        position: absolute;
        top: -100%;
        left: 0;
        width: 100%;
        height: fit-content;
        background-color: #0b2239;
        padding: 30px;
        transition: 0.3s;
        text-align: center;
        z-index: -1;
    }
    header .header-left nav.active {
        top: 70px;
    }
    header .header-left nav ul {
        display: block;
    }
}
@media only screen and (max-width: 500px) {
    nav .login-signup {
        display: block;
        margin-top: 20px;
    }
    header .header-right .login-signup {
        display: none;
    }
}

 /* The footer is fixed to the bottom of the page */
 footer {
  position: fixed;
  bottom: 0;
}

@media (max-height:1500px) {
  footer {
      position: static;
  }
  header {
      padding-top: 40px;
  }
}

.footer-distributed {
  background-color: #2d2a30;
  box-sizing: border-box;
  width: 100%;
  text-align: left;
  font: bold 16px sans-serif;
  padding: 50px 50px 60px 50px;
  margin-top: 80px;
}

.footer-distributed .footer-left, .footer-distributed .footer-center, .footer-distributed .footer-right {
  display: inline-block;
  vertical-align: top;
}

/* Footer left */
.footer-distributed .footer-left {
  width: 30%;
}

.footer-distributed h3 {
  color: #ffffff;
  font: normal 36px 'Cookie', cursive;
  margin: 0;
}

.footer-distributed h3 span {
  color: #e0ac1c;
}

/* Footer links */
.footer-distributed .footer-links {
  color: #ffffff;
  margin: 20px 0 12px;
}

.footer-distributed .footer-links a {
  display: inline-block;
  line-height: 1.8;
  text-decoration: none;
  color: inherit;
}

.footer-distributed .footer-company-name {
  color: #8f9296;
  font-size: 14px;
  font-weight: normal;
  margin: 0;
}

/* Footer Center */
.footer-distributed .footer-center {
  width: 35%;
}

.footer-distributed .footer-center i {
  background-color: #33383b;
  color: #ffffff;
  font-size: 25px;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  text-align: center;
  line-height: 42px;
  margin: 10px 15px;
  vertical-align: middle;
}

.footer-distributed .footer-center i.fa-envelope {
  font-size: 17px;
  line-height: 38px;
}

.footer-distributed .footer-center p {
  display: inline-block;
  color: #ffffff;
  vertical-align: middle;
  margin: 0;
}

.footer-distributed .footer-center p span {
  display: block;
  font-weight: normal;
  font-size: 14px;
  line-height: 2;
}

.footer-distributed .footer-center p a {
  color: #e0ac1c;
  text-decoration: none;
}

/* Footer Right */
.footer-distributed .footer-right {
  width: 30%;
}

.footer-distributed .footer-company-about {
  line-height: 20px;
  color: #92999f;
  font-size: 13px;
  font-weight: normal;
  margin: 0;
}

.footer-distributed .footer-company-about span {
  display: block;
  color: #ffffff;
  font-size: 18px;
  font-weight: bold;
  margin-bottom: 20px;
}

.footer-distributed .footer-icons {
  margin-top: 25px;
}

.footer-distributed .footer-icons a {
  display: inline-block;
  width: 35px;
  height: 35px;
  cursor: pointer;
  background-color: #33383b;
  border-radius: 2px;
  font-size: 20px;
  color: #ffffff;
  text-align: center;
  line-height: 35px;
  margin-right: 3px;
  margin-bottom: 5px;
}

.footer-distributed .footer-icons a:hover {
  background-color: #3F71EA;
}

.footer-links a:hover {
  color: #3F71EA;
}

@media (max-width: 1500px) {
  .footer-distributed .footer-left, .footer-distributed .footer-center, .footer-distributed .footer-right {
      display: block;
      width: 100%;
      margin-bottom: 40px;
      text-align: center;
  }
  .footer-distributed .footer-center i {
      margin-left: 0;
  }




}

 </style>
  
  </body>
</html>

