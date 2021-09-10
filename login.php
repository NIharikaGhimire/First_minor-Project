<?php 
$err="";
 ?>
<html>
<head>
    <title>Login Form</title>
    <link rel="stylesheet" type="text/css" href="css1/login.css">


    <style type="text/css">
		.error{
			color:red;
		}
	</style>
</head>
<body>
<?php
session_start();

if(isset($_POST['submit'])){

					//user
	if(empty($_POST['password']) || empty($_POST['user'])){
		$err="Cannot be empty.";
	}
	else{
		$fullname = $_POST['user'];
		
		$password =md5($_POST['password']);
		
		
		$conn =new mysqli('localhost','root', '','theater_db');
								                        //user
		$sql = "SELECT * FROM register WHERE fullname='$fullname' AND password='$password'";

		$result= mysqli_query($conn, $sql);

		if($row = mysqli_fetch_assoc($result)){
			
						//user			//user
			$_SESSION['user'] = $fullname;
			$_SESSION['contact'] = $row['contact'];
			
			header("location: index.php");
			}
		else{
		echo "username or password is invalid.";
		}
	}
}
?>
                    
    <h1> Login Form</h1>
    <form class="point" method="post" action=" ">
        username:<input type="text" name="user"id="user"> <!--id name -->
        <span class="error"> <?php  echo "$err"; ?></span>
        password :<input type="password" name="password">
        <button type="submit" name="submit"> login</button>
<h6>Don't have account? <a href="registrationform.php">Register now</a></h6>

    </form>
</body>
</html>