<?php
if(!empty($_FILES['picture']['name'])){
    //Include database configuration file
    include('includes/Dbconnect.php');
    include('includes/auth.php');

    //File uplaod configuration
    $result = 0;
    $uploadDir = "uploads/";
    $fileName = time().'_'.basename($_FILES['picture']['name']);
    $targetPath = $uploadDir.$fileName;

    //Upload file to server
    if(@move_uploaded_file($_FILES['picture']['tmp_name'], $targetPath)){
        //Get current user ID from session
        $eid= $_SESSION['username'];
        //Update picture name in the database
        $query = "UPDATE users_details SET user_image = '".$fileName."' WHERE user_code = '$eid'";
        $result1 = mysqli_query($DBcon, $query) or die(mysqli_error($DBcon));
        if($result1){
          $result = 1;

        }
    }

    //Load JavaScript function to show the upload status
    echo '<script type="text/javascript"> window.top.window.completeUpload(' . $result . ',\'' . $targetPath . '\');</script>  ';
}

?>