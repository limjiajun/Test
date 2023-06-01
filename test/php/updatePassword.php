<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upadte Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <?php 
        
       include_once("dbconnect.php");


        if (isset($_GET['Email']) && isset($_GET['reset_token'])) {

            date_default_timezone_set('Asia/kolkata');
            $date = date("Y-m-d");
            
            $Email = $_GET['Email'];    
            $reset_token = $_GET['reset_token'];

            $sql="SELECT * FROM `user_profile` WHERE Email = '$Email' AND resettoken = '$reset_token' AND resettokenexp = '$date'";
            $result = $conn->query($sql);

            if ($result) {
    // Use rowCount() instead of num_rows
    if ($result->rowCount() == 1) {
        echo '
            <div class="container d-flex justify-content-center mt-5 pt-5">
                <div class="card mt-5" style="width:500px">
                    <div class="card-header">
                        <h1 class="text-center">Create New Password</h1>
                    </div>
                    <div class="card-body">
                        <form method="post">
                            <div class="mt-2">
                                <label for="Password">Password : </label>
                                <input type="Password" name="Password" class="form-control" placeholder="Create New Password">
                                <input type="hidden" name="Email" class="form-control" value='.$Email.'>
                            </div>
                            <div class="mt-4 text-end">
                                <input type="submit" name="update" value="update" class="btn btn-primary">
                                <a href="index.php" class="btn btn-danger">Back</a>
                            </div>
                        </form>
                                </div>
                            </div>
                        </div>';
                }else{
                    echo "
                        <script>
                            alert('invelid or Expired link');
                            window.location.href='index.php'
                        </script>";
                }
            }   
        
        }else{
            echo "
                <script>
                    alert('server down!!');
                    window.location.href='index.php'
                </script>";
        }
        
       if (isset($_POST['update'])) {
    $Password = sha1($_POST["Password"]);
    $Email = $_POST['Email'];

    $update = "UPDATE `user_profile` SET Password=:Password, resettoken=NULL, resettokenexp=NULL WHERE Email = :Email";
    $stmt = $conn->prepare($update);
    $stmt->bindParam(':Password', $Password);
    $stmt->bindParam(':Email', $Email);

    try {
        $stmt->execute();
        echo "
            <script>
                alert('New Password Created Successfully');
                window.location.href='index.php'                
            </script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        echo "
            <script>
                alert('Password not updated');
                window.location.href='index.php'                     
            </script>";
    }
}

    ?>
</body>
</html>
