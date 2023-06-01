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




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Rating System</title> 
    
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">


<link rel="stylesheet" href="../css/dashboard-style.css">
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="./assets/css/style-index.css">
<link rel="stylesheet" href="./css/style-page.css">


<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>


<link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>


<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@600&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">




<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>


<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  

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
      

  
  
    <div class="container">
    	<h1 class="mt-5 mb-5">Review & Rating </h1>
    	<div class="card">
    		<div class="card-header"><b>Visitor Reviews</b></div>
    		<div class="card-body">
    			<div class="row">
    				<div class="col-sm-4 text-center text-center">
    					<h1 class="text-warning mt-4 mb-4">
    						<b><span id="average_rating">0.0</span> / 5</b>
    					</h1>
    					<div class="mb-3">
    						<i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
                            <i class="fas fa-star star-light mr-1 main_star"></i>
	    				</div>
    					<h2><span id="total_review">0</span> Review</h2>
    				</div>
    				<div class="col-sm-4">
    					<p>
                            <div class="progress-label-left"><b>5</b> <i class="fas fa-star text-warning"></i></div>

                            <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                            </div>
                        </p>
    					<p>
                            <div class="progress-label-left"><b>4</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>3</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>2</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                            </div>               
                        </p>
    					<p>
                            <div class="progress-label-left"><b>1</b> <i class="fas fa-star text-warning"></i></div>
                            
                            <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                            </div>               
                        </p>
    				</div>
    				<div class="col-sm-4 text-center">
    					<h3 class="mt-4 mb-3">Write Review Here</h3>
    					  <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>


    				</div>
    
    			</div>
    		</div>
    	</div>
    	<div class="mt-5" id="review_content"></div>
    </div>
    
    
</body>
</html>

<div id="review_modal" class="modal" tabindex="-1" role="dialog">
  	<div class="modal-dialog" role="document">
    	<div class="modal-content">
	      	<div class="modal-header">
	        	<h5 class="modal-title">Submit Review</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>
	      	</div>
	      	<div class="modal-body">
	      		<h4 class="text-center mt-2 mb-4">
	        		<i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                    <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
	        	</h4>
	        	<div class="form-group">
	        		<input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Your Name" />
	        	</div>
	        	<div class="form-group">
	        		<textarea name="user_review" id="user_review" class="form-control" placeholder="Type Review Here"></textarea>
	        	</div>
	        	<div class="form-group text-center mt-4">
	        		<button type="button" class="btn btn-primary" id="save_review">Submit</button>
	        	</div>
	      	</div>
    	</div>
  	</div>
</div>

<style>
.progress-label-left
{
    float: left;
    margin-right: 0.5em;
    line-height: 1em;
}
.progress-label-right
{
    float: right;
    margin-left: 0.3em;
    line-height: 1em;
}
.star-light
{
	color:#e9ecef;
}


  
</style>

<script>



/***********/
$(document).ready(function(){

	var rating_data = 0;

    $('#add_review').click(function(){

        $('#review_modal').modal('show');

    });

    $(document).on('mouseenter', '.submit_star', function(){

        var rating = $(this).data('rating');

        reset_background();

        for(var count = 1; count <= rating; count++)
        {

            $('#submit_star_'+count).addClass('text-warning');

        }

    });

    function reset_background()
    {
        for(var count = 1; count <= 5; count++)
        {

            $('#submit_star_'+count).addClass('star-light');

            $('#submit_star_'+count).removeClass('text-warning');

        }
    }

    $(document).on('mouseleave', '.submit_star', function(){

        reset_background();

        for(var count = 1; count <= rating_data; count++)
        {

            $('#submit_star_'+count).removeClass('star-light');

            $('#submit_star_'+count).addClass('text-warning');
        }

    });

    $(document).on('click', '.submit_star', function(){

        rating_data = $(this).data('rating');

    });

    $('#save_review').click(function(){

        var user_name = $('#user_name').val();

        var user_review = $('#user_review').val();

        if(user_name == '' || user_review == '')
        {
            alert("Please Fill Both Field");
            return false;
        }
        else
        {
            $.ajax({
                url:"submit_rating.php",
                method:"POST",
                data:{rating_data:rating_data, user_name:user_name, user_review:user_review},
                success:function(data)
                {
                    $('#review_modal').modal('hide');

                    load_rating_data();

                    alert(data);
                }
            })
        }

    });

    load_rating_data();
$(document).on("click", ".delete_review", function() {
    const review_id = $(this).data("review_id");

    $.ajax({
        url: "delete_review.php",
        method: "POST",
        data: { action: "delete_review", review_id: review_id },
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                alert(response.message);
                location.reload();
            } else {
                alert("Error: " + response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            alert("Request failed: " + textStatus + " - " + errorThrown);
        }
    });
});



     load_rating_data();
    function load_rating_data()
    {
        $.ajax({
            url:"submit_rating.php",
            method:"POST",
            data:{action:'load_data'},
            dataType:"JSON",
            success:function(data)
            {
                $('#average_rating').text(data.average_rating);
                $('#total_review').text(data.total_review);

                var count_star = 0;

                $('.main_star').each(function(){
                    count_star++;
                    if(Math.ceil(data.average_rating) >= count_star)
                    {
                        $(this).addClass('text-warning');
                        $(this).addClass('star-light');
                    }
                });

                $('#total_five_star_review').text(data.five_star_review);

                $('#total_four_star_review').text(data.four_star_review);

                $('#total_three_star_review').text(data.three_star_review);

                $('#total_two_star_review').text(data.two_star_review);

                $('#total_one_star_review').text(data.one_star_review);

                $('#five_star_progress').css('width', (data.five_star_review/data.total_review) * 100 + '%');

                $('#four_star_progress').css('width', (data.four_star_review/data.total_review) * 100 + '%');

                $('#three_star_progress').css('width', (data.three_star_review/data.total_review) * 100 + '%');

                $('#two_star_progress').css('width', (data.two_star_review/data.total_review) * 100 + '%');

                $('#one_star_progress').css('width', (data.one_star_review/data.total_review) * 100 + '%');

             if(data.review_data.length > 0)
{
    var html = '';

    for(var count = 0; count < data.review_data.length; count++)
    {
        html += '<div class="row mb-3">';

        html += '<div class="col-sm-1"><div class="rounded-circle bg-danger text-white pt-2 pb-2"><h3 class="text-center">'+data.review_data[count].user_name.charAt(0)+'</h3></div></div>';

        html += '<div class="col-sm-11">';

        html += '<div class="card">';

        html += '<div class="card-header"><b>'+data.review_data[count].user_name+'</b></div>';

        html += '<div class="card-body">';

        for(var star = 1; star <= 5; star++)
        {
            var class_name = '';

            if(data.review_data[count].rating >= star)
            {
                class_name = 'text-warning';
            }
            else
            {
                class_name = 'star-light';
            }

            html += '<i class="fas fa-star '+class_name+' mr-1"></i>';
        }

        html += '<br />';

        html += data.review_data[count].user_review;

        html += '</div>';

        html += '<div class="card-footer">';
        html += '<span>On '+data.review_data[count].datetime+'</span>';
        /***********/

html += '<button type="button" class="btn btn-danger btn-sm float-right delete_review" data-review_id="' + data.review_data[count].review_id + '">Delete</button></div>';
        html += '</div>';

        html += '</div>';
 html += '</div>';
        html += '</div>';
    }

    $('#review_content').html(html);
}

            }
        })
    }

});


</script>


      <script src="../php/js/script.js"></script>
      </body>
      </html>
