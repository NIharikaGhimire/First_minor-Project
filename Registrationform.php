<!DOCTYPE html>
<html>
<head>
	
	<title>RegistrationForm</title>
	<link rel="stylesheet" type="text/css" href="css1/style.css">

</head>
<body>

	<?php
	// $err=$error="";
	// session_start();

	// if(isset($_POST['submit'])) {
	// if(empty($_POST['name']) || empty($_POST['address']) || empty($_POST['contact']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['genders'])){
	// 	$err="Error Ocuurs: Cannot be empty.";


	// }
	// 		else{
	// 	$fullname = $_POST['name'];
	// 	$address = $_POST['address'];
	// 	$contact = $_POST['contact']; 
	// 	$email = $_POST['email']; 
	// 	$password =($_POST['password']);
	// 	$gender = $_POST['genders'];

	// 	$conn = new mysqli('localhost','root', '' ,'theater_db');


	// 	$sql = "INSERT INTO register(fullname,address,contact,email,password)
 //     VALUES('$fullname','$address','$contact','$email','$password')";

 //     if ($conn->query($sql)=== TRUE) {
 //     	echo "New account created successfully";
 //     } else{
 //     	$error = "Invalid Input.";
 //     }

	// 	 $conn->close();
	// 	}
	// }
	if(isset($_POST['submit'])){
		$fullname = $_POST['fullname'];
		$address = $_POST['address'];
		$contact = $_POST['contact']; 
		$email = $_POST['email']; 
		$password =md5($_POST['password']);
		$gender = $_POST['genders'];
			

		$count = 0;
		if (!preg_match("/^(?!\.)[\w. ]*$(?<!\.)/",$fullname)) {
			echo "Enter a username that starts with string <br>";
			$count = $count+1;
		}
		
		if(empty($address) || strlen($address)>40){
			echo "Address should be upto 40 characters only<br>";
			$count = $count+1;
		}
		if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
			echo "email address must be in proper format<br>";
			$count = $count+1;
		}

		if(strlen($password)<8){
			echo "Enter a password more than 8 characters<br>";
			$count = $count+1;
		}
		if(strlen($contact) < 10 ||strlen($contact) >11){
			echo "Contact must be  10 characters<br>";
			$count = $count+1;
		}

		if($gender== ''  ){
			echo "gender is required<br>";
			$count = $count+1;
		}
		$newpassword = ($password);
		
		if ($count == 0) {
			$servername = "localhost";
			$user ="root";
			$pass = "";
			$dbname = "theater_db";
			$conn = new mysqli($servername,$user,$pass,$dbname);
			if ($conn->connect_error) {
				die("Connection error");
			}
			$sql = "INSERT INTO register(fullname,address,contact,email,password,genders) VALUES('$fullname','$address','$contact','$email','$newpassword','$gender')";

			if($conn->query($sql) === TRUE){
				echo "new record created";
			}
			else{
				echo "Username already taken";
			}

					//echo "user registered successfully";





			$conn->close();
		}
	}
	?>
	




	<div id="Mydiv"></div>
	<h1> Registration Form</h1>
	<form class="point"  method="POST"  style="padding: 50px;">

		Full Name:<input  type="text" name="fullname" placeholder="Full name"id="fullname">
		

		Address:<input  type="text" name="address" placeholder="Addess"id="address">
		
		
		Contact:<input  type="number" name="contact" placeholder="Contact" id="Contact"> 
		
		

		Email:<input type="email" name="email"placeholder="Email" >
		Gender:
		<input  type="radio" name="genders" id="male" value="male"  >Male
		<input  type="radio" name="genders" id="female" value="female">Female <br>

		Password :<input  type="password" name="password"/> <br>

		

		<button type="submit" name="submit" > Register </button><br>

		<h6>Already have account? <a href="login.php">Login now</a></h6>
		<form>

		</body>
		</html>