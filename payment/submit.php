<?php

require('config.php');

if(isset($_POST['id'])){

	$price = $_GET['price']; //Get the price from query string
	$quantity = $_GET['quantity']; //Get the quantity from query string

	\Stripe\Stripe::setVerifySslCerts(false);

	$token = $_POST['id'];

	$data=\Stripe\Charge::create(array(
		"amount" => $price,
		"currency"=>"inr",
		"description"=>"Theater Seat Booking system desc",
		"source"=>$token,
	));

	echo "<pre>";
	print_r($data);
}
