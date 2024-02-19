<?php 
session_start();
include('dbconn.php');

if(isset($_GET["token"])){
    $token=$_GET['token'];
    $verify_query= "SELECT verification_token,verify_status from trial_table where verification_token='$token' LIMIT 1";

    $verify_query_run = mysqli_query($conn, $verify_query);

    if(mysqli_num_rows($verify_query_run)>0){
        $row=mysqli_fetch_array($verify_query_run);
        // echo $row['verify_token'];
        if($row['verify_status']=="0"){
            $clicked_token=$row['verification_token'];
            $query="UPDATE trial_table SET verify_status='1' WHERE verification_token='$clicked_token' LIMIT 1";

            $query_run=mysqli_query($conn,$query);

            if($query_run){
                $_SESSION['status']="Email verified Successfully!";
                header("Location:index.php");
                exit(0);
            }
            else{
                $_SESSION['status']="Verification Failed!";
                header("Location:index.php");
                exit(0);
            }
        }
        else{
            $_SESSION['status']="Email Already verified !";
            header("Location:index.php");
            exit(0);
        }
    }
    else{
        $_SESSION['status']="This token does not exist";
        header("Location:index.php");
    }
}
else{
    $_SESSION['status']="Not Allowed";
    header("Location:index.php");
}

?>