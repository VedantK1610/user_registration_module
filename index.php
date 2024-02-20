<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    
		<!-- MATERIAL DESIGN ICONIC FONT -->
		<link rel="stylesheet" href="fonts/material-design-iconic-font/css/material-design-iconic-font.min.css">
        <!-- STYLE CSS -->
        <link rel="stylesheet" href="css/style.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	
		<script src="script.js"></script>	
</head>
<body>
    <div class="wrapper" style="background-image: linear-gradient(90deg, #486cb4 0%, #e06c34 100%);">
			<div class="inner">
				<div class="image-holder">
					<img src="images/registration-form.jpg" alt="">
				</div>
                <form action="process_registration.php" method="post"> <!--action="process_registration.php" method="post"-->
                <h3>Futures Begin Here !</h3>
					<div class="form-group">
						<input type="text" placeholder="Full Name" id="full_name" name="full_name"  class="form-control" required>
					</div>
					<div class="form-wrapper">
						<input type="email" placeholder="Email" id="email" name="email" required class="form-control">
						<i class="zmdi zmdi-account"></i>
					</div>
					OR
					<br><br>
                    <div class="form-wrapper">
						<input type="text" placeholder="Mobile Number" type="text" id="mobile_num" name="mobile_num" maxlength="10" required class="form-control">
						<i class="zmdi zmdi-account"></i>
					</div>
                    <!-- <div class="form-wrapper">
						<input type="text"  placeholder="Highest Qualification" id="qualification" name="qualification" required class="form-control">
						<i class="zmdi zmdi-account"></i>
					</div>
					<div class="form-wrapper">
						<select id="area_of_interest" name="area_of_interest" class="form-control">
							<option value="" disabled selected>Area of Interest</option>
							<option value="java_fullstack"> Java Fullstack</option>
							<option value="data_science"> Data Science</option>
							<option value="cloud_computing"> Cloud Computing</option>
						</select>
						<i class="zmdi zmdi-caret-down" style="font-size: 17px"></i>
					</div> -->
					<div class="form-wrapper">
						<input type="password" placeholder="Password" id="password" name="password" class="form-control">
						<i class="zmdi zmdi-lock"></i>
					</div>
					<button type="submit" name="register_button">Register
						<i class="zmdi zmdi-arrow-right"></i>
					</button>
					<div class="alert">
					<?php
					if(isset($_SESSION['status'])){
						echo "<h4 style='margin:10px'>" . $_SESSION['status'] . "</h4>";
						unset($_SESSION['status']);
					}
					?>
				</div>
                </form>
				
            </div>
		</div>
</body>
</html>
