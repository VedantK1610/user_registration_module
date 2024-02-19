<?php
// Connect to your MySQL database
session_start();
include ('dbconn.php');
include('smtp/PHPMailerAutoload.php');
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
    $mail->SMTPDebug =1;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'trialmepleasevk@gmail.com';
    $mail->Password = 'ibqk qrom nerx lfbn';
    $mail->setFrom('trialmepleasevk@gmail.com', 'Fameux Technologies');
    $mail->AddAddress($email);
    $mail->Subject = 'Email Verification From Fameux Technologies pvt ltd.';

    $email_template="
        <h2>You have registered with Fameux Technologies pvt ltd.</h2>
        <h5>Verify your email address from following link</h5>
        <br/>
        <br/>
        <a href='http://localhost/trial_project/verify-email.php?token=$verification_token'>Click Here !</a>
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


// Close the database connection
$conn->close();
}
?>
