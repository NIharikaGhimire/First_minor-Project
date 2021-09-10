<!-- <?php
session_start();
//session related to username from login
if(isset($_SESSION['session'])){
	
	session_destroy();
	header("location:login.php");

}
else{
	header('location:index.php');
}

?> -->


<?php
session_start();
unset($_SESSION["user"]);


	header('location:index.php');


?>