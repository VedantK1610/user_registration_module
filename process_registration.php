<?php
// Connect to your MySQL database
session_start();
include ('dbconn.php');
require 'PHPMailer/PHPMailerAutoload.php';
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function isPasswordValid($password) {
    // Minimum length of 8 characters
    $minLength = 8;

    // Check for at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // Check for at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Check for at least one digit
    if (!preg_match('/\d/', $password)) {
        return false;
    }

    // Check for at least one special character
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
        return false;
    }

    // Check for minimum length
    if (strlen($password) < $minLength) {
        return false;
    }

    // All checks passed, the password is valid
    return true;
}

function isEmailValid($email) {
    // Your email validation logic here
    // Using PHP's filter_var function with FILTER_VALIDATE_EMAIL
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function send_verification_mail($full_name,$email,$verification_token){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug =0;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'trialmepleasevk@gmail.com';
    $mail->Password = 'ibqk qrom nerx lfbn';
    $mail->setFrom('trialmepleasevk@gmail.com', 'Fameux Technologies');
    $mail->AddAddress($email);
    $mail->Subject = 'Email Verification From Fameux Technologies pvt ltd.';
    $mail->isHTML(true);

    $email_template="
        <!DOCTYPE html>
        <html lang='en'>
        <html>
        <head>
        <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        h2 {
            color: #3498db;
        }

        p {
            color: #555;
            margin: 15px 0;
        }

        h5 {
            color: #666;
        }

        a {
            display: inline-block;
            margin: 20px 0;
            padding: 15px 30px;
            text-decoration: none;
            background-color: #e7e7e7;
            color: #fff;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #008CBA;
            color:white;
        }
    </style>
        </head> 
        <body>
        <h1>Welcome to Fameux Technologies!</h1>
        <h2>You have successfully registered with us.</h2>
        <p>Get ready to embark on a journey of innovation and excellence. By joining Fameux Technologies, you've become a part of a dynamic community committed to pushing boundaries.</p>
        <h5>To get started, please verify your email address by clicking the link below:</h5>
        <a href='http://localhost/trial_project/verify-email.php?token=$verification_token'>Click Here !</a>
        <p>Thank you for choosing Fameux Technologies! We look forward to achieving great things together.</p>
        </body>
        </html>
    ";

    $mail->Body = $email_template;
    //$mail->addAttachment('attachment.txt');
    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'The email message was sent.';
    }
}


if (isset($_POST['register_button'])){
// Get form data
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $mobile_num = $_POST['mobile_num'];
    // $qualification = $_POST['qualification'];
    // $area_of_interest = $_POST['area_of_interest'];
    $password = $_POST['password'];
    $verification_token=md5(rand());

    if (!isPasswordValid($password)) {
        die("Error: Password does not meet the criteria.");
    }

    if (!isEmailValid($email)) {
        die("Error: Invalid email address.");
    }

    #check here condition if not entered mail and mobile both

    #check if entered both

    #check here condition if user entered mail do this
        $check_email_query="SELECT email FROM trial_table WHERE email='$email' LIMIT 1";
        $check_email_query_run= mysqli_query($conn , $check_email_query);

        if(mysqli_num_rows($check_email_query_run)>0){
            $_SESSION['status']="Email Already Exist";
            header("Location:index.php");
        }
        else{
            $uuid = uniqid();

            // Insert data into the database
            $sql = "INSERT INTO trial_table (user_id,full_name, email, mobile_num, password,verification_token) 
                    VALUES ('$uuid','$full_name', '$email', '$mobile_num', '$password','$verification_token')";
            $query_run=mysqli_query($conn , $sql);        

            if ($query_run) {

                send_verification_mail("$full_name","$email","$verification_token");

                $_SESSION['status']="Registeres Successfuly ! Please check your email";

            } else {
                $_SESSION['status']="Registeres Failed !";
                header("Location:index.php");
            }
        }
    
    #check if user entered mobile num do this    



// Close the database connection
$conn->close();
}
?>
