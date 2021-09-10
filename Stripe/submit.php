<?php

require('config.php');

if(isset($_POST['stripeToken'])){



\Stripe\Stripe::setVerifySslCerts(false);

$token =$_POST['stripeToken'];

$data=\Stripe\Charge::create(array(
	"amount" =>"500",
	"currency"=>"inr",
	"description"=>"Theater Seat Booking system desc",
	"source"=>$token,
));

echo "<pre>";
print_r($data);
}
?>