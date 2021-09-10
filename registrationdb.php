<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_Theater";

$conn = new mysqli($servername, $username, $password);

if($conn->connect_error) {
	die ("Connection failed:" .$conn->connect_error);
}
//create database
$sql ="CREATE DATABASE db_Theater";
if($conn->query($sql) === TRUE)
{
	echo "database created successfully";
} else{
	echo "Error creating database: " .$conn->error; //query related error ->error
}
$conn->close();
?>


